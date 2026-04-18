$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $("#jenisUsahaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5] },
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
                        text: 'LAPORAN DATA JENIS USAHA',
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
                                if (j === 4) {
                                    rows[i][j].alignment = 'left';
                                } else {
                                    rows[i][j].alignment = 'center';
                                }
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
                exportOptions: { columns: [0,1,2,3,4,5] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA JENIS USAHA</h2>' +
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
            { width: '200px', targets: 4 }
        ]
    });

    // Event untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama_peternak').val($(this).data('nama_peternak'));
        $('#edit_jenis_usaha').val($(this).data('jenis_usaha'));
        $('#edit_jumlah').val($(this).data('jumlah'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_kecamatan').val($(this).data('kecamatan'));
        $('#editDataModal').modal('show');
    });

    // Event untuk tombol hapus
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        if (confirm("Apakah Anda yakin ingin menghapus data jenis usaha: " + nama + "?")) {
            window.location.href = base_url + "jenis_usaha/hapus/" + id;
        }
    });

    // Validasi jumlah (tidak negatif)
    $("input[name='jumlah'], #edit_jumlah").on("input", function() {
        if ($(this).val() < 0) {
            $(this).val(0);
        }
    });

    // Auto close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

// Base URL untuk redirect
var base_url = "<?= base_url() ?>";