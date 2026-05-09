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
    $("#dataTableBody").html('<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...<br>pakah');

    $.ajax({
        url: base_url + 'index.php/data_penjual_pakan/get_all_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && !response.error) {
                if (Array.isArray(response) && response.length > 0) {
                    allData = response;
                    console.log('Total data dimuat:', allData.length);
                } else {
                    allData = [];
                }
            } else {
                allData = [];
            }
            renderTable(allData);
            updateFilterOptions();
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
                    updateFilterOptions();
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

// ================ UPDATE FILTER OPTIONS ================
function updateFilterOptions() {
    var kecamatanSet = new Set();

    allData.forEach(function(item) {
        if (item.kecamatan && item.kecamatan !== '') {
            kecamatanSet.add(item.kecamatan);
        }
    });

    var kecamatanOptions = '<option selected value="all">Semua Kecamatan</option>';
    var sortedKecamatan = Array.from(kecamatanSet).sort();
    sortedKecamatan.forEach(function(kecamatan) {
        kecamatanOptions += '<option value="' + kecamatan + '">' + kecamatan + '</option>';
    });
    $("#filterKecamatan").html(kecamatanOptions);

    console.log('Filter options updated - Kecamatan:', sortedKecamatan);
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');

    var html = "";
    if (data && data.length > 0) {
        for (var idx = 0; idx < data.length; idx++) {
            var item = data[idx];
            var no = idx + 1;

            var statusBadge = (item.status === 'Y' || item.status === 'Aktif') ? 
                '<span class="badge-status badge-active"><i class="fas fa-check-circle me-1"></i>Aktif</span>' : 
                '<span class="badge-status badge-inactive"><i class="fas fa-times-circle me-1"></i>Tidak Aktif</span>';

            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.nama_toko || '') + '\', \'' + escapeHtml(item.pemilik || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\')" title="Lihat Peta"><i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia"><i class="fas fa-map-marker-alt me-1"></i>No Koordinat</button>';

            var produkCount = (item.produk && Array.isArray(item.produk)) ? item.produk.length : 0;

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
                '<button class="btn btn-action btn-delete" onclick="deleteData(' + item.id + ', \'' + escapeHtml(item.nama_toko || '') + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        }
    } else {
        html = '<tr><td colspan="9" class="text-center py-5"><i class="fas fa-store-slash fa-3x text-muted mb-3 d-block"></i>Tidak ada data penjual pakan ternak<\/td><\/tr>';
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
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,7] }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,7] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
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
        pageLength: 15,
        lengthChange: false,
        scrollX: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [6, 8] },
            { className: "text-nowrap", targets: [1, 2, 3, 4] }
        ],
        order: [[0, 'asc']]
    });
}

// ================ FUNCTION PRINT ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');

    var table = $('#penjualPakanTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();

    var totalData = rows.length;

    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');

    printWindow.document.write('<html><head><title>Laporan Data Penjual Pakan Ternak</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA PENJUAL PAKAN TERNAK</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');

    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama Toko</th>');
    printWindow.document.write('<th>Pemilik</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Alamat</th>');
    printWindow.document.write('<th>Telepon</th>');
    printWindow.document.write('<th>Status</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[7] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }

    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="6" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Toko</strong></td>');
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
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// ================ FUNCTION DELETE (MENGGUNAKAN CONFIRM BROWSER) ================
function deleteData(id, namaToko) {
    if (confirm("Apakah Anda yakin ingin menghapus data penjual pakan: " + namaToko + "?")) {
        $.ajax({
            url: base_url + 'index.php/data_penjual_pakan/delete/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data berhasil dihapus');
                    loadDataFromServer();
                } else {
                    alert(response.message || 'Gagal menghapus data');
                }
            },
            error: function() {
                alert('Gagal menghapus data');
            }
        });
    }
}

// ================ FUNCTION FILTER ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    var kecamatan = $("#filterKecamatan").val();

    console.log('Filter values - Kecamatan:', kecamatan);

    $('#dataTableBody').html('<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></td></tr>');

    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }

    var filteredData = [];

    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchKecamatan = true;

        if (kecamatan !== "all") {
            matchKecamatan = (item.kecamatan && item.kecamatan === kecamatan);
        }

        if (matchKecamatan) {
            filteredData.push(item);
        }
    }

    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    renderTable(filteredData);
}

// ================ FUNCTION RESET FILTER ================
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');

    $("#filterKecamatan").val("all");

    $('#dataTableBody').html('<td><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat semua data...</p></td></tr>');

    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }

    renderTable(allData);

    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
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
            alert('Gagal mengambil数据');
        }
    });
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

    var item = null;
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].nama_toko === namaToko) {
            item = allData[i];
            break;
        }
    }

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
    console.log('Document ready, loading data...');
    loadDataFromServer();

    $("#filterBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Filter button clicked');
        filterData();
    });

    $("#resetBtn").off('click').on('click', function(e) {
        e.preventDefault();
        console.log('Reset button clicked');
        resetFilter();
    });

    $("#closeMapBtn").off('click').on('click', closeMap);

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
        if (map && currentShopMarker) {
            var latlng = currentShopMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 16);
        }
    });

    $("#formEdit").off('submit').on('submit', function(e) {
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