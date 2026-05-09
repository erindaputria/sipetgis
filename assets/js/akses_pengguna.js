/**
 * Master Akses Pengguna
 * SIPETGIS - Kota Surabaya
 */

// CSRF Token untuk AJAX
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

// Fungsi toggle password visibility
function togglePassword(inputId) {
    var input = document.getElementById(inputId);
    if (!input) return;
    
    var button = input.parentElement.querySelector('.password-toggle');
    if (!button) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.innerHTML = '<i class="fas fa-eye-slash"></i>';
    } else {
        input.type = 'password';
        button.innerHTML = '<i class="fas fa-eye"></i>';
    }
}

$(document).ready(function() {
    // Initialize DataTable (Hanya Excel & Print)
    var table = $("#aksesPenggunaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5] },
                action: function(e, dt, button, config) {
                    window.open(base_url + "akses_pengguna/export_excel", '_blank');
                }
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5] },
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
            { width: '5%', targets: 0 },
            { width: '15%', targets: 1 },
            { width: '15%', targets: 2 },
            { width: '15%', targets: 3 },
            { width: '20%', targets: 4 },
            { width: '10%', targets: 5 },
            { width: '15%', targets: 6 }
        ]
    });

    // Event untuk tombol lihat password
    $(document).on("click", ".btn-view", function() {
        var username = $(this).data('username');
        var password = $(this).data('password');
        
        $('#view_username').val(username);
        $('#view_password').val(password);
        $('#viewPasswordModal').modal('show');
    });

    // Event untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_username').val($(this).data('username'));
        $('#edit_level').val($(this).data('level'));
        $('#edit_telepon').val($(this).data('telepon'));
        $('#edit_kecamatan').val($(this).data('kecamatan'));
        
        var status = $(this).data('status');
        if (status === 'Nonaktif' || status === 'Non-Aktif') {
            $('#edit_status').val('Non-Aktif');
        } else {
            $('#edit_status').val('Aktif');
        }
        
        $('#edit_password').val('');
        $('#editDataModal').modal('show');
    });

    // ========== EVENT UNTUK TOMBOL HAPUS - DIPERBAIKI ==========
    $(document).on("click", ".btn-delete", function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var username = $(this).data('username');
        
        // Konfirmasi dengan SweetAlert atau confirm biasa
        if (confirm("Apakah Anda yakin ingin menghapus data pengguna: " + username + "?")) {
            
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
                url: base_url + "akses_pengguna/hapus",
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

    // Form validation untuk tambah data
    $('#formTambah').submit(function(e) {
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Password minimal 6 karakter');
            return false;
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
    
    var tableData = [];
    var totalData = 0;
    
    var table = $('#aksesPenggunaTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
    });
    
    totalData = tableData.length;
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Akses Pengguna</title>');
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
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA AKSES PENGGUNA</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Username</th>');
    printWindow.document.write('<th>Level</th>');
    printWindow.document.write('<th>Telepon</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Status</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Pengguna</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write(' nahil');
    
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

// Base URL untuk redirect - TETAP DIPERTAHANKAN
var base_url = "<?= base_url() ?>";