// ================ BASE URL ================
var base_url = window.base_url || "";

// ================ VARIABLES ================
var dataTable = null;
var deleteId = null;
var deleteNama = null;
var allData = [];

// CSRF Token
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#stokTable tbody").html('<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...<\/td><\/tr>');

    $.ajax({
        url: base_url + 'index.php/Data_stok_pakan/get_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.length > 0) {
                allData = response;
                console.log('Total data dimuat:', allData.length);
                updateFilterOptions();
                renderTable(allData);
            } else {
                allData = [];
                console.log('Tidak ada data dari server');
                renderTable([]);
            }
            loadStatistik();
        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
            allData = [];
            renderTable([]);
        }
    });
}

// ================ DESTROY DATATABLE DENGAN AMAN ================
function safeDestroyDataTable() {
    if (dataTable !== null) {
        try {
            if ($.fn.DataTable.isDataTable("#stokTable")) {
                dataTable.destroy();
                dataTable = null;
            }
        } catch(e) {
            console.log('Error destroying table:', e);
            dataTable = null;
        }
    }
    
    // Bersihkan tbody
    $("#stokTable tbody").empty();
}

// ================ RENDER TABLE (DIPERBAIKI TOTAL) ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    // Destroy DataTable dengan aman
    safeDestroyDataTable();
    
    // Kosongkan tbody
    $("#stokTable tbody").empty();
    
    // Jika data kosong, tampilkan pesan dan inisialisasi DataTable kosong
    if (!data || data.length === 0) {
        $("#stokTable tbody").html('<tr><td colspan="11" class="text-center py-5"><i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>Tidak ada data stok pakan</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>');
        
        // Inisialisasi DataTable untuk data kosong
        dataTable = $("#stokTable").DataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excel",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-sm btn-success',
                    exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
                },
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
                searchPlaceholder: "Ketik kata kunci...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                zeroRecords: "Tidak ada data yang ditemukan",
                paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
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
        return;
    }
    
    // Build HTML untuk data yang ada
    var html = "";
    for (var idx = 0; idx < data.length; idx++) {
        var item = data[idx];
        var no = idx + 1;
        
        var stokAkhirHtml = '<span class="badge-akhir">' + formatNumber(item.stok_akhir || 0) + '</span>';
        if (item.stok_awal && item.stok_awal > 0) {
            var persen = (item.stok_akhir / item.stok_awal) * 100;
            stokAkhirHtml += '<div class="stok-progress"><div class="stok-progress-bar" style="width: ' + Math.min(persen, 100) + '%"></div></div>';
        }
        
        html += '<tr>' +
            '<td class="text-center">' + no + '</td>' +
            '<td>' + formatDate(item.tanggal) + '</td>' +
            '<td><span class="demplot-info">Demplot ' + escapeHtml(String(item.id_demplot || '-')) + '</span></td>' +
            '<td><span class="badge-jenis">' + escapeHtml(String(item.jenis_pakan || '-')) + '</span></td>' +
            '<td><span class="badge-merk">' + escapeHtml(String(item.merk_pakan || '-')) + '</span></td>' +
            '<td class="text-center"><span class="badge-stok">' + formatNumber(item.stok_awal || 0) + '</span></td>' +
            '<td class="text-center"><span class="badge-masuk">+' + formatNumber(item.stok_masuk || 0) + '</span></td>' +
            '<td class="text-center"><span class="badge-keluar">-' + formatNumber(item.stok_keluar || 0) + '</span></td>' +
            '<td class="text-center">' + stokAkhirHtml + '</td>' +
            '<td><small>' + escapeHtml(String(item.keterangan || '-').substring(0, 30)) + '</small></td>' +
            '<td class="text-center">' +
            '<div class="btn-action-group">' +
            '<button class="btn btn-action btn-edit" data-id="' + item.id_stok + '" data-tanggal="' + item.tanggal + '" data-demplot="' + item.id_demplot + '" data-jenis="' + escapeForAttribute(String(item.jenis_pakan || '')) + '" data-merk="' + escapeForAttribute(String(item.merk_pakan || '')) + '" data-stok_awal="' + (item.stok_awal || 0) + '" data-stok_masuk="' + (item.stok_masuk || 0) + '" data-stok_keluar="' + (item.stok_keluar || 0) + '" data-keterangan="' + escapeForAttribute(String(item.keterangan || '')) + '" title="Edit"><i class="fas fa-edit"></i></button>' +
            '<button class="btn btn-action btn-delete" data-id="' + item.id_stok + '" data-nama="' + escapeForAttribute(String(item.jenis_pakan || 'Stok Pakan')) + '" title="Hapus"><i class="fas fa-trash"></i></button>' +
            '</div>' +
            '</td>' +
            '</tr>';
    }
    
    $("#stokTable tbody").html(html);
    
    // Inisialisasi DataTable baru
    dataTable = $("#stokTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
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
            searchPlaceholder: "Ketik kata kunci...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
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
    
    console.log('Table rendered successfully');
}

// ================ EDIT DATA ================
function editData(id) {
    $.ajax({
        url: base_url + 'index.php/Data_stok_pakan/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.status === 'success' && response.data) {
                var d = response.data;
                $('#edit_id').val(d.id_stok);
                $('#edit_tanggal').val(d.tanggal);
                $('#edit_demplot').val(d.id_demplot);
                $('#edit_jenis').val(d.jenis_pakan);
                $('#edit_merk').val(d.merk_pakan);
                $('#edit_stok_awal').val(d.stok_awal);
                $('#edit_stok_masuk').val(d.stok_masuk);
                $('#edit_stok_keluar').val(d.stok_keluar);
                $('#edit_keterangan').val(d.keterangan);
                $('#editModal').modal('show');
            } else {
                alert('Data tidak ditemukan');
            }
        },
        error: function() {
            alert('Gagal mengambil data');
        }
    });
}

// ================ UPDATE DATA ================
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    
    var formData = $(this).serializeArray();
    var postData = {};
    
    $.each(formData, function(i, field) {
        postData[field.name] = field.value;
    });
    postData.action = 'update';
    
    if (csrf_name && csrf_token) {
        postData[csrf_name] = csrf_token;
    }
    
    $('.btn-save-edit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
    
    $.ajax({
        url: base_url + 'index.php/Data_stok_pakan/update',
        type: 'POST',
        data: postData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#editModal').modal('hide');
                alert('Data berhasil diupdate');
                loadDataFromServer();
            } else {
                alert(response.message || 'Gagal update data');
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 403) {
                alert('Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
            } else if (xhr.status === 500) {
                alert('Error server. Silakan coba lagi.');
            } else {
                alert('Gagal menyimpan perubahan. Silakan coba lagi.');
            }
        },
        complete: function() {
            $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
        }
    });
});

// ================ DELETE DATA ================
$(document).on("click", ".btn-delete", function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    
    if (confirm("Apakah Anda yakin ingin menghapus data stok pakan: " + nama + "?")) {
        
        var postData = {
            id: id,
            action: 'delete'
        };
        
        if (csrf_name && csrf_token) {
            postData[csrf_name] = csrf_token;
        }
        
        $.ajax({
            url: base_url + "index.php/Data_stok_pakan/hapus_ajax",
            type: 'POST',
            data: postData,
            dataType: 'json',
            beforeSend: function() {
                $('.btn-delete').prop('disabled', true);
            },
            success: function(res) {
                if (res.status === 'success') {
                    alert(res.message);
                    loadDataFromServer();
                } else {
                    alert(res.message || 'Gagal menghapus data');
                }
            },
            error: function(xhr, status, error) {
                alert('Gagal menghapus data. Error: ' + error);
            },
            complete: function() {
                $('.btn-delete').prop('disabled', false);
            }
        });
    }
});

// ================ EDIT DATA BUTTON EVENT ================
$(document).on("click", ".btn-edit", function() {
    var id = $(this).data('id');
    if (id) {
        editData(id);
    }
});

// ================ FUNGSI FILTER ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    
    var jenisPakan = $("#filterJenisPakan").val();
    var merkPakan = $("#filterMerkPakan").val();
    var demplot = $("#filterDemplot").val();
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    
    console.log('Filter values - Jenis:', jenisPakan, 'Merk:', merkPakan, 'Demplot:', demplot, 'Tanggal:', startDate, '-', endDate);
    console.log('Total data sebelum filter:', allData.length);
    
    var filteredData = [];
    
    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchJenis = true;
        var matchMerk = true;
        var matchDemplot = true;
        var matchTanggal = true;
        
        // Filter Jenis Pakan
        if (jenisPakan !== "all" && jenisPakan !== "") {
            matchJenis = (item.jenis_pakan && item.jenis_pakan === jenisPakan);
        }
        
        // Filter Merk Pakan
        if (merkPakan !== "all" && merkPakan !== "") {
            matchMerk = (item.merk_pakan && item.merk_pakan === merkPakan);
        }
        
        // Filter Demplot
        if (demplot !== "all" && demplot !== "") {
            matchDemplot = (item.id_demplot && item.id_demplot == demplot);
        }
        
        // Filter Periode
        if (startDate && endDate) {
            if (item.tanggal) {
                matchTanggal = (item.tanggal >= startDate && item.tanggal <= endDate);
            } else {
                matchTanggal = false;
            }
        }
        
        if (matchJenis && matchMerk && matchDemplot && matchTanggal) {
            filteredData.push(item);
        }
    }
    
    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    renderTable(filteredData);
}

// ================ RESET FILTER ================
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');
    
    $("#filterJenisPakan").val("all");
    $("#filterMerkPakan").val("all");
    $("#filterDemplot").val("all");
    $("#startDate").val(getFirstDayOfMonth());
    $("#endDate").val(getLastDayOfMonth());
    
    renderTable(allData);
    
    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
}

// ================ UPDATE FILTER OPTIONS ================
function updateFilterOptions() {
    console.log('Updating filter options from data...');
    
    var jenisPakanSet = new Set();
    var merkPakanSet = new Set();
    var demplotSet = new Set();

    allData.forEach(function(item) {
        if (item.jenis_pakan && item.jenis_pakan.trim() !== '') {
            jenisPakanSet.add(item.jenis_pakan.trim());
        }
        if (item.merk_pakan && item.merk_pakan.trim() !== '') {
            merkPakanSet.add(item.merk_pakan.trim());
        }
        if (item.id_demplot && item.id_demplot !== '' && item.id_demplot !== null) {
            demplotSet.add(item.id_demplot);
        }
    });

    // Update filter Jenis Pakan
    var jenisOptions = '<option selected value="all">Semua Jenis</option>';
    var sortedJenis = Array.from(jenisPakanSet).sort();
    for (var i = 0; i < sortedJenis.length; i++) {
        jenisOptions += '<option value="' + escapeHtml(sortedJenis[i]) + '">' + escapeHtml(sortedJenis[i]) + '</option>';
    }
    $("#filterJenisPakan").html(jenisOptions);

    // Update filter Merk Pakan
    var merkOptions = '<option selected value="all">Semua Merk</option>';
    var sortedMerk = Array.from(merkPakanSet).sort();
    for (var i = 0; i < sortedMerk.length; i++) {
        merkOptions += '<option value="' + escapeHtml(sortedMerk[i]) + '">' + escapeHtml(sortedMerk[i]) + '</option>';
    }
    $("#filterMerkPakan").html(merkOptions);

    // Update filter Demplot 
    var demplotOptions = '<option selected value="all">Semua Demplot</option>';
    var sortedDemplot = Array.from(demplotSet).sort();
    for (var i = 0; i < sortedDemplot.length; i++) {
        demplotOptions += '<option value="' + sortedDemplot[i] + '">Demplot ' + sortedDemplot[i] + '</option>';
    }
    $("#filterDemplot").html(demplotOptions);

    console.log('Filter options updated');
}

// ================ LOAD STATISTIK ================
function loadStatistik() {
    $.ajax({
        url: base_url + 'index.php/Data_stok_pakan/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Statistik elements (if exist)
            if ($('#totalTransaksi').length) $('#totalTransaksi').text(formatNumber(data.total_transaksi || 0));
            if ($('#totalStokMasuk').length) $('#totalStokMasuk').text(formatNumber(data.total_stok_masuk || 0));
            if ($('#totalStokKeluar').length) $('#totalStokKeluar').text(formatNumber(data.total_stok_keluar || 0));
            if ($('#totalStokAkhir').length) $('#totalStokAkhir').text(formatNumber(data.total_stok_akhir || 0));
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

// ================ HELPER FUNCTIONS ================
function escapeForAttribute(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/'/g, "\\'")
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
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

function formatDate(dateString) {
    if (!dateString) return '-';
    var date = new Date(dateString);
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var year = date.getFullYear();
    return day + '-' + month + '-' + year;
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

// ================ FUNCTION PRINT ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    if (!printWindow) {
        alert("Mohon izinkan pop-up window untuk mencetak!");
        return;
    }
    
    var table = $('#stokTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalStokAwal = 0;
    var totalStokMasuk = 0;
    var totalStokKeluar = 0;
    var totalStokAkhir = 0;
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var stokAwal = parseInt(stripHtml(row[5] || '0').replace(/\./g, '')) || 0;
        var stokMasuk = parseInt(stripHtml(row[6] || '0').replace(/\./g, '')) || 0;
        var stokKeluar = parseInt(stripHtml(row[7] || '0').replace(/\./g, '')) || 0;
        var stokAkhir = parseInt(stripHtml(row[8] || '0').replace(/\./g, '')) || 0;
        
        totalStokAwal += stokAwal;
        totalStokMasuk += stokMasuk;
        totalStokKeluar += stokKeluar;
        totalStokAkhir += stokAkhir;
    }
    
    var totalData = rows.length;
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
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA STOK PAKAN</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th>No</th>');
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
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="right">' + stripHtml(row[5] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="right">' + stripHtml(row[6] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="right">' + stripHtml(row[7] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td align="right">' + stripHtml(row[8] || '0') + ' kg' + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[9] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL</strong></td>');
    printWindow.document.write('<td align="right"><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>');
    printWindow.document.write('<td align="right"><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>');
    printWindow.document.write('<td align="right"><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>');
    printWindow.document.write('<td align="right"><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + totalData + ' Transaksi</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
    printWindow.document.write('Surabaya, ' + formattedDateTime);
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    
    setTimeout(function() {
        printWindow.print();
        printWindow.close();
    }, 500);
}

// ================ SHOW DETAIL ================
function showDetail(id) {
    $.ajax({
        url: base_url + 'index.php/Data_stok_pakan/detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                var data = response.data;
                
                $("#detailTitle").text('Detail Stok Pakan: ' + (data.jenis_pakan || '-') + ' - ' + (data.merk_pakan || '-'));
                $("#detailInfo").html('Tanggal: ' + formatDate(data.tanggal) + ' | Demplot: ' + (data.id_demplot || '-'));

                $("#detailStokInfo").html(
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Demplot</strong>NonNull<td>:</td><td><span class="demplot-info">Demplot ' + escapeHtml(String(data.id_demplot || '-')) + '</span></td>' +
                    '</tr>' +
                    '<tr><td><strong>Jenis Pakan</strong>NonNull<td>:</td><td><span class="badge-jenis">' + escapeHtml(String(data.jenis_pakan || '-')) + '</span></td>' +
                    '</tr>' +
                    '<tr><td><strong>Merk Pakan</strong>NonNull<td>:</td><td><span class="badge-merk">' + escapeHtml(String(data.merk_pakan || '-')) + '</span></td>' +
                    '</tr>' +
                    '<tr><td><strong>Tanggal</strong>NonNull<td>:</td><td>' + formatDate(data.tanggal) + '</td>' +
                    '</tr>' +
                    '<tr><td><strong>Keterangan</strong>NonNull<td>:</td><td>' + escapeHtml(String(data.keterangan || '-')) + '</td>' +
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
                    '<div class="col-md-3"><div class="card bg-light"><div class="card-body text-center"><span>Stok Awal</span><div style="font-size: 1.5rem; font-weight: bold;">' + formatNumber(stokAwal) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-success text-white"><div class="card-body text-center"><span class="text-white">Stok Masuk</span><div style="font-size: 1.5rem; font-weight: bold;">+' + formatNumber(stokMasuk) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-danger text-white"><div class="card-body text-center"><span class="text-white">Stok Keluar</span><div style="font-size: 1.5rem; font-weight: bold;">-' + formatNumber(stokKeluar) + ' kg</div></div></div></div>' +
                    '<div class="col-md-3"><div class="card bg-warning"><div class="card-body text-center"><span>Stok Akhir</span><div style="font-size: 1.5rem; font-weight: bold;">' + formatNumber(stokAkhir) + ' kg</div></div></div></div>' +
                    '</div>' +
                    (stokAwal > 0 ? '<div class="mt-3"><strong>Persentase Sisa Stok:</strong><div class="progress mt-1" style="height: 20px;"><div class="progress-bar bg-primary" style="width: ' + Math.min(persenSisa, 100) + '%;">' + persenSisa.toFixed(1) + '%</div></div></div>' : '')
                );

                $("#detailKeteranganInfo").html('<p class="mb-0">' + escapeHtml(String(data.keterangan || '-')) + '</p>');

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

// ================ CLOSE DETAIL ================
function closeDetail() {
    $("#detailSection").hide();
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    console.log('Document ready, loading data...');
    loadDataFromServer();

    $("#filterBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Filter button clicked');
        filterData();
    }); 

    $("#resetBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Reset button clicked');
        resetFilter();
    });

    $("#closeDetailBtn").off('click').on('click', function() {
        closeDetail();
    });

    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});