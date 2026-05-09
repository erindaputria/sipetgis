var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

$(document).ready(function() {
    $("#komoditasTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4] },
                action: function(e, dt, button, config) {
                    window.location.href = base_url + "komoditas/export_excel";
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
            { width: "30%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "20%", targets: 4 },
            { width: "10%", targets: 5 }
        ]
    });

    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama').val($(this).data('nama'));
        $('#edit_jenis').val($(this).data('jenis'));
        $('#edit_satuan').val($(this).data('satuan'));
        $('#edit_jk').val($(this).data('jk'));
        $('#editDataModal').modal('show');
    });

    $(document).on("click", ".btn-delete", function(e) {
        e.preventDefault();
        
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        if (confirm("Apakah Anda yakin ingin menghapus data komoditas: " + nama + "?")) {
            
            var postData = {
                id: id,
                action: 'delete'
            };
            
            if (csrf_name && csrf_token) {
                postData[csrf_name] = csrf_token;
            } else {
                postData[$('meta[name="csrf-name"]').attr('content')] = $('meta[name="csrf-token"]').attr('content');
            }
            
            $.ajax({
                url: base_url + "komoditas/hapus_ajax",
                type: 'POST',
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-delete').prop('disabled', true);
                },
                success: function(res) {
                    if (res.status === 'success') {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message || 'Gagal menghapus data');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 403) {
                        alert('Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
                    } else if (xhr.status === 500) {
                        alert('Error server. Silakan coba lagi.');
                    } else {
                        alert('Gagal menghapus data. Error: ' + error);
                    }
                },
                complete: function() {
                    $('.btn-delete').prop('disabled', false);
                }
            });
        }
    });

    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var tableData = [];
    var totalData = 0;
    
    var table = $('#komoditasTable').DataTable();
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
    
    printWindow.document.write('<html><head><title>Laporan Komoditas</title>');
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
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA KOMODITAS</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table border="1" cellpadding="8" cellspacing="0" width="100%">');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama Komoditas</th>');
    printWindow.document.write('<th>Jenis Hewan</th>');
    printWindow.document.write('<th>Satuan</th>');
    printWindow.document.write('<th>Jenis Kelamin</th>');
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
        printWindow.document.write('<td align="center">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data Komoditas</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
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