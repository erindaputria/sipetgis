/**
 * Master Kepemilikan Jenis Usaha
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Gunakan variable dari view
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
    
    // Initialize DataTable (Hanya Excel & Print)
    var table = $("#kepemilikanJenisUsahaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            // {
            //     extend: "copy",
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3,4,5,6] }
            // },
            // {
            //     extend: "csv",
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3,4,5,6] }
            // },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                action: function(e, dt, button, config) {
                    window.location.href = baseUrl + "kepemilikan_jenis_usaha/export_excel";
                }
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3,4,5,6] }
            // },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
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
        lengthChange: false,  // HILANGKAN DROPDOWN SHOW ENTRIES
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { width: '200px', targets: 5 }
        ]
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

// ========== FUNCTION PRINT ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var tableData = [];
    var totalData = 0;
    var totalJumlah = 0;
    
    // Ambil semua baris dari DataTable yang sedang ditampilkan
    var table = $('#kepemilikanJenisUsahaTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
        // Ambil jumlah (kolom ke-5 index 4)
        var jumlah = parseInt(stripHtml(rowData[4]).replace(/\./g, '')) || 0;
        totalJumlah += jumlah;
    });
    
    totalData = tableData.length;
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Kepemilikan Jenis Usaha</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #000000; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #000000; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #000000; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #832706; color: #000000; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.total-row td { color: #000000; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Header Laporan
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA KEPEMILIKAN JENIS USAHA</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>NIK</th>');
    printWindow.document.write('<th>Nama Pelaku Usaha</th>');
    printWindow.document.write('<th>Jenis Usaha</th>');
    printWindow.document.write('<th>Jumlah</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Alamat</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[4] || '0') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[6] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalJumlah) + '</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalData) + ' Data</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    // Footer Note
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('SIPETGIS - Sistem Informasi Peternakan Kota Surabaya');
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function formatNumber(num) {
    if (num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function stripHtml(html) {
    if (!html) return '-';
    var tmp = document.createElement('DIV');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '-';
}