// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentShopMarker = null;
let dataTable = null;
let deleteId = null;
let allData = [];

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#dataTableBody").html('<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...</td></tr>');
    
    var apiUrl = base_url + 'index.php/data_penjual_pakan/get_all_data';
    
    $.ajax({
        url: apiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && !response.error) {
                if (Array.isArray(response) && response.length > 0) {
                    allData = response;
                } else {
                    allData = [];
                }
            } else {
                allData = [];
            }
            renderTable(allData);
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.status, error);
            $.ajax({
                url: base_url + 'data_penjual_pakan/get_all_data',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && !response.error) {
                        allData = Array.isArray(response) ? response : [];
                    } else {
                        allData = [];
                    }
                    renderTable(allData);
                },
                error: function() {
                    allData = [];
                    renderTable(allData);
                    alert('Gagal memuat data. Silahkan refresh halaman.');
                }
            });
        }
    });
}

// ================ RENDER TABLE ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            
            var statusBadge = (item.status === 'Y' || item.status === 'Aktif') ? 
                '<span class="badge-status badge-active"><i class="fas fa-check-circle me-1"></i>Aktif</span>' : 
                '<span class="badge-status badge-inactive"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>';
            
            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.nama_toko || '') + '\', \'' + escapeHtml(item.pemilik || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta"><i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia"><i class="fas fa-map-marker-alt me-1"></i>No Koordinat</button>';
            
            var produkCount = (item.produk && Array.isArray(item.produk)) ? item.produk.length : 0;
            
            // TELEPON WARNA HITAM (tanpa warna hijau)
            var teleponDisplay = item.telepon ? 
                '<a href="tel:' + item.telepon + '" class="telp-link" style="color: #212529; text-decoration: none;">' + item.telepon + '</a>' : 
                '<span class="text-muted">-</span>';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td><span class="fw-bold">' + escapeHtml(item.nama_toko || '-') + '</span><br><small class="text-muted">' + produkCount + ' jenis</small></td>' +
                '<td>' + escapeHtml(item.pemilik || '-') + '</td>' +
                '<td>' + escapeHtml(item.kecamatan || '-') + '</td>' +
                '<td title="' + escapeHtml(item.alamat || '') + '">' + truncateText(item.alamat, 30) + '</td>' +
                '<td class="text-center">' + teleponDisplay + '</td>' +
                '<td class="text-center">' + btnMap + '</td>' +
                '<td class="text-center">' + statusBadge + '</td>' +
                '<td class="text-center">' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + escapeHtml(item.nama_toko || '') + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        });
    } else {
        html = '<tr><td colspan="9" class="text-center py-5"><i class="fas fa-store-slash fa-3x text-muted mb-3 d-block"></i>Tidak ada data penjual pakan ternak</td><td style="display:none"><td><td style="display:none"><td><td style="display:none"><td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>';
    }
    
    $("#dataTableBody").html(html);
    
    if (dataTable) {
        dataTable.destroy();
    }
    
    dataTable = $("#penjualPakanTable").DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,7] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,7] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,7] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,7] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID');
                    doc.content.unshift({
                        text: 'LAPORAN DATA PENJUAL PAKAN TERNAK',
                        style: 'title',
                        alignment: 'center',
                        margin: [0, 0, 0, 5],
                        fontSize: 14,
                        bold: true
                    });
                    doc.content.unshift({
                        text: 'DINAS PETERNAKAN KOTA SURABAYA',
                        style: 'subtitle',
                        alignment: 'center',
                        margin: [0, 0, 0, 3],
                        fontSize: 12
                    });
                    doc.content.unshift({
                        text: 'PEMERINTAH KOTA SURABAYA',
                        style: 'header',
                        alignment: 'center',
                        margin: [0, 0, 0, 15],
                        fontSize: 10
                    });
                    doc.content.push({
                        text: 'Tanggal Cetak: ' + formattedDate,
                        style: 'date',
                        alignment: 'center',
                        margin: [0, 15, 0, 0],
                        fontSize: 9,
                        color: '#666666'
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
                    doc.header = {
                        text: 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya',
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
                exportOptions: { columns: [0,1,2,3,4,5,7] },
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
            searchPlaceholder: "Ketik kata kunci...",
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
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [6, 8] },
            { className: "text-nowrap", targets: [1, 2, 3, 4] }
        ],
        order: [[0, 'asc']]
    });
}

function truncateText(text, maxLength) {
    if (!text) return '-';
    if (text.length <= maxLength) return escapeHtml(text);
    return escapeHtml(text.substring(0, maxLength)) + '...';
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

// ================ EDIT DATA ================
function editData(id) {
    $.ajax({
        url: base_url + 'index.php/data_penjual_pakan/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(item) {
            if (item && !item.error) {
                $('#edit_id').val(item.id);
                $('#edit_nama_toko').val(item.nama_toko || '');
                $('#edit_pemilik').val(item.pemilik || '');
                $('#edit_kecamatan').val(item.kecamatan || '');
                $('#edit_alamat').val(item.alamat || '');
                $('#edit_latitude').val(item.latitude || '');
                $('#edit_longitude').val(item.longitude || '');
                $('#edit_status').val((item.status === 'Y' || item.status === 'Aktif') ? 'Aktif' : 'Tidak Aktif');
                $('#edit_telepon').val(item.telepon || '');
                
                var produkStr = '';
                if (item.produk) {
                    produkStr = Array.isArray(item.produk) ? item.produk.join(", ") : item.produk;
                }
                $('#edit_produk').val(produkStr);
                
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

// ================ DELETE DATA ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").html('<i class="fas fa-store me-2"></i>' + escapeHtml(nama));
    $("#deleteModal").modal("show");
}

function deleteData(id) {
    $.ajax({
        url: base_url + 'index.php/data_penjual_pakan/delete/' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                allData = allData.filter(function(item) { return item.id !== id; });
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
            var itemStatus = (item.status === 'Y' || item.status === 'Aktif') ? 'Aktif' : 'Tidak Aktif';
            return itemStatus === status;
        });
    }
    
    if (jenisPakan !== "all") {
        filteredData = filteredData.filter(function(item) {
            if (item.produk) {
                var produkArray = Array.isArray(item.produk) ? item.produk : [item.produk];
                return produkArray.some(function(p) { 
                    return p && p.toLowerCase().includes(jenisPakan.toLowerCase()); 
                });
            }
            return false;
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterStatus").val("all");
    $("#filterJenisPakan").val("all");
    renderTable(allData);
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
    var produkList = (item && item.produk && Array.isArray(item.produk)) ? item.produk : [];
    
    $("#mapTitle").html('<i class="fas fa-store me-2"></i>' + escapeHtml(namaToko));
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-store me-1"></i> Toko:</span> ' + escapeHtml(namaToko) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-user me-1"></i> Pemilik:</span> ' + escapeHtml(pemilik) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Kecamatan:</span> ' + escapeHtml(kecamatan) + '</div>' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-map-pin me-1"></i> Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold"><i class="fas fa-phone-alt me-1"></i> Telepon:</span> ' + (telepon || '-') + '</div>' +
        '</div>'
    );
    
    $("#farmInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-store me-2"></i>Nama Toko:</span><br><span class="text-primary fw-bold fs-5">' + escapeHtml(namaToko) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-user me-2"></i>Pemilik:</span><br>' + escapeHtml(pemilik) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Kecamatan:</span><br><span class="badge bg-primary-custom">' + escapeHtml(kecamatan) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-location-dot me-2"></i>Alamat:</span><br>' + escapeHtml(alamat) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-phone-alt me-2"></i>Kontak:</span><br>' + (telepon || '-') + '</div>'
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-up me-2"></i>Latitude:</span><br><code class="bg-light p-1 rounded">' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-right me-2"></i>Longitude:</span><br><code class="bg-light p-1 rounded">' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-globe me-2"></i>Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-satellite me-2"></i>Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    var productHtml = '<div class="row">';
    if (produkList.length > 0) {
        for (var i = 0; i < produkList.length; i++) {
            productHtml += '<div class="col-md-4 col-sm-6 mb-2"><div class="product-card p-2 text-center"><i class="fas fa-tag me-1 text-primary-custom"></i> <span class="fw-bold">' + escapeHtml(produkList[i]) + '</span></div></div>';
        }
    } else {
        productHtml += '<div class="col-12 text-center py-3"><i class="fas fa-box-open fa-2x text-muted mb-2 d-block"></i><span class="text-muted">Informasi produk tidak tersedia</span></div>';
    }
    productHtml += '</div>';
    $("#productInfo").html(productHtml);
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 16);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var shopIcon = L.divIcon({
                html: '<div style="background-color: #fd7e14; width: 32px; height: 32px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-store"></i></div>',
                className: "shop-marker",
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });
            
            currentShopMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
            currentShopMarker.bindPopup(
                '<div style="min-width: 250px; font-family: inherit;">' +
                '<h6 style="margin: 0 0 8px 0; color: #fd7e14; text-align: center; font-weight: 700;">' + escapeHtml(namaToko) + '</h6>' +
                '<hr style="margin: 5px 0;">' +
                '<div><i class="fas fa-user fa-fw me-2 text-muted"></i><strong>Pemilik:</strong> ' + escapeHtml(pemilik) + '</div>' +
                '<div><i class="fas fa-map-marker-alt fa-fw me-2 text-muted"></i><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
                '<div><i class="fas fa-location-dot fa-fw me-2 text-muted"></i><strong>Alamat:</strong> ' + escapeHtml(alamat) + '</div>' +
                '<div><i class="fas fa-phone-alt fa-fw me-2 text-muted"></i><strong>Telepon:</strong> ' + (telepon || '-') + '</div>' +
                '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentShopMarker);
            
            var circle = L.circle([lat, lng], { 
                color: "#fd7e14", 
                fillColor: "#fd7e14", 
                fillOpacity: 0.1, 
                radius: 200,
                weight: 2
            }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 16);
        
        var shopIcon = L.divIcon({
            html: '<div style="background-color: #fd7e14; width: 32px; height: 32px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-store"></i></div>',
            className: "shop-marker",
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });
        
        currentShopMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
        currentShopMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h6 style="margin: 0 0 8px 0; color: #fd7e14; text-align: center; font-weight: 700;">' + escapeHtml(namaToko) + '</h6>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Pemilik:</strong> ' + escapeHtml(pemilik) + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
            '<div><strong>Alamat:</strong> ' + escapeHtml(alamat) + '</div>' +
            '<div><strong>Telepon:</strong> ' + (telepon || '-') + '</div>' +
            '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentShopMarker);
        
        var circle = L.circle([lat, lng], { color: "#fd7e14", fillColor: "#fd7e14", fillOpacity: 0.1, radius: 200 }).addTo(map);
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
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { 
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>', 
            maxZoom: 19 
        }).addTo(map);
    } else {
        L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", { 
            attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community", 
            maxZoom: 19 
        }).addTo(map);
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
        if (map && currentShopMarker) {
            var latlng = currentShopMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 16);
        }
    });
    
    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
    
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var id = $("#edit_id").val();
        
        var formData = {
            nama_toko: $("#edit_nama_toko").val(),
            pemilik: $("#edit_pemilik").val(),
            kecamatan: $("#edit_kecamatan").val(),
            alamat: $("#edit_alamat").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            status: $("#edit_status").val(),
            telepon: $("#edit_telepon").val()
        };
        
        $("#editModal .btn-primary-custom").prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
        
        $.ajax({
            url: base_url + 'index.php/data_penjual_pakan/update/' + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $("#editModal .btn-primary-custom").prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
                if (response.status === 'success') {
                    $("#editModal").modal("hide");
                    alert(response.message);
                    loadDataFromServer();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                $("#editModal .btn-primary-custom").prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
                alert('Gagal menyimpan perubahan');
            }
        });
    });
});