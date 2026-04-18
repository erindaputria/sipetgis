// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentShopMarker = null;
let dataTable = null;
let deleteId = null;

// Data Penjual Obat Hewan (tersebar di 31 kecamatan Surabaya)
let allData = [
    {
        id: 1,
        nama_toko: "Apotek Hewan Satwa Sehat",
        pemilik: "drh. Ahmad Fauzi",
        kecamatan: "Sukolilo",
        kelurahan: "Keputih",
        alamat: "Jl. Raya ITS No. 45",
        rt: "005",
        rw: "003",
        telepon: "031-5945678",
        latitude: "-7.2876",
        longitude: "112.7891",
        kategori_obat: ["Antibiotik", "Vitamin", "Antiparasit"],
        surat_ijin: "Y",
        keterangan: "Apotek hewan yang menyediakan berbagai obat-obatan hewan berkualitas."
    },
    {
        id: 2,
        nama_toko: "UD. Obat Hewan Sejahtera",
        pemilik: "Budi Santoso",
        kecamatan: "Rungkut",
        kelurahan: "Rungkut Kidul",
        alamat: "Jl. Raya Rungkut Industri No. 78",
        rt: "002",
        rw: "005",
        telepon: "031-8723456",
        latitude: "-7.3265",
        longitude: "112.7683",
        kategori_obat: ["Antibiotik", "Hormon", "Antiseptik"],
        surat_ijin: "Y",
        keterangan: "Toko obat hewan untuk peternakan."
    },
    {
        id: 3,
        nama_toko: "CV. Vet Medika Surabaya",
        pemilik: "Siti Aminah",
        kecamatan: "Gubeng",
        kelurahan: "Gubeng",
        alamat: "Jl. Gubeng Raya No. 112",
        rt: "001",
        rw: "002",
        telepon: "031-5034567",
        latitude: "-7.2667",
        longitude: "112.7500",
        kategori_obat: ["Obat Khusus", "Vitamin", "Antiparasit"],
        surat_ijin: "Y",
        keterangan: "Distributor obat-obatan hewan khusus."
    },
    {
        id: 4,
        nama_toko: "Toko Obat Hewan Kenari",
        pemilik: "Supriyadi",
        kecamatan: "Wonokromo",
        kelurahan: "Wonokromo",
        alamat: "Jl. Kenari No. 34",
        rt: "003",
        rw: "004",
        telepon: "031-7256789",
        latitude: "-7.2953",
        longitude: "112.7389",
        kategori_obat: ["Antibiotik", "Antiseptik", "Vitamin"],
        surat_ijin: "Y",
        keterangan: "Toko obat hewan sederhana."
    },
    {
        id: 5,
        nama_toko: "PD. Obat Ternak Mulyorejo",
        pemilik: "Dwi Handayani",
        kecamatan: "Mulyorejo",
        kelurahan: "Kalisari",
        alamat: "Jl. Mulyorejo Utara No. 56",
        rt: "002",
        rw: "006",
        telepon: "031-5961234",
        latitude: "-7.2621",
        longitude: "112.7915",
        kategori_obat: ["Vitamin", "Hormon", "Antiparasit"],
        surat_ijin: "Y",
        keterangan: "Perusahaan daerah obat ternak."
    },
    {
        id: 6,
        nama_toko: "Toko Obat Hewan Tandes",
        pemilik: "Rudi Hartono",
        kecamatan: "Tandes",
        kelurahan: "Balongsari",
        alamat: "Jl. Tandes No. 89",
        rt: "004",
        rw: "002",
        telepon: "031-7112345",
        latitude: "-7.2439",
        longitude: "112.6816",
        kategori_obat: ["Antibiotik", "Antiseptik"],
        surat_ijin: "N",
        keterangan: "Toko obat hewan sederhana."
    },
    {
        id: 7,
        nama_toko: "CV. Obat Hewan Genteng",
        pemilik: "Hasan Basri",
        kecamatan: "Genteng",
        kelurahan: "Genteng",
        alamat: "Jl. Genteng Besar No. 23",
        rt: "001",
        rw: "003",
        telepon: "031-5345678",
        latitude: "-7.2581",
        longitude: "112.7394",
        kategori_obat: ["Obat Khusus", "Vitamin", "Hormon"],
        surat_ijin: "Y",
        keterangan: "Distributor obat hewan khusus."
    },
    {
        id: 8,
        nama_toko: "UD. Obat Hewan Tegalsari",
        pemilik: "Joko Susilo",
        kecamatan: "Tegalsari",
        kelurahan: "Keputran",
        alamat: "Jl. Tegalsari No. 67",
        rt: "002",
        rw: "005",
        telepon: "031-5489012",
        latitude: "-7.2815",
        longitude: "112.7322",
        kategori_obat: ["Antibiotik", "Antiparasit", "Vitamin"],
        surat_ijin: "N",
        keterangan: "UD obat hewan."
    },
    // Tambahan data untuk kecamatan lain
    {
        id: 9,
        nama_toko: "Apotek Hewan Asemrowo",
        pemilik: "drh. Slamet",
        kecamatan: "Asemrowo",
        kelurahan: "Asemrowo",
        alamat: "Jl. Asemrowo No. 10",
        rt: "001",
        rw: "001",
        telepon: "031-1234567",
        latitude: "-7.2167",
        longitude: "112.6833",
        kategori_obat: ["Antibiotik", "Vitamin"],
        surat_ijin: "Y",
        keterangan: "Apotek hewan di Asemrowo."
    },
    {
        id: 10,
        nama_toko: "Toko Obat Benowo",
        pemilik: "M. Yusuf",
        kecamatan: "Benowo",
        kelurahan: "Benowo",
        alamat: "Jl. Benowo No. 25",
        rt: "002",
        rw: "002",
        telepon: "031-2345678",
        latitude: "-7.2167",
        longitude: "112.6667",
        kategori_obat: ["Antiparasit", "Vitamin"],
        surat_ijin: "Y",
        keterangan: "Toko obat hewan di Benowo."
    }
];

// Data detail untuk modal detail (dengan daftar obat lengkap)
const detailData = {
    1: {
        daftar_obat: [
            {no: 1, nama: "Amoxicillin 500mg", kategori: "Antibiotik", jenis: "Tablet", harga: 150000, stok: "50 botol", keterangan: "Untuk infeksi bakteri"},
            {no: 2, nama: "Vitamin B Complex", kategori: "Vitamin", jenis: "Injeksi", harga: 85000, stok: "30 vial", keterangan: "Multivitamin"},
            {no: 3, nama: "Ivermectin 1%", kategori: "Antiparasit", jenis: "Injeksi", harga: 120000, stok: "40 botol", keterangan: "Untuk kutu dan cacing"},
            {no: 4, nama: "Doxycycline", kategori: "Antibiotik", jenis: "Tablet", harga: 135000, stok: "35 botol", keterangan: "Antibiotik broad spectrum"},
            {no: 5, nama: "Vitamin ADE", kategori: "Vitamin", jenis: "Injeksi", harga: 95000, stok: "25 vial", keterangan: "Vitamin larut lemak"},
            {no: 6, nama: "Albendazole", kategori: "Antiparasit", jenis: "Tablet", harga: 110000, stok: "30 botol", keterangan: "Obat cacing"}
        ]
    },
    2: {
        daftar_obat: [
            {no: 1, nama: "Oxytetracycline LA", kategori: "Antibiotik", jenis: "Injeksi", harga: 175000, stok: "45 botol", keterangan: "Long acting"},
            {no: 2, nama: "Prostaglandin", kategori: "Hormon", jenis: "Injeksi", harga: 250000, stok: "20 vial", keterangan: "Sinkronisasi birahi"},
            {no: 3, nama: "Betadine Solution", kategori: "Antiseptik", jenis: "Cair", harga: 45000, stok: "60 botol", keterangan: "Antiseptik luka"},
            {no: 4, nama: "Penicillin-Streptomycin", kategori: "Antibiotik", jenis: "Injeksi", harga: 140000, stok: "35 botol", keterangan: "Kombinasi antibiotik"},
            {no: 5, nama: "Gentamicin Sulfate", kategori: "Antibiotik", jenis: "Injeksi", harga: 165000, stok: "30 botol", keterangan: "Untuk infeksi gram negatif"},
            {no: 6, nama: "Hormon Pregnant Mare", kategori: "Hormon", jenis: "Injeksi", harga: 320000, stok: "15 vial", keterangan: "Induksi birahi"},
            {no: 7, nama: "Chlorhexidine", kategori: "Antiseptik", jenis: "Cair", harga: 55000, stok: "40 botol", keterangan: "Antiseptik kuat"},
            {no: 8, nama: "Tylosin", kategori: "Antibiotik", jenis: "Injeksi", harga: 190000, stok: "25 botol", keterangan: "Untuk infeksi pernapasan"}
        ]
    },
    3: {
        daftar_obat: [
            {no: 1, nama: "Ketamin 10%", kategori: "Obat Khusus", jenis: "Injeksi", harga: 450000, stok: "15 botol", keterangan: "Anestesi"},
            {no: 2, nama: "Xylazine", kategori: "Obat Khusus", jenis: "Injeksi", harga: 380000, stok: "12 botol", keterangan: "Sedatif"},
            {no: 3, nama: "Multivitamin Plus", kategori: "Vitamin", jenis: "Injeksi", harga: 120000, stok: "40 vial", keterangan: "Vitamin lengkap"},
            {no: 4, nama: "Praziquantel", kategori: "Antiparasit", jenis: "Tablet", harga: 180000, stok: "25 botol", keterangan: "Obat cacing pita"},
            {no: 5, nama: "Atropine Sulfate", kategori: "Obat Khusus", jenis: "Injeksi", harga: 95000, stok: "30 botol", keterangan: "Antidot"},
            {no: 6, nama: "Vitamin C", kategori: "Vitamin", jenis: "Injeksi", harga: 75000, stok: "50 vial", keterangan: "Antioksidan"},
            {no: 7, nama: "Levamisole HCl", kategori: "Antiparasit", jenis: "Injeksi", harga: 145000, stok: "35 botol", keterangan: "Imunomodulator"},
            {no: 8, nama: "Diazepam", kategori: "Obat Khusus", jenis: "Injeksi", harga: 220000, stok: "20 botol", keterangan: "Antikonvulsan"},
            {no: 9, nama: "Vitamin E + Selenium", kategori: "Vitamin", jenis: "Injeksi", harga: 135000, stok: "30 vial", keterangan: "Untuk reproduksi"},
            {no: 10, nama: "Fenbendazole", kategori: "Antiparasit", jenis: "Tablet", harga: 160000, stok: "28 botol", keterangan: "Obat cacing broad spectrum"},
            {no: 11, nama: "Epinephrine", kategori: "Obat Khusus", jenis: "Injeksi", harga: 115000, stok: "25 botol", keterangan: "Syok anafilaktik"},
            {no: 12, nama: "Vitamin K", kategori: "Vitamin", jenis: "Injeksi", harga: 145000, stok: "22 vial", keterangan: "Anti perdarahan"}
        ]
    },
    4: {
        daftar_obat: [
            {no: 1, nama: "Amoxicillin Sirup", kategori: "Antibiotik", jenis: "Sirup", harga: 85000, stok: "20 botol", keterangan: "Untuk hewan kecil"},
            {no: 2, nama: "Betadine Salep", kategori: "Antiseptik", jenis: "Salep", harga: 35000, stok: "30 tube", keterangan: "Obat luka"},
            {no: 3, nama: "Vitamin B1", kategori: "Vitamin", jenis: "Tablet", harga: 45000, stok: "25 botol", keterangan: "Vitamin B kompleks"},
            {no: 4, nama: "Neomycin Salep", kategori: "Antibiotik", jenis: "Salep", harga: 55000, stok: "22 tube", keterangan: "Infeksi kulit"},
            {no: 5, nama: "Hansaplast Spray", kategori: "Antiseptik", jenis: "Spray", harga: 65000, stok: "18 botol", keterangan: "Antiseptik spray"}
        ]
    },
    5: {
        daftar_obat: [
            {no: 1, nama: "Vitamin B Kompleks Injeksi", kategori: "Vitamin", jenis: "Injeksi", harga: 95000, stok: "40 vial", keterangan: "Untuk ternak"},
            {no: 2, nama: "Progesteron", kategori: "Hormon", jenis: "Injeksi", harga: 185000, stok: "18 vial", keterangan: "Hormon kebuntingan"},
            {no: 3, nama: "Ivermectin 3.15%", kategori: "Antiparasit", jenis: "Injeksi", harga: 220000, stok: "25 botol", keterangan: "Long acting"},
            {no: 4, nama: "Vitamin ADE Injeksi", kategori: "Vitamin", jenis: "Injeksi", harga: 115000, stok: "35 vial", keterangan: "Untuk reproduksi"},
            {no: 5, nama: "Estradiol", kategori: "Hormon", jenis: "Injeksi", harga: 165000, stok: "20 vial", keterangan: "Hormon birahi"},
            {no: 6, nama: "Oxfendazole", kategori: "Antiparasit", jenis: "Tablet", harga: 140000, stok: "30 botol", keterangan: "Anthelmintik"},
            {no: 7, nama: "Mineral Blok", kategori: "Vitamin", jenis: "Blok", harga: 125000, stok: "40 pcs", keterangan: "Suplemen mineral"}
        ]
    },
    6: {
        daftar_obat: [
            {no: 1, nama: "Tetracycline Salep", kategori: "Antibiotik", jenis: "Salep", harga: 45000, stok: "20 tube", keterangan: "Infeksi mata"},
            {no: 2, nama: "Gentian Violet", kategori: "Antiseptik", jenis: "Cair", harga: 25000, stok: "15 botol", keterangan: "Obat luka"},
            {no: 3, nama: "Amoxicillin Kapsul", kategori: "Antibiotik", jenis: "Kapsul", harga: 75000, stok: "18 botol", keterangan: "Antibiotik oral"},
            {no: 4, nama: "Alcohol 70%", kategori: "Antiseptik", jenis: "Cair", harga: 30000, stok: "25 botol", keterangan: "Antiseptik"}
        ]
    },
    7: {
        daftar_obat: [
            {no: 1, nama: "Ketamin 10%", kategori: "Obat Khusus", jenis: "Injeksi", harga: 450000, stok: "15 botol", keterangan: "Anestesi"},
            {no: 2, nama: "Xylazine", kategori: "Obat Khusus", jenis: "Injeksi", harga: 380000, stok: "12 botol", keterangan: "Sedatif"},
            {no: 3, nama: "Multivitamin Plus", kategori: "Vitamin", jenis: "Injeksi", harga: 120000, stok: "40 vial", keterangan: "Vitamin lengkap"},
            {no: 4, nama: "Praziquantel", kategori: "Antiparasit", jenis: "Tablet", harga: 180000, stok: "25 botol", keterangan: "Obat cacing pita"},
            {no: 5, nama: "Atropine Sulfate", kategori: "Obat Khusus", jenis: "Injeksi", harga: 95000, stok: "30 botol", keterangan: "Antidot"},
            {no: 6, nama: "Vitamin C", kategori: "Vitamin", jenis: "Injeksi", harga: 75000, stok: "50 vial", keterangan: "Antioksidan"},
            {no: 7, nama: "Levamisole HCl", kategori: "Antiparasit", jenis: "Injeksi", harga: 145000, stok: "35 botol", keterangan: "Imunomodulator"},
            {no: 8, nama: "Diazepam", kategori: "Obat Khusus", jenis: "Injeksi", harga: 220000, stok: "20 botol", keterangan: "Antikonvulsan"},
            {no: 9, nama: "Vitamin E + Selenium", kategori: "Vitamin", jenis: "Injeksi", harga: 135000, stok: "30 vial", keterangan: "Untuk reproduksi"}
        ]
    },
    8: {
        daftar_obat: [
            {no: 1, nama: "Amoxicillin 500mg", kategori: "Antibiotik", jenis: "Tablet", harga: 150000, stok: "30 botol", keterangan: "Untuk infeksi bakteri"},
            {no: 2, nama: "Vitamin B Complex", kategori: "Vitamin", jenis: "Injeksi", harga: 85000, stok: "20 vial", keterangan: "Multivitamin"},
            {no: 3, nama: "Ivermectin 1%", kategori: "Antiparasit", jenis: "Injeksi", harga: 120000, stok: "25 botol", keterangan: "Untuk kutu dan cacing"},
            {no: 4, nama: "Doxycycline", kategori: "Antibiotik", jenis: "Tablet", harga: 135000, stok: "20 botol", keterangan: "Antibiotik broad spectrum"},
            {no: 5, nama: "Vitamin ADE", kategori: "Vitamin", jenis: "Injeksi", harga: 95000, stok: "15 vial", keterangan: "Vitamin larut lemak"},
            {no: 6, nama: "Albendazole", kategori: "Antiparasit", jenis: "Tablet", harga: 110000, stok: "18 botol", keterangan: "Obat cacing"}
        ]
    }
};

// ================ RENDER TABLE ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            
            var statusIjin = item.surat_ijin === 'Y' ? 
                '<span class="badge-status badge-ijin">Y</span>' : 
                '<span class="badge-status badge-belum-ijin">N</span>';
            
            var kategoriObat = item.kategori_obat.join(", ");
            
            var btnMap = (item.latitude && item.longitude) ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + item.nama_toko + '\', \'' + item.pemilik + '\', \'' + item.kecamatan + '\', \'' + item.kelurahan + '\', \'' + item.latitude + ', ' + item.longitude + '\', \'' + item.alamat + ', RT ' + item.rt + '/RW ' + item.rw + '\', \'' + item.telepon + '\', \'' + kategoriObat + '\', \'' + item.surat_ijin + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>';
            
            html += '<tr>' +
                '<td>' + no + '</td>' +
                '<td><span class="fw-bold">' + item.nama_toko + '</span><br><small class="text-muted">' + item.kategori_obat.length + ' kategori</small></td>' +
                '<td>' + item.pemilik + '</td>' +
                '<td>' + item.kecamatan + '</td>' +
                '<td>' + item.kelurahan + '</td>' +
                '<td>' + item.alamat + '<br><small>RT ' + item.rt + '/RW ' + item.rw + '</small></td>' +
                '<td>' + (item.telepon || '-') + '</td>' +
                '<td><span class="badge-obat">' + kategoriObat + '</span></td>' +
                '<td>' + statusIjin + '</td>' +
                '<td>' + btnMap + '</td>' +
                '<td>' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + item.nama_toko + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        });
    } else {
        html = '<tr><td colspan="11" class="text-center">Tidak ada data penjual obat hewan</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<tr>';
    }
    
    $("#dataTableBody").html(html);
    if (dataTable) {
        dataTable.clear();
        dataTable.rows.add($(html));
        dataTable.draw();
    }
}

// ================ EDIT DATA ================
function editData(id) {
    var item = allData.find(function(d) { return d.id === id; });
    if (item) {
        $('#edit_id').val(item.id);
        $('#edit_nama_toko').val(item.nama_toko);
        $('#edit_pemilik').val(item.pemilik);
        $('#edit_kecamatan').val(item.kecamatan);
        $('#edit_kelurahan').val(item.kelurahan);
        $('#edit_alamat').val(item.alamat);
        $('#edit_rt').val(item.rt);
        $('#edit_rw').val(item.rw);
        $('#edit_telepon').val(item.telepon);
        $('#edit_latitude').val(item.latitude);
        $('#edit_longitude').val(item.longitude);
        $('#edit_status').val(item.surat_ijin);
        $('#edit_kategori').val(item.kategori_obat.join(", "));
        $('#edit_keterangan').val(item.keterangan);
        
        $('#editModal').modal('show');
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data penjual obat: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    var index = allData.findIndex(function(item) { return item.id === id; });
    if (index !== -1) {
        allData.splice(index, 1);
        renderTable(allData);
    }
    $("#deleteModal").modal("hide");
    alert("Data berhasil dihapus");
}

// ================ FILTER ================
function filterData() {
    var kecamatan = $("#filterKecamatan").val();
    var ijin = $("#filterIjin").val();
    var kategori = $("#filterKategori").val();
    
    var filteredData = allData.slice();
    
    // Filter berdasarkan kecamatan - langsung pakai nilai asli (sudah sesuai dengan data)
    if (kecamatan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.kecamatan === kecamatan;
        });
    }
    
    if (ijin !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.surat_ijin === ijin;
        });
    }
    
    if (kategori !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.kategori_obat.includes(kategori);
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterIjin").val("all");
    $("#filterKategori").val("all");
    renderTable(allData.slice());
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterIjin").val("all");
    $("#filterKategori").val("all");
    renderTable(allData.slice());
}

// ================ MAP FUNCTION ================
function showMap(namaToko, pemilik, kecamatan, kelurahan, coordinates, alamat, telepon, kategoriObat, suratIjin) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    $("#mapTitle").text("Peta Lokasi " + namaToko);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Toko:</span> ' + namaToko + '<br>' +
        '<span class="fw-bold">Pemilik:</span> ' + pemilik + '<br>' +
        '<span class="fw-bold">Kecamatan:</span> ' + kecamatan + ' - ' + kelurahan +
        '</div>' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold">Telepon:</span> ' + telepon +
        '</div>' +
        '</div>'
    );
    
    $("#shopInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Toko:</span><br><span class="text-primary fw-bold">' + namaToko + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Pemilik:</span><br>' + pemilik + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kecamatan/Kelurahan:</span><br>' + kecamatan + ' - ' + kelurahan + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Alamat:</span><br>' + alamat + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kontak:</span><br><i class="fas fa-phone-alt me-1"></i> ' + telepon + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kategori Obat:</span><br><span class="badge-obat">' + kategoriObat + '</span></div>'
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">RT/RW:</span><br><code>' + (alamat.split('RT')[1] ? 'RT' + alamat.split('RT')[1].split(',')[0] : '-') + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    var kategoriArray = kategoriObat.split(',');
    var kategoriHtml = '<div class="row">';
    for (var i = 0; i < kategoriArray.length; i++) {
        kategoriHtml += '<div class="col-md-3"><div class="kategori-card"><i class="fas fa-pills text-primary me-1"></i>' + kategoriArray[i].trim() + '</div></div>';
    }
    kategoriHtml += '</div>';
    $("#kategoriInfo").html(kategoriHtml);
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var obatIcon = L.divIcon({
                html: '<div style="background-color: #dc3545; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
                className: "obat-marker",
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });
            
            currentShopMarker = L.marker([lat, lng], { icon: obatIcon }).addTo(map);
            currentShopMarker.bindPopup(
                '<div style="min-width: 250px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #dc3545; text-align: center;">' + namaToko + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Pemilik:</strong> ' + pemilik + '</div>' +
                '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
                '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
                '<div><strong>Kelurahan:</strong> ' + kelurahan + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
                '<div><strong>Kategori:</strong> ' + kategoriObat + '</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentShopMarker);
            
            var circle = L.circle([lat, lng], { color: "#dc3545", fillColor: "#dc3545", fillOpacity: 0.1, radius: 300 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);
        
        var obatIcon = L.divIcon({
            html: '<div style="background-color: #dc3545; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
            className: "obat-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });
        
        currentShopMarker = L.marker([lat, lng], { icon: obatIcon }).addTo(map);
        currentShopMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #dc3545; text-align: center;">' + namaToko + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Pemilik:</strong> ' + pemilik + '</div>' +
            '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
            '<div><strong>Kelurahan:</strong> ' + kelurahan + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
            '<div><strong>Kategori:</strong> ' + kategoriObat + '</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentShopMarker);
        
        var circle = L.circle([lat, lng], { color: "#dc3545", fillColor: "#dc3545", fillOpacity: 0.1, radius: 300 }).addTo(map);
        mapMarkers.push(circle);
        setTimeout(function() { map.invalidateSize(); }, 50);
    }
    
    $("#mapSection").show();
    $("html, body").animate({ scrollTop: $("#mapSection").offset().top - 20 }, 500);
    setTimeout(function() { if (map) map.invalidateSize(); }, 300);
}

// ================ SHOW DETAIL ================
function showDetail(id) {
    var item = allData.find(function(d) { return d.id === id; });
    var detail = detailData[id];
    
    if (!item) {
        alert("Data tidak ditemukan");
        return;
    }
    
    $("#detailTitle").text("Detail Penjual Obat: " + item.nama_toko);
    
    var statusIjin = item.surat_ijin === 'Y' ? 
        '<span class="badge-status badge-ijin">Memiliki Ijin</span>' : 
        '<span class="badge-status badge-belum-ijin">Belum Memiliki Ijin</span>';
    
    $("#detailInfo").html(statusIjin);
    
    // Informasi Toko
    $("#detailTokoInfo").html(
        '<table class="table table-sm table-borderless">' +
        '<tr><td width="35%"><strong>Nama Toko</strong></td><td>: ' + item.nama_toko + '</td></tr>' +
        '<tr><td><strong>Kecamatan</strong></td><td>: ' + item.kecamatan + '</td></tr>' +
        '<tr><td><strong>Kelurahan</strong></td><td>: ' + item.kelurahan + '</td></tr>' +
        '<tr><td><strong>RT/RW</strong></td><td>: RT ' + item.rt + ' / RW ' + item.rw + '</td></tr>' +
        '<tr><td><strong>Telepon</strong></td><td>: ' + item.telepon + '</td></tr>' +
        '</table>'
    );
    
    // Informasi Pemilik
    $("#detailPemilikInfo").html(
        '<table class="table table-sm table-borderless">' +
        '<tr><td width="35%"><strong>Nama Pemilik</strong></td><td>: ' + item.pemilik + '</td></tr>' +
        '<tr><td><strong>Kategori Obat</strong></td><td>: ' + item.kategori_obat.join(", ") + '</td></tr>' +
        '</table>'
    );
    
    // Informasi Lokasi
    var koordinat = (item.latitude && item.longitude) ? item.latitude + ", " + item.longitude : "Tidak tersedia";
    $("#detailLokasiInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<table class="table table-sm table-borderless">' +
        '<tr><td width="40%"><strong>Latitude</strong></td><td>: <code>' + (item.latitude || '-') + '</code></td></tr>' +
        '<tr><td><strong>Longitude</strong></td><td>: <code>' + (item.longitude || '-') + '</code></td></tr>' +
        '</table>' +
        '</div>' +
        '<div class="col-md-6">' +
        '<button class="btn btn-sm btn-primary-custom" onclick="showMap(\'' + item.nama_toko + '\', \'' + item.pemilik + '\', \'' + item.kecamatan + '\', \'' + item.kelurahan + '\', \'' + koordinat + '\', \'' + item.alamat + ', RT ' + item.rt + '/RW ' + item.rw + '\', \'' + item.telepon + '\', \'' + item.kategori_obat.join(", ") + '\', \'' + item.surat_ijin + '\')">' +
        '<i class="fas fa-map-marker-alt me-1"></i>Lihat di Peta' +
        '</button>' +
        '</div>' +
        '</div>'
    );
    
    // Informasi Obat dan Ijin
    $("#detailObatInfo").html(
        '<div class="mb-3"><strong>Keterangan:</strong><br><p class="text-muted">' + (item.keterangan || '-') + '</p></div>' +
        '<div class="mb-3"><strong>Status Ijin:</strong><br>' + statusIjin + '</div>' +
        '<div class="mb-3"><strong>Kategori Obat:</strong><br>' +
        '<div class="row">' +
        item.kategori_obat.map(function(kat) { 
            return '<div class="col-md-3"><span class="badge-obat">' + kat + '</span></div>';
        }).join('') +
        '</div></div>'
    );
    
    // Daftar Obat
    var obatHtml = "";
    if (detail && detail.daftar_obat && detail.daftar_obat.length > 0) {
        for (var i = 0; i < detail.daftar_obat.length; i++) {
            var ob = detail.daftar_obat[i];
            obatHtml += '<tr>' +
                '<td>' + ob.no + '</td>' +
                '<td>' + ob.nama + '</td>' +
                '<td>' + ob.kategori + '</td>' +
                '<td>' + ob.jenis + '</td>' +
                '<td>Rp ' + ob.harga.toLocaleString('id-ID') + '</td>' +
                '<td>' + ob.stok + '</td>' +
                '<td>' + ob.keterangan + '</td>' +
                '</tr>';
        }
    } else {
        obatHtml = '<tr><td colspan="7" class="text-center">Tidak ada data obat</td></tr>';
    }
    $("#detailObatBody").html(obatHtml);
    
    $("#detailSection").show();
    $("#mapSection").hide();
    
    $("html, body").animate({ scrollTop: $("#detailSection").offset().top - 20 }, 500);
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
    renderTable(allData);
    
    dataTable = $("#penjualObatTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA PENJUAL OBAT HEWAN',
                        style: 'title',
                        alignment: 'center',
                        margin: [0, 0, 0, 5]
                    });
                    
                    doc.content.unshift({
                        text: 'DINAS PETERNAKAN KOTA SURABAYA',
                        style: 'subtitle',
                        alignment: 'center',
                        margin: [0, 0, 0, 3]
                    });
                    
                    doc.content.unshift({
                        text: 'PEMERINTAH KOTA SURABAYA',
                        style: 'header',
                        alignment: 'center',
                        margin: [0, 0, 0, 15]
                    });
                    
                    doc.content.push({
                        text: 'Tanggal Cetak: ' + formattedDate,
                        style: 'date',
                        alignment: 'center',
                        margin: [0, 15, 0, 0]
                    });
                    
                    if (doc.content[3] && doc.content[3].table) {
                        var rows = doc.content[3].table.body;
                        
                        for (var i = 0; i < rows[0].length; i++) {
                            rows[0][i].fillColor = '#832706';
                            rows[0][i].color = '#ffffff';
                            rows[0][i].bold = true;
                            rows[0][i].alignment = 'center';
                        }
                        
                        for (var i = 1; i < rows.length; i++) {
                            for (var j = 0; j < rows[i].length; j++) {
                                rows[i][j].alignment = 'center';
                                rows[i][j].color = '#333333';
                                rows[i][j].fontSize = 9;
                            }
                        }
                    }
                    
                    doc.pageMargins = [20, 60, 20, 40];
                    
                    var headerText = 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
                    doc.header = {
                        text: headerText,
                        alignment: 'center',
                        fontSize: 8,
                        color: '#666666',
                        margin: [20, 15, 20, 0]
                    };
                    
                    doc.footer = function(currentPage, pageCount) {
                        return {
                            text: 'Halaman ' + currentPage + ' dari ' + pageCount,
                            alignment: 'center',
                            fontSize: 8,
                            color: '#666666',
                            margin: [20, 0, 20, 15]
                        };
                    };
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA PENJUAL OBAT HEWAN</h2>' +
                        '<p style="margin: 0;">Dinas Peternakan Kota Surabaya</p>' +
                        '<p style="margin: 0;">Pemerintah Kota Surabaya</p>' +
                        '<hr style="margin: 15px 0;">' +
                        '<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>' +
                        '</div>'
                    );
                    $(win.document.body).append(
                        '<div style="text-align: center; margin-top: 30px; font-size: 10px; color: #666;">' +
                        'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya' +
                        '</div>'
                    );
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
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { targets: [9], orderable: false },
            { targets: [10], orderable: false }
        ]
    });
    
    // Event listeners
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);
    $("#closeMapBtn").click(closeMap);
    $("#closeDetailBtn").click(function() {
        $("#detailSection").hide();
    });
    
    $("#btnMapView").click(function() {
        currentView = "map";
        updateMapView();
        $(this).addClass("active");
        $("#btnSatelliteView").removeClass("active");
    });
    
    $("#btnSatelliteView").click(function() {
        currentView = "satellite";
        updateMapView();
        $(this).addClass("active");
        $("#btnMapView").removeClass("active");
    });
    
    $("#btnResetView").click(function() {
        if (map && currentShopMarker) {
            var latlng = currentShopMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });
    
    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
    
    // Form edit submit
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var id = parseInt($("#edit_id").val());
        var kategoriArray = $("#edit_kategori").val().split(",").map(function(p) { return p.trim(); });
        
        var updatedData = {
            id: id,
            nama_toko: $("#edit_nama_toko").val(),
            pemilik: $("#edit_pemilik").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            alamat: $("#edit_alamat").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            telepon: $("#edit_telepon").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            kategori_obat: kategoriArray,
            surat_ijin: $("#edit_status").val(),
            keterangan: $("#edit_keterangan").val()
        };
        
        var index = allData.findIndex(function(item) { return item.id === id; });
        if (index !== -1) {
            allData[index] = updatedData;
            renderTable(allData);
            
            if (dataTable) {
                dataTable.clear();
                dataTable.rows.add($("#dataTableBody tr"));
                dataTable.draw();
            }
            
            $("#editModal").modal("hide");
            alert("Data berhasil diupdate");
        }
    });
});

// Base URL
var base_url = "<?= base_url() ?>";