/**
 * Data History Ternak
 * SIPETGIS - Kota Surabaya
 */

let map = null;
let currentFarmMarker = null;
let dataTable = null;
let allData = [];
let currentView = "map";

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
    let options = '<option value="">Pilih Kelurahan</option>';
    if (selectedKec && kelurahanData[selectedKec]) {
        kelurahanData[selectedKec].sort().forEach(function(kel) {
            options += '<option value="' + kel + '">' + kel + '</option>';
        });
    }
    $(targetId).html(options);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// LOAD DATA
function loadData() {
    $('#historyDataTable tbody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary"></div><br>Memuat data...<\/td><\/tr>');
    
    $.ajax({
        url: base_url + 'index.php/data_history_ternak/get_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.data) {
                allData = response.data;
                console.log('Total data dimuat:', allData.length);
                
                let komoditasSet = new Set();
                let tahunSet = new Set();
                
                allData.forEach(function(item) {
                    if (item.komoditas && item.komoditas !== '-') komoditasSet.add(item.komoditas);
                    if (item.tanggal_update && item.tanggal_update !== '-') {
                        let parts = item.tanggal_update.split('-');
                        if (parts.length === 3 && parts[2]) {
                            tahunSet.add(parts[2]);
                        }
                    }
                });
                
                let komoditasHtml = '<option selected value="all">Semua Komoditas</option>';
                Array.from(komoditasSet).sort().forEach(function(k) {
                    komoditasHtml += '<option value="' + k + '">' + k + '</option>';
                });
                $('#filterKomoditas').html(komoditasHtml);
                
                let tahunHtml = '<option selected value="all">Semua Periode</option>';
                Array.from(tahunSet).sort().reverse().forEach(function(t) {
                    tahunHtml += '<option value="' + t + '">Tahun ' + t + '</option>';
                });
                $('#filterPeriode').html(tahunHtml);
                
                renderTable();
            } else {
                allData = [];
                renderTable();
            }
        },
        error: function(xhr, status, error) {
            console.error('Load data error:', status, error, xhr.responseText);
            allData = [];
            renderTable();
            alert('Gagal memuat data: ' + error);
        }
    });
}

// RENDER TABLE
function renderTable() {
    let komoditas = $('#filterKomoditas').val();
    let periode = $('#filterPeriode').val();
    
    console.log('Filter - Komoditas:', komoditas, 'Periode:', periode);
    
    let filteredData = [];
    
    for (let i = 0; i < allData.length; i++) {
        let item = allData[i];
        
        let matchKomoditas = (komoditas === 'all');
        if (!matchKomoditas && item.komoditas) {
            matchKomoditas = (item.komoditas.toLowerCase() === komoditas.toLowerCase());
        }
        
        let matchPeriode = (periode === 'all');
        if (!matchPeriode && item.tanggal_update && item.tanggal_update !== '-') {
            let parts = item.tanggal_update.split('-');
            if (parts.length === 3 && parts[2]) {
                matchPeriode = (parts[2] === periode);
            }
        }
        
        if (matchKomoditas && matchPeriode) {
            filteredData.push(item);
        }
    }
    
    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
    
    $('#historyDataTable tbody').empty();
    
    let html = '';
    if (filteredData.length > 0) {
        for (let i = 0; i < filteredData.length; i++) {
            let item = filteredData[i];
            let koordinatText = (item.raw_latitude && item.raw_longitude && item.raw_latitude != 0) ? 
                item.raw_latitude + ', ' + item.raw_longitude : 'Koordinat tidak tersedia';
            
            let btnMap = (item.raw_latitude && item.raw_longitude && item.raw_latitude != 0) ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.komoditas) + '\', \'' + escapeHtml(item.nama_peternak) + '\', ' + item.raw_latitude + ', ' + item.raw_longitude + ')"><i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' : 
                '<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-map-marker-alt me-1"></i>No Koordinat</button>';
            
            html += '<tr>';
            html += '<td class="text-center">' + (i + 1) + '</td>';
            html += '<td><span class="fw-bold">' + escapeHtml(item.nama_peternak) + '</span></td>';
            html += '<td>' + escapeHtml(item.komoditas) + '</td>';
            html += '<td class="text-center"><span class="badge" style="background:#832706; color:white; padding:5px 12px; border-radius:20px;">' + item.jumlah_ternak_value + '</span> Ekor</span></td>';
            html += '<td><div class="small text-muted mb-1">' + koordinatText + '</div>' + btnMap + '</td>';
            html += '<td class="text-center">' + item.tanggal_update + '</td>';
            html += '<td class="text-center">';
            html += '<button class="btn btn-action btn-edit" title="Edit" data-id="' + item.id + '" data-nama="' + escapeHtml(item.nama_peternak) + '" data-komoditas="' + escapeHtml(item.komoditas) + '" data-jumlah="' + item.jumlah_ternak_value + '" data-kecamatan="' + escapeHtml(item.kecamatan) + '" data-kelurahan="' + escapeHtml(item.kelurahan) + '" data-alamat="' + escapeHtml(item.alamat) + '" data-rt="' + escapeHtml(item.rt) + '" data-rw="' + escapeHtml(item.rw) + '" data-latitude="' + (item.raw_latitude || '') + '" data-longitude="' + (item.raw_longitude || '') + '" data-telepon="' + escapeHtml(item.telepon) + '" data-nama_petugas="' + escapeHtml(item.nama_petugas) + '" data-tanggal_input="' + (item.tanggal_input || '') + '">';
            html += '<i class="fas fa-edit"></i>';
            html += '</button>';
            html += '<button class="btn btn-action btn-delete" title="Hapus" data-id="' + item.id + '" data-nama="' + escapeHtml(item.nama_peternak) + '">';
            html += '<i class="fas fa-trash"></i>';
            html += '</button>';
            html += '</td>';
            html += '</tr>';
        }
    } else {
        html = '<tr><td colspan="7" class="text-center py-5"><i class="fas fa-database fa-3x text-muted mb-3 d-block"></i>Tidak ada data yang sesuai dengan filter</span></td></tr>';
    }
    
    $('#historyDataTable tbody').html(html);
    
    dataTable = $('#historyDataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { 
                extend: 'excel', 
                text: '<i class="fas fa-file-excel"></i> Excel', 
                className: 'btn btn-sm btn-success', 
                exportOptions: { columns: [0,1,2,3,5] } 
            },
            { 
                extend: 'print', 
                text: '<i class="fas fa-print"></i> Print', 
                className: 'btn btn-sm btn-info', 
                exportOptions: { columns: [0,1,2,3,5] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ],
        language: { 
            search: "Cari:", 
            lengthMenu: "Tampilkan _MENU_ data", 
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", 
            zeroRecords: "Tidak ada data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 15,
        scrollX: true,
        ordering: false,
        drawCallback: function() {
            console.log('DataTable redrawn, total rows:', this.api().rows().count());
        }
    });
    
    console.log('Render selesai, menampilkan', filteredData.length, 'baris');
}

// FUNGSI FILTER
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    let komoditas = $('#filterKomoditas').val();
    let periode = $('#filterPeriode').val();
    console.log('Nilai filter:', komoditas, periode);
    renderTable();
}

// FUNGSI RESET FILTER
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');
    $('#filterKomoditas').val('all');
    $('#filterPeriode').val('all');
    renderTable();
}

// FUNGSI UPDATE MAP VIEW
function updateMapView() {
    if (!map) return;
    
    map.eachLayer(function(layer) {
        if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
        }
    });
    
    if (currentView === "map") {
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);
    } else {
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 19
        }).addTo(map);
    }
    
    setTimeout(function() { map.invalidateSize(); }, 50);
}

// SHOW MAP
function showMap(komoditas, peternak, lat, lng) {
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert('Koordinat tidak valid');
        return;
    }
    
    let item = null;
    for (let i = 0; i < allData.length; i++) {
        if (allData[i].nama_peternak === peternak && allData[i].komoditas === komoditas) {
            item = allData[i];
            break;
        }
    }
    
    $('#mapTitle').html('<i class="fas fa-paw me-2"></i>' + escapeHtml(peternak) + ' - ' + escapeHtml(komoditas));
    $('#mapInfo').html('<div class="row"><div class="col-md-6"><strong>Peternak:</strong> ' + escapeHtml(peternak) + '<br><strong>Komoditas:</strong> ' + escapeHtml(komoditas) + '</div><div class="col-md-6"><strong>Koordinat:</strong> <span class="coord-badge">' + lat + ', ' + lng + '</span><br><strong>Update:</strong> ' + (item ? item.tanggal_update : '-') + '</div></div>');
    
    $('#farmInfo').html('<div class="mb-3"><strong>Nama Peternak:</strong><br><span class="text-primary fw-bold">' + escapeHtml(peternak) + '</span></div><div class="mb-3"><strong>Komoditas:</strong><br><span class="badge" style="background:#832706; color:white; padding:5px 12px;">' + escapeHtml(komoditas) + '</span></div><div class="mb-3"><strong>Jumlah Ternak:</strong><br><span class="fw-bold fs-4" style="color:#832706;">' + (item ? item.jumlah_ternak_value : 0) + '</span> Ekor</div><div class="mb-3"><strong>Kecamatan:</strong><br>' + (item ? escapeHtml(item.kecamatan) : '-') + '</div><div class="mb-3"><strong>Kelurahan:</strong><br>' + (item ? escapeHtml(item.kelurahan) : '-') + '</div><div class="mb-3"><strong>Alamat:</strong><br>' + (item ? escapeHtml(item.alamat) : '-') + '</div><div class="mb-3"><strong>Telepon:</strong><br>' + (item ? escapeHtml(item.telepon) : '-') + '</div>');
    
    $('#coordInfo').html(
        '<div class="mb-3"><strong>Latitude:</strong><br><code class="bg-light p-2 rounded d-inline-block">' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-3"><strong>Longitude:</strong><br><code class="bg-light p-2 rounded d-inline-block">' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-3"><strong>Format Koordinat:</strong><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-3"><strong>Akurasi:</strong><br><small>GPS ± 5 meter</small></div>'
    );
    
    if (map) {
        map.remove();
        map = null;
    }
    
    setTimeout(function() {
        map = L.map('mapContainer').setView([lat, lng], 15);
        
        if (currentView === "map") {
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
        } else {
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                maxZoom: 19
            }).addTo(map);
        }
        
        let icon = L.divIcon({
            html: '<div style="background:#832706; width:36px; height:36px; border-radius:50%; border:3px solid white; display:flex; align-items:center; justify-content:center; color:white; font-size:16px;"><i class="fas fa-paw"></i></div>',
            iconSize: [36, 36], iconAnchor: [18, 18]
        });
        
        currentFarmMarker = L.marker([lat, lng], { icon: icon }).addTo(map);
        currentFarmMarker.bindPopup('<b>' + escapeHtml(peternak) + '</b><br>' + escapeHtml(komoditas)).openPopup();
        L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 500 }).addTo(map);
        
        setTimeout(function() { map.invalidateSize(); }, 100);
    }, 100);
    
    $('#mapSection').show();
    $('html, body').animate({ scrollTop: $('#mapSection').offset().top - 20 }, 500);
}

// CLOSE MAP
function closeMap() {
    $('#mapSection').hide();
    if (map) {
        map.remove();
        map = null;
    }
}

// FUNGSI PRINT - SAMA PERSIS DENGAN DATA_HISTORY_VAKSINASI
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var table = $('#historyDataTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalTernak = 0;
    
    // Hitung total ternak
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var ternakText = stripHtml(row[3] || '0');
        var ternakAngka = ternakText.replace(/\./g, '').replace(' Ekor', '');
        var ternak = parseInt(ternakAngka) || 0;
        totalTernak += ternak;
    }
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan History Data Ternak</title>');
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
    printWindow.document.write('<h2>LAPORAN HISTORY DATA TERNAK</h2>');
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
    printWindow.document.write('<th>Nama Peternak</th>');
    printWindow.document.write('<th>Komoditas</th>');
    printWindow.document.write('<th>Jumlah Ternak</th>');
    printWindow.document.write('<th>Tanggal Update</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalTernak) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data</strong></td>');
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

// EVENT EDIT
$(document).on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    var komoditas = $(this).data('komoditas');
    var jumlah = $(this).data('jumlah');
    var kecamatan = $(this).data('kecamatan');
    var kelurahan = $(this).data('kelurahan');
    var alamat = $(this).data('alamat');
    var rt = $(this).data('rt');
    var rw = $(this).data('rw');
    var latitude = $(this).data('latitude');
    var longitude = $(this).data('longitude');
    var telepon = $(this).data('telepon');
    var namaPetugas = $(this).data('nama_petugas');
    var tanggalInput = $(this).data('tanggal_input');
    
    $('#edit_id').val(id);
    $('#edit_nama_peternak').val(nama);
    $('#edit_komoditas').val(komoditas);
    $('#edit_jumlah').val(jumlah);
    $('#edit_kecamatan').val(kecamatan);
    $('#edit_alamat').val(alamat);
    $('#edit_rt').val(rt);
    $('#edit_rw').val(rw);
    $('#edit_latitude').val(latitude);
    $('#edit_longitude').val(longitude);
    $('#edit_telepon').val(telepon);
    $('#edit_nama_petugas').val(namaPetugas);
    $('#edit_tanggal_input').val(tanggalInput);
    
    if (kecamatan) {
        updateKelurahanOptions(kecamatan, '#edit_kelurahan');
        setTimeout(function() { 
            $('#edit_kelurahan').val(kelurahan); 
        }, 100);
    }
    
    $('#editModal').modal('show');
});

// EVENT DELETE
$(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    
    var id = $(this).data('id');
    var nama = $(this).data('nama');
    
    if (confirm("Apakah Anda yakin ingin menghapus data ternak: " + nama + "?")) {
        $.ajax({
            url: base_url + 'index.php/data_history_ternak/delete/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil dihapus');
                    loadData();
                } else {
                    alert('Gagal menghapus data');
                }
            },
            error: function(xhr, status, error) {
                console.error('Delete error:', error);
                alert('Gagal menghapus data. Error: ' + error);
            }
        });
    }
});

// DOCUMENT READY
$(document).ready(function() {
    $('#editModal .modal-footer .btn-secondary').removeClass('btn-secondary').css({
        'background': '#e6d2c8',
        'border': 'none',
        'color': '#832706',
        'border-radius': '6px',
        'padding': '8px 20px',
        'font-weight': '500'
    }).text('Batal');
    
    console.log('Document ready, base_url =', base_url);
    loadData();
    
    $('#filterBtn').off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Tombol Filter diklik');
        filterData();
    });
    
    $('#resetBtn').off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Tombol Reset diklik');
        resetFilter();
    });
    
    $('#closeMapBtn').off('click').on('click', closeMap);
    
    $('#btnMapView').off('click').on('click', function() {
        currentView = "map";
        updateMapView();
        $(this).addClass('active');
        $('#btnSatelliteView').removeClass('active');
    });
    
    $('#btnSatelliteView').off('click').on('click', function() {
        currentView = "satellite";
        updateMapView();
        $(this).addClass('active');
        $('#btnMapView').removeClass('active');
    });
    
    $('#btnResetView').off('click').on('click', function() {
        if (map && currentFarmMarker) {
            var latlng = currentFarmMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });
    
    $('#formEdit').off('submit').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = {
            nama_peternak: $('#edit_nama_peternak').val(),
            komoditas: $('#edit_komoditas').val(),
            jumlah: $('#edit_jumlah').val(),
            kecamatan: $('#edit_kecamatan').val(),
            kelurahan: $('#edit_kelurahan').val(),
            alamat: $('#edit_alamat').val(),
            rt: $('#edit_rt').val(),
            rw: $('#edit_rw').val(),
            latitude: $('#edit_latitude').val(),
            longitude: $('#edit_longitude').val(),
            telepon: $('#edit_telepon').val(),
            nama_petugas: $('#edit_nama_petugas').val(),
            tanggal_input: $('#edit_tanggal_input').val()
        };
        
        $('.btn-save-edit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        $.ajax({
            url: base_url + 'index.php/data_history_ternak/update/' + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                if (response.success) {
                    $('#editModal').modal('hide');
                    alert('Data berhasil diupdate'); 
                    loadData();
                } else {
                    alert(response.message || 'Gagal update data');
                }
            },
            error: function() {
                $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                alert('Gagal menyimpan perubahan');
            }
        });
    });
    
    $('#edit_kecamatan').off('change').on('change', function() {
        updateKelurahanOptions($(this).val(), '#edit_kelurahan');
    });
});