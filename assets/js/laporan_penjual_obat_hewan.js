/**
 * Laporan Penjual Obat Hewan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    obatHewanTable = $('#obatHewanTable').DataTable({
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
        }
    });
    
    // Load semua data saat halaman pertama dibuka
    loadAllData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        
        if(currentData.tahun === '' && (currentData.kecamatan === 'semua' || currentData.kecamatan === '')) {
            loadAllData();
        } else if(currentData.tahun === '') {
            loadDataWithKecamatanOnly();
        } else {
            loadDataWithFilter();
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        
        currentData = {
            tahun: '',
            kecamatan: 'semua'
        };
        
        loadAllData();
    });
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun === '' && (currentData.kecamatan === 'semua' || currentData.kecamatan === '')) {
            loadAllData();
        } else if(currentData.tahun === '') {
            loadDataWithKecamatanOnly();
        } else {
            loadDataWithFilter();
        }
    });
});

var obatHewanTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua'
};

function exportWithParams(format) {
    var tahun = currentData.tahun || 'all';
    var kecamatan = currentData.kecamatan || 'semua';
    
    var url = base_url + 'laporan_penjual_obat_hewan/export_' + format;
    url += "?tahun=" + encodeURIComponent(tahun);
    url += "&kecamatan=" + encodeURIComponent(kecamatan);
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    var tableHtml = $('#obatHewanTable').clone();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Penjual Obat Hewan</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.nama-toko { font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('obatHewanTable').cloneNode(true);
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
        url: base_url + 'laporan_penjual_obat_hewan/get_all_data',
        type: "POST",
        dataType: "json",
        success: function(response) {
            $("#reportTitle").html('DATA PENJUAL OBAT HEWAN KOTA SURABAYA');
            $("#reportSubtitle").html('Seluruh Data');
            
            obatHewanTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var daganganText = item.dagangan || '-';
                    
                    obatHewanTable.row.add([
                        no,
                        '<span class="nama-toko">' + escapeHtml(item.nama_toko) + '</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.nib) || '-',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        daganganText,
                        escapeHtml(item.telp) || '-'
                    ]);
                    no++;
                });
                
                obatHewanTable.draw();
                $("#tableFooter").html('');
                
            } else {
                obatHewanTable.row.add(['-', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-']);
                obatHewanTable.draw();
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

function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_penjual_obat_hewan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            $("#reportTitle").html('DATA PENJUAL OBAT HEWAN KOTA SURABAYA TAHUN ' + tahun);
            $("#reportSubtitle").html(kecamatanText);
            
            obatHewanTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var daganganText = item.dagangan || '-';
                    
                    obatHewanTable.row.add([
                        no,
                        '<span class="nama-toko">' + escapeHtml(item.nama_toko) + '</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.nib) || '-',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        daganganText,
                        escapeHtml(item.telp) || '-'
                    ]);
                    no++;
                });
                
                obatHewanTable.draw();
                $("#tableFooter").html('');
                
            } else {
                obatHewanTable.row.add(['-', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-']);
                obatHewanTable.draw();
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

function loadDataWithKecamatanOnly() {
    var kecamatan = currentData.kecamatan;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_penjual_obat_hewan/get_data_by_kecamatan',
        type: "POST",
        data: {
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            $("#reportTitle").html('DATA PENJUAL OBAT HEWAN KOTA SURABAYA');
            $("#reportSubtitle").html(kecamatanText);
            
            obatHewanTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var daganganText = item.dagangan || '-';
                    
                    obatHewanTable.row.add([
                        no,
                        '<span class="nama-toko">' + escapeHtml(item.nama_toko) + '</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.nib) || '-',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        daganganText,
                        escapeHtml(item.telp) || '-'
                    ]);
                    no++;
                });
                
                obatHewanTable.draw();
                $("#tableFooter").html('');
                
            } else {
                obatHewanTable.row.add(['-', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-']);
                obatHewanTable.draw();
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

function escapeHtml(text) {
    if(!text) return '-';
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}