// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentDemplotMarker = null;
let dataTable = null;
let deleteId = null;

// ================ EDIT DATA ================
function editData(id) {
    var btn = $('.btn-edit[data-id="' + id + '"]');
    
    if (btn.length > 0) {
        $('#edit_id').val(btn.data('id'));
        $('#edit_nama').val(btn.data('nama'));
        $('#edit_alamat').val(btn.data('alamat'));
        $('#edit_kecamatan').val(btn.data('kecamatan')); 
        $('#edit_kelurahan').val(btn.data('kelurahan'));
        $('#edit_luas').val(btn.data('luas'));
        $('#edit_jenis_hewan').val(btn.data('jenis_hewan'));
        $('#edit_jumlah_hewan').val(btn.data('jumlah_hewan'));
        $('#edit_stok_pakan').val(btn.data('stok_pakan'));
        $('#edit_petugas').val(btn.data('petugas'));
        $('#edit_latitude').val(btn.data('latitude'));
        $('#edit_longitude').val(btn.data('longitude'));
        $('#edit_keterangan').val(btn.data('keterangan'));
        
        $('#editModal').modal('show');
    } else {
        alert("Data tidak ditemukan");
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data demplot: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    window.location.href = base_url + "data_demplot/hapus/" + id;
}

// ================ SHOW FOTO PREVIEW ================
function showFotoPreview(src) {
    $('#modalFoto').attr('src', src);
    $('#fotoModal').modal('show');
}

// ================ FILTER FUNCTIONS ================
function filterByLuas(minLuas, maxLuas, searchTerm) {
    const table = $("#demplotTable").DataTable();
    
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            const luas = parseFloat(data[5].replace(/[^0-9.-]+/g, '')) || 0;
            
            if ((minLuas === '' || minLuas === null) && (maxLuas === '' || maxLuas === null)) {
                return true;
            }
            
            if (minLuas !== '' && maxLuas !== '') {
                return luas >= parseFloat(minLuas) && luas <= parseFloat(maxLuas);
            } else if (minLuas !== '') {
                return luas >= parseFloat(minLuas);
            } else if (maxLuas !== '') {
                return luas <= parseFloat(maxLuas);
            }
            
            return true;
        }
    );
    
    table.draw();
    $.fn.dataTable.ext.search.pop();
    
    if (searchTerm) {
        table.search(searchTerm).draw();
    }
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Function to show detail
function showDetail(id) {
    $.ajax({
        url: base_url + 'data_demplot/detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                $("#detailTitle").text('Detail Demplot: ' + data.nama_demplot);

                if (data.foto_demplot) {
                    $("#detailFoto").attr("src", base_url + "uploads/demplot/" + data.foto_demplot).attr("alt", data.nama_demplot);
                    $("#detailThumbnails").html('<img src="' + base_url + 'uploads/demplot/' + data.foto_demplot + '" class="photo-thumbnail" onclick="$(\'#detailFoto\').attr(\'src\', this.src)">');
                } else {
                    $("#detailFoto").attr("src", base_url + "assets/images/no-image.jpg").attr("alt", "No Image");
                    $("#detailThumbnails").html('<p class="text-muted small">Tidak ada foto</p>');
                }

                $("#detailDemplotInfo").html(
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Nama Demplot</strong>NonNull<td>: ' + escapeHtml(data.nama_demplot) + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Alamat</strong>NonNull<td>: ' + escapeHtml(data.alamat || '-') + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Kecamatan</strong>NonNull<td>: ' + escapeHtml(data.kecamatan) + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Kelurahan</strong>NonNull<td>: ' + escapeHtml(data.kelurahan) + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Nama Petugas</strong>NonNull<td>: ' + escapeHtml(data.nama_petugas) + 'NonNull<' +
                    '</tr>' +
                    '</table>'
                );

                $("#detailLokasiInfo").html(
                    '<div class="row">' +
                    '<div class="col-md-6">' +
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Alamat Lengkap</strong>NonNull<td>: ' + escapeHtml(data.alamat || '-') + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Kecamatan</strong>NonNull<td>: ' + escapeHtml(data.kecamatan) + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Kelurahan</strong>NonNull<td>: ' + escapeHtml(data.kelurahan) + 'NonNull<' +
                    '</tr>' +
                    '</table>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Latitude</strong>NonNull<td>: <code>' + escapeHtml(data.latitude || '-') + '</code>NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Longitude</strong>NonNull<td>: <code>' + escapeHtml(data.longitude || '-') + '</code>NonNull<' +
                    '</tr>' +
                    (data.latitude && data.longitude ? 
                    '<tr><td colspan="2"><button class="btn btn-sm btn-primary-custom mt-2" onclick="showMap(\'' + escapeHtml(data.nama_demplot) + '\', \'' + escapeHtml(data.alamat || '') + '\', \'' + escapeHtml(data.kecamatan) + '\', \'' + escapeHtml(data.kelurahan) + '\', \'' + data.latitude + ', ' + data.longitude + '\', \'' + escapeHtml(data.jenis_hewan || '') + '\', \'' + (data.jumlah_hewan || 0) + '\', \'' + parseFloat(data.luas_m2 || 0).toFixed(2) + '\', \'' + escapeHtml(data.stok_pakan || '') + '\', ' + data.id_demplot + ')"><i class="fas fa-map-marker-alt me-1"></i>Lihat di Peta</button>NonNull<' +
                    '</tr>' : '') +
                    '</table>' +
                    '</div>' +
                    '</div>'
                );

                $("#detailHewanInfo").html(
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Jenis Hewan</strong>NonNull<td>: ' + escapeHtml(data.jenis_hewan || '-') + 'NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Jumlah Hewan</strong>NonNull<td>: ' + (data.jumlah_hewan || 0) + ' ekorNonNull<' +
                    '</table>' +
                    '<tr><td><strong>Luas Area</strong>NonNull<td>: ' + parseFloat(data.luas_m2 || 0).toFixed(2) + ' m²NonNull<' +
                    '</tr>' +
                    '<tr><td><strong>Stok Pakan</strong>NonNull<td>: ' + escapeHtml(data.stok_pakan || '-') + 'NonNull<' +
                    '</tr>' +
                    '</table>'
                );

                $("#detailKeteranganInfo").html('<p class="mb-0">' + escapeHtml(data.keterangan || '-') + '</p>');

                $("#detailSection").show();
                $("#mapSection").hide();

                $("html, body").animate({ scrollTop: $("#detailSection").offset().top - 20 }, 500);
            } else {
                alert('Data tidak ditemukan');
            }
        },
        error: function() {
            alert('Gagal memuat detail data');
        }
    });
}

// Function to show map
function showMap(namaDemplot, alamat, kecamatan, kelurahan, coordinates, jenisHewan, jumlahHewan, luas, stokPakan, id) {
    const [lat, lng] = coordinates.split(",").map(function(coord) { return parseFloat(coord.trim()); });

    $("#mapTitle").text("Peta Lokasi " + namaDemplot);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Demplot:</span> ' + escapeHtml(namaDemplot) + '<br>' +
        '<span class="fw-bold">Kecamatan:</span> ' + escapeHtml(kecamatan) + '<br>' +
        '<span class="fw-bold">Kelurahan:</span> ' + escapeHtml(kelurahan) +
        '</div>' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold">Jenis Hewan:</span> ' + escapeHtml(jenisHewan || '-') + '<br>' +
        '<span class="fw-bold">Jumlah:</span> ' + jumlahHewan + ' ekor' +
        '</div>' +
        '</div>'
    );

    $("#demplotInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Demplot:</span><br><span class="text-primary fw-bold">' + escapeHtml(namaDemplot) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Kecamatan/Kelurahan:</span><br>' + escapeHtml(kecamatan) + ' - ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Alamat:</span><br>' + escapeHtml(alamat || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Luas Area:</span><br><span class="badge-luas">' + luas + ' m²</span></div>'
    );

    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>'
    );

    $("#hewanMapInfo").html(
        '<div class="row">' +
        '<div class="col-md-4"><div class="info-card"><strong>Jenis Hewan</strong><br><span class="badge-hewan">' + escapeHtml(jenisHewan || '-') + '</span></div></div>' +
        '<div class="col-md-4"><div class="info-card"><strong>Jumlah</strong><br><span class="badge-hewan">' + jumlahHewan + ' ekor</span></div></div>' +
        '<div class="col-md-4"><div class="info-card"><strong>Stok Pakan</strong><br><span class="badge-pakan">' + escapeHtml(stokPakan || '-') + '</span></div></div>' +
        '</div>'
    );

    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();

            const demplotIcon = L.divIcon({
                html: '<div style="background-color: #28a745; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">D</div>',
                className: "demplot-marker",
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });

            currentDemplotMarker = L.marker([lat, lng], { icon: demplotIcon }).addTo(map);
            currentDemplotMarker.bindPopup(
                '<div style="min-width: 250px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #28a745; text-align: center;">' + escapeHtml(namaDemplot) + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Alamat:</strong> ' + escapeHtml(alamat || '-') + '</div>' +
                '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
                '<div><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Jenis Hewan:</strong> ' + escapeHtml(jenisHewan || '-') + '</div>' +
                '<div><strong>Jumlah:</strong> ' + jumlahHewan + ' ekor</div>' +
                '<div><strong>Luas:</strong> ' + luas + ' m²</div>' +
                '<div><strong>Stok Pakan:</strong> ' + escapeHtml(stokPakan || '-') + '</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentDemplotMarker);

            const circle = L.circle([lat, lng], { color: "#28a745", fillColor: "#28a745", fillOpacity: 0.1, radius: 300 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);

        const demplotIcon = L.divIcon({
            html: '<div style="background-color: #28a745; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">D</div>',
            className: "demplot-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });

        currentDemplotMarker = L.marker([lat, lng], { icon: demplotIcon }).addTo(map);
        currentDemplotMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #28a745; text-align: center;">' + escapeHtml(namaDemplot) + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Alamat:</strong> ' + escapeHtml(alamat || '-') + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
            '<div><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Jenis Hewan:</strong> ' + escapeHtml(jenisHewan || '-') + '</div>' +
            '<div><strong>Jumlah:</strong> ' + jumlahHewan + ' ekor</div>' +
            '<div><strong>Luas:</strong> ' + luas + ' m²</div>' +
            '<div><strong>Stok Pakan:</strong> ' + escapeHtml(stokPakan || '-') + '</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentDemplotMarker);

        const circle = L.circle([lat, lng], { color: "#28a745", fillColor: "#28a745", fillOpacity: 0.1, radius: 300 }).addTo(map);
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

// Fungsi untuk load statistik
function loadStatistik() {
    $.ajax({
        url: base_url + 'data_demplot/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalDemplot').text(data.total_demplot);
            $('#totalHewan').text(data.total_hewan);
            $('#totalLuas').text(data.total_luas.toFixed(2));
            $('#totalJenisHewan').text(data.total_jenis_hewan);
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

// ================ FUNCTION PRINT RAPI (SAMA PERSIS PELAKU USAHA) ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var table = $('#demplotTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalHewan = 0;
    var totalLuas = 0;
    
    // Hitung total hewan dan luas
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        // Ekstrak jumlah hewan dari kolom 7 (index 7)
        var hewanText = stripHtml(row[7] || '0');
        var hewanMatch = hewanText.match(/(\d+)/);
        if (hewanMatch) {
            totalHewan += parseInt(hewanMatch[0]) || 0;
        }
        
        // Ekstrak luas dari kolom 5 (index 5)
        var luasText = stripHtml(row[5] || '0');
        var luasMatch = luasText.match(/([\d,]+\.?\d*)/);
        if (luasMatch) {
            totalLuas += parseFloat(luasMatch[0].replace(/,/g, '')) || 0;
        }
    }
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Demplot</title>');
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
    printWindow.document.write('.total-row td { color: #000000; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Header Laporan
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA DEMPLOT</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data untuk Print
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama Demplot</th>');
    printWindow.document.write('<th>Alamat</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Kelurahan</th>');
    printWindow.document.write('<th>Luas (m²)</th>');
    printWindow.document.write('<th>Jenis Hewan</th>');
    printWindow.document.write('<th>Jumlah Hewan</th>');
    printWindow.document.write('<th>Stok Pakan</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        
        // Luas (kolom index 5)
        var luasText = stripHtml(row[5] || '0');
        var luasMatch = luasText.match(/([\d,]+\.?\d*)/);
        var luas = luasMatch ? luasMatch[0] : '0';
        
        // Jenis Hewan (kolom index 6)
        var jenisHewan = stripHtml(row[6] || '-');
        
        // Jumlah Hewan (kolom index 7)
        var hewanText = stripHtml(row[7] || '0');
        var hewanMatch = hewanText.match(/(\d+)/);
        var hewan = hewanMatch ? hewanMatch[0] : '0';
        
        // Stok Pakan (kolom index 8)
        var stokPakan = stripHtml(row[8] || '-');
        
        printWindow.document.write('<td align="center">' + parseFloat(luas).toFixed(2) + ' m²' + '</td>');
        printWindow.document.write('<td align="left">' + jenisHewan + '</td>');
        printWindow.document.write('<td align="center">' + hewan + ' Ekor' + '</td>');
        printWindow.document.write('<td align="left">' + stokPakan + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalLuas) + ' m²</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalHewan) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Demplot</strong></td>');
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

// ================ DOCUMENT READY ================
$(document).ready(function() {
    // Initialize DataTable with custom buttons (SAMA PERSIS PELAKU USAHA)
    dataTable = $("#demplotTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            // {
            //     extend: "copy",
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            // {
            //     extend: "csv",
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            // {
            //     extend: "pdf",
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            // },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
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
        pageLength: 15,
        lengthChange: false,
        responsive: true,
        columnDefs: [
            { targets: [9], orderable: false },
            { targets: [10], orderable: false }
        ]
    });

    // Event listener untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        if (id) {
            editData(id);
        }
    });

    // Event listener untuk tombol hapus
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (id) {
            confirmDelete(id, nama);
        }
    });

    // Filter button event
    $("#filterBtn").click(function() {
        const kecamatanValue = $("#filterKecamatan").val();
        const jenisHewanValue = $("#filterJenisHewan").val();
        const kelurahanValue = $("#filterKelurahan").val();
        const minLuas = $("#minLuas").val();
        const maxLuas = $("#maxLuas").val();
        
        let searchTerm = "";

        if (kecamatanValue !== "all") {
            searchTerm += kecamatanValue;
        }
        if (jenisHewanValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += jenisHewanValue;
        }
        if (kelurahanValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += kelurahanValue;
        }

        filterByLuas(minLuas, maxLuas, searchTerm);
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterKecamatan").val("all");
        $("#filterJenisHewan").val("all");
        $("#filterKelurahan").val("all");
        $("#minLuas").val("");
        $("#maxLuas").val("");
        $("#demplotTable").DataTable().search("").draw();
        loadStatistik();
    });

    // Close detail button event
    $("#closeDetailBtn").click(function() {
        $("#detailSection").hide();
    });

    // Close map button event
    $("#closeMapBtn").click(function() {
        $("#mapSection").hide();
        if (map) {
            map.remove();
            map = null;
        }
    });

    // Map view controls
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
        if (map && currentDemplotMarker) {
            const latlng = currentDemplotMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });

    // Confirm delete button
    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });

    // Form edit submit
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: base_url + 'data_demplot/update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data berhasil diupdate');
                    location.reload();
                } else {
                    alert('Gagal mengupdate data: ' + (response.message || 'Unknown error'));
                }
            },
            error: function() {
                alert('Gagal mengupdate data');
            }
        });
    });

    loadStatistik();
});

// Base URL
var base_url = "<?= base_url() ?>";