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
    console.log('Loading data from server...');
    
    $.ajax({
        url: base_url + 'index.php/data_history_vaksinasi/get_all_data',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Data received:', response);
            if (response && response.length > 0) {
                allData = response;
                console.log('Total data:', allData.length);
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

// ================ UPDATE FILTER OPTIONS ================
function updateFilterOptions() {
    var komoditasSet = new Set();
    allData.forEach(function(item) {
        if (item.komoditas_ternak && item.komoditas_ternak !== '') {
            komoditasSet.add(item.komoditas_ternak);
        }
    });
    
    var komoditasOptions = '<option selected value="all">Semua Komoditas</option>';
    var sortedKomoditas = Array.from(komoditasSet).sort();
    sortedKomoditas.forEach(function(komoditas) {
        komoditasOptions += '<option value="' + komoditas + '">' + komoditas + '</option>';
    });
    $("#filterKomoditas").html(komoditasOptions);
    
    var tahunSet = new Set();
    allData.forEach(function(item) {
        if (item.tanggal_vaksinasi) {
            var year = new Date(item.tanggal_vaksinasi).getFullYear();
            tahunSet.add(year);
        }
    });
    
    var tahunOptions = '<option selected value="all">Semua Periode</option>';
    var sortedTahun = Array.from(tahunSet).sort().reverse();
    sortedTahun.forEach(function(tahun) {
        tahunOptions += '<option value="' + tahun + '">Tahun ' + tahun + '</option>';
    });
    $("#filterPeriode").html(tahunOptions);
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            var tanggal = formatDate(item.tanggal_vaksinasi);
            
            var koordinatText = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                item.latitude + ', ' + item.longitude : 
                'Koordinat tidak tersedia';
            
            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.jenis_vaksinasi || '') + '\', \'' + escapeHtml(item.nama_peternak || '') + '\', \'' + escapeHtml(item.komoditas_ternak || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>No Koordinat' +
                '</button>';
            
            var fotoPath = item.foto_vaksinasi;
            var fotoLink = (fotoPath && fotoPath != '') ? 
                '<a href="javascript:void(0)" class="foto-link" onclick="showFoto(\'' + base_url + 'uploads/vaksinasi/' + fotoPath + '\')" title="Lihat Foto">' +
                '<i class="fas fa-image fa-lg"></i>' +
                '</a>' : 
                '<span class="badge-foto">No Foto</span>';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td>' + (item.jenis_vaksinasi || '-') + '</td>' +
                '<td>' + (item.nama_peternak || '-') + '</td>' +
                '<td>' + (item.komoditas_ternak || '-') + '</td>' +
                '<td class="text-center"><span class="badge-jumlah">' + (item.jumlah || 0) + '</span> Ekor</span>' +
                '</td>' +
                '<td>' +
                '<div class="mb-1 text-muted small">' + koordinatText + '</div>' +
                btnMap +
                '</td>' +
                '<td class="text-center">' + tanggal + '</td>' +
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
        });
    } else {
        html = '<tr><td colspan="9" class="text-center">Tidak ada data vaksinasi</td>' + '</tr>';
    }
    
    $("#historyDataTable tbody").html(html);
    
    if (dataTable) {
        dataTable.destroy();
    }
    
    dataTable = $("#historyDataTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger', exportOptions: { columns: [0,1,2,3,4,5,6] } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6] } }
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
            { orderable: false, targets: [7, 8] }
        ]
    });
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

// ================ EDIT DATA ================
function editData(id) {
    $.ajax({
        url: base_url + 'data_history_vaksinasi/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(item) {
            if (item) {
                $('#edit_id').val(item.id);
                $('#edit_tanggal').val(item.tanggal_vaksinasi);
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
                $('#edit_jenis_vaksinasi').val(item.jenis_vaksinasi);
                $('#edit_dosis').val(item.dosis);
                $('#edit_telp').val(item.telp);
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

// ================ FILTER ================
function filterData() {
    var komoditas = $("#filterKomoditas").val();
    var periode = $("#filterPeriode").val();
    
    var filteredData = allData.slice();
    
    if (komoditas !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.komoditas_ternak && item.komoditas_ternak === komoditas;
        });
    }
    
    if (periode !== "all") {
        filteredData = filteredData.filter(function(item) {
            if (!item.tanggal_vaksinasi) return false;
            var year = new Date(item.tanggal_vaksinasi).getFullYear();
            return year.toString() === periode;
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKomoditas").val("all");
    $("#filterPeriode").val("all");
    renderTable(allData);
}

// ================ UTILITIES ================
function formatDate(dateString) {
    if (!dateString) return "-";
    var d = new Date(dateString);
    if (isNaN(d.getTime())) return dateString;
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
    $("#deleteInfo").text("Data vaksinasi: " + nama);
    $("#deleteModal").modal("show");
}

function deleteData(id) {
    $.ajax({
        url: base_url + 'data_history_vaksinasi/delete/' + id,
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
function showMap(jenisVaksinasi, peternak, komoditas, coordinates) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    $("#mapTitle").text("Peta Lokasi Kegiatan " + jenisVaksinasi);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold">Peternak:</span> ' + peternak + '<br><span class="fw-bold">Komoditas:</span> ' + komoditas + '</div>' +
        '<div class="col-md-6"><span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br><span class="fw-bold">Kegiatan:</span> ' + jenisVaksinasi + '</div>' +
        '</div>'
    );
    
    $("#farmInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Kegiatan:</span><br><span class="text-primary fw-bold">' + escapeHtml(jenisVaksinasi) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Peternak:</span><br>' + escapeHtml(peternak) + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Komoditas:</span><br><span class="badge bg-primary-custom">' + escapeHtml(komoditas) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Status:</span><br><span class="badge bg-success">Tervaksinasi</span></div>'
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
            
            var vaksinIcon = L.divIcon({
                html: '<div style="background-color: #28a745; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">V</div>',
                className: "farm-marker",
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });
            
            currentFarmMarker = L.marker([lat, lng], { icon: vaksinIcon }).addTo(map);
            currentFarmMarker.bindPopup(
                '<div style="min-width: 200px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #28a745; text-align: center;">' + escapeHtml(jenisVaksinasi) + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Peternak:</strong> ' + escapeHtml(peternak) + '</div>' +
                '<div><strong>Komoditas:</strong> ' + escapeHtml(komoditas) + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentFarmMarker);
            
            var circle = L.circle([lat, lng], { color: "#28a745", fillColor: "#28a745", fillOpacity: 0.1, radius: 500 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);
        
        var vaksinIcon = L.divIcon({
            html: '<div style="background-color: #28a745; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">V</div>',
            className: "farm-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
        
        currentFarmMarker = L.marker([lat, lng], { icon: vaksinIcon }).addTo(map);
        currentFarmMarker.bindPopup(
            '<div style="min-width: 200px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #28a745; text-align: center;">' + escapeHtml(jenisVaksinasi) + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Peternak:</strong> ' + escapeHtml(peternak) + '</div>' +
            '<div><strong>Komoditas:</strong> ' + escapeHtml(komoditas) + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentFarmMarker);
        
        var circle = L.circle([lat, lng], { color: "#28a745", fillColor: "#28a745", fillOpacity: 0.1, radius: 500 }).addTo(map);
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
    
    $("#edit_kecamatan").change(function() {
        var selectedKec = $(this).val();
        updateKelurahanOptions(selectedKec, '#edit_kelurahan');
    });
    
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var id = $("#edit_id").val();
        
        var formData = {
            tanggal_vaksinasi: $("#edit_tanggal").val(),
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
            jenis_vaksinasi: $("#edit_jenis_vaksinasi").val(),
            dosis: $("#edit_dosis").val(),
            telp: $("#edit_telp").val(),
            bantuan_prov: $("#edit_bantuan").val(),
            keterangan: $("#edit_keterangan").val()
        };
        
        $.ajax({
            url: base_url + 'data_history_vaksinasi/update/' + id,
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