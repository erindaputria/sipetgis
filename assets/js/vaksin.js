/**
 * Master Vaksin
 * SIPETGIS - Kota Surabaya
 */

// CSRF Token untuk AJAX
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

$(document).ready(function() {
    // Initialize DataTable (Hanya Excel & Print)
    $("#vaksinTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4] },
                action: function(e, dt, button, config) {
                    window.location.href = base_url + "vaksin/export_excel";
                }
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4] },
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
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "35%", targets: 1 },
            { width: "10%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "15%", targets: 5 }
        ]
    });

    // Event untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_jenis').val($(this).data('jenis'));
        $('#edit_tahun').val($(this).data('tahun'));
        $('#edit_status').val($(this).data('status'));
        $('#edit_bantuan').val($(this).data('bantuan'));
        $('#editDataModal').modal('show');
    });

    // ========== EVENT UNTUK TOMBOL HAPUS - SAMA SEPERTI AKSES PENGGUNA ==========
    $(document).on("click", ".btn-delete", function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var jenis = $(this).data('jenis');
        
        // Konfirmasi dengan confirm biasa
        if (confirm("Apakah Anda yakin ingin menghapus data vaksin: " + jenis + "?")) {
            
            // Siapkan data yang akan dikirim termasuk CSRF token
            var postData = {
                id: id,
                action: 'delete'
            };
            
            // Tambahkan CSRF token ke data yang dikirim
            if (csrf_name && csrf_token) {
                postData[csrf_name] = csrf_token;
            } else {
                // Alternatif: ambil dari meta tag
                postData[$('meta[name="csrf-name"]').attr('content')] = $('meta[name="csrf-token"]').attr('content');
            }
            
            console.log('Mengirim data:', postData);
            
            $.ajax({
                url: base_url + "vaksin/hapus_ajax",
                type: 'POST',
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    // Tampilkan loading state jika perlu
                    $('.btn-delete').prop('disabled', true);
                },
                success: function(res) {
                    console.log('Response:', res);
                    
                    if (res.status === 'success') {
                        alert(res.message);
                        // Refresh halaman setelah sukses
                        location.reload();
                    } else {
                        alert(res.message || 'Gagal menghapus data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error detail:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    // Tampilkan pesan error yang lebih informatif
                    if (xhr.status === 403) {
                        alert('Error 403: Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
                    } else if (xhr.status === 500) {
                        alert('Error server (500). Silakan coba lagi atau hubungi administrator.');
                    } else {
                        alert('Gagal menghapus data. Error: ' + error + '\nStatus: ' + xhr.status);
                    }
                },
                complete: function() {
                    $('.btn-delete').prop('disabled', false);
                }
            });
        }
    });

    // Auto close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

// ========== FUNCTION PRINT ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var tableData = [];
    var totalData = 0;
    
    // Ambil semua baris dari DataTable yang sedang ditampilkan
    var table = $('#vaksinTable').DataTable();
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
    
    printWindow.document.write('<html><head><title>Laporan Vaksin</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #000000; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #000000; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #000000; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.total-row td { color: #000000; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Header Laporan
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA VAKSIN</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data
    printWindow.document.write('<table border="1" cellpadding="8" cellspacing="0" width="100%">');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Jenis Vaksin</th>');
    printWindow.document.write('<th>Tahun</th>');
    printWindow.document.write('<th>Status Perolehan</th>');
    printWindow.document.write('<th>Bantuan Prov</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data Vaksin</strong></td>');
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

// Base URL untuk redirect
var base_url = "<?= base_url() ?>";