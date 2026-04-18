// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentFarmMarker = null;
let dataTable = null;
let deleteId = null;

// Data Penjual Pakan (tanpa email)
const allData = [
    {
        id: 1,
        nama_toko: "Toko Pakan Ternak Sumber Rejeki",
        pemilik: "H. Ahmad S.",
        kecamatan: "Sukolilo",
        alamat: "Jl. Raya Sukolilo No. 45, Surabaya",
        telepon: "081234567890",
        latitude: "-7.2876",
        longitude: "112.7891",
        status: "Aktif",
        produk: ["Konsentrat", "Pakan Sapi", "Pakan Ayam"]
    },
    {
        id: 2,
        nama_toko: "UD. Pakan Ternak Sejahtera",
        pemilik: "Budi Santoso",
        kecamatan: "Rungkut",
        alamat: "Jl. Raya Rungkut Industri No. 12, Surabaya",
        telepon: "082345678901",
        latitude: "-7.3265",
        longitude: "112.7683",
        status: "Aktif",
        produk: ["Konsentrat", "Fermentasi", "Pakan Sapi", "Pakan Kambing", "Vitamin"]
    },
    {
        id: 3,
        nama_toko: "CV. Agro Pakan Surabaya",
        pemilik: "Siti Aminah",
        kecamatan: "Gunung Anyar",
        alamat: "Jl. Gunung Anyar Timur No. 78, Surabaya",
        telepon: "083456789012",
        latitude: "-7.3381",
        longitude: "112.7944",
        status: "Aktif",
        produk: ["Konsentrat", "Hijauan", "Fermentasi", "Pakan Ayam", "Pakan Sapi", "Pakan Kambing", "Pakan Itik"]
    },
    {
        id: 4,
        nama_toko: "Toko Pakan Mulyorejo",
        pemilik: "Supriyadi",
        kecamatan: "Mulyorejo",
        alamat: "Jl. Mulyorejo Utara No. 23, Surabaya",
        telepon: "084567890123",
        latitude: "-7.2621",
        longitude: "112.7915",
        status: "Aktif",
        produk: ["Pakan Ayam", "Pakan Itik", "Vitamin"]
    },
    {
        id: 5,
        nama_toko: "PD. Pakan Ternak Jaya",
        pemilik: "Dwi Handayani",
        kecamatan: "Sawahan",
        alamat: "Jl. Sawahan Baru No. 56, Surabaya",
        telepon: "085678901234",
        latitude: "-7.2511",
        longitude: "112.7304",
        status: "Aktif",
        produk: ["Konsentrat", "Pakan Ayam", "Pakan Sapi", "Pakan Kambing"]
    },
    {
        id: 6,
        nama_toko: "Toko Pakan Gubeng",
        pemilik: "Rudi Hartono",
        kecamatan: "Gubeng",
        alamat: "Jl. Gubeng Pojok No. 34, Surabaya",
        telepon: "086789012345",
        latitude: "-7.2667",
        longitude: "112.7500",
        status: "Tidak Aktif",
        produk: ["Pakan Ayam", "Vitamin"]
    },
    {
        id: 7,
        nama_toko: "CV. Pakan Ternak Berkah",
        pemilik: "Hasan Basri",
        kecamatan: "Wonokromo",
        alamat: "Jl. Wonokromo No. 89, Surabaya",
        telepon: "087890123456",
        latitude: "-7.2953",
        longitude: "112.7389",
        status: "Aktif",
        produk: ["Konsentrat", "Hijauan", "Fermentasi", "Pakan Ayam", "Pakan Sapi", "Pakan Kambing", "Pakan Itik", "Vitamin", "Mineral"]
    },
    {
        id: 8,
        nama_toko: "UD. Sumber Pakan Ternak",
        pemilik: "Joko Susilo",
        kecamatan: "Tandes",
        alamat: "Jl. Tandes Barat No. 67, Surabaya",
        telepon: "088901234567",
        latitude: "-7.2439",
        longitude: "112.6816",
        status: "Aktif",
        produk: ["Konsentrat", "Fermentasi", "Pakan Sapi", "Pakan Ayam", "Vitamin"]
    },
    {
        id: 9,
        nama_toko: "Toko Pakan Asemrowo",
        pemilik: "M. Syafi'i",
        kecamatan: "Asemrowo",
        alamat: "Jl. Asemrowo No. 12, Surabaya",
        telepon: "089123456789",
        latitude: "-7.2167",
        longitude: "112.6833",
        status: "Aktif",
        produk: ["Konsentrat", "Pakan Ayam"]
    },
    {
        id: 10,
        nama_toko: "Toko Pakan Benowo",
        pemilik: "Slamet Riyadi",
        kecamatan: "Benowo",
        alamat: "Jl. Benowo No. 45, Surabaya",
        telepon: "089234567890",
        latitude: "-7.2167",
        longitude: "112.6667",
        status: "Aktif",
        produk: ["Pakan Sapi", "Pakan Kambing"]
    }
];

// ================ RENDER TABLE ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            
            var btnMap = (item.latitude && item.longitude) ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + item.nama_toko + '\', \'' + item.pemilik + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>';
            
            html += '<tr>' +
                '<td>' + no + '</td>' +
                '<td><span class="fw-bold">' + item.nama_toko + '</span><br><small class="text-muted">' + item.produk.length + ' jenis pakan</small></td>' +
                '<td>' + item.pemilik + '</td>' +
                '<td>' + item.kecamatan + '</td>' +
                '<td>' + item.alamat + '</td>' +
                '<td>' + (item.telepon || '-') + '</td>' +
                '<td>' + btnMap + '</td>' +
                '<td><span class="badge-status ' + (item.status === 'Aktif' ? 'badge-active' : 'badge-inactive') + '">' + item.status + '</span></td>' +
                '<td>' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + item.nama_toko + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        });
    } else {
        html = '<tr><td colspan="9" class="text-center">Tidak ada data penjual pakan</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '</tr>';
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
        $('#edit_alamat').val(item.alamat);
        $('#edit_latitude').val(item.latitude);
        $('#edit_longitude').val(item.longitude);
        $('#edit_status').val(item.status);
        $('#edit_telepon').val(item.telepon);
        $('#edit_produk').val(item.produk.join(", "));
        
        $('#editModal').modal('show');
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data penjual pakan: " + nama);
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
    var status = $("#filterStatus").val();
    var jenisPakan = $("#filterJenisPakan").val();
    
    var filteredData = allData.slice();
    
    if (kecamatan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.kecamatan === kecamatan;
        });
    }
    
    if (status !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.status === status;
        });
    }
    
    if (jenisPakan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.produk.includes(jenisPakan);
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterStatus").val("all");
    $("#filterJenisPakan").val("all");
    renderTable(allData.slice());
}

// ================ MAP FUNCTION ================
function showMap(namaToko, pemilik, coordinates) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    var item = allData.find(function(d) { return d.nama_toko === namaToko; });
    var alamat = item ? item.alamat : "";
    var telepon = item ? item.telepon : "";
    var kecamatan = item ? item.kecamatan : "";
    var produkList = item ? item.produk : [];
    
    $("#mapTitle").text("Peta Lokasi " + namaToko);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold">Toko:</span> ' + namaToko + '<br><span class="fw-bold">Pemilik:</span> ' + pemilik + '<br><span class="fw-bold">Kecamatan:</span> ' + kecamatan + '</div>' +
        '<div class="col-md-6"><span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br><span class="fw-bold">Telepon:</span> ' + telepon + '</div>' +
        '</div>'
    );
    
    $("#farmInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Toko:</span><br><span class="text-primary fw-bold">' + namaToko + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Pemilik:</span><br>' + pemilik + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kecamatan:</span><br><span class="badge bg-primary-custom">' + kecamatan + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Alamat:</span><br>' + alamat + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kontak:</span><br><i class="fas fa-phone-alt me-1"></i> ' + telepon + '</div>'
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    // Produk list
    var productHtml = '<div class="row">';
    for (var i = 0; i < produkList.length; i++) {
        productHtml += '<div class="col-md-4"><div class="product-card"><span class="fw-bold">' + produkList[i] + '</span></div></div>';
    }
    productHtml += '</div>';
    $("#productInfo").html(productHtml);
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var shopIcon = L.divIcon({
                html: '<div style="background-color: #fd7e14; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
                className: "shop-marker",
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });
            
            currentFarmMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
            currentFarmMarker.bindPopup(
                '<div style="min-width: 250px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">' + namaToko + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Pemilik:</strong> ' + pemilik + '</div>' +
                '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
                '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentFarmMarker);
            
            var circle = L.circle([lat, lng], { color: "#fd7e14", fillColor: "#fd7e14", fillOpacity: 0.1, radius: 300 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);
        
        var shopIcon = L.divIcon({
            html: '<div style="background-color: #fd7e14; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
            className: "shop-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });
        
        currentFarmMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
        currentFarmMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">' + namaToko + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Pemilik:</strong> ' + pemilik + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
            '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentFarmMarker);
        
        var circle = L.circle([lat, lng], { color: "#fd7e14", fillColor: "#fd7e14", fillOpacity: 0.1, radius: 300 }).addTo(map);
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
    renderTable(allData);
    
    dataTable = $("#penjualPakanTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6,7] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6,7] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA PENJUAL PAKAN TERNAK',
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
                exportOptions: { columns: [0,1,2,3,4,5,6,7] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA PENJUAL PAKAN TERNAK</h2>' +
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
            { targets: [6], orderable: false },
            { targets: [8], orderable: false }
        ]
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
        var id = parseInt($("#edit_id").val());
        var produkArray = $("#edit_produk").val().split(",").map(function(p) { return p.trim(); });
        
        var updatedData = {
            id: id,
            nama_toko: $("#edit_nama_toko").val(),
            pemilik: $("#edit_pemilik").val(),
            kecamatan: $("#edit_kecamatan").val(),
            alamat: $("#edit_alamat").val(),
            telepon: $("#edit_telepon").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            status: $("#edit_status").val(),
            produk: produkArray
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