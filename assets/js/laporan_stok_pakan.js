/**
 * Laporan Stok Pakan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    stokPakanTable = $('#stokPakanTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'copy',
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: {
            //         columns: ':visible'
            //     } 
            // },
            // {
            //     extend: 'csv',
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     action: function(e, dt, button, config) {
            //         exportWithParams('csv');
            //     }
            // },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('excel');
                }
            },
            // {
            //     extend: 'pdf',
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     action: function(e, dt, button, config) {
            //         exportWithParams('pdf');
            //     }
            // },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
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
    
    // ========== LANGSUNG LOAD SEMUA DATA SAAT HALAMAN DIBUKA ==========
    loadAllData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.demplot = $("#filterDemplot").val();
        
        if(currentData.tahun === '' || currentData.tahun === 'semua') {
            loadAllData();
        } else {
            loadDataWithFilter();
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterDemplot").val('semua');
        
        currentData = {
            tahun: '',
            demplot: 'semua'
        };
        
        loadAllData();
    });
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun && currentData.tahun !== '' && currentData.tahun !== 'semua') {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
});

var stokPakanTable = null;
var currentData = {
    tahun: '',
    demplot: 'semua'
};

function exportWithParams(format) {
    var tahun = currentData.tahun || 'all';
    var demplot = currentData.demplot || 'semua';
    
    var url = base_url + 'laporan_stok_pakan/export_' + format;
    url += "?tahun=" + encodeURIComponent(tahun);
    url += "&demplot=" + encodeURIComponent(demplot);
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Stok Pakan</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.jenis-pakan { background-color: #fef3ef; color: #832706; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.positive-value { color: #832706 !important; font-weight: bold; }');
    printWindow.document.write('.zero-value { color: #000000 !important; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('stokPakanTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + title + '</h2>');
    printWindow.document.write('<p>' + subtitle + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_stok_pakan/get_all_data',
        type: "POST",
        dataType: "json",
        success: function(response) {
            $("#reportTitle").html('DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN');
            $("#reportSubtitle").html('Kota Surabaya - Seluruh Data');
            
            // Update tabel detail
            stokPakanTable.clear().draw();
            
            if(response.status === 'success' && response.data && response.data.length > 0) {
                var totalStokAwal = 0;
                var totalStokMasuk = 0;
                var totalStokKeluar = 0;
                var totalStokAkhir = 0;
                var no = 1;
                
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    
                    var stokAwal = parseInt(item.stok_awal) || 0;
                    var stokMasuk = parseInt(item.stok_masuk) || 0;
                    var stokKeluar = parseInt(item.stok_keluar) || 0;
                    var stokAkhir = parseInt(item.stok_akhir) || 0;
                    
                    totalStokAwal += stokAwal;
                    totalStokMasuk += stokMasuk;
                    totalStokKeluar += stokKeluar;
                    totalStokAkhir += stokAkhir;
                    
                    var kelasAwal = stokAwal > 0 ? 'positive-value' : 'zero-value';
                    var kelasAkhir = stokAkhir > 0 ? 'positive-value' : 'zero-value';
                    
                    var namaDemplot = (item.nama_demplot && item.nama_demplot !== 'null') ? item.nama_demplot : '-';
                    var jenisPakan = item.jenis_pakan || '-';
                    var merkPakan = item.merk_pakan || '-';
                    var keterangan = item.keterangan || '-';
                    
                    stokPakanTable.row.add([
                        no,
                        formatDate(item.tanggal),
                        '<span class="nama-demplot">' + escapeHtml(namaDemplot) + '</span>',
                        '<span class="jenis-pakan">' + escapeHtml(jenisPakan) + '</span>',
                        '<span class="merk-pakan">' + escapeHtml(merkPakan) + '</span>',
                        '<span class="' + kelasAwal + '">' + formatNumber(stokAwal) + ' kg</span>',
                        '<span class="positive-value">+' + formatNumber(stokMasuk) + ' kg</span>',
                        '<span class="zero-value">-' + formatNumber(stokKeluar) + ' kg</span>',
                        '<span class="' + kelasAkhir + '">' + formatNumber(stokAkhir) + ' kg</span>',
                        '<span class="keterangan">' + escapeHtml(keterangan) + '</span>'
                    ]);
                    no++;
                }
                
                stokPakanTable.draw();
                
                var totalTransaksi = response.data.length;
                var footerHtml = '<tr class="total-row" style="background-color: #e8f5e9; font-weight: bold;">' +
                    '<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>' +
                    '<td align="center"><strong>' + formatNumber(totalTransaksi) + ' Transaksi</strong></td>' +
                    '</table>';
                $("#tableFooter").html(footerHtml);
                $("#tableFooter").show();
            } else {
                stokPakanTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                stokPakanTable.draw();
                $("#tableFooter").hide();
            }
            
            // Set current data untuk export
            currentData.tahun = '';
            currentData.demplot = 'semua';
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var demplot = currentData.demplot;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_stok_pakan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            demplot: demplot
        },
        dataType: "json",
        success: function(response) {
            var tahunText = 'TAHUN ' + tahun;
            var demplotText = (demplot && demplot !== 'semua') ? demplot : 'Seluruh Demplot';
            $("#reportTitle").html('DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN ' + tahunText);
            $("#reportSubtitle").html(demplotText);
            
            // Update tabel detail
            stokPakanTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var totalStokAwal = 0;
                var totalStokMasuk = 0;
                var totalStokKeluar = 0;
                var totalStokAkhir = 0;
                var no = 1;
                
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    
                    var stokAwal = parseInt(item.stok_awal) || 0;
                    var stokMasuk = parseInt(item.stok_masuk) || 0;
                    var stokKeluar = parseInt(item.stok_keluar) || 0;
                    var stokAkhir = parseInt(item.stok_akhir) || 0;
                    
                    totalStokAwal += stokAwal;
                    totalStokMasuk += stokMasuk;
                    totalStokKeluar += stokKeluar;
                    totalStokAkhir += stokAkhir;
                    
                    var kelasAwal = stokAwal > 0 ? 'positive-value' : 'zero-value';
                    var kelasAkhir = stokAkhir > 0 ? 'positive-value' : 'zero-value';
                    
                    var namaDemplot = (item.nama_demplot && item.nama_demplot !== 'null') ? item.nama_demplot : '-';
                    var jenisPakan = item.jenis_pakan || '-';
                    var merkPakan = item.merk_pakan || '-';
                    var keterangan = item.keterangan || '-';
                    
                    stokPakanTable.row.add([
                        no,
                        formatDate(item.tanggal),
                        '<span class="nama-demplot">' + escapeHtml(namaDemplot) + '</span>',
                        '<span class="jenis-pakan">' + escapeHtml(jenisPakan) + '</span>',
                        '<span class="merk-pakan">' + escapeHtml(merkPakan) + '</span>',
                        '<span class="' + kelasAwal + '">' + formatNumber(stokAwal) + ' kg</span>',
                        '<span class="positive-value">+' + formatNumber(stokMasuk) + ' kg</span>',
                        '<span class="zero-value">-' + formatNumber(stokKeluar) + ' kg</span>',
                        '<span class="' + kelasAkhir + '">' + formatNumber(stokAkhir) + ' kg</span>',
                        '<span class="keterangan">' + escapeHtml(keterangan) + '</span>'
                    ]);
                    no++;
                }
                
                stokPakanTable.draw();
                
                var totalTransaksi = response.data.length;
                var footerHtml = '<tr class="total-row" style="background-color: #e8f5e9; font-weight: bold;">' +
                    '<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>' +
                    '<td align="right"><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>' +
                    '<td align="center"><strong>' + formatNumber(totalTransaksi) + ' Transaksi</strong></td>' +
                    '</tr>';
                $("#tableFooter").html(footerHtml);
                $("#tableFooter").show();
            } else {
                stokPakanTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                stokPakanTable.draw();
                $("#tableFooter").hide();
            }
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function formatNumber(num) {
    if (num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatDate(dateString) {
    if(!dateString) return '-';
    var parts = dateString.split('-');
    if(parts.length === 3) {
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }
    return dateString;
}

function escapeHtml(text) {
    if(!text) return '-';
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };
    return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}