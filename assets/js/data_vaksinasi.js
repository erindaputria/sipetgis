var mainTable;
var detailTable;

$(document).ready(function () {
    // Inisialisasi DataTable utama
    mainTable = $('#dataVaksinasiTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA VAKSINASI TERNAK',
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
                    
                    if (doc.content[3] && doc.content[3].table) {
                        var rows = doc.content[3].table.body;
                        
                        for (var i = 0; i < rows[0].length; i++) {
                            rows[0][i].fillColor = '#832706';
                            rows[0][i].color = '#ffffff';
                            rows[0][i].bold = true;
                            rows[0][i].alignment = 'center';
                        }
                        
                        for (var i = 1; i < rows.length; i++) {
                            for (var j = 0; j < rows[i].length; j++) {
                                rows[i][j].alignment = 'center';
                                rows[i][j].color = '#333333';
                                rows[i][j].fontSize = 9;
                            }
                        }
                    }
                    
                    doc.pageMargins = [20, 60, 20, 40];
                    
                    var headerText = 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
                    doc.header = {
                        text: headerText,
                        alignment: 'center',
                        fontSize: 8,
                        color: '#666666',
                        margin: [20, 15, 20, 0]
                    };
                    
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
                extend: 'print',
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
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA VAKSINASI TERNAK</h2>' +
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
        responsive: true
    });

    // Event filter button - MENGGUNAKAN VARIABEL GLOBAL
    $("#filterBtn").click(function () {
        const komoditas = $("#filterKomoditas").val();
        
        $.ajax({
            url: ajaxFilterUrl,
            type: 'POST',
            data: { komoditas: komoditas },
            dataType: 'json',
            success: function(response) {
                if (mainTable) {
                    mainTable.destroy();
                }
                
                $('#dataVaksinasiTable tbody').empty();
                
                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        $('#dataVaksinasiTable tbody').append(`
                            <tr>
                                <td>${item.no}</td>
                                <td>${item.nama_kegiatan}</td>
                                <td>${item.tahun}</td>
                                <td>${item.jumlah_ternak.toLocaleString('id-ID')} <span class="text-muted">Ekor</span></td>
                                <td>
                                    <button class="btn btn-detail-custom btn-sm" onclick="showDetail('${item.jenis_vaksinasi}', '${item.tahun}', '${item.jumlah_ternak.toLocaleString('id-ID')}')">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $('#dataVaksinasiTable tbody').append('<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>');
                }
                
                mainTable = $('#dataVaksinasiTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i> Copy',
                            className: 'btn btn-sm btn-primary',
                            exportOptions: { columns: [0,1,2,3] }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            className: 'btn btn-sm btn-success',
                            exportOptions: { columns: [0,1,2,3] }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: 'btn btn-sm btn-success',
                            exportOptions: { columns: [0,1,2,3] }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            className: 'btn btn-sm btn-danger',
                            exportOptions: { columns: [0,1,2,3] },
                            customize: function(doc) {
                                doc.content.splice(0, 1);
                                
                                var currentDate = new Date();
                                var formattedDate = currentDate.toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                });
                                
                                doc.content.unshift({
                                    text: 'LAPORAN DATA VAKSINASI TERNAK',
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
                                
                                if (doc.content[3] && doc.content[3].table) {
                                    var rows = doc.content[3].table.body;
                                    
                                    for (var i = 0; i < rows[0].length; i++) {
                                        rows[0][i].fillColor = '#832706';
                                        rows[0][i].color = '#ffffff';
                                        rows[0][i].bold = true;
                                        rows[0][i].alignment = 'center';
                                    }
                                    
                                    for (var i = 1; i < rows.length; i++) {
                                        for (var j = 0; j < rows[i].length; j++) {
                                            rows[i][j].alignment = 'center';
                                            rows[i][j].color = '#333333';
                                            rows[i][j].fontSize = 9;
                                        }
                                    }
                                }
                                
                                doc.pageMargins = [20, 60, 20, 40];
                                
                                var headerText = 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
                                doc.header = {
                                    text: headerText,
                                    alignment: 'center',
                                    fontSize: 8,
                                    color: '#666666',
                                    margin: [20, 15, 20, 0]
                                };
                                
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
                            extend: 'print',
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
                                    '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA VAKSINASI TERNAK</h2>' +
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
                    responsive: true
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Gagal memuat data filter');
            }
        });
    });

    // Close detail button event
    $("#closeDetailBtn").click(function () {
        $("#detailSection").hide();
        if (detailTable) {
            detailTable.destroy();
        }
    });
});

// Function to show detail - MENGGUNAKAN VARIABEL GLOBAL
function showDetail(jenisVaksin, tahun, jumlah) {
    $("#detailInfo").html(`
        <span class="fw-bold">Nama Kegiatan:</span> ${jenisVaksin} (${tahun})<br>
        <span class="fw-bold">Total Ternak Divaksin:</span> ${jumlah} Ekor
    `);

    $.ajax({
        url: ajaxDetailUrl,
        type: 'POST',
        data: { jenis_vaksin: jenisVaksin, tahun: tahun },
        dataType: 'json',
        success: function(response) {
            if (detailTable) {
                detailTable.destroy();
            }
            
            const detailTableBody = $("#detailTableBody");
            detailTableBody.empty();
            
            if (response.length > 0) {
                $.each(response, function(index, item) {
                    detailTableBody.append(`
                        <tr>
                            <td>${item.no}</td>
                            <td>${item.nama_peternak}</td>
                            <td><span class="badge-ternak">${item.komoditas_ternak}</span></td>
                            <td>${item.kecamatan}</td>
                            <td>${item.jumlah} <span class="text-muted">Ekor</span></td>
                            <td>${item.tanggal_vaksinasi}</td>
                        </tr>
                    `);
                });
            } else {
                detailTableBody.append('<tr><td colspan="6" class="text-center">Tidak ada data detail</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>');
            }
            
            detailTable = $('#detailTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
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
                destroy: true
            });
            
            $("#detailSection").show();
            
            $("html, body").animate({
                scrollTop: $("#detailSection").offset().top - 20
            }, 500);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Gagal memuat data detail');
        }
    });
}