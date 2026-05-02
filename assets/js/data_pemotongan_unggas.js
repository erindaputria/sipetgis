// ================ VARIABLES ================
let dataTable = null;
let deleteId = null;

// ================ EDIT DATA ================
function editData(id) {
    var btn = $('.btn-edit[data-id="' + id + '"]');
    
    if (btn.length > 0) {
        $('#edit_id').val(btn.data('id'));
        $('#edit_tanggal').val(btn.data('tanggal')); 
        $('#edit_rpu').val(btn.data('rpu'));
        $('#edit_ayam').val(btn.data('ayam'));
        $('#edit_itik').val(btn.data('itik'));
        $('#edit_dst').val(btn.data('dst'));
        $('#edit_daerah_asal').val(btn.data('daerah_asal'));
        $('#edit_petugas').val(btn.data('petugas'));
        $('#edit_keterangan').val(btn.data('keterangan'));
        
        $('#editModal').modal('show');
    } else {
        alert("Data tidak ditemukan");
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data pemotongan unggas: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    window.location.href = base_url + "data_pemotongan_unggas/hapus/" + id;
}

// ================ SHOW FOTO PREVIEW ================
function showFotoPreview(src) {
    $('#modalFoto').attr('src', src);
    $('#fotoModal').modal('show');
}

// ================ FILTER FUNCTIONS ================
function filterByPeriode(startDate, endDate, searchTerm) {
    $.ajax({
        url: base_url + 'data_pemotongan_unggas/filter_by_periode',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        dataType: 'json',
        success: function(response) {
            updateTableWithData(response.data, searchTerm);
        },
        error: function() {
            alert('Gagal memuat data filter');
        }
    });
}

function updateTableWithData(data, searchTerm) {
    const table = $("#pemotonganTable").DataTable();
    table.clear();
    
    if (data && data.length > 0) {
        let no = 1;
        data.forEach(function(item) {
            table.row.add([
                no++,
                formatDate(item.tanggal),
                '<span class="rpu-info">' + escapeHtml(item.nama_rpu || 'RPU ' + item.id_rpu) + '</span>',
                '<small>' + escapeHtml(item.komoditas_list || '-') + '</small>',
                '<span class="badge-ekor">' + (item.total_ekor || 0) + ' ekor</span>',
                '<span class="badge-berat">' + parseFloat(item.total_berat || 0).toFixed(2) + ' kg</span>',
                '<span class="badge-asal">' + escapeHtml(item.daerah_asal || '-') + '</span>',
                '<span class="badge-petugas">' + escapeHtml(item.nama_petugas || '-') + '</span>',
                formatFotoCell(item.foto_kegiatan),
                formatActionButtons(item.id_pemotongan, item.nama_rpu || 'RPU ' + item.id_rpu)
            ]);
        });
    } else {
        table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
    }
    
    table.draw();
    
    if (searchTerm) {
        table.search(searchTerm).draw();
    }
}

// Helper function to format date
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper function to format foto cell
function formatFotoCell(foto) {
    if (!foto) {
        return '<span class="text-muted">-</span>';
    }
    return '<img src="' + base_url + 'uploads/pemotongan_unggas/' + escapeHtml(foto) + '" alt="Foto" class="photo-thumbnail" onclick="showFotoPreview(this.src)">';
}

// Helper function to format action buttons (HANYA EDIT DAN HAPUS)
function formatActionButtons(id, nama) {
    return '<div class="btn-action-group">' +
        '<button class="btn btn-action btn-edit" title="Edit" data-id="' + id + '" onclick="editData(' + id + ')"><i class="fas fa-edit"></i></button>' +
        '<button class="btn btn-action btn-delete" title="Hapus" data-id="' + id + '" data-nama="' + escapeHtml(nama) + '" onclick="confirmDelete(' + id + ', \'' + escapeHtml(nama) + '\')"><i class="fas fa-trash"></i></button>' +
        '</div>';
}

// Fungsi untuk load statistik
function loadStatistik() {
    $.ajax({
        url: base_url + 'data_pemotongan_unggas/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalKegiatan').text(data.total_kegiatan);
            $('#totalEkor').text(data.total_ekor);
            $('#totalBerat').text(data.total_berat.toFixed(2));
            $('#totalRPU').text(data.total_rpu);
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

function getFirstDayOfMonth() {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    return firstDay.toISOString().split('T')[0];
}

function getLastDayOfMonth() {
    var date = new Date();
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    return lastDay.toISOString().split('T')[0];
}

// ================ FUNCTION PRINT RAPI (SAMA PERSIS PELAKU USAHA) ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var table = $('#pemotonganTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalEkor = 0;
    var totalBerat = 0;
    
    // Hitung total ekor dan berat
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        // Extract ekor dari kolom 4 (index 4)
        var ekorText = stripHtml(row[4] || '0');
        var ekorMatch = ekorText.match(/(\d+)/);
        if (ekorMatch) {
            totalEkor += parseInt(ekorMatch[0]) || 0;
        }
        
        // Extract berat dari kolom 5 (index 5)
        var beratText = stripHtml(row[5] || '0');
        var beratMatch = beratText.match(/([\d,]+\.?\d*)/);
        if (beratMatch) {
            totalBerat += parseFloat(beratMatch[0].replace(/,/g, '')) || 0;
        }
    }
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Pemotongan Unggas</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA PEMOTONGAN UNGGAS</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data untuk Print (SEMUA KOLOM)
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Tanggal</th>');
    printWindow.document.write('<th>RPU</th>');
    printWindow.document.write('<th>Komoditas</th>');
    printWindow.document.write('<th>Total Ekor</th>');
    printWindow.document.write('<th>Total Berat (kg)</th>');
    printWindow.document.write('<th>Daerah Asal</th>');
    printWindow.document.write('<th>Petugas</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        
        // Ekor (kolom index 4)
        var ekorText = stripHtml(row[4] || '0');
        var ekorMatch = ekorText.match(/(\d+)/);
        var ekor = ekorMatch ? ekorMatch[0] : '0';
        
        // Berat (kolom index 5)
        var beratText = stripHtml(row[5] || '0');
        var beratMatch = beratText.match(/([\d,]+\.?\d*)/);
        var berat = beratMatch ? beratMatch[0].replace(/,/g, '') : '0';
        
        printWindow.document.write('<td align="center">' + formatNumber(parseInt(ekor)) + ' Ekor' + '</td>');
        printWindow.document.write('<td align="center">' + formatNumber(parseFloat(berat)) + ' kg' + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[6] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[7] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalEkor) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalBerat) + ' kg</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalData) + ' Kegiatan</strong></td>');
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

// ================ DOCUMENT READY ================
$(document).ready(function() {
    // Initialize DataTable with custom buttons (SAMA PERSIS PELAKU USAHA)
    dataTable = $("#pemotonganTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            // {
            //     extend: "copy",
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            // {
            //     extend: "csv",
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
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
        pageLength: 15,
        lengthChange: false,
        responsive: true,
        order: [[1, 'desc']],
        columnDefs: [
            { targets: [8], orderable: false },
            { targets: [9], orderable: false }
        ]
    });

    // Event listener untuk tombol edit (delegasi)
    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        if (id) {
            editData(id);
        }
    });

    // Event listener untuk tombol hapus (delegasi)
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (id) {
            confirmDelete(id, nama);
        }
    });

    // Filter button event
    $("#filterBtn").click(function() {
        const rpuValue = $("#filterRPU").val();
        const petugasValue = $("#filterPetugas").val();
        const komoditasValue = $("#filterKomoditas").val();
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        
        let searchTerm = "";

        if (rpuValue !== "all") {
            searchTerm += "RPU " + rpuValue;
        }
        if (petugasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += petugasValue;
        }
        if (komoditasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += komoditasValue;
        }

        if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
        } else {
            $("#pemotonganTable").DataTable().search(searchTerm).draw();
        }
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterRPU").val("all");
        $("#filterPetugas").val("all");
        $("#filterKomoditas").val("all");
        $("#startDate").val(getFirstDayOfMonth());
        $("#endDate").val(getLastDayOfMonth());
        $("#pemotonganTable").DataTable().search("").draw();
        loadStatistik();
    });

    // Confirm delete button
    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });

    // Form edit submit
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: base_url + 'data_pemotongan_unggas/update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data berhasil diupdate');
                    location.reload();
                } else {
                    alert('Gagal mengupdate data: ' + (response.message || 'Unknown error'));
                }
            },
            error: function() {
                alert('Gagal mengupdate data');
            }
        });
    });

    loadStatistik();
});

// Base URL
var base_url = "<?= base_url() ?>";