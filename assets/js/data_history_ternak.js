/**
 * Data History Ternak
 * SIPETGIS - Kota Surabaya
 * Full CRUD - Edit, Hapus, Map, Print, Export
 */

// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentFarmMarker = null;
let dataTable = null;
let allData = [];

// Data kelurahan per kecamatan (lengkap)
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

function formatNumber(num) {
    if (num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

function formatDate(dateString) {
    if (!dateString) return '-';
    let date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString;
    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

// ================ LOAD DATA ================
function loadData() {
    $('#historyDataTable tbody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary"></div><br>Memuat data...</td></tr>');
    
    $.ajax({
        url: base_url + 'index.php/data_history_ternak/get_data',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.data) {
                allData = response.data;
                renderTable();
                updateFilters();
            } else {
                allData = [];
                renderTable();
            }
        },
        error: function() {
            allData = [];
            renderTable();
            Swal.fire('Error', 'Gagal memuat data', 'error');
        }
    });
}

// ================ UPDATE FILTERS ================
function updateFilters() {
    let komoditasSet = new Set();
    allData.forEach(item => { if (item.komoditas) komoditasSet.add(item.komoditas); });
    
    let komoditasHtml = '<option value="all">Semua Komoditas</option>';
    Array.from(komoditasSet).sort().forEach(k => { komoditasHtml += `<option value="${k}">${k}</option>`; });
    $('#filterKomoditas').html(komoditasHtml);
    
    let tahunSet = new Set();
    allData.forEach(item => { 
        if (item.tanggal_update && item.tanggal_update.split('-').length === 3) {
            tahunSet.add(item.tanggal_update.split('-')[2]);
        }
    });
    
    let tahunHtml = '<option value="all">Semua Periode</option>';
    Array.from(tahunSet).sort().reverse().forEach(t => { tahunHtml += `<option value="${t}">Tahun ${t}</option>`; });
    $('#filterPeriode').html(tahunHtml);
}

// ================ RENDER TABLE ================
function renderTable() {
    let data = allData;
    
    // Apply filters
    let komoditas = $('#filterKomoditas').val();
    let periode = $('#filterPeriode').val();
    
    if (komoditas !== 'all') {
        data = data.filter(item => item.komoditas === komoditas);
    }
    if (periode !== 'all') {
        data = data.filter(item => item.tanggal_update && item.tanggal_update.split('-')[2] === periode);
    }
    
    let html = '';
    if (data.length > 0) {
        data.forEach((item, idx) => {
            let koordinatText = (item.raw_latitude && item.raw_longitude && item.raw_latitude != 0) ? 
                `${item.raw_latitude}, ${item.raw_longitude}` : 'Koordinat tidak tersedia';
            
            let btnMap = (item.raw_latitude && item.raw_longitude && item.raw_latitude != 0) ? 
                `<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap('${escapeHtml(item.komoditas)}', '${escapeHtml(item.nama_peternak)}', ${item.raw_latitude}, ${item.raw_longitude})">
                    <i class="fas fa-map-marker-alt me-1"></i>Lihat Peta
                </button>` : 
                `<button class="btn btn-sm btn-secondary" disabled><i class="fas fa-map-marker-alt me-1"></i>No Koordinat</button>`;
            
            html += `<tr>
                <td class="text-center">${idx + 1}</td>
                <td><span class="fw-bold">${escapeHtml(item.nama_peternak)}</span><br><small class="text-muted">ID: ${item.id}</small></td>
                <td>${escapeHtml(item.komoditas)}</td>
                <td class="text-center"><span class="badge" style="background:#832706; color:white; padding:5px 12px; border-radius:20px;">${item.jumlah_ternak_value}</span> Ekor</td>
                <td><div class="small text-muted mb-1">${koordinatText}</div>${btnMap}</td>
                <td class="text-center">${item.tanggal_update}</td>
                <td class="text-center">
                    <div class="btn-group gap-1">
                        <button class="btn btn-sm" style="background:#ffc107; border:none; width:32px;" onclick="editData(${item.id})" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" style="width:32px;" onclick="deleteData(${item.id}, '${escapeHtml(item.nama_peternak)}')" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>`;
        });
    } else {
        html = `<tr><td colspan="7" class="text-center py-5"><i class="fas fa-database fa-3x text-muted mb-3 d-block"></i>Tidak ada data ternak</td></tr>`;
    }
    
    $('#historyDataTable tbody').html(html);
    
    if (dataTable) dataTable.destroy();
    dataTable = $('#historyDataTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,5] } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,5] } }
        ],
        language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_ data", info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", zeroRecords: "Tidak ada data" },
        pageLength: 15,
        scrollX: true,
        ordering: false
    });
}

// ================ EDIT DATA ================
function editData(id) {
    if (!id || id == 0) {
        Swal.fire('Error', 'ID data tidak valid!', 'error');
        return;
    }
    
    $.ajax({
        url: base_url + 'index.php/data_history_ternak/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.success && response.data && response.data.length > 0) {
                let item = response.data[0];
                $('#edit_id').val(item.id);
                $('#edit_nama_peternak').val(item.nama_peternak || '');
                $('#edit_komoditas').val(item.komoditas || '');
                $('#edit_jumlah').val(item.jumlah || 0);
                $('#edit_kecamatan').val(item.kecamatan || '');
                $('#edit_alamat').val(item.alamat || '');
                $('#edit_rt').val(item.rt || '');
                $('#edit_rw').val(item.rw || '');
                $('#edit_latitude').val(item.latitude || '');
                $('#edit_longitude').val(item.longitude || '');
                $('#edit_telepon').val(item.telepon || '');
                $('#edit_nama_petugas').val(item.nama_petugas || '');
                $('#edit_tanggal_input').val(item.tanggal_input || '');
                
                // Update kelurahan
                if (item.kecamatan) {
                    updateKelurahanOptions(item.kecamatan, '#edit_kelurahan');
                    setTimeout(() => { $('#edit_kelurahan').val(item.kelurahan || ''); }, 100);
                }
                
                $('#editModal').modal('show');
            } else {
                Swal.fire('Error', response?.message || 'Data tidak ditemukan', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Gagal mengambil data', 'error');
        }
    });
}

// ================ DELETE DATA ================
function deleteData(id, nama) {
    Swal.fire({
        title: 'Yakin hapus?',
        html: `Hapus data ternak: <strong>${escapeHtml(nama)}</strong>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#832706',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'index.php/data_history_ternak/delete/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Terhapus!', 'Data berhasil dihapus', 'success');
                        loadData();
                    } else {
                        Swal.fire('Gagal!', 'Gagal menghapus data', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                }
            });
        }
    });
}

// ================ MAP FUNCTION ================
function showMap(komoditas, peternak, lat, lng) {
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        Swal.fire('Error', 'Koordinat tidak valid', 'error');
        return;
    }
    
    // Find item data
    let item = allData.find(d => d.nama_peternak === peternak && d.komoditas === komoditas);
    
    $('#mapTitle').html(`<i class="fas fa-paw me-2"></i>${escapeHtml(peternak)} - ${escapeHtml(komoditas)}`);
    $('#mapInfo').html(`
        <div class="row">
            <div class="col-md-6">
                <strong>Peternak:</strong> ${escapeHtml(peternak)}<br>
                <strong>Komoditas:</strong> ${escapeHtml(komoditas)}
            </div>
            <div class="col-md-6">
                <strong>Koordinat:</strong> <span class="coord-badge">${lat}, ${lng}</span><br>
                <strong>Update:</strong> ${item ? item.tanggal_update : '-'}
            </div>
        </div>
    `);
    
    $('#farmInfo').html(`
        <div class="mb-3"><strong>Nama Peternak:</strong><br><span class="text-primary fw-bold">${escapeHtml(peternak)}</span></div>
        <div class="mb-3"><strong>Komoditas:</strong><br><span class="badge" style="background:#832706; color:white; padding:5px 12px;">${escapeHtml(komoditas)}</span></div>
        <div class="mb-3"><strong>Jumlah Ternak:</strong><br><span class="fw-bold fs-4" style="color:#832706;">${item ? item.jumlah_ternak_value : 0}</span> Ekor</div>
        <div class="mb-3"><strong>Kecamatan:</strong><br>${item ? escapeHtml(item.kecamatan) : '-'}</div>
        <div class="mb-3"><strong>Kelurahan:</strong><br>${item ? escapeHtml(item.kelurahan) : '-'}</div>
        <div class="mb-3"><strong>Alamat:</strong><br>${item ? escapeHtml(item.alamat) : '-'}</div>
        <div class="mb-3"><strong>Telepon:</strong><br>${item ? escapeHtml(item.telepon) : '-'}</div>
    `);
    
    $('#coordInfo').html(`
        <div class="mb-3"><strong>Latitude:</strong><br><code class="bg-light p-2 rounded">${lat.toFixed(6)}</code></div>
        <div class="mb-3"><strong>Longitude:</strong><br><code class="bg-light p-2 rounded">${lng.toFixed(6)}</code></div>
        <div class="mb-3"><a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" class="btn btn-sm btn-outline-primary-custom"><i class="fas fa-external-link-alt me-1"></i>Buka Google Maps</a></div>
    `);
    
    if (map) { map.remove(); map = null; }
    
    setTimeout(() => {
        map = L.map('mapContainer').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
        
        let icon = L.divIcon({
            html: '<div style="background:#832706; width:36px; height:36px; border-radius:50%; border:3px solid white; display:flex; align-items:center; justify-content:center; color:white; font-size:16px;"><i class="fas fa-paw"></i></div>',
            iconSize: [36, 36], iconAnchor: [18, 18]
        });
        
        currentFarmMarker = L.marker([lat, lng], { icon: icon }).addTo(map);
        currentFarmMarker.bindPopup(`<b>${escapeHtml(peternak)}</b><br>${escapeHtml(komoditas)}`).openPopup();
        L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 500 }).addTo(map);
        
        setTimeout(() => map.invalidateSize(), 100);
    }, 100);
    
    $('#mapSection').show();
    $('html, body').animate({ scrollTop: $('#mapSection').offset().top - 20 }, 500);
}

function closeMap() {
    $('#mapSection').hide();
    if (map) { map.remove(); map = null; }
}

function updateMapView() {
    if (!map) return;
    let currentCenter = map.getCenter();
    let currentZoom = map.getZoom();
    map.remove();
    map = L.map('mapContainer').setView([currentCenter.lat, currentCenter.lng], currentZoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    if (currentFarmMarker) currentFarmMarker.addTo(map);
}

// ================ FILTER FUNCTIONS ================
function filterData() {
    renderTable();
}

function resetFilter() {
    $('#filterKomoditas').val('all');
    $('#filterPeriode').val('all');
    renderTable();
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    loadData();
    
    $('#filterBtn').click(filterData);
    $('#resetBtn').click(resetFilter);
    $('#closeMapBtn').click(closeMap);
    
    $('#btnMapView').click(function() {
        currentView = 'map';
        updateMapView();
        $(this).addClass('active').siblings().removeClass('active');
    });
    
    $('#btnResetView').click(function() {
        if (map && currentFarmMarker) {
            let pos = currentFarmMarker.getLatLng();
            map.setView([pos.lat, pos.lng], 15);
        }
    });
    
    // Submit edit form
    $('#formEdit').submit(function(e) {
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
                    Swal.fire('Sukses', 'Data berhasil diupdate', 'success');
                    loadData();
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal update', 'error');
                }
            },
            error: function() {
                $('.btn-save-edit').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                Swal.fire('Error', 'Gagal menyimpan perubahan', 'error');
            }
        });
    });
    
    $('#edit_kecamatan').change(function() {
        updateKelurahanOptions($(this).val(), '#edit_kelurahan');
    });
});