$(document).ready(function() {
    var baseUrl = BASE_URL;
    var csrfName = CSRF_NAME;
    var csrfToken = CSRF_HASH;
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#jenisUsahaTable')) {
        $('#jenisUsahaTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan buttons di atas
    var table = $("#jenisUsahaTable").DataTable({
        dom: "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
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
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    });
                    doc.content.unshift({
                        text: 'DINAS PETERNAKAN KOTA SURABAYA',
                        alignment: 'center',
                        fontSize: 12,
                        margin: [0, 0, 0, 5]
                    });
                    doc.content.unshift({
                        text: 'PEMERINTAH KOTA SURABAYA',
                        alignment: 'center',
                        fontSize: 12,
                        margin: [0, 0, 0, 15]
                    });
                    doc.content.push({
                        text: 'Tanggal Cetak: ' + formattedDate,
                        alignment: 'center',
                        fontSize: 10,
                        margin: [0, 20, 0, 0]
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
                                rows[i][j].alignment = (j === 1) ? 'left' : 'center';
                                rows[i][j].color = '#333333';
                                rows[i][j].fontSize = 9;
                            }
                        }
                    }
                    
                    doc.pageMargins = [20, 60, 20, 40];
                    doc.header = {
                        text: 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya',
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
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706;">LAPORAN DATA JENIS USAHA</h2>' +
                        '<p>Dinas Peternakan Kota Surabaya</p>' +
                        '<p>Pemerintah Kota Surabaya</p>' +
                        '<hr>' +
                        '<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>' +
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
        order: [[0, 'asc']]
    });
    
    // ========== EDIT BUTTON ==========
    $(document).on("click", ".btn-edit", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var jenis_usaha = $(this).data('jenis_usaha');
        
        $('#edit_id').val(id);
        $('#edit_jenis_usaha').val(jenis_usaha);
        $('#editDataModal').modal('show');
    });
    
    // ========== DELETE BUTTON ==========
    $(document).on("click", ".btn-delete", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var jenis_usaha = $(this).data('jenis_usaha');
        
        if (confirm("Apakah Anda yakin ingin menghapus data jenis usaha: " + jenis_usaha + "?")) {
            window.location.href = baseUrl + "jenis_usaha/hapus/" + id;
        }
    });
    
    // ========== VALIDASI FORM TAMBAH ==========
    $('#formTambah').on('submit', function(e) {
        var jenisUsaha = $('input[name="jenis_usaha"]', this).val().trim();
        if (jenisUsaha === '') {
            e.preventDefault();
            alert('Jenis Usaha tidak boleh kosong!');
            return false;
        }
    });
    
    // ========== VALIDASI FORM EDIT ==========
    $('#formEdit').on('submit', function(e) {
        var jenisUsaha = $('#edit_jenis_usaha').val().trim();
        if (jenisUsaha === '') {
            e.preventDefault();
            alert('Jenis Usaha tidak boleh kosong!');
            return false;
        }
    });
    
    // ========== RESET FORM SAAT MODAL DITUTUP ==========
    $('#tambahDataModal').on('hidden.bs.modal', function() {
        $('#formTambah')[0].reset();
    });
    
    $('#editDataModal').on('hidden.bs.modal', function() {
        $('#formEdit')[0].reset();
    });
    
    // ========== AUTO CLOSE ALERTS ==========
    setTimeout(function() {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 3000);
    
    // ========== REFRESH CSRF TOKEN ==========
    $('#tambahDataModal, #editDataModal').on('hidden.bs.modal', function() {
        $.get(baseUrl + 'jenis_usaha/get_csrf', function(data) {
            if (data.csrf_token) {
                csrfToken = data.csrf_token;
                $('meta[name="csrf-token"]').attr('content', csrfToken);
                $('input[name="' + csrfName + '"]').val(csrfToken);
            }
        });
    });
});