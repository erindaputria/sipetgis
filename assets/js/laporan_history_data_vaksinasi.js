/**
 * Laporan History Data Vaksinasi
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#historyVaksinasiTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportToExcel();
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
        }
    });
    
    // ========== LANGSUNG LOAD SEMUA DATA SAAT HALAMAN DIBUKA ==========
    loadAllData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.jenis_vaksin = $("#filterJenisVaksin").val();
        currentData.jenis_hewan = $("#filterJenisHewan").val();
        
        if(!currentData.tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        loadDataWithFilter();
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        $("#filterJenisVaksin").val('semua');
        $("#filterJenisHewan").val('semua');
        
        currentData = {
            tahun: '',
            kecamatan: 'semua',
            jenis_vaksin: 'semua',
            jenis_hewan: 'semua'
        };
        
        loadAllData();
    });
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun) {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua',
    jenis_vaksin: 'semua',
    jenis_hewan: 'semua'
};

// ========== FUNGSI EXPORT EXCEL YANG DIPERBAIKI ==========
function exportToExcel() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var jenisVaksin = currentData.jenis_vaksin;
    var jenisHewan = currentData.jenis_hewan;
    
    // Buat URL untuk export
    var url = base_url + 'laporan_history_data_vaksinasi/export_excel';
    url += "?tahun=" + (tahun || '');
    url += "&kecamatan=" + (kecamatan || 'semua');
    url += "&jenis_vaksin=" + encodeURIComponent(jenisVaksin || 'semua');
    url += "&jenis_hewan=" + encodeURIComponent(jenisHewan || 'semua');
    
    console.log('Export URL:', url);
    window.location.href = url;
}

// Fungsi export lama (untuk kompatibilitas)
function exportWithParams(format) {
    exportToExcel();
}

function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan History Data Vaksinasi</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #832706; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.positive-value { color: #832706 !important; font-weight: bold; }');
    printWindow.document.write('.zero-value { color: #000000 !important; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('historyVaksinasiTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML.replace('<br>', ' - ') + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// ========== LOAD SEMUA DATA (TANPA FILTER) ==========
function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_vaksinasi/get_all_data',
        type: "POST",
        dataType: "json",
        success: function(response) {
            $("#reportTitle").html('REKAPITULASI VAKSINASI SEMUA DATA');
            $("#reportSubtitle").html('Kota Surabaya - Seluruh Data');
            
            dataTable.clear().draw();
            
            var totalDosis = 0;
            var nomor = 1;
            
            if(response.data && response.data.length > 0) {
                for(var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    var kelasDosis = (parseInt(item.jumlah) > 0) ? 'positive-value' : 'zero-value';
                    
                    var rowData = [
                        nomor,
                        item.tanggal || '-',
                        item.petugas || '-',
                        item.peternak || '-',
                        item.nik || '-',
                        item.alamat || '-',
                        item.kecamatan || '-',
                        item.kelurahan || '-',
                        item.jenis_hewan || '-',
                        '<span class="' + kelasDosis + '">' + formatNumber(item.jumlah) + '</span>'
                    ];
                    dataTable.row.add(rowData);
                    totalDosis += parseInt(item.jumlah) || 0;
                    nomor++;
                }
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '0']);
            }
            
            dataTable.draw();
            
            var totalClass = totalDosis > 0 ? 'positive-value' : 'zero-value';
            var footerHtml = '<tr class="total-row" style="background-color: #e8f5e9; font-weight: bold;">' +
                '<td colspan="9" align="center"><strong>TOTAL KESELURUHAN</strong></td>' +
                '<td align="center"><strong class="' + totalClass + '">' + formatNumber(totalDosis) + '</strong></td>' +
                '</tr>';
            $("#tableFooter").html(footerHtml);
            $("#tableFooter").show();
            
            currentData.tahun = '';
            currentData.kecamatan = 'semua';
            currentData.jenis_vaksin = 'semua';
            currentData.jenis_hewan = 'semua';
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

// ========== LOAD DATA DENGAN FILTER ==========
function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var jenisVaksin = currentData.jenis_vaksin;
    var jenisHewan = currentData.jenis_hewan;
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_vaksinasi/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan,
            jenis_vaksin: jenisVaksin,
            jenis_hewan: jenisHewan
        },
        dataType: "json",
        success: function(response) {
            var jenisVaksinText = (jenisVaksin && jenisVaksin !== 'semua') ? jenisVaksin : 'Semua Jenis Vaksin';
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            var jenisHewanText = (jenisHewan && jenisHewan !== 'semua') ? ' - Jenis Hewan: ' + jenisHewan : '';
            
            $("#reportTitle").html('REKAP DATA VAKSIN ' + jenisVaksinText + ' TAHUN ' + tahun);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + jenisHewanText);
            
            dataTable.clear().draw();
            
            var totalDosis = 0;
            var nomor = 1;
            
            if(response.data && response.data.length > 0) {
                for(var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    var kelasDosis = (parseInt(item.jumlah) > 0) ? 'positive-value' : 'zero-value';
                    
                    var rowData = [
                        nomor,
                        item.tanggal || '-',
                        item.petugas || '-',
                        item.peternak || '-',
                        item.nik || '-',
                        item.alamat || '-',
                        item.kecamatan || '-',
                        item.kelurahan || '-',
                        item.jenis_hewan || '-',
                        '<span class="' + kelasDosis + '">' + formatNumber(item.jumlah) + '</span>'
                    ];
                    dataTable.row.add(rowData);
                    totalDosis += parseInt(item.jumlah) || 0;
                    nomor++;
                }
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '0']);
            }
            
            dataTable.draw();
            
            var totalClass = totalDosis > 0 ? 'positive-value' : 'zero-value';
            var footerHtml = '<tr class="total-row" style="background-color: #e8f5e9; font-weight: bold;">' +
                '<td colspan="9" align="center"><strong>TOTAL KESELURUHAN</strong></td>' +
                '<td align="center"><strong class="' + totalClass + '">' + formatNumber(totalDosis) + '</strong></td>' +
                '</tr>';
            $("#tableFooter").html(footerHtml);
            $("#tableFooter").show();
            
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
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}