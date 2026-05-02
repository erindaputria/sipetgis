// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentRpuMarker = null;
let dataTable = null;
let deleteId = null;

// ================ EDIT DATA ================
function editData(id) {
    var btn = $('.btn-edit[data-id="' + id + '"]');
    
    if (btn.length > 0) {
        $('#edit_id').val(btn.data('id'));
        $('#edit_pejagal').val(btn.data('pejagal'));
        
        var tanggal = btn.data('tanggal');
        if (tanggal) {
            $('#edit_tanggal').val(tanggal);
        } else {
            $('#edit_tanggal').val('');
        }
        
        $('#edit_nama_pj').val(btn.data('nama_pj'));
        $('#edit_nik').val(btn.data('nik'));
        $('#edit_petugas').val(btn.data('petugas'));
        $('#edit_kecamatan').val(btn.data('kecamatan'));
        $('#edit_kelurahan').val(btn.data('kelurahan'));
        $('#edit_rt').val(btn.data('rt'));
        $('#edit_rw').val(btn.data('rw'));
        $('#edit_lokasi').val(btn.data('lokasi'));
        $('#edit_latitude').val(btn.data('latitude'));
        $('#edit_longitude').val(btn.data('longitude'));
        $('#edit_telepon').val('');
        $('#edit_keterangan').val(btn.data('keterangan'));
        
        $('#editModal').modal('show');
    } else {
        alert("Data tidak ditemukan");
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data RPU: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    window.location.href = base_url + "data_rpu/hapus/" + id;
}

// ================ FILTER ================
function filterByPeriode(startDate, endDate, searchTerm) {
    $.ajax({
        url: base_url + 'data_rpu/filter_by_periode',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        dataType: 'json',
        success: function(response) {
            updateTableWithData(response.data, searchTerm);
        },
        error: function() {
            alert('Gagal memuat data filter');
        }
    });
}

function updateTableWithData(data, searchTerm) {
    const table = $("#rpuTable").DataTable();
    table.clear();
    
    if (data && data.length > 0) {
        let no = 1;
        data.forEach(function(item) {
            table.row.add([
                no++,
                formatDate(item.tanggal_rpu),
                '<span class="fw-bold">' + escapeHtml(item.pejagal || '-') + '</span><br><small class="text-muted">Petugas: ' + escapeHtml(item.nama_petugas || '-') + '</small>',
                escapeHtml(item.nama_pj || '-') + '<br><small class="text-muted">' + escapeHtml(item.nik_pj || '-') + '</small>',
                escapeHtml(item.kecamatan || '-'),
                escapeHtml(item.kelurahan || '-'),
                '<small>' + escapeHtml(item.komoditas_list || '-') + '</small>',
                '<span class="badge-ekor">' + (item.total_ekor || 0) + ' ekor</span><br><span class="badge-berat">' + parseFloat(item.total_berat || 0).toFixed(2) + ' kg</span><br><span class="badge-asal">' + escapeHtml(item.asal_unggas || '-') + '</span>',
                formatCoordinateCell(item.latitude, item.longitude, item.pejagal, item.kecamatan, item.kelurahan, item.lokasi, item.telp_pj, item.total_ekor, item.total_berat, item.foto_kegiatan, item.id),
                formatActionButtons(item.id, item.pejagal)
            ]);
        });
    } else {
        table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
    }
    
    table.draw();
    
    if (searchTerm) {
        table.search(searchTerm).draw();
    }
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatCoordinateCell(lat, lng, pejagal, kecamatan, kelurahan, lokasi, telp, totalEkor, totalBerat, foto, id) {
    if (!lat || !lng) {
        return '<span class="empty-coord">Tidak ada</span>';
    }
    
    return '<div>' +
        '<div class="mb-1 small"><span class="coord-badge">' + lat.substring(0, 8) + '... , ' + lng.substring(0, 8) + '...</span></div>' +
        '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(pejagal) + '\', \'' + escapeHtml(kecamatan) + '\', \'' + escapeHtml(kelurahan) + '\', \'' + lat + ', ' + lng + '\', \'' + escapeHtml(lokasi || '') + '\', \'' + escapeHtml(telp || '') + '\', \'' + totalEkor + '\', \'' + parseFloat(totalBerat || 0).toFixed(2) + '\', ' + id + ')">' +
        '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' +
        '</div>';
}

function formatActionButtons(id, pejagal) {
    return '<div class="btn-action-group">' +
        '<button class="btn btn-action btn-edit" title="Edit" data-id="' + id + '" data-pejagal="' + escapeHtml(pejagal) + '" onclick="editData(' + id + ')"><i class="fas fa-edit"></i></button>' +
        '<button class="btn btn-action btn-delete" title="Hapus" data-id="' + id + '" data-nama="' + escapeHtml(pejagal) + '" onclick="confirmDelete(' + id + ', \'' + escapeHtml(pejagal) + '\')"><i class="fas fa-trash"></i></button>' +
        '</div>';
}

function showMap(namaRpu, kecamatan, kelurahan, coordinates, alamat, telp, totalEkor, totalBerat, id) {
    const [lat, lng] = coordinates.split(",").map(function(coord) { return parseFloat(coord.trim()); });

    $("#mapTitle").text("Peta Lokasi " + namaRpu);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">RPU:</span> ' + escapeHtml(namaRpu) + '<br>' +
        '<span class="fw-bold">Kecamatan:</span> ' + escapeHtml(kecamatan) + '<br>' +
        '<span class="fw-bold">Kelurahan:</span> ' + escapeHtml(kelurahan) +
        '</div>' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold">Telepon:</span> ' + escapeHtml(telp || '-') + '<br>' +
        '<span class="fw-bold">Total Potong:</span> ' + totalEkor + ' ekor (' + totalBerat + ' kg)' +
        '</div>' +
        '</div>'
    );

    $("#clinicInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama RPU:</span><br><span class="text-primary fw-bold">' + escapeHtml(namaRpu) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Kecamatan/Kelurahan:</span><br>' + escapeHtml(kecamatan) + ' - ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Alamat:</span><br>' + escapeHtml(alamat || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kontak:</span><br><i class="fas fa-phone-alt me-1"></i> ' + escapeHtml(telp || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Total Potong:</span><br><span class="badge-ekor">' + totalEkor + ' ekor</span> <span class="badge-berat">' + totalBerat + ' kg</span></div>'
    );

    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>'
    );

    $.ajax({
        url: base_url + 'data_rpu/detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data.komoditas) {
                let komoditasHtml = '<div class="row">';
                $.each(response.data.komoditas, function(i, k) {
                    komoditasHtml += '<div class="col-md-4"><div class="komoditas-card"><strong>' + escapeHtml(k.komoditas) + '</strong><br><small>' + k.jumlah_ekor + ' ekor (' + parseFloat(k.berat_kg).toFixed(2) + ' kg)</small><br><span class="badge-asal">' + escapeHtml(k.asal_unggas || '-') + '</span></div></div>';
                });
                komoditasHtml += '</div>';
                $("#komoditasMapInfo").html(komoditasHtml);
            } else {
                $("#komoditasMapInfo").html('<p class="text-muted">Tidak ada data komoditas</p>');
            }
        }
    });

    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();

            const rpuIcon = L.divIcon({
                html: '<div style="background-color: #832706; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
                className: "rpu-marker",
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });

            currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
            currentRpuMarker.bindPopup(
                '<div style="min-width: 250px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + escapeHtml(namaRpu) + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Alamat:</strong> ' + escapeHtml(alamat || '-') + '</div>' +
                '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
                '<div><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Telepon:</strong> ' + escapeHtml(telp || '-') + '</div>' +
                '<div><strong>Potongan:</strong> ' + totalEkor + ' ekor (' + totalBerat + ' kg)</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentRpuMarker);

            const circle = L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 300 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);

        const rpuIcon = L.divIcon({
            html: '<div style="background-color: #832706; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>',
            className: "rpu-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });

        currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
        currentRpuMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">' + escapeHtml(namaRpu) + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Alamat:</strong> ' + escapeHtml(alamat || '-') + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
            '<div><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Telepon:</strong> ' + escapeHtml(telp || '-') + '</div>' +
            '<div><strong>Potongan:</strong> ' + totalEkor + ' ekor (' + totalBerat + ' kg)</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentRpuMarker);

        const circle = L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 300 }).addTo(map);
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

// ================ FUNCTION PRINT RAPI (SAMA PERSIS PELAKU USAHA) ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var table = $('#rpuTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalEkor = 0;
    var totalBerat = 0;
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Rumah Potong Unggas</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA RUMAH POTONG UNGGAS (RPU)</h2>');
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
    printWindow.document.write('<th>Tanggal</th>');
    printWindow.document.write('<th>RPU/Pejagal</th>');
    printWindow.document.write('<th>Penanggung Jawab</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Kelurahan</th>');
    printWindow.document.write('<th>Komoditas</th>');
    printWindow.document.write('<th>Total Ekor</th>');
    printWindow.document.write('<th>Total Berat (kg)</th>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        // Kolom 7 (index 7) berisi total potong: "X ekor, Y kg"
        var totalText = stripHtml(row[7] || '0');
        var ekor = '0';
        var berat = '0';
        
        // Extract ekor
        var ekorMatch = totalText.match(/(\d+)\s*ekor/i);
        if (ekorMatch) {
            ekor = ekorMatch[1];
            totalEkor += parseInt(ekor) || 0;
        }
        
        // Extract berat
        var beratMatch = totalText.match(/([\d,]+\.?\d*)\s*kg/i);
        if (beratMatch) {
            berat = beratMatch[1].replace(/,/g, '');
            totalBerat += parseFloat(berat) || 0;
        }
        
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[6] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + ekor + ' Ekor' + '</td>');
        printWindow.document.write('<td align="center">' + formatNumber(parseFloat(berat)) + ' kg' + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="7" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalEkor) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalBerat) + ' kg</strong></td>');
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

// ================ INISIALISASI DATATABLE ================
$(document).ready(function() {
    dataTable = $("#rpuTable").DataTable({
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
        order: [[1, 'desc']],
        columnDefs: [
            { targets: [8], orderable: false },
            { targets: [9], orderable: false }
        ]
    });

    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        if (id) {
            editData(id);
        }
    });

    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (id) {
            confirmDelete(id, nama);
        }
    });

    $("#filterBtn").click(function() {
        const pejagalValue = $("#filterPejagal").val();
        const komoditasValue = $("#filterKomoditas").val();
        const kecamatanValue = $("#filterKecamatan").val();
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        
        let searchTerm = "";

        if (pejagalValue !== "all") {
            searchTerm += pejagalValue;
        }
        if (komoditasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += komoditasValue;
        }
        if (kecamatanValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += kecamatanValue;
        }

        if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
        } else {
            $("#rpuTable").DataTable().search(searchTerm).draw();
        }
    });

    $("#resetBtn").click(function() {
        $("#filterPejagal").val("all");
        $("#filterKomoditas").val("all");
        $("#filterKecamatan").val("all");
        $("#startDate").val(getFirstDayOfMonth());
        $("#endDate").val(getLastDayOfMonth());
        $("#rpuTable").DataTable().search("").draw();
    });

    $("#closeMapBtn").click(function() {
        $("#mapSection").hide();
        if (map) {
            map.remove();
            map = null;
        }
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
        if (map && currentRpuMarker) {
            const latlng = currentRpuMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });

    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
    
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: base_url + 'data_rpu/update',
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
});

function getFirstDayOfMonth() {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    return firstDay.toISOString().split('T')[0];
}

function getLastDayOfMonth() {
    var date = new Date();
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    return lastDay.toISOString().split('T')[0];
}

var base_url = "<?= base_url() ?>";