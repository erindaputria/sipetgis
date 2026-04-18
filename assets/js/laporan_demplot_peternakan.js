/**
 * Laporan Demplot Peternakan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#demplotTable').DataTable({
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
    
    // Load data langsung saat halaman dibuka
    loadData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.demplot = $("#filterDemplot").val();
        loadData();
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('semua');
        $("#filterKecamatan").val('semua');
        $("#filterDemplot").val('semua');
        currentData.tahun = 'semua';
        currentData.kecamatan = 'semua';
        currentData.demplot = 'semua';
        loadData();
    });
    
    $("#refreshBtn").click(function() {
        loadData();
    });
});

var dataTable = null;
var currentData = {
    tahun: 'semua',
    kecamatan: 'semua',
    demplot: 'semua'
};

function exportWithParams(format) {
    var url = base_url + 'laporan_demplot_peternakan/export_' + format;
    url += "?tahun=" + encodeURIComponent(currentData.tahun);
    url += "&kecamatan=" + encodeURIComponent(currentData.kecamatan);
    url += "&demplot=" + encodeURIComponent(currentData.demplot);
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    var tableHtml = $('#demplotTable').clone();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Demplot Peternakan</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('td:first-child { text-align: center; }');
    printWindow.document.write('td:nth-child(2) { text-align: left; }');
    printWindow.document.write('.badge-jenis { background-color: #fef3ef; color: #832706; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.stok-pakan { background-color: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 12px; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('demplotTable').cloneNode(true);
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
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var demplot = currentData.demplot;
    
    // Update title
    var titleText = 'DATA DEMPLOT PETERNAKAN';
    if(tahun && tahun !== 'semua') {
        titleText += ' TAHUN ' + tahun;
    }
    $("#reportTitle").html(titleText);
    $("#reportSubtitle").html('Kota Surabaya');
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_demplot_peternakan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan,
            demplot: demplot
        },
        dataType: "json",
        success: function(response) {
            dataTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                var totalLuas = 0;
                var totalJumlah = 0;
                
                $.each(response.data, function(index, item) {
                    var detailUrl = base_url + 'laporan_demplot_peternakan/detail_demplot/' + encodeURIComponent(item.nama_demplot);
                    if(tahun && tahun !== 'semua') {
                        detailUrl += '?tahun=' + tahun;
                    }
                    
                    dataTable.row.add([
                        no,
                        '<a href="' + detailUrl + '" class="data-link" target="_blank">' + escapeHtml(item.nama_demplot) + '</a>',
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        '<span class="luas-cell">' + formatNumber(parseFloat(item.luas_m2 || 0)) + ' m²</span>',
                        '<span class="badge-jenis">' + escapeHtml(item.jenis_hewan) + '</span>',
                        '<span class="jumlah-cell">' + formatNumber(parseInt(item.jumlah_hewan || 0)) + ' ekor</span>',
                        '<span class="stok-pakan">' + escapeHtml(item.stok_pakan) + '</span>',
                        escapeHtml(item.keterangan) || '-'
                    ]);
                    
                    totalLuas += parseFloat(item.luas_m2 || 0);
                    totalJumlah += parseInt(item.jumlah_hewan || 0);
                    no++;
                });
                
                dataTable.draw();
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                dataTable.draw();
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