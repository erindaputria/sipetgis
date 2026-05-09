// ================ BASE URL ================
// base_url sudah didefinisikan di HTML

// ================ CSRF TOKEN ================
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

// ================ VARIABLES ================
let dataTable = null;
let deleteId = null;
let allData = [];

// ================ FUNGSI UPDATE FILTER RPU DARI MASTER ================
function updateFilterRPU() {
    $.ajax({
        url: base_url + 'index.php/rpu/get_all_data',
        type: 'GET',
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            if (response && response.length > 0) {
                var options = '<option selected value="all">Semua RPU</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + escapeHtml(response[i].pejagal) + '">' + escapeHtml(response[i].pejagal) + '</option>';
                }
                $("#filterRPU").html(options);
                console.log('Filter RPU updated from master, total:', response.length);
            }
        },
        error: function() {
            console.log('Gagal mengambil data RPU master');
        }
    });
}

// ================ UPDATE FILTER KOMODITAS ================
function updateFilterKomoditas() {
    var komoditasSet = new Set();

    allData.forEach(function(item) {
        if (item.komoditas_list && item.komoditas_list !== '') {
            var komoditasList = item.komoditas_list.split(' | ');
            for (var i = 0; i < komoditasList.length; i++) {
                var komoditasItem = komoditasList[i].split(':')[0];
                if (komoditasItem && komoditasItem !== '') {
                    komoditasSet.add(komoditasItem.trim());
                }
            }
        }
    });

    var komoditasOptions = '<option selected value="all">Semua Komoditas</option>';
    var sortedKomoditas = Array.from(komoditasSet).sort();
    sortedKomoditas.forEach(function(komoditas) {
        komoditasOptions += '<option value="' + escapeHtml(komoditas) + '">' + escapeHtml(komoditas) + '</option>';
    });
    $("#filterKomoditas").html(komoditasOptions);

    console.log('Filter komoditas updated');
}

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#pemotonganTable tbody").html('<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...<\/td><\/tr>');

    $.ajax({
        url: base_url + 'index.php/data_pemotongan_unggas/get_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.length > 0) {
                allData = response;
                console.log('Total data dimuat:', allData.length);
            } else {
                allData = [];
            }
            renderTable(allData);
            updateFilterKomoditas();
            loadStatistik();
        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
            allData = [];
            renderTable(allData);
            alert('Gagal memuat data. Error: ' + error);
        }
    });
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    if (dataTable) {
        try {
            dataTable.destroy();
        } catch(e) {}
        dataTable = null;
    }
    
    $("#pemotonganTable tbody").empty();
    
    if (!data || data.length === 0) {
        $("#pemotonganTable tbody").html('<tr><td colspan="10" class="text-center py-5"><i class="fas fa-warehouse fa-3x text-muted mb-3 d-block"></i>Tidak ada data pemotongan unggas<\/td><\/tr>');
        
        dataTable = $("#pemotonganTable").DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] } },
                { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] }, action: function(e, dt, button, config) { printWithCurrentData(); } }
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
            scrollX: true,
            responsive: true,
            columnDefs: [{ orderable: false, targets: [0, 8, 9] }],
            order: []
        });
        return;
    }
    
    var html = "";
    for (var idx = 0; idx < data.length; idx++) {
        var item = data[idx];
        var no = idx + 1;
        
        var safeNamaRpu = escapeHtml(String(item.nama_rpu || 'RPU ' + (item.id_rpu || '-')));
        var safeKomoditasList = escapeHtml(String(item.komoditas_list || '-')).substring(0, 60);
        var safeDaerahAsal = escapeHtml(String(item.daerah_asal || '-'));
        var safePetugas = escapeHtml(String(item.nama_petugas || '-'));
        
        var totalEkor = item.total_ekor || 0;
        var totalBerat = parseFloat(item.total_berat || 0).toFixed(2);
        
        // FIX: Jika foto berisi multiple file (koma), ambil hanya yang pertama
        var fotoPath = item.foto_kegiatan;
        if (fotoPath && fotoPath.indexOf(',') !== -1) {
            fotoPath = fotoPath.split(',')[0].trim();
        }
        var fotoLink = (fotoPath && fotoPath != '') ? 
            '<img src="' + base_url + 'uploads/pemotongan_unggas/' + escapeHtml(fotoPath) + '" alt="Foto" class="photo-thumbnail" onclick="showFotoPreview(this.src)" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;">' : 
            '<span class="text-muted">-</span>';
        
        html += '<tr>' +
            '<td class="text-center" style="width: 40px;">' + no + '</td>' +
            '<td class="text-center" style="width: 100px;">' + formatDate(item.tanggal) + '</td>' +
            '<td style="min-width: 180px;"><span class="fw-bold">' + safeNamaRpu + '</span></td>' +
            '<td style="min-width: 180px;"><small>' + safeKomoditasList + '</small></td>' +
            '<td class="text-center" style="min-width: 100px;"><span class="badge-ekor">' + totalEkor + '</span> ekor</span></td>' +
            '<td class="text-center" style="min-width: 100px;"><span class="badge-berat">' + totalBerat + '</span> kg</span></td>' +
            '<td style="min-width: 140px;"><span class="badge-asal">' + safeDaerahAsal + '</span></td>' +
            '<td class="text-center" style="min-width: 140px;"><span class="badge-petugas">' + safePetugas + '</span></td>' +
            '<td class="text-center">' + fotoLink + '</td>' +
            '<td class="text-center">' +
            '<div class="btn-action-group">' +
            '<button class="btn btn-action btn-edit" onclick="editData(' + item.id_pemotongan + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
            '<button class="btn btn-action btn-delete" onclick="deleteData(' + item.id_pemotongan + ', \'' + escapeForAttribute(safeNamaRpu) + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
            '</div>' +
            '</td>' +
            '</tr>';
    }
    
    $("#pemotonganTable tbody").html(html);
    
    dataTable = $("#pemotonganTable").DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] }, action: function(e, dt, button, config) { printWithCurrentData(); } }
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
        scrollX: true,
        responsive: true,
        columnDefs: [{ orderable: false, targets: [0, 8, 9] }],
        order: []
    });
    
    console.log('Table rendered successfully');
}

// ================ FUNCTION ESCAPE ================
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

function formatDate(dateString) {
    if (!dateString) return '-';
    var d = new Date(dateString);
    if (isNaN(d.getTime())) return dateString;
    var day = String(d.getDate()).padStart(2, '0');
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var year = d.getFullYear();
    return day + '-' + month + '-' + year;
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

// ================ FUNCTION FILTER ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    var rpu = $("#filterRPU").val();
    var komoditas = $("#filterKomoditas").val();
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();

    console.log('Filter values - RPU:', rpu, 'Komoditas:', komoditas, 'Tanggal:', startDate, '-', endDate);

    if (dataTable) {
        try { dataTable.destroy(); } catch(e) {}
        dataTable = null;
    }

    var filteredData = [];

    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchRpu = true;
        var matchKomoditas = true;
        var matchTanggal = true;

        if (rpu !== "all") {
            matchRpu = (item.nama_rpu && item.nama_rpu === rpu);
        }

        if (komoditas !== "all") {
            if (item.komoditas_list) {
                matchKomoditas = item.komoditas_list.toLowerCase().includes(komoditas.toLowerCase());
            } else {
                matchKomoditas = false;
            }
        }

        if (startDate && endDate) {
            if (item.tanggal) {
                matchTanggal = (item.tanggal >= startDate && item.tanggal <= endDate);
            } else {
                matchTanggal = false;
            }
        }

        if (matchRpu && matchKomoditas && matchTanggal) {
            filteredData.push(item);
        }
    }

    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    renderTable(filteredData);
    
    if (filteredData.length === 0 && allData.length > 0) {
        alert('Tidak ada data yang sesuai dengan filter yang dipilih');
    }
}

// ================ FUNCTION RESET FILTER ================
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');

    $("#filterRPU").val("all");
    $("#filterKomoditas").val("all");
    
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    $("#startDate").val(firstDay.toISOString().split('T')[0]);
    $("#endDate").val(lastDay.toISOString().split('T')[0]);
    
    if (dataTable) {
        try { dataTable.destroy(); } catch(e) {}
        dataTable = null;
    }
    
    renderTable(allData);
    
    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
}

// ================ FUNCTION PRINT RAPI (TIDAK MENGUBAH TAMPILAN AWAL) ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar (DataTable)
    var table = $('#pemotonganTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalEkor = 0;
    var totalBerat = 0;
    
    // Hitung total ekor dan berat dari data yang tampil
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        // Ekstrak ekor dari kolom 4 (index 4)
        var ekorText = stripHtml(row[4] || '0');
        var ekorMatch = ekorText.match(/(\d+)/);
        if (ekorMatch) {
            totalEkor += parseInt(ekorMatch[0]) || 0;
        }
        
        // Ekstrak berat dari kolom 5 (index 5)
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
    printWindow.document.write('<h2>LAPORAN DATA PEMOTONGAN UNGGAS</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data untuk Print (SAMA PERSIS SEPERTI TABEL DI LAYAR)
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
    
    // Loop data dari tabel (menggunakan rows yang sudah diambil)
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        // Ambil data per kolom sesuai urutan tabel
        var no = row[0];
        var tanggal = stripHtml(row[1] || '-');
        var rpu = stripHtml(row[2] || '-');
        var komoditas = stripHtml(row[3] || '-');
        
        // Ekstrak ekor dan berat dari kolom total
        var totalText = stripHtml(row[4] || '0');
        var ekorMatch = totalText.match(/(\d+)/);
        var ekor = ekorMatch ? ekorMatch[0] : '0';
        
        var beratText = stripHtml(row[5] || '0');
        var beratMatch = beratText.match(/([\d,]+\.?\d*)/);
        var berat = beratMatch ? beratMatch[0].replace(/,/g, '') : '0';
        
        var daerahAsal = stripHtml(row[6] || '-');
        var petugas = stripHtml(row[7] || '-');
        
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + no + '</td>');
        printWindow.document.write('<td align="center">' + tanggal + '</td>');
        printWindow.document.write('<td align="left">' + rpu + '</td>');
        printWindow.document.write('<td align="left">' + komoditas + '</td>');
        printWindow.document.write('<td align="center">' + ekor + ' Ekor' + '</td>');
        printWindow.document.write('<td align="center">' + formatNumber(parseFloat(berat)) + ' kg' + '</td>');
        printWindow.document.write('<td align="left">' + daerahAsal + '</td>');
        printWindow.document.write('<td align="left">' + petugas + '</td>');
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

// ================ SHOW FOTO PREVIEW ================
function showFotoPreview(src) {
    $('#modalFoto').attr('src', src);
    $('#fotoModal').modal('show');
}

// ================ EDIT DATA ================
function editData(id) {
    var item = null;
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].id_pemotongan == id) {
            item = allData[i];
            break;
        }
    }
    
    if (item) {
        $('#edit_id').val(item.id_pemotongan);
        $('#edit_tanggal').val(item.tanggal || '');
        // Perbaikan: Kirim pejagal (nama RPU) bukan id_rpu
        $('#edit_rpu').val(item.nama_rpu || item.pejagal || item.nama_rpu || '');
        $('#edit_ayam').val(item.ayam || 0);
        $('#edit_itik').val(item.itik || 0);
        $('#edit_dst').val(item.dst || 0);
        $('#edit_daerah_asal').val(item.daerah_asal || '');
        $('#edit_petugas').val(item.nama_petugas || '');
        $('#edit_keterangan').val(item.keterangan || '');
        $('#editModal').modal('show');
    } else {
        $.ajax({
            url: base_url + 'index.php/data_pemotongan_unggas/detail/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var d = response.data;
                    $('#edit_id').val(d.id_pemotongan);
                    $('#edit_tanggal').val(d.tanggal || '');
                    $('#edit_rpu').val(d.nama_rpu || d.pejagal || '');
                    $('#edit_ayam').val(d.ayam || 0);
                    $('#edit_itik').val(d.itik || 0);
                    $('#edit_dst').val(d.dst || 0);
                    $('#edit_daerah_asal').val(d.daerah_asal || '');
                    $('#edit_petugas').val(d.nama_petugas || '');
                    $('#edit_keterangan').val(d.keterangan || '');
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
}

// ================ UPDATE DATA (REFRESH TABLE) ================
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    var id = $('#edit_id').val();
    var formData = $(this).serialize();
    
    $('.btn-save-edit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
    
    $.ajax({
        url: base_url + 'index.php/data_pemotongan_unggas/update/' + id,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            if (response.status === 'success') {
                $('#editModal').modal('hide');
                alert('Data berhasil diupdate');
                // RELOAD DATA DARI SERVER AGAR DATA TERBARU TAMPIL
                loadDataFromServer();
            } else {
                alert(response.message || 'Gagal update data');
            }
        },
        error: function(xhr, status, error) {
            $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            console.error('Error:', error);
            if (xhr.status === 403) {
                alert('Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
            } else {
                alert('Gagal menyimpan perubahan. Silakan coba lagi.');
            }
        }
    });
});

// ================ DELETE DATA (CONFIRM BROWSER) ================
function deleteData(id, namaRpu) {
    if (confirm("Apakah Anda yakin ingin menghapus data pemotongan unggas: " + namaRpu + "?")) {
        window.location.href = base_url + "index.php/data_pemotongan_unggas/hapus/" + id;
    }
}

// ================ LOAD STATISTIK ================
function loadStatistik() {
    $.ajax({
        url: base_url + 'index.php/data_pemotongan_unggas/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalKegiatan').text(data.total_kegiatan || 0);
            $('#totalEkor').text(data.total_ekor || 0);
            $('#totalBerat').text((data.total_berat || 0).toFixed(2));
            $('#totalRPU').text(data.total_rpu || 0);
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

// ================ UPDATE DATA ================
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    var id = $('#edit_id').val();
    var formData = $(this).serialize();
    
    $('.btn-save-edit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
    
    $.ajax({
        url: base_url + 'index.php/data_pemotongan_unggas/update/' + id,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            if (response.status === 'success') {
                $('#editModal').modal('hide');
                alert('Data berhasil diupdate');
                loadDataFromServer();
            } else {
                alert(response.message || 'Gagal update data');
            }
        },
        error: function(xhr, status, error) {
            $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            console.error('Error:', error);
            if (xhr.status === 403) {
                alert('Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
            } else {
                alert('Gagal menyimpan perubahan. Silakan coba lagi.');
            }
        }
    });
});

// ================ DOCUMENT READY ================
$(document).ready(function() {
    console.log('Document ready, loading data...');
    loadDataFromServer();
    
    // Ambil filter RPU dari master RPU
    updateFilterRPU();

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

    $("#confirmDelete").off('click').on('click', function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
    
    $('.btn-save-edit').on('click', function() {
        $('#formEdit').submit();
    });
});