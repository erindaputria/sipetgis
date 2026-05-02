/**
 * Data Kepemilikan Ternak
 * SIPETGIS - Kota Surabaya
 */

// Base URL untuk AJAX
var base_url = "<?= base_url() ?>";

$(document).ready(function() {
    // Initialize DataTable with custom buttons (SAMA PERSIS PELAKU USAHA)
    dataTernakTable = $('#dataTernakTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'copy',
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
            // {
            //     extend: 'csv',
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    window.location.href = base_url + "data_kepemilikan/export_excel";
                }
            },
            // {
            //     extend: 'pdf',
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
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

    // Event Filter Data
    $('#filterBtn').on('click', function() {
        var jenisUsaha = $('#filterKomoditas').val();
        
        // Tampilkan loading
        $('#dataTernakTable tbody').html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></td></tr>');
        
        $.ajax({
            url: base_url + 'data_kepemilikan/filter_data',
            type: 'POST',
            data: { jenis_usaha: jenisUsaha },
            dataType: 'json',
            success: function(response) {
                if (response.html) {
                    // Destroy existing DataTable
                    if ($.fn.DataTable.isDataTable('#dataTernakTable')) {
                        $('#dataTernakTable').DataTable().destroy();
                    }
                    
                    // Update table body
                    $('#dataTernakTable tbody').html(response.html);
                    
                    // Re-initialize DataTable dengan config yang sama
                    $('#dataTernakTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            // {
                            //     extend: 'copy',
                            //     text: '<i class="fas fa-copy"></i> Copy',
                            //     className: 'btn btn-sm btn-primary',
                            //     exportOptions: { columns: [0,1,2,3] }
                            // },
                            // {
                            //     extend: 'csv',
                            //     text: '<i class="fas fa-file-csv"></i> CSV',
                            //     className: 'btn btn-sm btn-success',
                            //     exportOptions: { columns: [0,1,2,3] }
                            // },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel"></i> Excel',
                                className: 'btn btn-sm btn-success',
                                exportOptions: { columns: [0,1,2,3] },
                                action: function(e, dt, button, config) {
                                    window.location.href = base_url + "data_kepemilikan/export_excel";
                                }
                            },
                            // {
                            //     extend: 'pdf',
                            //     text: '<i class="fas fa-file-pdf"></i> PDF',
                            //     className: 'btn btn-sm btn-danger',
                            //     exportOptions: { columns: [0,1,2,3] }
                            // },
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
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memfilter data');
                location.reload();
            }
        });
    });

    // Close detail button event
    $("#closeDetailBtn").click(function() {
        $("#detailSection").hide();
        $("#detailTableBody").empty();
        $("#detailInfo").empty();
    });

    // Auto close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

var dataTernakTable = null;

// ========== FUNCTION PRINT (SAMA PERSIS PELAKU USAHA) ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var tableData = [];
    var totalPeternak = 0;
    var totalTernak = 0;
    
    // Ambil semua baris dari DataTable yang sedang ditampilkan
    var table = $('#dataTernakTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Kepemilikan Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #000000; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #000000; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #000000; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #832706; color: #000000; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Header Laporan
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA KEPEMILIKAN TERNAK</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data
    printWindow.document.write('<table border="1" cellpadding="8" cellspacing="0" width="100%">');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Jenis Usaha</th>');
    printWindow.document.write('<th>Jumlah Peternak</th>');
    printWindow.document.write('<th>Total Ternak (Ekor)</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var peternakText = stripHtml(row[2] || '0');
        var ternakText = stripHtml(row[3] || '0');
        var peternak = parseInt(peternakText.replace(/\./g, '')) || 0;
        var ternak = parseInt(ternakText.replace(/\./g, '')) || 0;
        
        totalPeternak += peternak;
        totalTernak += ternak;
        
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + peternakText + ' Peternak</td>');
        printWindow.document.write('<td align="center">' + ternakText + ' Ekor</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="2" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalPeternak) + ' Peternak</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalTernak) + ' Ekor</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    // Footer Note
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('SIPETGIS - Sistem Informasi Peternakan Kota Surabaya');
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
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

// Fungsi showDetail
function showDetail(jenisUsaha) {
    // Tampilkan loading
    $('#detailSection').show();
    $('#detailTableBody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data peternak...</p></td></tr>');
    
    // Update detail info
    $("#detailInfo").html('<i class="fas fa-spinner fa-spin me-2"></i> Sedang mengambil data untuk: <strong>' + decodeURIComponent(jenisUsaha) + '</strong>');
    
    // Scroll ke detail section
    $("html, body").animate({
        scrollTop: $("#detailSection").offset().top - 100
    }, 500);
    
    // AJAX ke server
    $.ajax({
        url: base_url + 'data_kepemilikan/get_detail_pelaku_usaha',
        type: 'POST',
        data: { jenis_usaha: jenisUsaha },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                $('#detailTableBody').html('<tr><td colspan="7" class="text-center text-danger"><i class="fas fa-exclamation-triangle me-2"></i>' + response.error + '</td></tr>');
                $('#detailInfo').html('<i class="fas fa-exclamation-triangle text-danger me-2"></i> Gagal memuat data');
                return;
            }
            
            if (response.html && response.total_data > 0) {
                $('#detailTableBody').html(response.html);
                $('#detailInfo').html('<i class="fas fa-check-circle text-success me-2"></i> Menampilkan <strong>' + response.total_data + '</strong> data peternak untuk jenis usaha: <strong class="text-primary">' + response.jenis_usaha + '</strong>');
            } else {
                $('#detailTableBody').html('<tr><td colspan="7" class="text-center text-warning"><i class="fas fa-database me-2"></i> Tidak ada data ditemukan untuk jenis usaha ini</td></tr>');
                $('#detailInfo').html('<i class="fas fa-info-circle text-warning me-2"></i> Tidak ada data peternak untuk jenis usaha: <strong>' + decodeURIComponent(jenisUsaha) + '</strong>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            $('#detailTableBody').html('<tr><td colspan="7" class="text-center text-danger"><i class="fas fa-times-circle me-2"></i> Terjadi kesalahan saat memuat data. Silakan coba lagi.<br><small class="text-muted">Error: ' + error + '</small></td></tr>');
            $('#detailInfo').html('<i class="fas fa-exclamation-circle text-danger me-2"></i> Error: Gagal terhubung ke server');
        }
    });
}