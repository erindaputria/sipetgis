/**
 * Laporan Vaksinasi Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#vaksinasiTable').DataTable({
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
        paging: false,
        info: false,
        language: {
            search: "Cari:",
            zeroRecords: "Tidak ada data ditemukan"
        }
    });
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.jenis_vaksin = $("#filterJenisVaksin").val();
        
        if(!currentData.tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        loadData();
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        $("#filterJenisVaksin").val('PMK');
        
        currentData = {
            tahun: '',
            kecamatan: 'semua',
            jenis_vaksin: 'PMK'
        };
        
        // Reset semua cell ke 0
        $("#vaksinasiTable tbody tr").each(function(index, row) {
            if($(row).hasClass('total-row-bottom')) return;
            var kecamatan = $(row).data('kecamatan');
            var baseUrl = base_url + 'laporan_vaksinasi/detail_kecamatan/' + encodeURIComponent(kecamatan) + "/";
            
            $(row).find("td:eq(2)").html('<a href="' + baseUrl + 'Sapi Potong" class="data-link" target="_blank">0</a>');
            $(row).find("td:eq(3)").html('<a href="' + baseUrl + 'Sapi Perah" class="data-link" target="_blank">0</a>');
            $(row).find("td:eq(4)").html('<a href="' + baseUrl + 'Kambing" class="data-link" target="_blank">0</a>');
            $(row).find("td:eq(5)").html('<a href="' + baseUrl + 'Domba" class="data-link" target="_blank">0</a>');
        });
        
        // Reset total row
        $("#vaksinasiTable tbody tr.total-row-bottom").remove();
        
        // Reset title
        $('#reportTitle').html('REKAP DATA VAKSIN PMK');
        $('#reportSubtitle').html('Kota Surabaya');
        
        // Reset header ke default PMK
        updateTableHeader(['Sapi Potong', 'Sapi Perah', 'Kambing', 'Domba']);
    });
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun) {
            loadData();
        } else {
            alert("Silakan pilih filter terlebih dahulu!");
        }
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua',
    jenis_vaksin: 'PMK'
};

function exportWithParams(format) {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var url = base_url + 'laporan_vaksinasi/export_' + format;
    url += "?tahun=" + currentData.tahun;
    url += "&bulan=";
    url += "&kecamatan=" + currentData.kecamatan;
    url += "&jenis_vaksin=" + currentData.jenis_vaksin;
    
    window.location.href = url;
}

function printWithCurrentData() {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Vaksinasi Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.kecamatan-cell { text-align: left; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.data-link { color: black !important; text-decoration: none !important; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('vaksinasiTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function updateTableHeader(columns) {
    var headerHtml = '<tr><th width="50">No</th><th>Kecamatan</th>';
    for(var i = 0; i < columns.length; i++) {
        headerHtml += '<th>' + columns[i] + '</th>';
    }
    headerHtml += '</tr>';
    $("#vaksinasiTable thead").html(headerHtml);
}

function loadData() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var jenisVaksin = currentData.jenis_vaksin;
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_vaksinasi/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            bulan: '',
            kecamatan: kecamatan,
            jenis_vaksin: jenisVaksin
        },
        dataType: "json",
        success: function(response) {
            var config = columnConfig[jenisVaksin] || columnConfig['PMK'];
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            
            $("#reportTitle").html(config.title + ' TAHUN ' + tahun);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText);
            
            updateTableHeader(config.columns);
            
            var dataMap = {};
            if(response.data && response.data.length > 0) {
                $.each(response.data, function(index, item) {
                    dataMap[item.kecamatan] = item;
                });
            }
            
            var totals = {};
            for(var i = 0; i < config.fields.length; i++) {
                totals[config.fields[i]] = 0;
            }
            
            // Update setiap baris
            $("#vaksinasiTable tbody tr").each(function(index, row) {
                if($(row).hasClass('total-row-bottom')) return;
                
                var kecamatanNama = $(row).data('kecamatan');
                var item = dataMap[kecamatanNama];
                var baseUrlDetail = base_url + 'laporan_vaksinasi/detail_kecamatan/' + encodeURIComponent(kecamatanNama) + "/";
                
                for(var i = 0; i < config.fields.length; i++) {
                    var field = config.fields[i];
                    var value = item ? parseInt(item[field]) || 0 : 0;
                    totals[field] += value;
                    
                    var columnName = config.columns[i];
                    var url = baseUrlDetail + encodeURIComponent(columnName) + "?tahun=" + tahun;
                    $(row).find("td:eq(" + (i + 2) + ")").html('<a href="'+ url +'" class="data-link" target="_blank">' + formatNumber(value) + '</a>');
                }
            });
            
            // Hapus baris total sebelumnya
            $("#vaksinasiTable tbody tr.total-row-bottom").remove();
            
            // Tambahkan baris total
            var totalRow = '<tr class="total-row-bottom" style="background-color: #fef3ef; font-weight: bold;">' +
                '<td colspan="2" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>';
            
            for(var i = 0; i < config.fields.length; i++) {
                totalRow += '<td><strong>' + formatNumber(totals[config.fields[i]]) + '</strong></td>';
            }
            totalRow += '</tr>';
            
            $("#vaksinasiTable tbody").append(totalRow);
            
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