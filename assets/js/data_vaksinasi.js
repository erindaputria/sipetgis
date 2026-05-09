/**
 * Data Vaksinasi Ternak
 * SIPETGIS - Kota Surabaya
 */

var mainTable = null;
var detailTable = null;

$(document).ready(function () {
    // Initialize DataTable
    mainTable = $('#dataVaksinasiTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ],
        ordering: false,
        searching: true,
        paging: true,
        pageLength: 15,
        lengthMenu: [10, 15, 25, 50, 100],
        info: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            zeroRecords: "Tidak ada data ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        scrollX: true
    });

    // Event filter button
    $("#filterBtn").click(function () {
        var komoditas = $("#filterKomoditas").val();
        
        // Tampilkan loading
        $('#dataVaksinasiTable tbody').html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary"></div><br>Memuat data...<\/td><\/tr>');
        
        // Hancurkan DataTable lama
        if (mainTable) {
            mainTable.destroy();
            mainTable = null;
        }
        
        $.ajax({
            url: ajaxFilterUrl,
            type: 'POST',
            data: { komoditas: komoditas },
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                var tbodyHtml = '';
                
                if (response.length > 0) {
                    for (var i = 0; i < response.length; i++) {
                        var item = response[i];
                        tbodyHtml += '<tr>' +
                            '<td align="center">' + item.no + '<\/td>' +
                            '<td align="left">' + escapeHtml(item.nama_kegiatan) + '<\/td>' +
                            '<td align="center">' + item.tahun + '<\/td>' +
                            '<td align="center">' + formatNumber(item.jumlah_ternak) + ' Ekor<\/td>' +
                            '<td align="center">' +
                                '<button class="btn btn-detail-custom btn-sm" onclick="showDetail(\'' + escapeHtml(item.jenis_vaksinasi) + '\', \'' + item.tahun + '\', \'' + formatNumber(item.jumlah_ternak) + '\')">' +
                                    '<i class="fas fa-eye me-1"></i>Detail' +
                                '<\/button>' +
                            '<\/td>' +
                        '<\/tr>';
                    }
                } else {
                    tbodyHtml = '<tr><td colspan="5" class="text-center">Tidak ada data vaksinasi untuk komoditas ' + escapeHtml(komoditas) + '<\/td><\/tr>';
                }
                
                $('#dataVaksinasiTable tbody').html(tbodyHtml);
                
                // Inisialisasi ulang DataTable
                mainTable = $('#dataVaksinasiTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: 'btn btn-sm btn-success',
                            exportOptions: { columns: [0,1,2,3] }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Print',
                            className: 'btn btn-sm btn-info',
                            exportOptions: { columns: [0,1,2,3] },
                            action: function(e, dt, button, config) {
                                printWithCurrentData();
                            }
                        }
                    ],
                    ordering: false,
                    searching: true,
                    paging: true,
                    pageLength: 15,
                    lengthMenu: [10, 15, 25, 50, 100],
                    info: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        zeroRecords: "Tidak ada data ditemukan",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        }
                    },
                    scrollX: true
                });
                
                // Tutup detail section jika terbuka
                $("#detailSection").hide();
                if (detailTable) {
                    detailTable.destroy();
                    detailTable = null;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#dataVaksinasiTable tbody').html('<tr><td colspan="5" class="text-center text-danger">Gagal memuat data<\/td><\/tr>');
                
                mainTable = $('#dataVaksinasiTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: 'btn btn-sm btn-success',
                            exportOptions: { columns: [0,1,2,3] }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Print',
                            className: 'btn btn-sm btn-info',
                            exportOptions: { columns: [0,1,2,3] }
                        }
                    ],
                    ordering: false,
                    searching: true,
                    paging: true,
                    pageLength: 15,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        zeroRecords: "Tidak ada data ditemukan"
                    },
                    scrollX: true
                });
            }
        });
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterKomoditas").val("all");
        location.reload();
    });

    // Close detail button event
    $("#closeDetailBtn").click(function () {
        $("#detailSection").hide();
        if (detailTable) {
            detailTable.destroy();
            detailTable = null;
        }
    });
});

// ========== HELPER FUNCTIONS ==========
function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function formatNumber(num) {
    if (num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function stripHtml(html) {
    if (!html) return '-';
    var tmp = document.createElement('DIV');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '-';
}

// ========== FUNCTION PRINT ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var tableData = [];
    var totalTernak = 0;
    
    var table = $('#dataVaksinasiTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    for (var i = 0; i < rows.length; i++) {
        tableData.push(rows[i]);
    }
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        var ternakText = stripHtml(row[3] || '0');
        var ternakAngka = ternakText.replace(/\./g, '').replace(' Ekor', '');
        var ternak = parseInt(ternakAngka) || 0;
        totalTernak += ternak;
    }
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Vaksinasi Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #000000; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #000000; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('.total-row { background-color: #f0f0f0; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA VAKSINASI TERNAK</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table border="1" cellpadding="5" cellspacing="0" width="100%">');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama Kegiatan</th>');
    printWindow.document.write('<th>Tahun</th>');
    printWindow.document.write('<th>Jumlah Ternak Divaksin</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '<\/td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '<\/td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[2] || '-') + '<\/td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '<\/td>');
        printWindow.document.write('<\/tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong><\/td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalTernak) + ' Ekor</strong><\/td>');
    printWindow.document.write('<\/tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('<\/table>');
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('SIPETGIS - Sistem Informasi Peternakan Kota Surabaya');
    printWindow.document.write('<\/div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// ========== FUNCTION SHOW DETAIL ==========
function showDetail(jenisVaksin, tahun, jumlah) {
    console.log('showDetail called with:', jenisVaksin, tahun, jumlah);
    
    document.getElementById("detailInfo").innerHTML = 
        '<i class="fas fa-info-circle me-2"></i>' +
        '<span class="fw-bold">Nama Kegiatan:</span> ' + escapeHtml(jenisVaksin) + ' (' + tahun + ')<br>' +
        '<span class="fw-bold">Total Ternak Divaksin:</span> ' + jumlah + ' Ekor';

    document.getElementById("detailTableBody").innerHTML = 
        '<tr><td colspan="6" class="text-center text-muted">' +
            '<i class="fas fa-spinner fa-spin me-2"></i>Memuat data detail...' +
        '<\/td><\/tr>';
    
    document.getElementById("detailSection").style.display = "block";

    $.ajax({
        url: ajaxDetailUrl,
        type: 'POST',
        data: { 
            jenis_vaksin: jenisVaksin, 
            tahun: tahun 
        },
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            console.log('Ajax success, response:', response);
            
            if (detailTable) {
                detailTable.destroy();
                detailTable = null;
            }
            
            var detailTableBody = document.getElementById("detailTableBody");
            detailTableBody.innerHTML = '';
            
            if (response.length > 0) {
                for (var i = 0; i < response.length; i++) {
                    var item = response[i];
                    var tanggal = item.tanggal_vaksinasi || '-';
                    if (tanggal !== '-') {
                        tanggal = tanggal.split('-').reverse().join('-');
                    }
                    
                    var rowHtml = '<tr>' +
                        '<td align="center">' + item.no + '<\/td>' +
                        '<td><i class="fas fa-user me-2" style="color: #832706;"></i><strong>' + escapeHtml(item.nama_peternak) + '<\/strong><\/td>' +
                        '<td align="center"><span class="badge-ternak"><i class="fas fa-paw me-1"></i>' + escapeHtml(item.komoditas_ternak) + '<\/span><\/td>' +
                        '<td><i class="fas fa-map-marker-alt me-2" style="color: #832706;"></i>' + escapeHtml(item.kecamatan) + '<\/td>' +
                        '<td align="center" style="font-weight: 700; color: #832706;">' + item.jumlah.toLocaleString('id-ID') + ' Ekor<\/td>' +
                        '<td align="center">' + escapeHtml(tanggal) + '<\/td>' +
                    '<\/tr>';
                    
                    detailTableBody.innerHTML += rowHtml;
                }
            } else {
                detailTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">' +
                    '<i class="fas fa-database me-2"></i>Tidak ada data detail untuk kegiatan ini' +
                '<\/td><\/tr>';
            }
            
            detailTable = $('#detailTable').DataTable({
                ordering: true,
                searching: true,
                paging: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                info: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data rincian",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: {
                        first: "« Pertama",
                        last: "Terakhir »",
                        next: "Berikutnya →",
                        previous: "← Sebelumnya"
                    }
                },
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false
            });
            
            $("html, body").animate({
                scrollTop: $("#detailSection").offset().top - 20
            }, 500);
        },
        error: function(xhr, status, error) {
            console.error('Error detail:', error);
            document.getElementById("detailTableBody").innerHTML = 
                '<tr><td colspan="6" class="text-center text-danger py-4">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data detail: ' + error +
                '<\/td><\/tr>';
        }
    });
}