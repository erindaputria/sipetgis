$(document).ready(function() {
    // Gunakan variable dari view (tanpa PHP)
    var baseUrl = BASE_URL;
    var csrfName = CSRF_NAME;
    var csrfToken = CSRF_HASH;
    
    // Initialize Select2
    $('#nik_select').select2({
        dropdownParent: $('#tambahDataModal'),
        theme: 'bootstrap-5',
        placeholder: '-- Ketik NIK atau Nama Pelaku Usaha (minimal 2 karakter) --',
        allowClear: true,
        minimumInputLength: 2,
        ajax: {
            url: baseUrl + 'kepemilikan_jenis_usaha/search_pelaku_usaha',
            dataType: 'json',
            type: 'GET',
            delay: 300,
            data: function(params) {
                var data = { q: params.term };
                data[csrfName] = csrfToken;
                return data;
            },
            processResults: function(data) {
                return { results: data.results };
            },
            cache: true
        },
        templateResult: function(data) {
            if (data.loading) return data.text;
            if (!data.nik) return data.text;
            return $('<div><strong>' + escapeHtml(data.nama) + '</strong><br><small>NIK: ' + escapeHtml(data.nik) + '</small></div>');
        },
        templateSelection: function(data) {
            if (!data.nik) return data.text;
            return data.nama + ' - ' + data.nik;
        }
    });
    
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    $('#nik_select').on('change', function() {
        var selectedData = $(this).select2('data')[0];
        if (selectedData && selectedData.nik) {
            $('#nama_peternak').val(selectedData.nama);
            $('#btnSimpan').prop('disabled', false);
        } else {
            $('#nama_peternak').val('');
            $('#btnSimpan').prop('disabled', true);
        }
    });
    
    $('#btnSimpan').prop('disabled', true);
    
    $('#tambahDataModal').on('hidden.bs.modal', function() {
        $('#formTambah')[0].reset();
        $('#nik_select').val(null).trigger('change');
        $('#btnSimpan').prop('disabled', true);
        $('#nik_select').empty().trigger('change');
        
        $.get(baseUrl + 'kepemilikan_jenis_usaha/get_csrf', function(data) {
            if (data.csrf_token) {
                csrfToken = data.csrf_token;
                $('meta[name="csrf-token"]').attr('content', csrfToken);
                $('input[name="' + csrfName + '"]').val(csrfToken);
            }
        });
    });
    
    // Initialize DataTable
    var table = $("#kepemilikanJenisUsahaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            { extend: "copy", text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: "csv", text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: "excel", text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { 
                extend: "pdf", text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger', 
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    doc.content.unshift({ text: 'LAPORAN DATA KEPEMILIKAN JENIS USAHA', style: 'title', alignment: 'center', margin: [0,0,0,5] });
                    doc.content.unshift({ text: 'DINAS PETERNAKAN KOTA SURABAYA', style: 'subtitle', alignment: 'center', margin: [0,0,0,3] });
                    doc.content.unshift({ text: 'PEMERINTAH KOTA SURABAYA', style: 'header', alignment: 'center', margin: [0,0,0,15] });
                    doc.content.push({ text: 'Tanggal Cetak: ' + formattedDate, style: 'date', alignment: 'center', margin: [0,15,0,0] });
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
                                rows[i][j].alignment = (j === 5) ? 'left' : 'center';
                                rows[i][j].color = '#333333';
                                rows[i][j].fontSize = 9;
                            }
                        }
                    }
                    doc.pageMargins = [20, 60, 20, 40];
                    doc.header = { text: 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya', alignment: 'center', fontSize: 8, color: '#666666', margin: [20,15,20,0] };
                    doc.footer = function(currentPage, pageCount) {
                        return { text: 'Halaman ' + currentPage + ' dari ' + pageCount, alignment: 'center', fontSize: 8, color: '#666666', margin: [20,0,20,15] };
                    };
                }
            },
            { 
                extend: "print", text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', 
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({ 'background-color': '#832706', 'color': 'white', 'padding': '10px' });
                    $(win.document.body).prepend('<div style="text-align:center;margin-bottom:20px;"><h2 style="color:#832706;">LAPORAN DATA KEPEMILIKAN JENIS USAHA</h2><p>Dinas Peternakan Kota Surabaya</p><hr><p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p></div>');
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
            paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
        },
        pageLength: 10,
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50, 100],
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [{ width: '200px', targets: 5 }]
    });
    
    // Edit button
    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nik').val($(this).data('nik'));
        $('#edit_nama_peternak').val($(this).data('nama_peternak'));
        $('#edit_jenis_usaha').val($(this).data('jenis_usaha'));
        $('#edit_jumlah').val($(this).data('jumlah'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_kecamatan').val($(this).data('kecamatan'));
        $('#edit_kelurahan').val($(this).data('kelurahan'));
        $('#edit_rw').val($(this).data('rw'));
        $('#edit_rt').val($(this).data('rt'));
        $('#edit_gis_lat').val($(this).data('gis_lat'));
        $('#edit_gis_long').val($(this).data('gis_long'));
        $('#editDataModal').modal('show');
    });
    
    // Delete button
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (confirm("Apakah Anda yakin ingin menghapus data kepemilikan jenis usaha: " + nama + "?")) {
            window.location.href = baseUrl + "kepemilikan_jenis_usaha/hapus/" + id;
        }
    });
    
    // Validate jumlah
    $("input[name='jumlah'], #edit_jumlah").on("input", function() {
        if ($(this).val() < 0) $(this).val(0);
    });
    
    // Auto close alerts
    setTimeout(function() { $('.alert').alert('close'); }, 5000);
});