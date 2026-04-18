/**
 * Laporan Data Klinik Hewan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    klinikTable = $('#klinikTable').DataTable({
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
    
    // Load data awal saat halaman dimuat
    loadData();
    
    $("#btnFilter").click(function() {
        loadData();
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        loadData();
    });
    
    $("#refreshBtn").click(function() {
        loadData();
    });
});

var klinikTable = null;

function exportWithParams(format) {
    var tahun = $("#filterTahun").val() || '';
    var kecamatan = $("#filterKecamatan").val() || 'semua';
    
    var url = base_url + 'laporan_data_klinik_hewan/export_' + format;
    url += "?tahun=" + encodeURIComponent(tahun);
    url += "&kecamatan=" + encodeURIComponent(kecamatan);
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    var tableHtml = $('#klinikTable').clone();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Data Klinik Hewan</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.badge-sertifikat-ada { background-color: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.badge-sertifikat-tidak { background-color: #ffebee; color: #c62828; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('klinikTable').cloneNode(true);
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
    var kecamatan = $("#filterKecamatan").val();
    
    // Update title
    var tahunText = (tahun && tahun !== '') ? 'TAHUN ' + tahun : 'SEMUA TAHUN';
    var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
    $("#reportTitle").html('DATA KLINIK HEWAN KOTA SURABAYA');
    $("#reportSubtitle").html(kecamatanText + ' - ' + tahunText);
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_data_klinik_hewan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            klinikTable.clear().draw();
            
            if(response.status === 'success' && response.data && response.data.length > 0) {
                var no = 1;
                var totalDokter = 0;
                
                $.each(response.data, function(index, item) {
                    var sertifikatHtml = item.sertifikat_standar === 'Ada' 
                        ? '<span class="badge-sertifikat badge-sertifikat-ada">Ada</span>' 
                        : '<span class="badge-sertifikat badge-sertifikat-tidak">Tidak Ada</span>';
                    
                    klinikTable.row.add([
                        no,
                        '<span class="nama-klinik">' + escapeHtml(item.nama_klinik) + '</span>',
                        escapeHtml(item.nib) || '-',
                        sertifikatHtml,
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        '<span class="jumlah-dokter">' + formatNumber(item.jumlah_dokter || 0) + ' Dokter</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.no_wa) || '-'
                    ]);
                    totalDokter += parseInt(item.jumlah_dokter) || 0;
                    no++;
                });
                
                klinikTable.draw();
            } else {
                klinikTable.row.add([1, 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                klinikTable.draw();
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