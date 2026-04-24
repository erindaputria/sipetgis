/**
 * Peta Sebaran Peternakan
 * SIPETGIS - Kota Surabaya
 */

// DATA LENGKAP
const dataDariServer = {
    pengobatan: Array(50).fill().map((_, i) => ({
        id: i + 1,
        nama_peternak: `Peternak ${i + 1}`,
        alamat: `Jl. Contoh No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        tanggal_pengobatan: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
        diagnosa: ['Demam', 'Diare', 'Mastitis', 'Cacingan', 'Luka'][Math.floor(Math.random() * 5)],
        keterangan: 'Pengobatan rutin'
    })),

    vaksinasi: Array(40).fill().map((_, i) => ({
        id: i + 1,
        nama_peternak: `Peternak Vaksin ${i + 1}`,
        alamat: `Jl. Vaksin No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        tanggal_vaksinasi: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
        jenis_vaksin: ['ND', 'AI', 'PMK', 'LSD'][Math.floor(Math.random() * 4)],
        jumlah_ternak: Math.floor(Math.random() * 100) + 10,
        keterangan: 'Vaksinasi rutin'
    })),

    pelaku_usaha: Array(30).fill().map((_, i) => ({
        id: i + 1,
        nama_pelaku: `Pengusaha ${i + 1}`,
        alamat: `Jl. Usaha No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        jenis_usaha: ['Peternakan', 'Pembibitan', 'Penggemukan'][Math.floor(Math.random() * 3)],
        skala_usaha: ['Kecil', 'Menengah', 'Besar'][Math.floor(Math.random() * 3)],
        no_hp: '08123456789'
    })),

    penjual_pakan: Array(25).fill().map((_, i) => ({
        id: i + 1,
        nama_toko: `Toko Pakan ${i + 1}`,
        pemilik: `Pemilik ${i + 1}`,
        alamat: `Jl. Pakan No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        jenis_pakan: ['Konsentrat', 'Hijauan', 'Pelet', 'Jagung'][Math.floor(Math.random() * 4)],
        no_hp: '08123456789'
    })),

    klinik_hewan: Array(15).fill().map((_, i) => ({
        id: i + 1,
        nama_klinik: `Klinik Hewan ${i + 1}`,
        dokter_hewan: `Dokter ${i + 1}`,
        alamat: `Jl. Klinik No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        layanan: ['Umum', 'Spesialis', '24 Jam'][Math.floor(Math.random() * 3)],
        no_hp: '08123456789',
        jam_operasional: '08:00 - 20:00'
    })),

    penjual_obat: Array(20).fill().map((_, i) => ({
        id: i + 1,
        nama_toko: `Apotek Hewan ${i + 1}`,
        pemilik: `Pemilik ${i + 1}`,
        alamat: `Jl. Obat No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        no_sipa: 'SIPA/' + String(Math.floor(Math.random() * 1000)).padStart(3, '0'),
        no_hp: '08123456789'
    })),

    rpu: Array(12).fill().map((_, i) => ({
        id: i + 1,
        nama_rpu: `RPU ${i + 1}`,
        alamat: `Jl. RPU No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        tanggal_rpu: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
        jumlah_ekor: Math.floor(Math.random() * 500) + 50,
        tersedia_juleha: Math.random() > 0.5 ? 'Ya' : 'Tidak'
    })),

    pemotongan_unggas: Array(35).fill().map((_, i) => ({
        id: i + 1,
        alamat: `Jl. Pemotongan No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        tanggal: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
        ayam: Math.floor(Math.random() * 200),
        itik: Math.floor(Math.random() * 100),
        dst: Math.floor(Math.random() * 50),
        daerah_asal: ['Surabaya', 'Sidoarjo', 'Gresik', 'Mojokerto'][Math.floor(Math.random() * 4)]
    })),

    demplot: Array(18).fill().map((_, i) => ({
        id: i + 1,
        nama_demplot: `Demplot ${i + 1}`,
        alamat: `Jl. Demplot No. ${i + 1}, Surabaya`,
        latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
        longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
        id_kecamatan: Math.floor(Math.random() * 31) + 1,
        luas_m2: Math.floor(Math.random() * 1000) + 100,
        jenis_hewan: ['Sapi', 'Kambing', 'Ayam', 'Itik'][Math.floor(Math.random() * 4)],
        jumlah_hewan: Math.floor(Math.random() * 50) + 5,
        stok_pakan: Math.floor(Math.random() * 1000) + 100 + ' kg'
    })),

    kecamatan: [
        { id: 1, nama_kecamatan: 'Asemrowo', latitude: -7.2050, longitude: 112.7079 },
        { id: 2, nama_kecamatan: 'Benowo', latitude: -7.2296, longitude: 112.6523 },
        { id: 3, nama_kecamatan: 'Bubutan', latitude: -7.2455, longitude: 112.7293 },
        { id: 4, nama_kecamatan: 'Bulak', latitude: -7.2299, longitude: 112.7871 },
        { id: 5, nama_kecamatan: 'Dukuh Pakis', latitude: -7.2759, longitude: 112.6907 },
        { id: 6, nama_kecamatan: 'Gayungan', latitude: -7.3246, longitude: 112.7349 },
        { id: 7, nama_kecamatan: 'Genteng', latitude: -7.2569, longitude: 112.7482 },
        { id: 8, nama_kecamatan: 'Gubeng', latitude: -7.2841, longitude: 112.7536 },
        { id: 9, nama_kecamatan: 'Gununganyar', latitude: -7.3331, longitude: 112.7866 },
        { id: 10, nama_kecamatan: 'Jambangan', latitude: -7.3249, longitude: 112.7135 },
        { id: 11, nama_kecamatan: 'Karangpilang', latitude: -7.3193, longitude: 112.6768 },
        { id: 12, nama_kecamatan: 'Kenjeran', latitude: -7.2478, longitude: 112.7799 },
        { id: 13, nama_kecamatan: 'Krembangan', latitude: -7.2372, longitude: 112.7377 },
        { id: 14, nama_kecamatan: 'Lakarsantri', latitude: -7.2914, longitude: 112.6495 },
        { id: 15, nama_kecamatan: 'Mulyorejo', latitude: -7.2760, longitude: 112.7856 },
        { id: 16, nama_kecamatan: 'Pabean Cantian', latitude: -7.2337, longitude: 112.7311 },
        { id: 17, nama_kecamatan: 'Pakal', latitude: -7.2876, longitude: 112.6298 },
        { id: 18, nama_kecamatan: 'Rungkut', latitude: -7.3177, longitude: 112.7785 },
        { id: 19, nama_kecamatan: 'Sambikerep', latitude: -7.2971, longitude: 112.6668 },
        { id: 20, nama_kecamatan: 'Sawahan', latitude: -7.2771, longitude: 112.7291 },
        { id: 21, nama_kecamatan: 'Semampir', latitude: -7.2347, longitude: 112.7453 },
        { id: 22, nama_kecamatan: 'Simokerto', latitude: -7.2448, longitude: 112.7434 },
        { id: 23, nama_kecamatan: 'Sukolilo', latitude: -7.2875, longitude: 112.7772 },
        { id: 24, nama_kecamatan: 'Sukomanunggal', latitude: -7.2963, longitude: 112.6982 },
        { id: 25, nama_kecamatan: 'Tambaksari', latitude: -7.2593, longitude: 112.7604 },
        { id: 26, nama_kecamatan: 'Tandes', latitude: -7.2591, longitude: 112.6728 },
        { id: 27, nama_kecamatan: 'Tegalsari', latitude: -7.2645, longitude: 112.7428 },
        { id: 28, nama_kecamatan: 'Tenggilis Mejoyo', latitude: -7.3158, longitude: 112.7635 },
        { id: 29, nama_kecamatan: 'Wiyung', latitude: -7.3202, longitude: 112.6983 },
        { id: 30, nama_kecamatan: 'Wonocolo', latitude: -7.3101, longitude: 112.7246 },
        { id: 31, nama_kecamatan: 'Wonokromo', latitude: -7.2995, longitude: 112.7377 }
    ]
};

// Variabel global
let map;
let markerCluster;
let allMarkers = [];
let activeDataTypes = new Set(['pengobatan', 'vaksinasi', 'pelaku_usaha', 'penjual_pakan', 'klinik_hewan', 'penjual_obat', 'rpu', 'pemotongan_unggas', 'demplot']);
let selectedKecamatan = new Set(dataDariServer.kecamatan.map(k => k.id));
let tanggalMulai = null;
let tanggalSelesai = null;

// Warna marker
const warnaMarker = {
    pengobatan: '#ff5252',
    vaksinasi: '#4caf50',
    pelaku_usaha: '#2196f3',
    penjual_pakan: '#ff9800',
    klinik_hewan: '#9c27b0',
    penjual_obat: '#00bcd4',
    rpu: '#795548',
    pemotongan_unggas: '#e91e63',
    demplot: '#8bc34a'
};

const ikonMarker = {
    pengobatan: 'fa-notes-medical',
    vaksinasi: 'fa-syringe',
    pelaku_usaha: 'fa-users',
    penjual_pakan: 'fa-seedling',
    klinik_hewan: 'fa-clinic-medical',
    penjual_obat: 'fa-pills',
    rpu: 'fa-cut',
    pemotongan_unggas: 'fa-drumstick-bite',
    demplot: 'fa-seedling'
};

// Inisialisasi
$(document).ready(function() {
    initMap();
    makeDraggable();
    initToggles();
    initResizable();
});

// Inisialisasi peta
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

    loadKecamatanToFilter();
    loadDataKePeta();
    setupEventListeners();
}

// Buat elemen bisa digeser
function makeDraggable() {
    $("#filterPanel").draggable({
        handle: "#filterHeader",
        containment: "window"
    });

    $("#mapLegend").draggable({
        handle: "#legendHeader",
        containment: "window"
    });

    $("#detailPanel").draggable({
        handle: "#detailHeader",
        containment: "window"
    });
}

// Inisialisasi toggle untuk filter dan legenda
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

// Resize filter panel
function initResizable() {
    const panel = document.getElementById('filterPanel');
    const handle = document.getElementById('resizeHandle');
    
    if (handle) {
        handle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            const startX = e.clientX;
            const startY = e.clientY;
            const startWidth = parseInt(document.defaultView.getComputedStyle(panel).width, 10);
            const startHeight = parseInt(document.defaultView.getComputedStyle(panel).height, 10);

            function doDrag(e) {
                const newWidth = startWidth + (e.clientX - startX);
                const newHeight = startHeight + (e.clientY - startY);
                panel.style.width = Math.max(280, newWidth) + 'px';
                panel.style.height = Math.max(200, newHeight) + 'px';
            }

            function stopDrag() {
                document.documentElement.removeEventListener('mousemove', doDrag, false);
                document.documentElement.removeEventListener('mouseup', stopDrag, false);
            }

            document.documentElement.addEventListener('mousemove', doDrag, false);
            document.documentElement.addEventListener('mouseup', stopDrag, false);
        });
    }
}

// Load kecamatan ke filter
function loadKecamatanToFilter() {
    const list = document.getElementById('kecamatanList');
    list.innerHTML = '';
    
    dataDariServer.kecamatan.forEach(k => {
        const item = document.createElement('div');
        item.className = 'kecamatan-item';
        item.innerHTML = `
            <input type="checkbox" class="kecamatan-checkbox form-check-input" 
                   id="kec_${k.id}" value="${k.id}" checked>
            <label class="kecamatan-name" for="kec_${k.id}">${k.nama_kecamatan}</label>
            <span class="kecamatan-count" id="count_${k.id}">0</span>
        `;
        list.appendChild(item);
    });

    document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const id = parseInt(this.value);
            if (this.checked) {
                selectedKecamatan.add(id);
            } else {
                selectedKecamatan.delete(id);
            }
            updateSelectAllCheckbox();
            loadDataKePeta();
        });
    });

    document.getElementById('selectAllKecamatan').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
            cb.checked = checked;
            const id = parseInt(cb.value);
            if (checked) {
                selectedKecamatan.add(id);
            } else {
                selectedKecamatan.delete(id);
            }
        });
        loadDataKePeta();
    });
}

function updateSelectAllCheckbox() {
    const allChecked = document.querySelectorAll('.kecamatan-checkbox:checked').length === dataDariServer.kecamatan.length;
    document.getElementById('selectAllKecamatan').checked = allChecked;
}

// Load data ke peta
function loadDataKePeta() {
    showLoading();
    
    markerCluster.clearLayers();
    allMarkers = [];

    let totalMarkers = 0;
    const counts = {
        pengobatan: 0,
        vaksinasi: 0,
        pelaku_usaha: 0,
        penjual_pakan: 0,
        klinik_hewan: 0,
        penjual_obat: 0,
        rpu: 0,
        pemotongan_unggas: 0,
        demplot: 0
    };

    activeDataTypes.forEach(jenis => {
        const data = dataDariServer[jenis] || [];
        
        data.forEach(item => {
            if (!selectedKecamatan.has(item.id_kecamatan)) {
                return;
            }

            if ((jenis === 'pengobatan' || jenis === 'vaksinasi' || jenis === 'rpu' || jenis === 'pemotongan_unggas')) {
                if (tanggalMulai && tanggalSelesai) {
                    let tglItem = null;
                    if (jenis === 'pengobatan') tglItem = item.tanggal_pengobatan;
                    else if (jenis === 'vaksinasi') tglItem = item.tanggal_vaksinasi;
                    else if (jenis === 'rpu') tglItem = item.tanggal_rpu;
                    else if (jenis === 'pemotongan_unggas') tglItem = item.tanggal;
                    
                    if (tglItem && (tglItem < tanggalMulai || tglItem > tanggalSelesai)) {
                        return;
                    }
                }
            }

            const marker = createMarker(item, jenis);
            markerCluster.addLayer(marker);
            
            allMarkers.push({ marker, data: item, jenis });
            totalMarkers++;
            counts[jenis]++;
        });
    });

    document.getElementById('totalMarkers').innerText = totalMarkers;
    document.getElementById('totalFiltered').innerText = totalMarkers;
    
    // Update legend counts
    document.getElementById('countPengobatan').innerText = counts.pengobatan;
    document.getElementById('countVaksinasi').innerText = counts.vaksinasi;
    document.getElementById('countPelakuUsaha').innerText = counts.pelaku_usaha;
    document.getElementById('countPenjualPakan').innerText = counts.penjual_pakan;
    document.getElementById('countKlinik').innerText = counts.klinik_hewan;
    document.getElementById('countPenjualObat').innerText = counts.penjual_obat;
    document.getElementById('countRPU').innerText = counts.rpu;
    document.getElementById('countPemotonganUnggas').innerText = counts.pemotongan_unggas;
    document.getElementById('countDemplot').innerText = counts.demplot;
    
    updateKecamatanCounts();
    hideLoading();
}

// Buat marker
function createMarker(item, jenis) {
    const icon = L.divIcon({
        html: `<div style="background-color: ${warnaMarker[jenis]}; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                <i class="fas ${ikonMarker[jenis]}"></i>
               </div>`,
        className: 'custom-marker',
        iconSize: [28, 28],
        iconAnchor: [14, 14],
        popupAnchor: [0, -14]
    });

    const marker = L.marker([item.latitude, item.longitude], { icon });
    
    const popupContent = createPopupContent(item, jenis);
    marker.bindPopup(popupContent);

    marker.on('click', () => {
        showDetailPanel(item, jenis);
    });

    return marker;
}

// Buat konten popup
function createPopupContent(item, jenis) {
    let content = `<div class="popup-title">`;
    let namaKecamatan = dataDariServer.kecamatan.find(k => k.id === item.id_kecamatan)?.nama_kecamatan || '-';
    
    switch(jenis) {
        case 'pengobatan':
            content += `<i class="fas fa-notes-medical me-2" style="color: ${warnaMarker[jenis]}"></i>Data Pengobatan`;
            break;
        case 'vaksinasi':
            content += `<i class="fas fa-syringe me-2" style="color: ${warnaMarker[jenis]}"></i>Data Vaksinasi`;
            break;
        case 'pelaku_usaha':
            content += `<i class="fas fa-users me-2" style="color: ${warnaMarker[jenis]}"></i>Pelaku Usaha`;
            break;
        case 'penjual_pakan':
            content += `<i class="fas fa-seedling me-2" style="color: ${warnaMarker[jenis]}"></i>Penjual Pakan`;
            break;
        case 'klinik_hewan':
            content += `<i class="fas fa-clinic-medical me-2" style="color: ${warnaMarker[jenis]}"></i>Klinik Hewan`;
            break;
        case 'penjual_obat':
            content += `<i class="fas fa-pills me-2" style="color: ${warnaMarker[jenis]}"></i>Penjual Obat`;
            break;
        case 'rpu':
            content += `<i class="fas fa-cut me-2" style="color: ${warnaMarker[jenis]}"></i>RPU`;
            break;
        case 'pemotongan_unggas':
            content += `<i class="fas fa-drumstick-bite me-2" style="color: ${warnaMarker[jenis]}"></i>Pemotongan Unggas`;
            break;
        case 'demplot':
            content += `<i class="fas fa-seedling me-2" style="color: ${warnaMarker[jenis]}"></i>Demplot`;
            break;
    }
    
    content += `</div>`;

    switch(jenis) {
        case 'pengobatan':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Peternak:</span>
                    <span class="popup-value">${item.nama_peternak || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Tanggal:</span>
                    <span class="popup-value">${item.tanggal_pengobatan || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Diagnosa:</span>
                    <span class="popup-value">${item.diagnosa || '-'}</span>
                </div>
            `;
            break;
            
        case 'vaksinasi':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Peternak:</span>
                    <span class="popup-value">${item.nama_peternak || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Tanggal:</span>
                    <span class="popup-value">${item.tanggal_vaksinasi || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jenis Vaksin:</span>
                    <span class="popup-value">${item.jenis_vaksin || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jumlah:</span>
                    <span class="popup-value">${item.jumlah_ternak || '0'} ekor</span>
                </div>
            `;
            break;
            
        case 'pelaku_usaha':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Nama:</span>
                    <span class="popup-value">${item.nama_pelaku || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jenis Usaha:</span>
                    <span class="popup-value">${item.jenis_usaha || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Skala:</span>
                    <span class="popup-value">${item.skala_usaha || '-'}</span>
                </div>
            `;
            break;
            
        case 'penjual_pakan':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Toko:</span>
                    <span class="popup-value">${item.nama_toko || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Pemilik:</span>
                    <span class="popup-value">${item.pemilik || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jenis Pakan:</span>
                    <span class="popup-value">${item.jenis_pakan || '-'}</span>
                </div>
            `;
            break;
            
        case 'klinik_hewan':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Klinik:</span>
                    <span class="popup-value">${item.nama_klinik || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Dokter:</span>
                    <span class="popup-value">${item.dokter_hewan || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Layanan:</span>
                    <span class="popup-value">${item.layanan || '-'}</span>
                </div>
            `;
            break;
            
        case 'penjual_obat':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Toko:</span>
                    <span class="popup-value">${item.nama_toko || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Pemilik:</span>
                    <span class="popup-value">${item.pemilik || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">No. SIPA:</span>
                    <span class="popup-value">${item.no_sipa || '-'}</span>
                </div>
            `;
            break;
            
        case 'rpu':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Nama RPU:</span>
                    <span class="popup-value">${item.nama_rpu || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Tanggal:</span>
                    <span class="popup-value">${item.tanggal_rpu || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jumlah Potong:</span>
                    <span class="popup-value">${item.jumlah_ekor || '0'} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Tersedia Juleha:</span>
                    <span class="popup-value">${item.tersedia_juleha || '-'}</span>
                </div>
            `;
            break;
            
        case 'pemotongan_unggas':
            const total = (item.ayam || 0) + (item.itik || 0) + (item.dst || 0);
            content += `
                <div class="popup-item">
                    <span class="popup-label">Tanggal:</span>
                    <span class="popup-value">${item.tanggal || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Ayam:</span>
                    <span class="popup-value">${item.ayam || 0} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Itik:</span>
                    <span class="popup-value">${item.itik || 0} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Lainnya:</span>
                    <span class="popup-value">${item.dst || 0} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Total:</span>
                    <span class="popup-value">${total} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Daerah Asal:</span>
                    <span class="popup-value">${item.daerah_asal || '-'}</span>
                </div>
            `;
            break;
            
        case 'demplot':
            content += `
                <div class="popup-item">
                    <span class="popup-label">Nama Demplot:</span>
                    <span class="popup-value">${item.nama_demplot || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Luas Lahan:</span>
                    <span class="popup-value">${item.luas_m2 || 0} m²</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jenis Hewan:</span>
                    <span class="popup-value">${item.jenis_hewan || '-'}</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Jumlah:</span>
                    <span class="popup-value">${item.jumlah_hewan || 0} ekor</span>
                </div>
                <div class="popup-item">
                    <span class="popup-label">Stok Pakan:</span>
                    <span class="popup-value">${item.stok_pakan || '-'}</span>
                </div>
            `;
            break;
    }

    content += `
        <div class="popup-item">
            <span class="popup-label">Kecamatan:</span>
            <span class="popup-value">${namaKecamatan}</span>
        </div>
        <div class="popup-item">
            <span class="popup-label">Alamat:</span>
            <span class="popup-value">${item.alamat || '-'}</span>
        </div>
        <button class="popup-btn" onclick="window.showDetailFromPopup('${jenis}', ${item.id})">
            <i class="fas fa-info-circle me-1"></i>Lihat Detail
        </button>
    `;

    return content;
}

window.showDetailFromPopup = function(jenis, id) {
    const data = dataDariServer[jenis];
    const item = data.find(d => d.id == id);
    if (item) {
        showDetailPanel(item, jenis);
    }
};

function showDetailPanel(item, jenis) {
    const panel = document.getElementById('detailPanel');
    const body = document.getElementById('detailBody');
    let namaKecamatan = dataDariServer.kecamatan.find(k => k.id === item.id_kecamatan)?.nama_kecamatan || '-';
    
    let html = '';
    
    switch(jenis) {
        case 'pengobatan':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Pengobatan</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Peternak:</span>
                    <span class="detail-value">${item.nama_peternak || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">${item.tanggal_pengobatan || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Diagnosa:</span>
                    <span class="detail-value">${item.diagnosa || '-'}</span>
                </div>
            `;
            break;
            
        case 'vaksinasi':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Vaksinasi</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Peternak:</span>
                    <span class="detail-value">${item.nama_peternak || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">${item.tanggal_vaksinasi || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Vaksin:</span>
                    <span class="detail-value">${item.jenis_vaksin || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah:</span>
                    <span class="detail-value">${item.jumlah_ternak || '0'} ekor</span>
                </div>
            `;
            break;
            
        case 'pelaku_usaha':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Pelaku Usaha</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama:</span>
                    <span class="detail-value">${item.nama_pelaku || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Usaha:</span>
                    <span class="detail-value">${item.jenis_usaha || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Skala:</span>
                    <span class="detail-value">${item.skala_usaha || '-'}</span>
                </div>
            `;
            break;
            
        case 'penjual_pakan':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Penjual Pakan</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Toko:</span>
                    <span class="detail-value">${item.nama_toko || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pemilik:</span>
                    <span class="detail-value">${item.pemilik || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Pakan:</span>
                    <span class="detail-value">${item.jenis_pakan || '-'}</span>
                </div>
            `;
            break;
            
        case 'klinik_hewan':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Klinik Hewan</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Klinik:</span>
                    <span class="detail-value">${item.nama_klinik || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Dokter:</span>
                    <span class="detail-value">${item.dokter_hewan || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Layanan:</span>
                    <span class="detail-value">${item.layanan || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jam Operasional:</span>
                    <span class="detail-value">${item.jam_operasional || '-'}</span>
                </div>
            `;
            break;
            
        case 'penjual_obat':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Penjual Obat</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Toko:</span>
                    <span class="detail-value">${item.nama_toko || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pemilik:</span>
                    <span class="detail-value">${item.pemilik || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">No. SIPA:</span>
                    <span class="detail-value">${item.no_sipa || '-'}</span>
                </div>
            `;
            break;
            
        case 'rpu':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">RPU</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama RPU:</span>
                    <span class="detail-value">${item.nama_rpu || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">${item.tanggal_rpu || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah Potong:</span>
                    <span class="detail-value">${item.jumlah_ekor || '0'} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tersedia Juleha:</span>
                    <span class="detail-value">${item.tersedia_juleha || '-'}</span>
                </div>
            `;
            break;
            
        case 'pemotongan_unggas':
            const total = (item.ayam || 0) + (item.itik || 0) + (item.dst || 0);
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Pemotongan Unggas</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal:</span>
                    <span class="detail-value">${item.tanggal || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ayam:</span>
                    <span class="detail-value">${item.ayam || 0} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Itik:</span>
                    <span class="detail-value">${item.itik || 0} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lainnya:</span>
                    <span class="detail-value">${item.dst || 0} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total:</span>
                    <span class="detail-value">${total} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Daerah Asal:</span>
                    <span class="detail-value">${item.daerah_asal || '-'}</span>
                </div>
            `;
            break;
            
        case 'demplot':
            html = `
                <div class="detail-row">
                    <span class="detail-label">Jenis Data:</span>
                    <span class="detail-value">Demplot</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Demplot:</span>
                    <span class="detail-value">${item.nama_demplot || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Luas Lahan:</span>
                    <span class="detail-value">${item.luas_m2 || 0} m²</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenis Hewan:</span>
                    <span class="detail-value">${item.jenis_hewan || '-'}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah:</span>
                    <span class="detail-value">${item.jumlah_hewan || 0} ekor</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stok Pakan:</span>
                    <span class="detail-value">${item.stok_pakan || '-'}</span>
                </div>
            `;
            break;
    }
    
    html += `
        <div class="detail-row">
            <span class="detail-label">Kecamatan:</span>
            <span class="detail-value">${namaKecamatan}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Alamat:</span>
            <span class="detail-value">${item.alamat || '-'}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">No. HP:</span>
            <span class="detail-value">${item.no_hp || '-'}</span>
        </div>
    `;
    
    body.innerHTML = html;
    panel.classList.add('active');
}

function updateKecamatanCounts() {
    const counts = {};
    dataDariServer.kecamatan.forEach(k => counts[k.id] = 0);

    allMarkers.forEach(({ data }) => {
        const idKec = data.id_kecamatan;
        if (counts[idKec] !== undefined) {
            counts[idKec]++;
        }
    });

    Object.keys(counts).forEach(idKec => {
        const el = document.getElementById(`count_${idKec}`);
        if (el) {
            el.innerText = counts[idKec];
        }
    });
}

function setupEventListeners() {
    // Data type selector
    document.querySelectorAll('.data-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            const dataType = this.dataset.type;
            
            if (this.classList.contains('active')) {
                activeDataTypes.add(dataType);
            } else {
                activeDataTypes.delete(dataType);
            }
            
            document.getElementById('activeDataCount').innerText = `${activeDataTypes.size}/9`;
            loadDataKePeta();
        });
    });

    // Apply filter
    document.getElementById('applyFilter').addEventListener('click', function() {
        tanggalMulai = document.getElementById('tanggalMulai').value;
        tanggalSelesai = document.getElementById('tanggalSelesai').value;
        loadDataKePeta();
    });

    // Reset filter
    document.getElementById('resetFilter').addEventListener('click', function() {
        document.querySelectorAll('.data-type-btn').forEach(btn => {
            btn.classList.add('active');
        });
        activeDataTypes = new Set(['pengobatan', 'vaksinasi', 'pelaku_usaha', 'penjual_pakan', 'klinik_hewan', 'penjual_obat', 'rpu', 'pemotongan_unggas', 'demplot']);
        document.getElementById('activeDataCount').innerText = '9/9';

        document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
            cb.checked = true;
            selectedKecamatan.add(parseInt(cb.value));
        });
        document.getElementById('selectAllKecamatan').checked = true;

        document.getElementById('tanggalMulai').value = '';
        document.getElementById('tanggalSelesai').value = '';
        tanggalMulai = null;
        tanggalSelesai = null;

        document.getElementById('searchInput').value = '';

        loadDataKePeta();
    });

    // Search
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        
        if (keyword.length < 3) return;

        for (let { marker, data, jenis } of allMarkers) {
            let match = false;
            
            switch(jenis) {
                case 'pengobatan':
                case 'vaksinasi':
                    match = data.nama_peternak && data.nama_peternak.toLowerCase().includes(keyword);
                    break;
                case 'pelaku_usaha':
                    match = data.nama_pelaku && data.nama_pelaku.toLowerCase().includes(keyword);
                    break;
                case 'penjual_pakan':
                case 'penjual_obat':
                    match = (data.nama_toko && data.nama_toko.toLowerCase().includes(keyword)) ||
                           (data.pemilik && data.pemilik.toLowerCase().includes(keyword));
                    break;
                case 'klinik_hewan':
                    match = (data.nama_klinik && data.nama_klinik.toLowerCase().includes(keyword)) ||
                           (data.dokter_hewan && data.dokter_hewan.toLowerCase().includes(keyword));
                    break;
                case 'rpu':
                    match = data.nama_rpu && data.nama_rpu.toLowerCase().includes(keyword);
                    break;
                case 'demplot':
                    match = data.nama_demplot && data.nama_demplot.toLowerCase().includes(keyword);
                    break;
                case 'pemotongan_unggas':
                    match = data.daerah_asal && data.daerah_asal.toLowerCase().includes(keyword);
                    break;
            }

            if (match) {
                marker.openPopup();
                map.setView(marker.getLatLng(), 15);
                break;
            }
        }
    });

    // Map controls
    document.getElementById('zoomInBtn').addEventListener('click', () => map.zoomIn());
    document.getElementById('zoomOutBtn').addEventListener('click', () => map.zoomOut());
    document.getElementById('resetViewBtn').addEventListener('click', () => map.setView([-7.2575, 112.7521], 12));
    
    document.getElementById('locateMeBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => map.setView([position.coords.latitude, position.coords.longitude], 15),
                () => alert('Tidak dapat mengakses lokasi Anda')
            );
        } else {
            alert('Browser tidak mendukung geolokasi');
        }
    });

    // Close detail panel
    document.getElementById('closeDetailBtn').addEventListener('click', function() {
        document.getElementById('detailPanel').classList.remove('active');
    });

    // Click outside to close detail panel
    document.addEventListener('click', function(e) {
        const panel = document.getElementById('detailPanel');
        if (panel.classList.contains('active') && 
            !panel.contains(e.target) && 
            !e.target.closest('.leaflet-popup-content')) {
            panel.classList.remove('active');
        }
    });
}

function showLoading() {
    document.getElementById('loadingOverlay').classList.add('active');
}

function hideLoading() {
    document.getElementById('loadingOverlay').classList.remove('active');
}