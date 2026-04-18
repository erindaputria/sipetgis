// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentFarmMarker = null;
let dataTable = null;
let deleteId = null;
let allData = [];

// Data dummy untuk sementara
const dummyData = [
    {
        id: 1,
        tanggal_pengobatan: "2025-03-15",
        nama_petugas: "Drh. Ahmad Wijaya",
        nama_peternak: "Budi Santoso",
        nik: "3515085606040001",
        kecamatan: "Sawahan",
        kelurahan: "Pakis",
        rt: "02",
        rw: "03",
        latitude: "-7.2575",
        longitude: "112.7521",
        jumlah: 5,
        komoditas_ternak: "Sapi Potong",
        gejala_klinis: "Demam tinggi, nafsu makan menurun",
        jenis_pengobatan: "Antibiotik",
        bantuan_prov: "Ya",
        telp: "081234567890",
        jenis_kelamin: "Jantan",
        keterangan: "Pengobatan berhasil, sapi pulih setelah 3 hari",
        foto_pengobatan: null
    },
    {
        id: 2,
        tanggal_pengobatan: "2025-03-10",
        nama_petugas: "Drh. Siti Rahayu",
        nama_peternak: "Ternak Sejahtera Group",
        nik: "3515085606040002",
        kecamatan: "Tambaksari",
        kelurahan: "Gading",
        rt: "05",
        rw: "02",
        latitude: "-7.2650",
        longitude: "112.7475",
        jumlah: 12,
        komoditas_ternak: "Ayam Ras Petelur",
        gejala_klinis: "Batuk, bersin, produksi telur menurun",
        jenis_pengobatan: "Vitamin dan Probiotik",
        bantuan_prov: "Tidak",
        telp: "081234567891",
        jenis_kelamin: "Betina",
        keterangan: "Perlu pengobatan lanjutan 1 minggu lagi",
        foto_pengobatan: null
    },
    {
        id: 3,
        tanggal_pengobatan: "2025-03-05",
        nama_petugas: "Drh. Budi Setiawan",
        nama_peternak: "Mekar Sari Farm",
        nik: "3515085606040003",
        kecamatan: "Rungkut",
        kelurahan: "Wonorejo",
        rt: "08",
        rw: "04",
        latitude: "-7.2600",
        longitude: "112.7500",
        jumlah: 8,
        komoditas_ternak: "Kambing",
        gejala_klinis: "Diare, lemah",
        jenis_pengobatan: "Antibiotik dan Oralit",
        bantuan_prov: "Ya",
        telp: "081234567892",
        jenis_kelamin: "Jantan",
        keterangan: "Sudah sembuh, monitoring lanjutan",
        foto_pengobatan: null
    }
];

// Data kelurahan per kecamatan (LENGKAP)
const kelurahanData = {
    'Asemrowo': ['Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'],
    'Benowo': ['Benowo', 'Kandangan', 'Rompokalisari', 'Sememi', 'Tambak Osowilangon'],
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
    'Krembangan': ['Dupak', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat', 'Perak Timur'],
    'Lakarsantri': ['Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'],
    'Mulyorejo': ['Dukuh Sutorejo', 'Kalijudan', 'Kalisari', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'],
    'Pabean Cantian': ['Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'],
    'Pakal': ['Babat Jerawat', 'Benowo', 'Pakal', 'Sumber Rejo', 'Tambak Dono'],
    'Rungkut': ['Kedung Baruk', 'Medokan Ayu', 'Penjaringansari', 'Rungkut Kidul', 'Rungkut Tengah', 'Wonorejo'],
    'Sambikerep': ['Bringin', 'Lontar', 'Made', 'Sambikerep', 'Sememi'],
    'Sawahan': ['Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'],
    'Semampir': ['Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'],
    'Simokerto': ['Kapasan', 'Simokerto', 'Tambakrejo', 'Sidodadi'],
    'Sukolilo': ['Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'],
    'Sukomanunggal': ['Putat Gede', 'Simomulyo', 'Sukomanunggal', 'Tanah Kali Kedinding', 'Tandes Kidul'],
    'Tambaksari': ['Dukuh Setro', 'Gading', 'Kapas Madya', 'Pacar Keling', 'Pacar Kembang', 'Ploso', 'Rangkah', 'Tambaksari'],
    'Tandes': ['Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'],
    'Tegalsari': ['Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'],
    'Tenggilis Mejoyo': ['Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'],
    'Wiyung': ['Babat Jerawat', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'],
    'Wonocolo': ['Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'],
    'Wonokromo': ['Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo']
};

// Fungsi untuk update kelurahan options
function updateKelurahanOptions(selectedKec, targetId) {
    var options = '<option value="">Pilih Kelurahan</option>';
    if (selectedKec && kelurahanData[selectedKec]) {
        kelurahanData[selectedKec].sort().forEach(function(kel) {
            options += '<option value="' + kel + '">' + kel + '</option>';
        });
    }
    $(targetId).html(options);
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    // Load dummy data
    allData = dummyData;
    renderTable(allData);
    
    // Initialize DataTable
    dataTable = $("#historyDataTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA PENGOBATAN TERNAK',
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
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA PENGOBATAN TERNAK</h2>' +
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
        responsive: false,
        scrollX: true,
        columnDefs: [
            { orderable: false, targets: [7, 15, 16] }
        ]
    });
    
    // Event: Filter Kecamatan -> update kelurahan
    $("#filterKecamatan").change(function() {
        var selectedKec = $(this).val();
        if (selectedKec === 'all') {
            $("#filterKelurahan").html('<option selected value="all">Semua Kelurahan</option>');
        } else {
            updateKelurahanOptions(selectedKec, '#filterKelurahan');
            $("#filterKelurahan").prepend('<option value="all">Semua Kelurahan</option>');
            $("#filterKelurahan").val('all');
        }
    });
    
    // Event: Edit Kecamatan -> update kelurahan di modal edit
    $("#edit_kecamatan").change(function() {
        var selectedKec = $(this).val();
        updateKelurahanOptions(selectedKec, '#edit_kelurahan');
    });
    
    // Event listeners
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);
    $("#closeMapBtn").click(closeMap);
    
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
        if (map && currentFarmMarker) {
            var latlng = currentFarmMarker.getLatLng();
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
        var id = $("#edit_id").val();
        var updatedData = {
            id: parseInt(id),
            tanggal_pengobatan: $("#edit_tanggal").val(),
            nama_petugas: $("#edit_petugas").val(),
            nama_peternak: $("#edit_peternak").val(),
            nik: $("#edit_nik").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            jumlah: parseInt($("#edit_jumlah").val()),
            komoditas_ternak: $("#edit_komoditas").val(),
            gejala_klinis: $("#edit_gejala").val(),
            jenis_pengobatan: $("#edit_tindakan").val(),
            bantuan_prov: $("#edit_bantuan").val(),
            telp: $("#edit_telp").val(),
            jenis_kelamin: $("#edit_jk").val(),
            keterangan: $("#edit_keterangan").val(),
            foto_pengobatan: null
        };
        
        var index = allData.findIndex(function(item) { return item.id === parseInt(id); });
        if (index !== -1) {
            allData[index] = updatedData;
            renderTable(allData);
            $("#editModal").modal("hide");
            alert("Data berhasil diupdate");
        }
    });
});

// ================ RENDER TABLE ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            var tanggal = formatDate(item.tanggal_pengobatan);
            
            var telp = item.telp ? 
                '<a href="tel:' + item.telp + '" class="telp-link" title="Telepon">' +
                '<i class="fas fa-phone-alt"></i> ' + item.telp +
                '</a>' : 
                '<span class="text-muted">-</span>';
            
            var bantuanProv = item.bantuan_prov === 'Ya' ? 
                '<span class="badge-bantuan-ya">Ya</span>' : 
                '<span class="badge-bantuan-tidak">Tidak</span>';
            
            var jenisKelamin = item.jenis_kelamin === 'Jantan' ? 
                '<span class="badge-jk-jantan">Jantan</span>' : 
                item.jenis_kelamin === 'Betina' ? 
                '<span class="badge-jk-betina">Betina</span>' : 
                '-';
            
            var btnMap = (item.latitude && item.longitude) ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + item.komoditas_ternak + '\', \'' + item.nama_peternak + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>';
            
            var fotoLink = item.foto_pengobatan ? 
                '<a href="javascript:void(0)" class="foto-link" onclick="showFoto(\'' + base_url + 'uploads/pengobatan/' + item.foto_pengobatan + '\')" title="Lihat Foto">' +
                '<i class="fas fa-image"></i>' +
                '</a>' : 
                '<span class="badge-foto">No Foto</span>';
            
            var nik = item.nik ? 
                '<span class="nik-text">' + item.nik + '</span>' : 
                '-';
            
            html += '<tr>' +
                '<td>' + no + '</td>' +
                '<td>' + tanggal + '</td>' +
                '<td>' + (item.nama_petugas || '-') + '</td>' +
                '<td>' + (item.nama_peternak || '-') + '</td>' +
                '<td>' + nik + '</td>' +
                '<td>' + (item.kecamatan || '-') + '</td>' +
                '<td>' + (item.kelurahan || '-') + '</td>' +
                '<td>' + btnMap + '</td>' +
                '<td><span class="badge-jumlah">' + (item.jumlah || 0) + '</span> <span class="text-muted">Ekor</span></td>' +
                '<td>' + (item.komoditas_ternak || '-') + '</td>' +
                '<td>' + (item.gejala_klinis || '-') + '</td>' +
                '<td>' + (item.jenis_pengobatan || '-') + '</td>' +
                '<td>' + bantuanProv + '</td>' +
                '<td>' + telp + '</td>' +
                '<td>' + jenisKelamin + '</td>' +
                '<td>' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit">' +
                '<i class="fas fa-edit"></i>' +
                '</button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + item.nama_peternak + '\')" title="Hapus">' +
                '<i class="fas fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</td>' +
                '<td>' + fotoLink + '</td>' +
                '</td>';
        });
    } else {
        html = '<tr><td colspan="17" class="text-center">Tidak ada data pengobatan</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>';
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
        $('#edit_tanggal').val(item.tanggal_pengobatan);
        $('#edit_petugas').val(item.nama_petugas);
        $('#edit_peternak').val(item.nama_peternak);
        $('#edit_nik').val(item.nik);
        $('#edit_kecamatan').val(item.kecamatan);
        
        // Update kelurahan options berdasarkan kecamatan yang dipilih
        updateKelurahanOptions(item.kecamatan, '#edit_kelurahan');
        setTimeout(function() {
            $('#edit_kelurahan').val(item.kelurahan);
        }, 100);
        
        $('#edit_rt').val(item.rt);
        $('#edit_rw').val(item.rw);
        $('#edit_latitude').val(item.latitude);
        $('#edit_longitude').val(item.longitude);
        $('#edit_jumlah').val(item.jumlah);
        $('#edit_komoditas').val(item.komoditas_ternak);
        $('#edit_jk').val(item.jenis_kelamin);
        $('#edit_telp').val(item.telp);
        $('#edit_gejala').val(item.gejala_klinis);
        $('#edit_tindakan').val(item.jenis_pengobatan);
        $('#edit_bantuan').val(item.bantuan_prov);
        $('#edit_keterangan').val(item.keterangan);
        
        $('#editModal').modal('show');
    }
}

// ================ FILTER ================
function filterData() {
    var komoditas = $("#filterKomoditas").val();
    var kecamatan = $("#filterKecamatan").val();
    var kelurahan = $("#filterKelurahan").val();
    var periode = $("#filterPeriode").val();
    
    var filteredData = allData;
    
    if (komoditas !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.komoditas_ternak === komoditas;
        });
    }
    
    if (kecamatan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.kecamatan === kecamatan;
        });
    }
    
    if (kelurahan !== "all" && kelurahan !== "") {
        filteredData = filteredData.filter(function(item) {
            return item.kelurahan === kelurahan;
        });
    }
    
    if (periode !== "all") {
        filteredData = filteredData.filter(function(item) {
            if (!item.tanggal_pengobatan) return false;
            var year = new Date(item.tanggal_pengobatan).getFullYear();
            return year.toString() === periode;
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKomoditas").val("all");
    $("#filterKecamatan").val("all");
    $("#filterKelurahan").html('<option selected value="all">Semua Kelurahan</option>');
    $("#filterPeriode").val("all");
    renderTable(allData);
}

// ================ UTILITIES ================
function formatDate(dateString) {
    if (!dateString) return "-";
    var d = new Date(dateString);
    var day = String(d.getDate()).padStart(2, '0');
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var year = d.getFullYear();
    return day + '-' + month + '-' + year;
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
    allData = allData.filter(function(item) {
        return item.id !== id;
    });
    renderTable(allData);
    $("#deleteModal").modal("hide");
    alert("Data berhasil dihapus");
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
        '<div class="mb-2"><span class="fw-bold">Nama Peternak:</span><br><span class="text-primary fw-bold">' + peternak + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Komoditas:</span><br><span class="badge bg-primary-custom">' + komoditas + '</span></div>' +
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
                '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + peternak + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Komoditas:</strong> ' + komoditas + '</div>' +
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
            '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + peternak + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Komoditas:</strong> ' + komoditas + '</div>' +
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

// Base URL
var base_url = "<?= base_url() ?>";