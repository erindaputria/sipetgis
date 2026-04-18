// Base URL untuk AJAX
var base_url = window.location.origin + '/';

$(document).ready(function() {
    // Inisialisasi DataTable utama
    var table = $("#dataTernakTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3] },
                customize: function(doc) {
                    // Menghapus header default DataTables
                    doc.content.splice(0, 1);
                    
                    // Menambahkan judul laporan
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA KEPEMILIKAN TERNAK',
                        style: 'title',
                        alignment: 'center',
                        margin: [0, 0, 0, 5]
                    });
                    
                    doc.content.unshift({
                        text: 'DINAS PETERNAKAN KOTA SURABAYA',
                        style: 'subtitle',
                        alignment: 'center',
                        margin: [0, 0, 0, 3]
                    });
                    
                    doc.content.unshift({
                        text: 'PEMERINTAH KOTA SURABAYA',
                        style: 'header',
                        alignment: 'center',
                        margin: [0, 0, 0, 15]
                    });
                    
                    doc.content.push({
                        text: 'Tanggal Cetak: ' + formattedDate,
                        style: 'date',
                        alignment: 'center',
                        margin: [0, 15, 0, 0]
                    });
                    
                    // Styling tabel
                    if (doc.content[3] && doc.content[3].table) {
                        var rows = doc.content[3].table.body;
                        
                        // Header tabel
                        for (var i = 0; i < rows[0].length; i++) {
                            rows[0][i].fillColor = '#832706';
                            rows[0][i].color = '#ffffff';
                            rows[0][i].bold = true;
                            rows[0][i].alignment = 'center';
                        }
                        
                        // Styling body tabel
                        for (var i = 1; i < rows.length; i++) {
                            for (var j = 0; j < rows[i].length; j++) {
                                rows[i][j].alignment = 'center';
                                rows[i][j].color = '#333333';
                                rows[i][j].fontSize = 9;
                            }
                        }
                    }
                    
                    // Konfigurasi margin halaman
                    doc.pageMargins = [20, 60, 20, 40];
                    
                    // Header setiap halaman
                    var headerText = 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
                    doc.header = {
                        text: headerText,
                        alignment: 'center',
                        fontSize: 8,
                        color: '#666666',
                        margin: [20, 15, 20, 0]
                    };
                    
                    // Footer setiap halaman
                    doc.footer = function(currentPage, pageCount) {
                        return {
                            text: 'Halaman ' + currentPage + ' dari ' + pageCount,
                            alignment: 'center',
                            fontSize: 8,
                            color: '#666666',
                            margin: [20, 0, 20, 15]
                        };
                    };
                }
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA KEPEMILIKAN TERNAK</h2>' +
                        '<p style="margin: 0;">Dinas Peternakan Kota Surabaya</p>' +
                        '<p style="margin: 0;">Pemerintah Kota Surabaya</p>' +
                        '<hr style="margin: 15px 0;">' +
                        '<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>' +
                        '</div>'
                    );
                    $(win.document.body).append(
                        '<div style="text-align: center; margin-top: 30px; font-size: 10px; color: #666;">' +
                        'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya' +
                        '</div>'
                    );
                }
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50, 100],
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "35%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "25%", targets: 3 },
            { width: "15%", targets: 4 }
        ]
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
                    
                    // Re-initialize DataTable
                    $('#dataTernakTable').DataTable({
                        dom: "Bfrtip",
                        buttons: [
                            { extend: "copy", text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary', exportOptions: { columns: [0,1,2,3] } },
                            { extend: "csv", text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3] } },
                            { extend: "excel", text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3] } },
                            { extend: "pdf", text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger', exportOptions: { columns: [0,1,2,3] } },
                            { extend: "print", text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3] } }
                        ],
                        language: {
                            search: "Cari:",
                            lengthMenu: "Tampilkan _MENU_ data",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                            zeroRecords: "Tidak ada data yang ditemukan",
                            paginate: {
                                first: "Pertama",
                                last: "Terakhir",
                                next: "Berikutnya",
                                previous: "Sebelumnya"
                            }
                        },
                        pageLength: 10,
                        lengthChange: true,
                        lengthMenu: [5, 10, 25, 50, 100],
                        responsive: true,
                        order: [[0, 'asc']]
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

// Fungsi showDetail - Hanya SATU fungsi
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