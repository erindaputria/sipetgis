// ================ VARIABLES ================
let dataTable = null;
let deleteId = null;

// ================ EDIT DATA ================
function editData(id) {
    var btn = $('.btn-edit[data-id="' + id + '"]');
    
    if (btn.length > 0) {
        $('#edit_id').val(btn.data('id'));
        $('#edit_tanggal').val(btn.data('tanggal'));
        $('#edit_demplot').val(btn.data('demplot'));
        $('#edit_jenis').val(btn.data('jenis'));
        $('#edit_merk').val(btn.data('merk'));
        $('#edit_stok_awal').val(btn.data('stok_awal'));
        $('#edit_stok_masuk').val(btn.data('stok_masuk')); 
        $('#edit_stok_keluar').val(btn.data('stok_keluar'));
        $('#edit_keterangan').val(btn.data('keterangan'));
        
        $('#editModal').modal('show');
    } else {
        alert("Data tidak ditemukan");
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data stok pakan: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    window.location.href = base_url + "data_stok_pakan/hapus/" + id;
}

// ================ SHOW DETAIL ================
function showDetail(id) {
    $.ajax({
        url: base_url + 'data_stok_pakan/detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                $("#detailTitle").text('Detail Stok Pakan: ' + (data.jenis_pakan || '-') + ' - ' + (data.merk_pakan || '-'));
                $("#detailInfo").html('Tanggal: ' + formatDate(data.tanggal) + ' | Demplot: ' + (data.id_demplot || '-'));

                $("#detailStokInfo").html(
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Demplot</strong>NonNull<td>: <span class="demplot-info">Demplot ' + escapeHtml(data.id_demplot || '-') + '</span>NonNull<' +
                    '</tr>' +
                    '<tr><td width="35%"><strong>Jenis Pakan</strong>NonNull<td>: <span class="badge-jenis">' + escapeHtml(data.jenis_pakan || '-') + '</span>NonNull<' +
                    '</tr>' +
                    '<tr><td width="35%"><strong>Merk Pakan</strong>NonNull<td>: <span class="badge-merk">' + escapeHtml(data.merk_pakan || '-') + '</span>NonNull<' +
                    '</tr>' +
                    '<tr><td width="35%"><strong>Tanggal</strong>NonNull<td>: ' + formatDate(data.tanggal) + 'NonNull<' +
                    '</tr>' +
                    '<tr><td width="35%"><strong>Keterangan</strong>NonNull<td>: ' + escapeHtml(data.keterangan || '-') + 'NonNull<' +
                    '</tr>' +
                    '</table>'
                );

                var stokAwal = data.stok_awal || 0;
                var stokMasuk = data.stok_masuk || 0;
                var stokKeluar = data.stok_keluar || 0;
                var stokAkhir = data.stok_akhir || 0;
                var persenSisa = stokAwal > 0 ? (stokAkhir / stokAwal) * 100 : 0;

                $("#detailPerubahanInfo").html(
                    '<div class="row">' +
                    '<div class="col-md-3"><div class="card bg-light"><div class="card-body text-center"><span class="stat-label">Stok Awal</span><div class="stat-value" style="font-size: 1.5rem;">' + formatNumber(stokAwal) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-success text-white"><div class="card-body text-center"><span class="text-white">Stok Masuk</span><div class="fw-bold" style="font-size: 1.5rem;">+' + formatNumber(stokMasuk) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-danger text-white"><div class="card-body text-center"><span class="text-white">Stok Keluar</span><div class="fw-bold" style="font-size: 1.5rem;">-' + formatNumber(stokKeluar) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-warning"><div class="card-body text-center"><span>Stok Akhir</span><div class="fw-bold" style="font-size: 1.5rem;">' + formatNumber(stokAkhir) + ' kg</div></div></div></div>' +
                    '</div>' +
                    (stokAwal > 0 ? '<div class="mt-3"><strong>Persentase Sisa Stok:</strong><div class="stok-progress" style="height: 20px;"><div class="stok-progress-bar" style="width: ' + Math.min(persenSisa, 100) + '%; height: 20px;"></div></div><small class="text-muted">' + persenSisa.toFixed(1) + '% dari stok awal</small></div>' : '')
                );

                $("#detailKeteranganInfo").html('<p class="mb-0">' + escapeHtml(data.keterangan || '-') + '</p>');

                $("#detailSection").show();

                $("html, body").animate({ scrollTop: $("#detailSection").offset().top - 20 }, 500);
            } else {
                alert('Data tidak ditemukan');
            }
        },
        error: function() {
            alert('Gagal memuat detail data');
        }
    });
}

// ================ FILTER FUNCTIONS ================
function filterByPeriode(startDate, endDate, searchTerm) {
    $.ajax({
        url: base_url + 'data_stok_pakan/filter_by_periode',
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
    const table = $("#stokTable").DataTable();
    table.clear();
    
    if (data && data.length > 0) {
        let no = 1;
        data.forEach(function(item) {
            var stokAkhirHtml = '<span class="badge-akhir">' + formatNumber(item.stok_akhir || 0) + '</span>';
            if (item.stok_awal && item.stok_awal > 0) {
                var persen = (item.stok_akhir / item.stok_awal) * 100;
                stokAkhirHtml += '<div class="stok-progress"><div class="stok-progress-bar" style="width: ' + Math.min(persen, 100) + '%"></div></div>';
            }
            
            table.row.add([
                no++,
                formatDate(item.tanggal),
                '<span class="demplot-info">Demplot ' + escapeHtml(item.id_demplot || '-') + '</span>',
                '<span class="badge-jenis">' + escapeHtml(item.jenis_pakan || '-') + '</span>',
                '<span class="badge-merk">' + escapeHtml(item.merk_pakan || '-') + '</span>',
                '<span class="badge-stok">' + formatNumber(item.stok_awal || 0) + '</span>',
                '<span class="badge-masuk">+' + formatNumber(item.stok_masuk || 0) + '</span>',
                '<span class="badge-keluar">-' + formatNumber(item.stok_keluar || 0) + '</span>',
                stokAkhirHtml,
                '<small>' + escapeHtml((item.keterangan || '-').substring(0, 30)) + '</small>',
                formatActionButtons(item.id_stok, item.jenis_pakan || 'Stok Pakan')
            ]);
        });
    } else {
        table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
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

// Helper function to format number
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper function to format action buttons
function formatActionButtons(id, nama) {
    return '<div class="btn-action-group">' +
        '<button class="btn btn-action btn-edit" title="Edit" data-id="' + id + '" onclick="editData(' + id + ')"><i class="fas fa-edit"></i></button>' +
        '<button class="btn btn-action btn-delete" title="Hapus" data-id="' + id + '" data-nama="' + escapeHtml(nama) + '" onclick="confirmDelete(' + id + ', \'' + escapeHtml(nama) + '\')"><i class="fas fa-trash"></i></button>' +
        '</div>';
}

// Fungsi untuk load statistik
function loadStatistik() {
    $.ajax({
        url: base_url + 'data_stok_pakan/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalTransaksi').text(data.total_transaksi);
            $('#totalStokMasuk').text(data.total_stok_masuk);
            $('#totalStokKeluar').text(data.total_stok_keluar);
            $('#totalStokAkhir').text(data.total_stok_akhir);
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
    var tableData = [];
    var totalStokAwal = 0;
    var totalStokMasuk = 0;
    var totalStokKeluar = 0;
    var totalStokAkhir = 0;
    
    // Ambil semua baris dari DataTable yang sedang ditampilkan
    var table = $('#stokTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
    });
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        var stokAwal = parseInt(row[5]?.toString().replace(/\./g, '') || '0');
        var stokMasuk = parseInt(row[6]?.toString().replace(/\./g, '') || '0');
        var stokKeluar = parseInt(row[7]?.toString().replace(/\./g, '') || '0');
        var stokAkhir = parseInt(row[8]?.toString().replace(/\./g, '') || '0');
        
        totalStokAwal += stokAwal;
        totalStokMasuk += stokMasuk;
        totalStokKeluar += stokKeluar;
        totalStokAkhir += stokAkhir;
    }
    
    var totalData = tableData.length;
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Stok Pakan</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA STOK PAKAN</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data untuk Print
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Tanggal</th>');
    printWindow.document.write('<th>Demplot</th>');
    printWindow.document.write('<th>Jenis Pakan</th>');
    printWindow.document.write('<th>Merk</th>');
    printWindow.document.write('<th>Stok Awal (kg)</th>');
    printWindow.document.write('<th>Stok Masuk (kg)</th>');
    printWindow.document.write('<th>Stok Keluar (kg)</th>');
    printWindow.document.write('<th>Stok Akhir (kg)</th>');
    printWindow.document.write('<th>Keterangan</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[5] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[6] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[7] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[8] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[9] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Transaksi</strong></td>');
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
    dataTable = $("#stokTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            // {
            //     extend: "copy",
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            // {
            //     extend: "csv",
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] },
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
            { targets: [9], orderable: false },
            { targets: [10], orderable: false }
        ]
    });

    // Event listener untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        if (id) {
            editData(id);
        }
    });

    // Event listener untuk tombol hapus
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (id) {
            confirmDelete(id, nama);
        }
    });

    // Filter button event
    $("#filterBtn").click(function() {
        const jenisValue = $("#filterJenisPakan").val();
        const merkValue = $("#filterMerkPakan").val();
        const demplotValue = $("#filterDemplot").val();
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        
        let searchTerm = "";

        if (jenisValue !== "all") {
            searchTerm += jenisValue;
        }
        if (merkValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += merkValue;
        }
        if (demplotValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += "Demplot " + demplotValue;
        }

        if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
        } else {
            $("#stokTable").DataTable().search(searchTerm).draw();
        }
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterJenisPakan").val("all");
        $("#filterMerkPakan").val("all");
        $("#filterDemplot").val("all");
        $("#startDate").val(getFirstDayOfMonth());
        $("#endDate").val(getLastDayOfMonth());
        $("#stokTable").DataTable().search("").draw();
        loadStatistik();
    });

    // Close detail button event
    $("#closeDetailBtn").click(function() {
        $("#detailSection").hide();
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
            url: base_url + 'data_stok_pakan/update',
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