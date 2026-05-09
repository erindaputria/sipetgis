/**
 * Master Jenis Usaha
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    var baseUrl = BASE_URL;
    var csrfName = CSRF_NAME;
    var csrfToken = CSRF_HASH;
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#jenisUsahaTable')) {
        $('#jenisUsahaTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan buttons Excel & Print saja
    var table = $("#jenisUsahaTable").DataTable({
        dom: "<'row'<'col-sm-12'B>>" +
             "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            // {
            //     extend: "copy",
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1] }
            // },
            // {
            //     extend: "csv",
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1] }
            // },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1] },
                action: function(e, dt, button, config) {
                    window.location.href = baseUrl + "jenis_usaha/export_excel";
                }
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1] }
            // },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1] },
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
        lengthChange: false,
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

// ========== FUNCTION PRINT ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var tableData = [];
    var totalData = 0;
    
    // Ambil semua baris dari DataTable yang sedang ditampilkan
    var table = $('#jenisUsahaTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
    });
    
    totalData = tableData.length;
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Jenis Usaha</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA JENIS USAHA</h2>');
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
    printWindow.document.write('<th>Jenis Usaha</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="1" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Jenis Usaha</strong></td>');
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