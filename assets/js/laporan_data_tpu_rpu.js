/**
 * Laporan Data TPU/RPU
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#tpuRpuTable').DataTable({
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
    
    // Load semua data saat halaman pertama dibuka (tanpa filter tahun)
    loadAllData();
    
    $("#btnFilter").click(function() {
        var tahun = $("#filterTahun").val();
        if(tahun) {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        loadAllData();
    });
    
    $("#refreshBtn").click(function() {
        var tahun = $("#filterTahun").val();
        if(tahun) {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
});

var dataTable = null;

function exportWithParams(format) {
    var tahun = $("#filterTahun").val();
    var kecamatan = $("#filterKecamatan").val();
    
    var url = base_url + 'laporan_data_tpu_rpu/export_' + format;
    
    if(tahun) {
        url += "?tahun=" + encodeURIComponent(tahun);
        url += "&kecamatan=" + encodeURIComponent(kecamatan);
    } else {
        url += "?tahun=all";
        url += "&kecamatan=" + encodeURIComponent(kecamatan);
    }
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    var tableHtml = $('#tpuRpuTable').clone();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Data TPU/RPU</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.badge-izin { background-color: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.badge-juleha-ya { background-color: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.badge-juleha-tidak { background-color: #ffebee; color: #c62828; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('tpuRpuTable').cloneNode(true);
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
    $("#reportTitle").html('DATA TEMPAT PEMOTONGAN UNGGAS KOTA SURABAYA');
    $("#reportSubtitle").html('Seluruh Data');
    
    $("#loadingOverlay").fadeIn();
    
    // Gunakan get_data dengan tahun kosong untuk mengambil semua data
    $.ajax({
        url: base_url + 'laporan_data_tpu_rpu/get_data',
        type: "POST",
        data: {
            tahun: '',
            kecamatan: 'semua'
        },
        dataType: "json",
        success: function(response) {
            dataTable.clear().draw();
            
            if(response.status === 'success' && response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var kelasJuleha = (item.tersedia_juleha === 'Ya') ? 'badge-juleha-ya' : 'badge-juleha-tidak';
                    var teksJuleha = item.tersedia_juleha || 'Tidak';
                    
                    var htmlJumlah = '<span class="jumlah-pemotongan">Ayam: ' + formatNumber(item.jumlah_pemotongan.ayam) + 
                                        '<br>Itik: ' + formatNumber(item.jumlah_pemotongan.itik) + 
                                        '<br>Lainnya: ' + formatNumber(item.jumlah_pemotongan.lainnya) + '</span>';
                    
                    dataTable.row.add([
                        no,
                        '<span class="nama-tpu">' + escapeHtml(item.nama_tpu) + '</span>',
                        '<span class="badge-izin">' + escapeHtml(item.perizinan) + '</span>',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        escapeHtml(item.pj) || '-',
                        escapeHtml(item.no_telp) || '-',
                        htmlJumlah,
                        '<span class="' + kelasJuleha + '">' + teksJuleha + '</span>'
                    ]);
                    no++;
                });
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
            }
            
            dataTable.draw();
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
    var tahun = $("#filterTahun").val();
    var kecamatan = $("#filterKecamatan").val();
    
    if(!tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    // Update title
    var teksKecamatan = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
    $("#reportTitle").html('DATA TEMPAT PEMOTONGAN UNGGAS KOTA SURABAYA TAHUN ' + tahun);
    $("#reportSubtitle").html(teksKecamatan);
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_data_tpu_rpu/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            dataTable.clear().draw();
            
            if(response.status === 'success' && response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var kelasJuleha = (item.tersedia_juleha === 'Ya') ? 'badge-juleha-ya' : 'badge-juleha-tidak';
                    var teksJuleha = item.tersedia_juleha || 'Tidak';
                    
                    var htmlJumlah = '<span class="jumlah-pemotongan">Ayam: ' + formatNumber(item.jumlah_pemotongan.ayam) + 
                                        '<br>Itik: ' + formatNumber(item.jumlah_pemotongan.itik) + 
                                        '<br>Lainnya: ' + formatNumber(item.jumlah_pemotongan.lainnya) + '</span>';
                    
                    dataTable.row.add([
                        no,
                        '<span class="nama-tpu">' + escapeHtml(item.nama_tpu) + '</span>',
                        '<span class="badge-izin">' + escapeHtml(item.perizinan) + '</span>',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        escapeHtml(item.pj) || '-',
                        escapeHtml(item.no_telp) || '-',
                        htmlJumlah,
                        '<span class="' + kelasJuleha + '">' + teksJuleha + '</span>'
                    ]);
                    no++;
                });
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
            }
            
            dataTable.draw();
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