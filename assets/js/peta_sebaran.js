/**
 * Peta Sebaran Peternakan - SIPETGIS
 * VERSI: AWAL KOSONG, MUNCUL SETELAH FILTER DIPILIH
 */

// Variabel global
let map;
let markerCluster;
let allMarkers = [];

let activeDataTypes = new Set(); // AWALNYA KOSONG!
let selectedKecamatan = new Set(); // AWALNYA KOSONG!
let tanggalMulai = null;
let tanggalSelesai = null;

// Data per jenis
let dataPengobatan = [], dataVaksinasi = [], dataPelakuUsaha = [];
let dataPenjualPakan = [], dataPenjualObat = [], dataKlinikHewan = [];
let dataRpu = [], dataPemotonganUnggas = [], dataDemplot = [];

let dataKecamatan = [];

// Warna marker
const warnaMarker = {
    pengobatan: '#ff5252', vaksinasi: '#4caf50', pelaku_usaha: '#2196f3',
    penjual_pakan: '#ff9800', klinik_hewan: '#9c27b0', penjual_obat: '#00bcd4',
    rpu: '#795548', pemotongan_unggas: '#e91e63', demplot: '#8bc34a'
};

const ikonMarker = {
    pengobatan: 'fa-notes-medical', vaksinasi: 'fa-syringe', pelaku_usaha: 'fa-users',
    penjual_pakan: 'fa-seedling', klinik_hewan: 'fa-clinic-medical', penjual_obat: 'fa-pills',
    rpu: 'fa-cut', pemotongan_unggas: 'fa-drumstick-bite', demplot: 'fa-seedling'
};

// Label untuk detail panel
const fieldLabels = {
    nama_petugas: 'Petugas', nama_peternak: 'Peternak', nama_pelaku: 'Nama',
    nama_klinik: 'Klinik', nama_toko: 'Toko', nama_pemilik: 'Pemilik',
    nama_rpu: 'Nama RPU', nama_demplot: 'Nama Demplot', nama_pj: 'Penanggung Jawab',
    tanggal_pengobatan: 'Tanggal', tanggal_vaksinasi: 'Tanggal', tanggal_rpu: 'Tanggal',
    tanggal_input: 'Tgl Input', created_at: 'Tgl Input', tanggal: 'Tanggal',
    jumlah: 'Jumlah (ekor)', jumlah_dokter: 'Jumlah Dokter', jumlah_hewan: 'Jumlah Hewan',
    luas_m2: 'Luas (m²)', ayam: 'Ayam (ekor)', itik: 'Itik (ekor)', dst: 'Lainnya (ekor)',
    tersedia_juleha: 'Tersedia Juleha', stok_pakan: 'Stok Pakan', jenis_hewan: 'Jenis Hewan',
    jenis_layanan: 'Jenis Layanan', jenis_vaksinasi: 'Jenis Vaksin', komoditas_ternak: 'Komoditas',
    diagnosa: 'Gejala Klinis', daerah_asal: 'Daerah Asal', perizinan: 'Perizinan',
    nib: 'NIB', surat_ijin: 'Surat Ijin', sertifikat_standar: 'Sertifikat',
    obat_hewan: 'Obat Hewan', kategori_obat: 'Kategori Obat', jenis_obat: 'Jenis Obat',
    dosis: 'Dosis', bantuan_prov: 'Bantuan Prov', kelurahan: 'Kelurahan',
    kecamatan: 'Kecamatan', lokasi: 'Lokasi', alamat: 'Alamat', telp: 'No. Telp',
    telepon: 'No. Telp', telp_pj: 'No. Telp PJ', rt: 'RT', rw: 'RW',
    nik: 'NIK', nik_pj: 'NIK PJ', pejagal: 'Pejagal', keterangan: 'Keterangan'
};

// ============================================
// INISIALISASI
// ============================================
$(document).ready(function() {
    console.log('Peta Sebaran - Starting...');
    initMap();
    makeDraggable();
    initToggles();
    initResizable();
    loadInitialData();
    setupEventListeners();
});

function initMap() {
    map = L.map('map').setView([-7.2575, 112.7521], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    map.removeControl(map.zoomControl);

    markerCluster = L.markerClusterGroup({
        maxClusterRadius: 50,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true
    });
    map.addLayer(markerCluster);
}

function makeDraggable() {
    $("#filterPanel").draggable({ handle: "#filterHeader", containment: "window" });
    $("#mapLegend").draggable({ handle: "#legendHeader", containment: "window" });
    $("#detailPanel").draggable({ handle: "#detailHeader", containment: "window" });
}

function initToggles() {
    $("#toggleFilter").click(function() {
        $("#filterContent").slideToggle();
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
    });
    $("#toggleLegend").click(function() {
        $("#legendContent").slideToggle();
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
    });
    $("#filterToggleMobile").click(function() {
        $("#filterPanel").toggleClass('active');
    });
}

function initResizable() {
    const panel = document.getElementById('filterPanel');
    const handle = document.getElementById('resizeHandle');
    if (handle) {
        handle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            const startX = e.clientX, startY = e.clientY;
            const startWidth = parseInt(document.defaultView.getComputedStyle(panel).width, 10);
            const startHeight = parseInt(document.defaultView.getComputedStyle(panel).height, 10);

            function doDrag(e) {
                panel.style.width = Math.max(280, startWidth + (e.clientX - startX)) + 'px';
                panel.style.height = Math.max(200, startHeight + (e.clientY - startY)) + 'px';
            }
            function stopDrag() {
                document.documentElement.removeEventListener('mousemove', doDrag);
                document.documentElement.removeEventListener('mouseup', stopDrag);
            }
            document.documentElement.addEventListener('mousemove', doDrag);
            document.documentElement.addEventListener('mouseup', stopDrag);
        });
    }
}

// ============================================
// LOAD DATA AWAL (HANYA KECAMATAN, TIDAK ADA DATA)
// ============================================

function loadInitialData() {
    showLoading();
    console.log('Loading initial data (kosong)...');
    
    // Reset semua data
    dataPengobatan = [];
    dataVaksinasi = [];
    dataPelakuUsaha = [];
    dataPenjualPakan = [];
    dataPenjualObat = [];
    dataKlinikHewan = [];
    dataRpu = [];
    dataPemotonganUnggas = [];
    dataDemplot = [];
    
    // Load kecamatan saja
    loadKecamatan();
    
    // Set counter ke 0
    $('#totalMarkers, #totalFiltered').text('0');
    $('#countPengobatan, #countVaksinasi, #countPelakuUsaha').text('0');
    $('#countPenjualPakan, #countKlinik, #countPenjualObat').text('0');
    $('#countRPU, #countPemotonganUnggas, #countDemplot').text('0');
    
    hideLoading();
}

function loadKecamatan() {
    $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_all_kecamatan',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data && data.length) {
                dataKecamatan = data;
            } else {
                dataKecamatan = [
                    {id:1, nama_kecamatan:'Jambangan'}, {id:2, nama_kecamatan:'Benowo'},
                    {id:3, nama_kecamatan:'Dukuh Pakis'}, {id:4, nama_kecamatan:'Bulak'},
                    {id:5, nama_kecamatan:'Kenjeran'}, {id:6, nama_kecamatan:'Pakal'}
                ];
            }
            loadKecamatanToFilter();
        },
        error: function() {
            dataKecamatan = [{id:1, nama_kecamatan:'Jambangan'}];
            loadKecamatanToFilter();
        }
    });
}

function loadKecamatanToFilter() {
    const list = document.getElementById('kecamatanList');
    if (!list) return;
    list.innerHTML = '';
    
    dataKecamatan.forEach(k => {
        const namaKec = k.nama_kecamatan;
        const item = document.createElement('div');
        item.className = 'kecamatan-item';
        item.innerHTML = `
            <input type="checkbox" class="kecamatan-checkbox" id="kec_${k.id}" value="${namaKec}">
            <label class="kecamatan-name" for="kec_${k.id}">${namaKec}</label>
            <span class="kecamatan-count" id="count_${k.id}">0</span>
        `;
        list.appendChild(item);
    });
    
    // Event listener untuk checkbox kecamatan
    document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            if (this.checked) selectedKecamatan.add(this.value);
            else selectedKecamatan.delete(this.value);
            updateSelectAllCheckbox();
            if (activeDataTypes.size > 0) {
                applyFiltersAndReload();
            }
        });
    });
    
    const selectAll = document.getElementById('selectAllKecamatan');
    if (selectAll) {
        // PASTIKAN "PILIH SEMUA KECAMATAN" TIDAK DICENTANG DI AWAL
        selectAll.checked = false;
        
        selectAll.addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
                cb.checked = checked;
                if (checked) selectedKecamatan.add(cb.value);
                else selectedKecamatan.delete(cb.value);
            });
            if (activeDataTypes.size > 0) {
                applyFiltersAndReload();
            }
        });
    }
}

function updateSelectAllCheckbox() {
    const checkboxes = document.querySelectorAll('.kecamatan-checkbox');
    const selectAll = document.getElementById('selectAllKecamatan');
    if (selectAll && checkboxes.length) {
        const allChecked = document.querySelectorAll('.kecamatan-checkbox:checked').length === checkboxes.length;
        selectAll.checked = allChecked;
    }
}

// ============================================
// FUNGSI LOAD DATA BERDASARKAN FILTER
// ============================================

function applyFiltersAndReload() {
    if (activeDataTypes.size === 0) {
        // Tidak ada jenis data yang dipilih -> peta kosong
        clearMap();
        return;
    }
    
    showLoading();
    
    const kecamatanArray = Array.from(selectedKecamatan);
    
    // Load data berdasarkan jenis data yang aktif
    const promises = [];
    
    if (activeDataTypes.has('pengobatan')) {
        promises.push(loadDataPengobatan(kecamatanArray, tanggalMulai, tanggalSelesai));
    } else {
        dataPengobatan = [];
    }
    
    if (activeDataTypes.has('vaksinasi')) {
        promises.push(loadDataVaksinasi(kecamatanArray, tanggalMulai, tanggalSelesai));
    } else {
        dataVaksinasi = [];
    }
    
    if (activeDataTypes.has('pelaku_usaha')) {
        promises.push(loadDataPelakuUsaha(kecamatanArray));
    } else {
        dataPelakuUsaha = [];
    }
    
    if (activeDataTypes.has('penjual_pakan')) {
        promises.push(loadDataPenjualPakan(kecamatanArray));
    } else {
        dataPenjualPakan = [];
    }
    
    if (activeDataTypes.has('penjual_obat')) {
        promises.push(loadDataPenjualObat(kecamatanArray));
    } else {
        dataPenjualObat = [];
    }
    
    if (activeDataTypes.has('klinik_hewan')) {
        promises.push(loadDataKlinikHewan(kecamatanArray));
    } else {
        dataKlinikHewan = [];
    }
    
    if (activeDataTypes.has('rpu')) {
        promises.push(loadDataRpu(kecamatanArray, tanggalMulai, tanggalSelesai));
    } else {
        dataRpu = [];
    }
    
    if (activeDataTypes.has('pemotongan_unggas')) {
        promises.push(loadDataPemotonganUnggas(kecamatanArray, tanggalMulai, tanggalSelesai));
    } else {
        dataPemotonganUnggas = [];
    }
    
    if (activeDataTypes.has('demplot')) {
        promises.push(loadDataDemplot(kecamatanArray));
    } else {
        dataDemplot = [];
    }
    
    Promise.all(promises).finally(() => {
        refreshMap();
        hideLoading();
    });
}

function loadDataPengobatan(kecamatan, tglMulai, tglSelesai) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    if (tglMulai && tglSelesai) {
        params.tgl_mulai = tglMulai;
        params.tgl_selesai = tglSelesai;
    }
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_pengobatan',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataPengobatan = data || []; },
        error: function() { dataPengobatan = []; }
    });
}

function loadDataVaksinasi(kecamatan, tglMulai, tglSelesai) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    if (tglMulai && tglSelesai) {
        params.tgl_mulai = tglMulai;
        params.tgl_selesai = tglSelesai;
    }
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_vaksinasi',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataVaksinasi = data || []; },
        error: function() { dataVaksinasi = []; }
    });
}

function loadDataPelakuUsaha(kecamatan) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_pelaku_usaha',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataPelakuUsaha = data || []; },
        error: function() { dataPelakuUsaha = []; }
    });
}

function loadDataPenjualPakan(kecamatan) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_penjual_pakan',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataPenjualPakan = data || []; },
        error: function() { dataPenjualPakan = []; }
    });
}

function loadDataPenjualObat(kecamatan) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_penjual_obat',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataPenjualObat = data || []; },
        error: function() { dataPenjualObat = []; }
    });
}

function loadDataKlinikHewan(kecamatan) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_klinik_hewan',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataKlinikHewan = data || []; },
        error: function() { dataKlinikHewan = []; }
    });
}

function loadDataRpu(kecamatan, tglMulai, tglSelesai) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    if (tglMulai && tglSelesai) {
        params.tgl_mulai = tglMulai;
        params.tgl_selesai = tglSelesai;
    }
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_rpu',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataRpu = data || []; },
        error: function() { dataRpu = []; }
    });
}

function loadDataPemotonganUnggas(kecamatan, tglMulai, tglSelesai) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    if (tglMulai && tglSelesai) {
        params.tgl_mulai = tglMulai;
        params.tgl_selesai = tglSelesai;
    }
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_pemotongan_unggas',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataPemotonganUnggas = data || []; },
        error: function() { dataPemotonganUnggas = []; }
    });
}

function loadDataDemplot(kecamatan) {
    let params = {};
    if (kecamatan && kecamatan.length) params.kecamatan = JSON.stringify(kecamatan);
    return $.ajax({
        url: base_url + 'index.php/Peta_sebaran/get_data_demplot',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(data) { dataDemplot = data || []; },
        error: function() { dataDemplot = []; }
    });
}

function clearMap() {
    if (markerCluster) {
        markerCluster.clearLayers();
    }
    allMarkers = [];
    $('#totalMarkers, #totalFiltered').text('0');
    $('#countPengobatan, #countVaksinasi, #countPelakuUsaha').text('0');
    $('#countPenjualPakan, #countKlinik, #countPenjualObat').text('0');
    $('#countRPU, #countPemotonganUnggas, #countDemplot').text('0');
    
    // Reset counter kecamatan
    dataKecamatan.forEach(k => {
        const el = document.getElementById(`count_${k.id}`);
        if (el) el.innerText = '0';
    });
}

// ============================================
// REFRESH MAP - TAMPILKAN MARKER
// ============================================

function refreshMap() {
    if (!markerCluster) return;
    markerCluster.clearLayers();
    allMarkers = [];
    
    // Reset counter kecamatan
    let kecamatanCounts = {};
    dataKecamatan.forEach(k => kecamatanCounts[k.nama_kecamatan] = 0);
    
    let totalMarkers = 0;
    let legendCounts = {
        pengobatan: 0, vaksinasi: 0, pelaku_usaha: 0,
        penjual_pakan: 0, penjual_obat: 0, klinik_hewan: 0,
        rpu: 0, pemotongan_unggas: 0, demplot: 0
    };
    
    // Data configuration: [dataArray, jenis]
    const dataConfigs = [
        [dataPengobatan, 'pengobatan'], [dataVaksinasi, 'vaksinasi'],
        [dataPelakuUsaha, 'pelaku_usaha'], [dataPenjualPakan, 'penjual_pakan'],
        [dataPenjualObat, 'penjual_obat'], [dataKlinikHewan, 'klinik_hewan'],
        [dataRpu, 'rpu'], [dataPemotonganUnggas, 'pemotongan_unggas'],
        [dataDemplot, 'demplot']
    ];
    
    dataConfigs.forEach(([dataArr, jenis]) => {
        if (!activeDataTypes.has(jenis)) return;
        
        (dataArr || []).forEach(item => {
            // Filter kecamatan (sudah terfilter dari API, tapi double check)
            const kecamatan = (item.nama_kecamatan || item.kecamatan || '').toLowerCase();
            if (selectedKecamatan.size > 0 && !Array.from(selectedKecamatan).some(k => k.toLowerCase() === kecamatan)) {
                return;
            }
            
            totalMarkers++;
            legendCounts[jenis]++;
            
            // Update counter kecamatan
            for (let k of dataKecamatan) {
                if (k.nama_kecamatan.toLowerCase() === kecamatan) {
                    kecamatanCounts[k.nama_kecamatan]++;
                    break;
                }
            }
            
            // Buat marker
            let lat = parseFloat(item.latitude);
            let lng = parseFloat(item.longitude);
            if (!isNaN(lat) && lat !== 0 && !isNaN(lng) && lng !== 0) {
                lat = lat || -7.2575;
                lng = lng || 112.7521;
                const marker = createMarker(item, jenis, lat, lng);
                markerCluster.addLayer(marker);
                allMarkers.push({ marker, data: item, jenis });
            }
        });
    });
    
    // Update legend counts
    $('#totalMarkers, #totalFiltered').text(totalMarkers);
    $('#countPengobatan').text(legendCounts.pengobatan);
    $('#countVaksinasi').text(legendCounts.vaksinasi);
    $('#countPelakuUsaha').text(legendCounts.pelaku_usaha);
    $('#countPenjualPakan').text(legendCounts.penjual_pakan);
    $('#countKlinik').text(legendCounts.klinik_hewan);
    $('#countPenjualObat').text(legendCounts.penjual_obat);
    $('#countRPU').text(legendCounts.rpu);
    $('#countPemotonganUnggas').text(legendCounts.pemotongan_unggas);
    $('#countDemplot').text(legendCounts.demplot);
    
    // Update counter kecamatan
    dataKecamatan.forEach(k => {
        const el = document.getElementById(`count_${k.id}`);
        if (el) el.innerText = kecamatanCounts[k.nama_kecamatan] || 0;
    });
    
    // Zoom ke marker jika ada
    if (allMarkers.length > 0) {
        const group = L.featureGroup(allMarkers.map(m => m.marker));
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

function createMarker(item, jenis, lat, lng) {
    const icon = L.divIcon({
        html: `<div style="background-color: ${warnaMarker[jenis]}; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"><i class="fas ${ikonMarker[jenis]}"></i></div>`,
        className: 'custom-marker', iconSize: [28, 28], iconAnchor: [14, 14], popupAnchor: [0, -14]
    });
    const marker = L.marker([lat, lng], { icon });
    marker.bindPopup(createPopupContent(item, jenis));
    marker.on('click', () => showDetail(item, jenis));
    return marker;
}

function createPopupContent(item, jenis) {
    let title = '', fields = '';
    const kec = item.nama_kecamatan || item.kecamatan || '-';
    
    switch(jenis) {
        case 'pengobatan':
            title = 'Pengobatan';
            fields = `<b>Peternak:</b> ${item.nama_peternak || '-'}<br><b>Tanggal:</b> ${item.tanggal_pengobatan || '-'}<br><b>Diagnosa:</b> ${item.diagnosa || '-'}`;
            break;
        case 'vaksinasi':
            title = 'Vaksinasi';
            fields = `<b>Peternak:</b> ${item.nama_peternak || '-'}<br><b>Tanggal:</b> ${item.tanggal_vaksinasi || '-'}<br><b>Jenis Vaksin:</b> ${item.jenis_vaksinasi || '-'}`;
            break;
        case 'pelaku_usaha':
            title = 'Pelaku Usaha';
            fields = `<b>Nama:</b> ${item.nama_pelaku || '-'}<br><b>Alamat:</b> ${item.alamat || '-'}<br><b>Telepon:</b> ${item.telepon || '-'}`;
            break;
        case 'penjual_pakan':
            title = 'Penjual Pakan';
            fields = `<b>Toko:</b> ${item.nama_toko || '-'}<br><b>Pemilik:</b> ${item.nama_pemilik || '-'}`;
            break;
        case 'penjual_obat':
            title = 'Penjual Obat';
            fields = `<b>Toko:</b> ${item.nama_toko || '-'}<br><b>Pemilik:</b> ${item.nama_pemilik || '-'}<br><b>Kategori:</b> ${item.kategori_obat || '-'}`;
            break;
        case 'klinik_hewan':
            title = 'Klinik Hewan';
            fields = `<b>Klinik:</b> ${item.nama_klinik || '-'}<br><b>Alamat:</b> ${item.alamat || '-'}<br><b>Dokter:</b> ${item.jumlah_dokter || 0}`;
            break;
        case 'rpu':
            title = 'RPU';
            fields = `<b>Nama RPU:</b> ${item.nama_rpu || '-'}<br><b>Tanggal:</b> ${item.tanggal_rpu || '-'}<br><b>Juleha:</b> ${item.tersedia_juleha || '-'}`;
            break;
        case 'pemotongan_unggas':
            title = 'Pemotongan Unggas';
            const total = (item.ayam||0)+(item.itik||0)+(item.dst||0);
            fields = `<b>Tanggal:</b> ${item.tanggal || '-'}<br><b>Total:</b> ${total} ekor<br><b>Daerah Asal:</b> ${item.daerah_asal || '-'}`;
            break;
        case 'demplot':
            title = 'Demplot';
            fields = `<b>Nama:</b> ${item.nama_demplot || '-'}<br><b>Luas:</b> ${item.luas_m2 || 0} m²<br><b>Hewan:</b> ${item.jenis_hewan || '-'}<br><b>Jumlah:</b> ${item.jumlah_hewan || 0} ekor`;
            break;
    }
    return `<div style="min-width:250px;"><b style="color:${warnaMarker[jenis]};">${title}</b><hr>${fields}<br><b>Kecamatan:</b> ${kec}<br><button onclick='showDetailById("${jenis}", ${item.id})' style="margin-top:8px;padding:5px 10px;background:${warnaMarker[jenis]};color:white;border:none;border-radius:4px;cursor:pointer;">Detail</button></div>`;
}

window.showDetailById = function(jenis, id) {
    let item = null;
    switch(jenis) {
        case 'pengobatan': item = dataPengobatan.find(d=>d.id==id); break;
        case 'vaksinasi': item = dataVaksinasi.find(d=>d.id==id); break;
        case 'pelaku_usaha': item = dataPelakuUsaha.find(d=>d.id==id); break;
        case 'penjual_pakan': item = dataPenjualPakan.find(d=>d.id==id); break;
        case 'penjual_obat': item = dataPenjualObat.find(d=>d.id==id); break;
        case 'klinik_hewan': item = dataKlinikHewan.find(d=>d.id==id); break;
        case 'rpu': item = dataRpu.find(d=>d.id==id); break;
        case 'pemotongan_unggas': item = dataPemotonganUnggas.find(d=>d.id==id); break;
        case 'demplot': item = dataDemplot.find(d=>d.id==id); break;
    }
    if (item) showDetail(item, jenis);
};

function showDetail(item, jenis) {
    const panel = document.getElementById('detailPanel');
    const body = document.getElementById('detailBody');
    let html = `<div class="detail-row"><span class="detail-label">Jenis Data:</span><span class="detail-value">${jenis.toUpperCase().replace(/_/g,' ')}</span></div>`;
    
    const fieldsMap = {
        pengobatan: ['nama_petugas','nama_peternak','nik','tanggal_pengobatan','kelurahan','rt','rw','komoditas_ternak','diagnosa','jenis_pengobatan','jumlah','keterangan','bantuan_prov','alamat','telp'],
        vaksinasi: ['nama_petugas','nama_peternak','nik','tanggal_vaksinasi','kelurahan','rt','rw','komoditas_ternak','jenis_vaksinasi','dosis','jumlah','keterangan','bantuan_prov','alamat','telp'],
        pelaku_usaha: ['nama_petugas','nama_pelaku','nik','tanggal_input','kelurahan','alamat','telepon'],
        penjual_pakan: ['nama_petugas','nama_toko','nama_pemilik','nik','tanggal_input','kelurahan','alamat','telp','nib','surat_ijin'],
        penjual_obat: ['nama_petugas','nama_toko','nama_pemilik','nik','tanggal_input','kelurahan','alamat','telp','kategori_obat','jenis_obat','nib','surat_ijin','obat_hewan'],
        klinik_hewan: ['nama_klinik','nama_pemilik','created_at','kelurahan','alamat','telp','jumlah_dokter','jenis_layanan','surat_ijin','sertifikat_standar','nib'],
        rpu: ['nama_rpu','tanggal_rpu','kelurahan','lokasi','nama_pj','telp_pj','tersedia_juleha','perizinan','nama_petugas','keterangan'],
        pemotongan_unggas: ['tanggal','ayam','itik','dst','daerah_asal','nama_petugas','keterangan','nama_rpu'],
        demplot: ['nama_demplot','created_at','kelurahan','alamat','luas_m2','jenis_hewan','jumlah_hewan','stok_pakan','nama_petugas','keterangan']
    };
    
    (fieldsMap[jenis] || []).forEach(field => {
        let val = item[field];
        if (val && val !== '-') html += `<div class="detail-row"><span class="detail-label">${fieldLabels[field]||field}:</span><span class="detail-value">${val}</span></div>`;
    });
    
    const kec = item.nama_kecamatan || item.kecamatan;
    if (kec && kec !== '-') html += `<div class="detail-row"><span class="detail-label">Kecamatan:</span><span class="detail-value">${kec}</span></div>`;
    
    body.innerHTML = html;
    panel.classList.add('active');
}

// ============================================
// EVENT LISTENERS
// ============================================

function setupEventListeners() {
    // Data type selector - AWALNYA SEMUA TIDAK AKTIF
    document.querySelectorAll('.data-type-btn').forEach(btn => {
        // Hapus class active di awal
        btn.classList.remove('active');
        
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            const type = this.dataset.type;
            
            if (this.classList.contains('active')) {
                activeDataTypes.add(type);
            } else {
                activeDataTypes.delete(type);
            }
            
            document.getElementById('activeDataCount').innerText = `${activeDataTypes.size}/9`;
            
            // Jika ada jenis data yang dipilih, load data
            if (activeDataTypes.size > 0) {
                applyFiltersAndReload();
            } else {
                // Jika tidak ada jenis data yang dipilih, kosongkan peta
                clearMap();
            }
        });
    });
    
    // Apply filter (tanggal)
    document.getElementById('applyFilter')?.addEventListener('click', function() {
        const newTglMulai = document.getElementById('tanggalMulai').value || null;
        const newTglSelesai = document.getElementById('tanggalSelesai').value || null;
        
        if (newTglMulai !== tanggalMulai || newTglSelesai !== tanggalSelesai) {
            tanggalMulai = newTglMulai;
            tanggalSelesai = newTglSelesai;
            if (activeDataTypes.size > 0) {
                applyFiltersAndReload();
            }
        }
    });
    
    // Reset filter
    document.getElementById('resetFilter')?.addEventListener('click', function() {
        // Reset jenis data
        document.querySelectorAll('.data-type-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        activeDataTypes.clear();
        document.getElementById('activeDataCount').innerText = '0/9';
        
        // Reset kecamatan - SEMUA CHECKBOX TIDAK DICENTANG
        document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
            cb.checked = false;
        });
        selectedKecamatan.clear();
        
        // Reset "Pilih Semua Kecamatan" - TIDAK DICENTANG
        const selectAll = document.getElementById('selectAllKecamatan');
        if (selectAll) selectAll.checked = false;
        
        // Reset tanggal
        document.getElementById('tanggalMulai').value = '';
        document.getElementById('tanggalSelesai').value = '';
        tanggalMulai = null;
        tanggalSelesai = null;
        
        // Reset search
        document.getElementById('searchInput').value = '';
        
        // Kosongkan peta
        clearMap();
    });
    
    // Search
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        if (keyword.length < 3) return;
        for (let { marker, data, jenis } of allMarkers) {
            let match = false;
            if (jenis === 'pengobatan') match = data.nama_peternak?.toLowerCase().includes(keyword);
            if (jenis === 'vaksinasi') match = data.nama_peternak?.toLowerCase().includes(keyword);
            if (jenis === 'pelaku_usaha') match = data.nama_pelaku?.toLowerCase().includes(keyword);
            if (jenis === 'penjual_pakan' || jenis === 'penjual_obat') match = data.nama_toko?.toLowerCase().includes(keyword);
            if (jenis === 'klinik_hewan') match = data.nama_klinik?.toLowerCase().includes(keyword);
            if (jenis === 'rpu') match = data.nama_rpu?.toLowerCase().includes(keyword);
            if (jenis === 'demplot') match = data.nama_demplot?.toLowerCase().includes(keyword);
            if (match) { marker.openPopup(); map.setView(marker.getLatLng(), 15); break; }
        }
    });
    
    // Map controls
    document.getElementById('zoomInBtn')?.addEventListener('click', () => map.zoomIn());
    document.getElementById('zoomOutBtn')?.addEventListener('click', () => map.zoomOut());
    document.getElementById('resetViewBtn')?.addEventListener('click', () => map.setView([-7.2575,112.7521],12));
    document.getElementById('locateMeBtn')?.addEventListener('click', () => {
        if (navigator.geolocation) navigator.geolocation.getCurrentPosition(p => map.setView([p.coords.latitude,p.coords.longitude],15), () => alert('Gagal mendapatkan lokasi'));
        else alert('Browser tidak mendukung geolokasi');
    });
    
    // Close detail panel
    document.getElementById('closeDetailBtn')?.addEventListener('click', () => document.getElementById('detailPanel').classList.remove('active'));
    document.addEventListener('click', (e) => {
        const panel = document.getElementById('detailPanel');
        if (panel?.classList.contains('active') && !panel.contains(e.target) && !e.target.closest('.leaflet-popup-content')) {
            panel.classList.remove('active');
        }
    });
}

function showLoading() { document.getElementById('loadingOverlay')?.classList.add('active'); }
function hideLoading() { document.getElementById('loadingOverlay')?.classList.remove('active'); }