/**
 * Data Pengobatan Ternak
 * SIPETGIS - Kota Surabaya
 */

// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentFarmMarker = null;
let dataTable = null;
let deleteId = null;
let allData = [];

// Data kelurahan per kecamatan
const kelurahanData = {
    'Asemrowo': ['Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'],
    'Benowo': ['Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun'],
    'Bubutan': ['Alun-alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'],
    'Bulak': ['Bulak', 'Kedung Cowek', 'Kenjeran', 'Sukolilo Baru'],
    'Dukuh Pakis': ['Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'],
    'Gayungan': ['Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'],
    'Genteng': ['Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'],
    'Gubeng': ['Airlangga', 'Baratajaya', 'Gubeng', 'Kertajaya', 'Mojo', 'Pucang Sewu'],
    'Gunung Anyar': ['Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'],
    'Jambangan': ['Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'],
    'Karang Pilang': ['Karang Pilang', 'Kebraon', 'Kedurus', 'Waru Gunung'],
    'Kenjeran': ['Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding', 'Sidotopo Wetan'],
    'Krembangan': ['Dupak', 'Kemayoran', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat'],
    'Lakarsantri': ['Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'],
    'Mulyorejo': ['Dukuh Sutorejo', 'Kalijudan', 'Kaliawan', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'],
    'Pabean Cantian': ['Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'],
    'Pakal': ['Babat Jerawat', 'Pakal', 'Sumber Rejo'],
    'Rungkut': ['Kali Rungkut', 'Kedung Baruk', 'Medokan Ayu', 'Penjaringan Sari', 'Rungkut Kidul', 'Wonorejo'],
    'Sambikerep': ['Bringin', 'Lontar', 'Madya', 'Sambikerep'],
    'Sawahan': ['Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'],
    'Semampir': ['Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'],
    'Simokerto': ['Kapasan', 'Simokerto', 'Simolawang', 'Tambak Rejo'],
    'Sukolilo': ['Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Medokan Semampir', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'],
    'Sukomanunggal': ['Putat Gede', 'Simomulyo', 'Simomulyo Baru', 'Sukomanunggal', 'Tanjungsari'],
    'Tambaksari': ['Gading', 'Kapas Madya', 'Pacar Kembang', 'Pacar Keling', 'Ploso', 'Rangkah', 'Tambaksari'],
    'Tandes': ['Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'],
    'Tegalsari': ['Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'],
    'Tenggilis Mejoyo': ['Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'],
    'Wiyung': ['Babat Jerawat', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'],
    'Wonocolo': ['Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'],
    'Wonokromo': ['Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo']
};

function updateKelurahanOptions(selectedKec, targetId) {
    var options = '<option value="">Pilih Kelurahan</option>';
    if (selectedKec && kelurahanData[selectedKec]) {
        kelurahanData[selectedKec].sort().forEach(function(kel) {
            options += '<option value="' + kel + '">' + kel + '</option>';
        });
    }
    $(targetId).html(options);
}

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() { 
    // Tampilkan loading
    $('#dataTableBody').html('<tr><td colspan="17" class="text-center"><div class="spinner-border text-primary"></div><br>Memuat data...<\/td><\/tr>');
    
    $.ajax({
        url: base_url + 'data_pengobatan/get_all_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.length > 0) { 
                allData = response;
                console.log('Total data dimuat:', allData.length);
            } else {
                allData = [];
                console.log('No data found');
            } 
            renderTable(allData);
            updateFilterOptions();
        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
            allData = [];
            renderTable(allData);
            alert('Gagal memuat data. Silakan refresh halaman.');
        }
    });
}

// ================ UPDATE FILTER OPTIONS (SEPERTI LAYANAN KLINIK) ================
function updateFilterOptions() {
    var komoditasSet = new Set();
    var kecamatanSet = new Set();
    var tahunSet = new Set();
    
    allData.forEach(function(item) {
        if (item.komoditas_ternak && item.komoditas_ternak !== '') {
            komoditasSet.add(item.komoditas_ternak);
        }
        if (item.kecamatan && item.kecamatan !== '') {
            kecamatanSet.add(item.kecamatan);
        }
        if (item.tanggal_pengobatan) {
            var year = new Date(item.tanggal_pengobatan).getFullYear();
            if (!isNaN(year)) {
                tahunSet.add(year);
            }
        }
    });
    
    // Update filter komoditas
    var komoditasOptions = '<option selected value="all">Semua Komoditas</option>';
    var sortedKomoditas = Array.from(komoditasSet).sort();
    sortedKomoditas.forEach(function(komoditas) {
        komoditasOptions += '<option value="' + komoditas + '">' + komoditas + '</option>';
    });
    $("#filterKomoditas").html(komoditasOptions);
    
    // Update filter kecamatan
    var kecamatanOptions = '<option selected value="all">Semua Kecamatan</option>';
    var sortedKecamatan = Array.from(kecamatanSet).sort();
    sortedKecamatan.forEach(function(kecamatan) {
        kecamatanOptions += '<option value="' + kecamatan + '">' + kecamatan + '</option>';
    });
    $("#filterKecamatan").html(kecamatanOptions);
    
    // Update filter periode
    var tahunOptions = '<option selected value="all">Semua Periode</option>';
    var sortedTahun = Array.from(tahunSet).sort().reverse();
    sortedTahun.forEach(function(tahun) {
        tahunOptions += '<option value="' + tahun + '">Tahun ' + tahun + '</option>';
    });
    $("#filterPeriode").html(tahunOptions);
    
    console.log('Filter options updated - Komoditas:', sortedKomoditas, 'Kecamatan:', sortedKecamatan, 'Tahun:', sortedTahun);
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    var html = "";
    if (data && data.length > 0) {
        for (var idx = 0; idx < data.length; idx++) {
            var item = data[idx];
            var no = idx + 1;
            var tanggal = formatDate(item.tanggal_pengobatan);
            
            var telp = item.telp ? 
                '<a href="tel:' + item.telp + '" class="telp-link" title="Telepon">' +
                '<i class="fas fa-phone-alt"></i> ' + item.telp +
                '</a>' : 
                '<span class="text-muted">-</span>';
            
            var bantuanProv = item.bantuan_prov === 'Ya' ? 
                '<span class="badge-bantuan-ya">Ya</span>' : 
                '<span class="badge-bantuan-tidak">Tidak</span>';
            
            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.komoditas_ternak || '') + '\', \'' + escapeHtml(item.nama_peternak || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>No Koordinat' +
                '</button>';
            
            var fotoPath = item.foto_pengobatan;
            var fotoLink = (fotoPath && fotoPath != '') ? 
                '<a href="javascript:void(0)" class="foto-link" onclick="showFoto(\'' + base_url + 'uploads/pengobatan/' + fotoPath + '\')" title="Lihat Foto">' +
                '<i class="fas fa-image fa-lg" style="color: #832706;"></i>' +
                '</a>' : 
                '<span class="badge-foto">No Foto</span>';
            
            var nik = item.nik ? 
                '<span class="nik-text">' + item.nik + '</span>' : 
                '-';
            
            var alamat = item.alamat ? 
                '<span class="alamat-text" title="' + escapeHtml(item.alamat) + '">' + truncateText(item.alamat, 30) + '</span>' : 
                '-';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td class="text-center">' + tanggal + '</td>' +
                '<td class="text-center">' + (item.nama_petugas || '-') + '</td>' +
                '<td class="text-center">' + (item.nama_peternak || '-') + '</td>' +
                '<td class="text-center">' + nik + '</td>' +
                '<td class="text-center">' + (item.kecamatan || '-') + '</td>' +
                '<td class="text-center">' + (item.kelurahan || '-') + '</td>' +
                '<td class="text-center">' + alamat + '</td>' +
                '<td class="text-center">' + btnMap + '</td>' +
                '<td class="text-center"><span class="badge-jumlah">' + (item.jumlah || 0) + '</span> Ekor' +
                '</td>' +
                '<td class="text-center">' + (item.komoditas_ternak || '-') + '</td>' +
                '<td class="text-center">' + (item.gejala_klinis || '-') + '</td>' +
                '<td class="text-center">' + (item.jenis_pengobatan || '-') + '</td>' +
                '<td class="text-center">' + bantuanProv + '</td>' +
                '<td class="text-center">' + telp + '</td>' +
                '<td class="text-center">' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit">' +
                '<i class="fas fa-edit"></i>' +
                '</button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + escapeHtml(item.nama_peternak || '') + '\')" title="Hapus">' +
                '<i class="fas fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</td>' +
                '<td class="text-center">' + fotoLink + '</td>' +
                '</tr>';
        }
    } else {
        html = '<tr><td colspan="17" class="text-center">Tidak ada data pengobatan<\/td><\/tr>';
    }
    
    $("#dataTableBody").html(html);
    
    if (dataTable) {
        dataTable.destroy();
    }
    
    dataTable = $("#historyDataTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15] }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15] },
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
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50, 100],
        scrollX: true,
        columnDefs: [
            { orderable: false, targets: [15, 16] }
        ]
    });
}

// ================ FUNCTION FILTER (DIPERBAIKI) ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    var komoditas = $("#filterKomoditas").val();
    var kecamatan = $("#filterKecamatan").val();
    var kelurahan = $("#filterKelurahan").val();
    var periode = $("#filterPeriode").val();
    
    console.log('Filter values - Komoditas:', komoditas, 'Kecamatan:', kecamatan, 'Kelurahan:', kelurahan, 'Periode:', periode);
    
    // Tampilkan loading
    $('#dataTableBody').html('<tr><td colspan="17" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></td></tr>');
    
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
    
    var filteredData = [];
    
    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchKomoditas = true;
        var matchKecamatan = true;
        var matchKelurahan = true;
        var matchPeriode = true;
        
        // Filter komoditas
        if (komoditas !== "all") {
            matchKomoditas = (item.komoditas_ternak && item.komoditas_ternak === komoditas);
        }
        
        // Filter kecamatan
        if (kecamatan !== "all") {
            matchKecamatan = (item.kecamatan && item.kecamatan === kecamatan);
        }
        
        // Filter kelurahan
        if (kelurahan !== "all" && kelurahan !== "" && kelurahan !== "all") {
            matchKelurahan = (item.kelurahan && item.kelurahan === kelurahan);
        }
        
        // Filter periode/tahun
        if (periode !== "all") {
            if (item.tanggal_pengobatan) {
                var itemTahun = new Date(item.tanggal_pengobatan).getFullYear();
                matchPeriode = (itemTahun.toString() === periode);
            } else {
                matchPeriode = false;
            }
        }
        
        if (matchKomoditas && matchKecamatan && matchKelurahan && matchPeriode) {
            filteredData.push(item);
        }
    }
    
    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    renderTable(filteredData);
    
    // Tampilkan pesan jika tidak ada data
    if (filteredData.length === 0 && komoditas !== "all") {
        console.log('No data found for filter');
    }
}

// ================ FUNCTION RESET FILTER (RESET DATA DAN FILTER) ================
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');
    
    // Reset semua dropdown filter ke default
    $("#filterKomoditas").val("all");
    $("#filterKecamatan").val("all");
    $("#filterKelurahan").html('<option selected value="all">Semua Kelurahan</option>');
    $("#filterPeriode").val("all");
    
    // Tampilkan loading
    $('#dataTableBody').html('<tr><td colspan="17" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat semua data...</p></td></tr>');
    
    // Hancurkan DataTable lama
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
    
    // Render SEMUA data (allData)
    renderTable(allData);
    
    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
}
// ================ FUNCTION PRINT CUSTOM ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var table = $('#historyDataTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalTernak = 0;
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var ternakText = stripHtml(row[9] || '0');
        var ternakAngka = ternakText.replace(/\./g, '');
        var ternak = parseInt(ternakAngka) || 0;
        totalTernak += ternak;
    }
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Pengobatan Ternak</title>');
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
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA PENGOBATAN TERNAK</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Tanggal</th>');
    printWindow.document.write('<th>Nama Peternak</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Komoditas</th>');
    printWindow.document.write('<th>Jumlah Ternak</th>');
    printWindow.document.write('<th>Jenis Pengobatan</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[10] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[9] || '0') + ' Ekor' + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[12] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalTernak) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data</strong></td>');
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

function truncateText(text, maxLength) {
    if (!text) return '-';
    if (text.length <= maxLength) return escapeHtml(text);
    return escapeHtml(text.substring(0, maxLength)) + '...';
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function formatDate(dateString) {
    if (!dateString) return "-";
    var d = new Date(dateString);
    if (isNaN(d.getTime())) return dateString;
    var day = String(d.getDate()).padStart(2, '0');
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var year = d.getFullYear();
    return day + '-' + month + '-' + year;
}

// ================ EDIT DATA ================
function editData(id) {
    $.ajax({
        url: base_url + 'data_pengobatan/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(item) {
            if (item) {
                $('#edit_id').val(item.id);
                $('#edit_tanggal').val(item.tanggal_pengobatan);
                $('#edit_petugas').val(item.nama_petugas);
                $('#edit_peternak').val(item.nama_peternak);
                $('#edit_nik').val(item.nik);
                $('#edit_kecamatan').val(item.kecamatan);
                
                updateKelurahanOptions(item.kecamatan, '#edit_kelurahan');
                setTimeout(function() {
                    $('#edit_kelurahan').val(item.kelurahan);
                }, 100);
                
                $('#edit_alamat').val(item.alamat || '');
                $('#edit_rt').val(item.rt);
                $('#edit_rw').val(item.rw);
                $('#edit_latitude').val(item.latitude);
                $('#edit_longitude').val(item.longitude);
                $('#edit_jumlah').val(item.jumlah);
                $('#edit_komoditas').val(item.komoditas_ternak);
                $('#edit_telp').val(item.telp);
                $('#edit_gejala').val(item.gejala_klinis);
                $('#edit_tindakan').val(item.jenis_pengobatan);
                $('#edit_bantuan').val(item.bantuan_prov);
                $('#edit_keterangan').val(item.keterangan);
                
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

// ================ CRUD ================
function showFoto(url) {
    $("#fotoModalImg").attr("src", url);
    $("#fotoModal").modal("show");
}

function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data pengobatan: " + nama);
    $("#deleteModal").modal("show");
}

function deleteData(id) {
    $.ajax({
        url: base_url + 'data_pengobatan/delete/' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                allData = allData.filter(function(item) {
                    return item.id !== id;
                });
                renderTable(allData);
                $("#deleteModal").modal("hide");
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Gagal menghapus data');
        }
    });
}

// ================ MAP FUNCTION ================
function showMap(komoditas, peternak, coordinates) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    $("#mapTitle").text("Peta Lokasi Pengobatan " + komoditas + ", Peternak: " + peternak);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold">Peternak:</span> ' + peternak + '<br><span class="fw-bold">Komoditas:</span> ' + komoditas + '</div>' +
        '<div class="col-md-6"><span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br><span class="fw-bold">Tanggal Update:</span> Terbaru</div>' +
        '</div>'
    );
    
    $("#farmInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Peternak:</span><br><span class="text-primary fw-bold">' + escapeHtml(peternak) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Komoditas:</span><br><span class="badge bg-primary-custom">' + escapeHtml(komoditas) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Jumlah Ternak:</span><br><span class="fw-bold">- Ekor</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Status:</span><br><span class="badge bg-success">Aktif</span></div>'
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var farmIcon = L.divIcon({
                html: '<div style="background-color: #832706; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
                className: "farm-marker",
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });
            
            currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
            currentFarmMarker.bindPopup(
                '<div style="min-width: 200px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + escapeHtml(peternak) + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Komoditas:</strong> ' + escapeHtml(komoditas) + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Jenis Pengobatan:</strong> Pengobatan</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentFarmMarker);
            
            var circle = L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 500 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);
        
        var farmIcon = L.divIcon({
            html: '<div style="background-color: #832706; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
            className: "farm-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
        
        currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
        currentFarmMarker.bindPopup(
            '<div style="min-width: 200px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + escapeHtml(peternak) + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Komoditas:</strong> ' + escapeHtml(komoditas) + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Jenis Pengobatan:</strong> Pengobatan</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentFarmMarker);
        
        var circle = L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 500 }).addTo(map);
        mapMarkers.push(circle);
        setTimeout(function() { map.invalidateSize(); }, 50);
    }
    
    $("#mapSection").show();
    $("html, body").animate({ scrollTop: $("#mapSection").offset().top - 20 }, 500);
    setTimeout(function() { if (map) map.invalidateSize(); }, 300);
}

function updateMapView() {
    if (!map) return;
    map.eachLayer(function(layer) { if (layer instanceof L.TileLayer) map.removeLayer(layer); });
    if (currentView === "map") {
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { attribution: '&copy; OpenStreetMap', maxZoom: 19 }).addTo(map);
    } else {
        L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", { attribution: "Tiles &copy; Esri", maxZoom: 19 }).addTo(map);
    }
    mapMarkers.forEach(function(m) { if (!map.hasLayer(m)) map.addLayer(m); });
    setTimeout(function() { map.invalidateSize(); }, 50);
}

function closeMap() {
    $("#mapSection").hide();
    if (map) {
        map.remove();
        map = null;
    }
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    console.log('Document ready, loading data...');
    loadDataFromServer();
    
    // Event filter kecamatan change untuk update kelurahan
    $("#filterKecamatan").off('change').on('change', function() {
        var selectedKec = $(this).val();
        console.log('Kecamatan changed to:', selectedKec);
        if (selectedKec === 'all') {
            $("#filterKelurahan").html('<option selected value="all">Semua Kelurahan</option>');
        } else {
            updateKelurahanOptions(selectedKec, '#filterKelurahan');
            $("#filterKelurahan").prepend('<option value="all">Semua Kelurahan</option>');
            $("#filterKelurahan").val('all');
        }
    });
    
    // Event filter kecamatan untuk edit modal
    $("#edit_kecamatan").off('change').on('change', function() {
        var selectedKec = $(this).val();
        updateKelurahanOptions(selectedKec, '#edit_kelurahan');
    });
    
    // Event filter button
    $("#filterBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Filter button clicked');
        filterData();
    });
    
    // Event reset button
    $("#resetBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Reset button clicked');
        resetFilter();
    });
    
    // Event close map button
    $("#closeMapBtn").off('click').on('click', closeMap);
    
    // Event map view buttons
    $("#btnMapView").off('click').on('click', function() {
        currentView = "map";
        updateMapView();
        $(this).addClass("active");
        $("#btnSatelliteView").removeClass("active");
    });
    
    $("#btnSatelliteView").off('click').on('click', function() {
        currentView = "satellite";
        updateMapView();
        $(this).addClass("active");
        $("#btnMapView").removeClass("active");
    });
    
    $("#btnResetView").off('click').on('click', function() {
        if (map && currentFarmMarker) {
            var latlng = currentFarmMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });
    
    // Event confirm delete
    $("#confirmDelete").off('click').on('click', function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
    
    // Event form edit submit
    $("#formEdit").off('submit').on('submit', function(e) {
        e.preventDefault();
        var id = $("#edit_id").val();
        
        var formData = {
            tanggal_pengobatan: $("#edit_tanggal").val(),
            nama_petugas: $("#edit_petugas").val(),
            nama_peternak: $("#edit_peternak").val(),
            nik: $("#edit_nik").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            alamat: $("#edit_alamat").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            jumlah: $("#edit_jumlah").val(),
            komoditas_ternak: $("#edit_komoditas").val(),
            telp: $("#edit_telp").val(),
            gejala_klinis: $("#edit_gejala").val(),
            jenis_pengobatan: $("#edit_tindakan").val(),
            bantuan_prov: $("#edit_bantuan").val(),
            keterangan: $("#edit_keterangan").val()
        };
        
        $.ajax({
            url: base_url + 'data_pengobatan/update/' + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) { 
                if (response.status === 'success') {
                    $("#editModal").modal("hide");
                    alert(response.message);
                    loadDataFromServer();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Gagal menyimpan perubahan');
            }
        });
    });
});