/**
 * Laporan Stok Pakan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    stokPakanTable = $('#stokPakanTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('csv');
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('excel');
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function(e, dt, button, config) {
                    exportWithParams('pdf');
                }
            },
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
    
    $("#btnFilter").click(function() {
        var tahun = $("#filterTahun").val();
        if(tahun) {
            loadData();
        } else {
            alert("Silakan pilih tahun terlebih dahulu!");
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterDemplot").val('semua');
        $("#reportTitle").html('DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN');
        $("#reportSubtitle").html('Silakan pilih tahun terlebih dahulu');
        stokPakanTable.clear().draw();
        stokPakanTable.row.add(['-', 'Silakan pilih filter untuk menampilkan data', '-', '-', '-', '-', '-', '-', '-', '-']);
        stokPakanTable.draw();
        $("#tableFooter").html('');
    });
    
    $("#btnExport").click(function() {
        var tahun = $("#filterTahun").val();
        var demplot = $("#filterDemplot").val();
        
        if(!tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        window.location.href = base_url + "laporan_stok_pakan/export_excel?tahun=" + encodeURIComponent(tahun) + "&demplot=" + encodeURIComponent(demplot);
    });
    
    $("#refreshBtn").click(function() {
        var tahun = $("#filterTahun").val();
        if(tahun) {
            loadData();
        } else {
            alert("Silakan pilih tahun terlebih dahulu!");
        }
    });
});

var stokPakanTable = null;

function exportWithParams(format) {
    var tahun = $("#filterTahun").val();
    var demplot = $("#filterDemplot").val();
    
    if(!tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var url = base_url + 'laporan_stok_pakan/export_' + format;
    url += "?tahun=" + encodeURIComponent(tahun);
    url += "&demplot=" + encodeURIComponent(demplot);
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    var tableHtml = $('#stokPakanTable').clone();
    
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

function loadData() {
    var tahun = $("#filterTahun").val();
    var demplotFilter = $("#filterDemplot").val();
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    var demplotText = (demplotFilter && demplotFilter !== 'semua') ? $('#filterDemplot option:selected').text() : 'Seluruh Demplot';
    $("#reportTitle").html('DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN TAHUN ' + tahun);
    $("#reportSubtitle").html(demplotText);
    
    $.ajax({
        url: base_url + 'laporan_stok_pakan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            demplot: demplotFilter
        },
        dataType: "json",
        success: function(response) {
            stokPakanTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var totalStokAwal = 0;
                var totalStokMasuk = 0;
                var totalStokKeluar = 0;
                var totalStokAkhir = 0;
                var no = 1;
                
                for (var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    
                    totalStokAwal += parseInt(item.stok_awal) || 0;
                    totalStokMasuk += parseInt(item.stok_masuk) || 0;
                    totalStokKeluar += parseInt(item.stok_keluar) || 0;
                    totalStokAkhir += parseInt(item.stok_akhir) || 0;
                    
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
                        '<span class="stok-awal">' + formatNumber(item.stok_awal) + ' kg</span>',
                        '<span class="stok-masuk">+' + formatNumber(item.stok_masuk) + ' kg</span>',
                        '<span class="stok-keluar">-' + formatNumber(item.stok_keluar) + ' kg</span>',
                        '<span class="stok-akhir">' + formatNumber(item.stok_akhir) + ' kg</span>',
                        '<span class="keterangan">' + escapeHtml(keterangan) + '</span>'
                    ]);
                    no++;
                }
                
                stokPakanTable.draw();
                
                var totalTransaksi = response.data.length;
                var footerHtml = '<tr class="total-row">' +
                    '<td colspan="5" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>' +
                    '<td><strong>' + totalTransaksi + ' Transaksi</strong></td>' +
                    '</tr>';
                $("#tableFooter").html(footerHtml);
            } else {
                stokPakanTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                stokPakanTable.draw();
                $("#tableFooter").html('');
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