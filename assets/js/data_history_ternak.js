// Data untuk detail history
const historyDetailData = {
    1: [
        {
            no: 1,
            jenis: "Penambahan",
            jumlah: 5,
            alasan: "Kelahiran",
            petugas: "Dr. Andi",
            tanggal: "22-03-2023",
        },
    ],
    2: [
        {
            no: 1,
            jenis: "Penambahan",
            jumlah: 725,
            alasan: "Pembelian bibit",
            petugas: "Dr. Sari",
            tanggal: "28-10-2022",
        },
    ],
    3: [
        {
            no: 1,
            jenis: "Penambahan",
            jumlah: 500,
            alasan: "Pembelian bibit",
            petugas: "Dr. Budi",
            tanggal: "27-10-2022",
        },
    ],
    4: [
        {
            no: 1,
            jenis: "Penambahan",
            jumlah: 3,
            alasan: "Kelahiran",
            petugas: "Dr. Andi",
            tanggal: "15-02-2023",
        },
        {
            no: 2,
            jenis: "Pengurangan",
            jumlah: 1,
            alasan: "Penjualan",
            petugas: "Dr. Andi",
            tanggal: "15-02-2023",
        },
    ],
    5: [
        {
            no: 1,
            jenis: "Penambahan",
            jumlah: 150,
            alasan: "Pembelian bibit",
            petugas: "Dr. Rina",
            tanggal: "10-01-2023",
        },
        {
            no: 2,
            jenis: "Pengurangan",
            jumlah: 20,
            alasan: "Kematian",
            petugas: "Dr. Rina",
            tanggal: "10-01-2023",
        },
    ],
};

// Variable untuk peta
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentFarmMarker = null;

$(document).ready(function() {
    // Inisialisasi DataTable dengan warna tombol seperti pelaku usaha
    var table = $("#historyDataTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN HISTORY DATA TERNAK',
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
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN HISTORY DATA TERNAK</h2>' +
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
        order: [[0, 'asc']]
    });

    // Filter button event
    $("#filterBtn").click(function() {
        const komoditasValue = $("#filterKomoditas").val();
        const periodeValue = $("#filterPeriode").val();
        let searchTerm = "";

        if (komoditasValue === "all" && periodeValue === "all") {
            table.search("").draw();
            return;
        }

        if (komoditasValue !== "all") {
            let komoditasTerm = "";
            switch (komoditasValue) {
                case "sapi_potong":
                    komoditasTerm = "Sapi Potong";
                    break;
                case "ayam_petelur":
                    komoditasTerm = "Ayam Ras Petelur";
                    break;
                case "ayam_kampung":
                    komoditasTerm = "Ayam Kampung";
                    break;
                case "kambing":
                    komoditasTerm = "Kambing";
                    break;
                case "itik":
                    komoditasTerm = "Itik";
                    break;
            }
            searchTerm += komoditasTerm;
        }

        if (periodeValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += periodeValue;
        }

        table.search(searchTerm).draw();
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterKomoditas").val("all");
        $("#filterPeriode").val("all");
        table.search("").draw();
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
        if (map && currentFarmMarker) {
            const latlng = currentFarmMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });

    // Auto close alerts
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

// Function to show map
function showMap(komoditas, peternak, coordinates) {
    const [lat, lng] = coordinates.split(",").map((coord) => parseFloat(coord.trim()));

    $("#mapTitle").text(`Peta Lokasi Ternak ${komoditas}, Peternak: ${peternak}`);
    $("#mapInfo").html(`
        <div class="row">
            <div class="col-md-6">
                <span class="fw-bold">Peternak:</span> ${peternak}<br>
                <span class="fw-bold">Komoditas:</span> ${komoditas}
            </div>
            <div class="col-md-6">
                <span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br>
                <span class="fw-bold">Tanggal Update:</span> Terbaru
            </div>
        </div>
    `);

    $("#farmInfo").html(`
        <div class="mb-2">
            <span class="fw-bold">Nama Peternak:</span><br>
            <span class="text-primary fw-bold">${peternak}</span>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Komoditas:</span><br>
            <span class="badge bg-primary-custom">${komoditas}</span>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Jumlah Ternak:</span><br>
            <span class="fw-bold">5 Ekor</span>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Status:</span><br>
            <span class="badge bg-success">Aktif</span>
        </div>
    `);

    $("#coordInfo").html(`
        <div class="mb-2">
            <span class="fw-bold">Latitude:</span><br>
            <code>${lat.toFixed(6)}</code>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Longitude:</span><br>
            <code>${lng.toFixed(6)}</code>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Format Koordinat:</span><br>
            <small>DD (Decimal Degrees)</small>
        </div>
        <div class="mb-2">
            <span class="fw-bold">Akurasi:</span><br>
            <small>GPS ± 5 meter</small>
        </div>
    `);

    if (!map) {
        $("#mapContainer").css("height", "500px");
        
        setTimeout(() => {
            map = L.map("mapContainer", {
                zoomControl: false,
                attributionControl: false,
            }).setView([lat, lng], 15);

            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");

            updateMapView();

            const farmIcon = L.divIcon({
                html: `<div style="background-color: #832706; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
                className: "farm-marker",
                iconSize: [30, 30],
                iconAnchor: [15, 15],
            });

            currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
            currentFarmMarker.bindPopup(`
                <div style="min-width: 200px;">
                    <h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">${peternak}</h5>
                    <hr style="margin: 5px 0;">
                    <div style="margin-bottom: 3px;"><strong>Komoditas:</strong> ${komoditas}</div>
                    <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                    <div style="margin-bottom: 3px;"><strong>Jumlah Ternak:</strong> 5 Ekor</div>
                    <div style="text-align: center; margin-top: 8px;">
                        <small class="text-muted">Klik di luar popup untuk menutup</small>
                    </div>
                </div>
            `).openPopup();
            mapMarkers.push(currentFarmMarker);

            const circle = L.circle([lat, lng], {
                color: "#832706",
                fillColor: "#832706",
                fillOpacity: 0.1,
                radius: 500,
            }).addTo(map);
            mapMarkers.push(circle);

            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        }, 100);
    } else {
        mapMarkers.forEach((marker) => map.removeLayer(marker));
        mapMarkers = [];

        map.setView([lat, lng], 15);

        const farmIcon = L.divIcon({
            html: `<div style="background-color: #832706; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
            className: "farm-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15],
        });

        currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
        currentFarmMarker.bindPopup(`
            <div style="min-width: 200px;">
                <h5 style="margin: 0 0 5px 0; color: #832706; text-align: center;">${peternak}</h5>
                <hr style="margin: 5px 0;">
                <div style="margin-bottom: 3px;"><strong>Komoditas:</strong> ${komoditas}</div>
                <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                <div style="margin-bottom: 3px;"><strong>Jumlah Ternak:</strong> 5 Ekor</div>
                <div style="text-align: center; margin-top: 8px;">
                    <small class="text-muted">Klik di luar popup untuk menutup</small>
                </div>
            </div>
        `).openPopup();
        mapMarkers.push(currentFarmMarker);

        const circle = L.circle([lat, lng], {
            color: "#832706",
            fillColor: "#832706",
            fillOpacity: 0.1,
            radius: 500,
        }).addTo(map);
        mapMarkers.push(circle);

        setTimeout(() => {
            map.invalidateSize();
        }, 50);
    }

    $("#mapSection").show();
    $("#detailSection").hide();

    $("html, body").animate({
        scrollTop: $("#mapSection").offset().top - 20
    }, 500);

    setTimeout(() => {
        if (map) {
            map.invalidateSize();
        }
    }, 300);
}

// Function to update map view
function updateMapView() {
    if (!map) return;

    map.eachLayer((layer) => {
        if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
        }
    });

    if (currentView === "map") {
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);
    } else if (currentView === "satellite") {
        L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
            attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
            maxZoom: 19,
        }).addTo(map);
    }

    mapMarkers.forEach((marker) => {
        if (marker instanceof L.Circle || marker instanceof L.Marker) {
            map.addLayer(marker);
        }
    });

    setTimeout(() => {
        map.invalidateSize();
    }, 50);
}