// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentClinicMarker = null;
let dataTable = null;
let deleteId = null;

// Data Klinik Hewan (8 klinik)
let allData = [
    {
        id: 1,
        nama_klinik: "Klinik Hewan Satwa Sehat",
        kecamatan: "Sukolilo",
        kelurahan: "Keputih",
        alamat: "Jl. Raya ITS No. 45",
        rt: "005",
        rw: "003",
        telepon: "031-5945678",
        latitude: "-7.2876",
        longitude: "112.7891",
        jumlah_dokter: 4,
        jenis_layanan: "24 Jam, Rawat Inap, Bedah",
        surat_ijin: "Y",
        keterangan: "Klinik hewan dengan layanan lengkap 24 jam. Dilengkapi dengan fasilitas rawat inap dan ruang operasi. Melayani berbagai jenis hewan kesayangan dan ternak."
    },
    {
        id: 2,
        nama_klinik: "Klinik Drh. Soeparno",
        kecamatan: "Rungkut",
        kelurahan: "Rungkut Kidul",
        alamat: "Jl. Raya Rungkut Industri No. 78",
        rt: "002",
        rw: "005",
        telepon: "031-8723456",
        latitude: "-7.3265",
        longitude: "112.7683",
        jumlah_dokter: 2,
        jenis_layanan: "Praktek Umum, Vaksinasi",
        surat_ijin: "Y",
        keterangan: "Klinik praktek umum untuk hewan kesayangan. Fokus pada pelayanan vaksinasi dan pengobatan rutin."
    },
    {
        id: 3,
        nama_klinik: "Surabaya Veterinary Clinic",
        kecamatan: "Gubeng",
        kelurahan: "Gubeng",
        alamat: "Jl. Gubeng Raya No. 112",
        rt: "001",
        rw: "002",
        telepon: "031-5034567",
        latitude: "-7.2667",
        longitude: "112.7500",
        jumlah_dokter: 6,
        jenis_layanan: "24 Jam, Spesialis, Bedah, Laboratorium",
        surat_ijin: "Y",
        keterangan: "Klinik hewan spesialis dengan peralatan modern. Menyediakan layanan bedah, laboratorium, dan konsultasi spesialis."
    },
    {
        id: 4,
        nama_klinik: "Klinik Hewan Kenari",
        kecamatan: "Wonokromo",
        kelurahan: "Wonokromo",
        alamat: "Jl. Kenari No. 34",
        rt: "003",
        rw: "004",
        telepon: "031-7256789",
        latitude: "-7.2953",
        longitude: "112.7389",
        jumlah_dokter: 3,
        jenis_layanan: "Praktek Umum, Vaksinasi",
        surat_ijin: "Y",
        keterangan: "Klinik hewan yang berlokasi di pusat kota, melayani pengobatan umum dan vaksinasi untuk hewan kesayangan."
    },
    {
        id: 5,
        nama_klinik: "Puskeswan Mulyorejo",
        kecamatan: "Mulyorejo",
        kelurahan: "Kalisari",
        alamat: "Jl. Mulyorejo Utara No. 56",
        rt: "002",
        rw: "006",
        telepon: "031-5961234",
        latitude: "-7.2621",
        longitude: "112.7915",
        jumlah_dokter: 5,
        jenis_layanan: "Praktek Umum, Laboratorium, Vaksinasi",
        surat_ijin: "Y",
        keterangan: "Pusat Kesehatan Hewan milik pemerintah yang melayani masyarakat dengan tarif terjangkau."
    },
    {
        id: 6,
        nama_klinik: "Klinik Hewan Tandes",
        kecamatan: "Tandes",
        kelurahan: "Balongsari",
        alamat: "Jl. Tandes No. 89",
        rt: "004",
        rw: "002",
        telepon: "031-7112345",
        latitude: "-7.2439",
        longitude: "112.6816",
        jumlah_dokter: 2,
        jenis_layanan: "Praktek Umum",
        surat_ijin: "N",
        keterangan: "Klinik hewan sederhana yang melayani pengobatan umum untuk hewan ternak dan kesayangan di wilayah Tandes."
    },
    {
        id: 7,
        nama_klinik: "Klinik Hewan Genteng",
        kecamatan: "Genteng",
        kelurahan: "Genteng",
        alamat: "Jl. Genteng Besar No. 23",
        rt: "001",
        rw: "003",
        telepon: "031-5345678",
        latitude: "-7.2581",
        longitude: "112.7394",
        jumlah_dokter: 3,
        jenis_layanan: "Praktek Umum, Rawat Inap",
        surat_ijin: "Y",
        keterangan: "Klinik hewan dengan fasilitas rawat inap yang nyaman. Melayani konsultasi dan pengobatan untuk hewan kesayangan."
    },
    {
        id: 8,
        nama_klinik: "Klinik Hewan Tegalsari",
        kecamatan: "Tegalsari",
        kelurahan: "Keputran",
        alamat: "Jl. Tegalsari No. 67",
        rt: "002",
        rw: "005",
        telepon: "031-5489012",
        latitude: "-7.2815",
        longitude: "112.7322",
        jumlah_dokter: 2,
        jenis_layanan: "Praktek Umum, Vaksinasi",
        surat_ijin: "N",
        keterangan: "Klinik hewan yang sedang dalam proses pengurusan ijin. Saat ini melayani pengobatan umum terbatas."
    }
];

// ================ RENDER TABLE ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            
            var statusIjin = item.surat_ijin === 'Y' ? 
                '<span class="badge-status badge-ijin">Y</span>' : 
                '<span class="badge-status badge-belum-ijin">N</span>';
            
            var btnMap = (item.latitude && item.longitude) ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + item.nama_klinik + '\', \'' + item.kecamatan + '\', \'' + item.kelurahan + '\', \'' + item.latitude + ', ' + item.longitude + '\', \'' + item.alamat + ', RT ' + item.rt + '/RW ' + item.rw + '\', \'' + item.telepon + '\', \'' + item.jumlah_dokter + '\', \'' + item.jenis_layanan + '\', \'' + item.surat_ijin + '\')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>';
            
            html += '<tr>' +
                '<td>' + no + '</td>' +
                '<td><span class="fw-bold">' + item.nama_klinik + '</span><br><small class="text-muted">' + item.jenis_layanan.split(',')[0] + '</small></td>' +
                '<td>' + item.kecamatan + '</td>' +
                '<td>' + item.kelurahan + '</td>' +
                '<td>' + item.alamat + '<br><small>RT ' + item.rt + '/RW ' + item.rw + '</small></td>' +
                '<td><div>' + item.telepon + '</div></td>' +
                '<td><span class="badge-dokter">' + item.jumlah_dokter + ' Dokter</span></td>' +  // <-- PERUBAHAN DI SINI
                '<td>' + item.jenis_layanan + '</td>' +
                '<td>' + statusIjin + '</td>' +
                '<td>' + btnMap + '</td>' +
                '<td>' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + item.nama_klinik + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        });
    } else {
        html = '<tr><td colspan="11" class="text-center">Tidak ada data klinik hewan</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
            '<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>' +
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
        $('#edit_nama').val(item.nama_klinik);
        $('#edit_kecamatan').val(item.kecamatan);
        $('#edit_kelurahan').val(item.kelurahan);
        $('#edit_alamat').val(item.alamat);
        $('#edit_rt').val(item.rt);
        $('#edit_rw').val(item.rw);
        $('#edit_telepon').val(item.telepon);
        $('#edit_latitude').val(item.latitude);
        $('#edit_longitude').val(item.longitude);
        $('#edit_dokter').val(item.jumlah_dokter);
        $('#edit_layanan').val(item.jenis_layanan);
        $('#edit_status').val(item.surat_ijin);
        $('#edit_keterangan').val(item.keterangan);
        
        $('#editModal').modal('show');
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data klinik hewan: " + nama);
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
    var layanan = $("#filterLayanan").val();
    
    var filteredData = allData.slice();
    
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
    
    if (layanan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.jenis_layanan.includes(layanan);
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterIjin").val("all");
    $("#filterLayanan").val("all");
    renderTable(allData.slice());
}

// ================ MAP FUNCTION ================
function showMap(namaKlinik, kecamatan, kelurahan, coordinates, alamat, telepon, jumlahDokter, jenisLayanan, suratIjin) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    $("#mapTitle").text("Peta Lokasi " + namaKlinik);
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Klinik:</span> ' + namaKlinik + '<br>' +
        '<span class="fw-bold">Kecamatan:</span> ' + kecamatan + '<br>' +
        '<span class="fw-bold">Kelurahan:</span> ' + kelurahan +
        '</div>' +
        '<div class="col-md-6">' +
        '<span class="fw-bold">Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold">Telepon:</span> ' + telepon +
        '</div>' +
        '</div>'
    );
    
    $("#clinicInfo").html(
        '<div class="mb-2"><span class="fw-bold">Nama Klinik:</span><br><span class="text-primary fw-bold">' + namaKlinik + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold">Kecamatan/Kelurahan:</span><br>' + kecamatan + ' - ' + kelurahan + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Alamat:</span><br>' + alamat + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Kontak:</span><br><i class="fas fa-phone-alt me-1"></i> ' + telepon + '</div>' +
        '<div class="mb-2"><span class="fw-bold">Jumlah Dokter:</span><br><span class="badge-dokter">' + jumlahDokter + ' Dokter</span></div>'  // <-- PERUBAHAN DI SINI
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    var layananArray = jenisLayanan.split(','); 
    var layananHtml = '<div class="row">';
    for (var i = 0; i < layananArray.length; i++) {
        layananHtml += '<div class="col-md-3"><div class="layanan-card"><i class="fas fa-check-circle text-success me-1"></i>' + layananArray[i].trim() + '</div></div>';
    }
    layananHtml += '</div>';
    $("#layananInfo").html(layananHtml);
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var clinicIcon = L.divIcon({
                html: '<div style="background-color: #fd7e14; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">K</div>',
                className: "clinic-marker",
                iconSize: [36, 36],
                iconAnchor: [18, 18]
            });
            
            currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
            currentClinicMarker.bindPopup(
                '<div style="min-width: 250px;">' +
                '<h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">' + namaKlinik + '</h5>' +
                '<hr style="margin: 5px 0;">' +
                '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
                '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
                '<div><strong>Kelurahan:</strong> ' + kelurahan + '</div>' +
                '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
                '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
                '<div><strong>Dokter:</strong> ' + jumlahDokter + ' orang</div>' +
                '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentClinicMarker);
            
            var circle = L.circle([lat, lng], { color: "#fd7e14", fillColor: "#fd7e14", fillOpacity: 0.1, radius: 300 }).addTo(map);
            mapMarkers.push(circle);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        mapMarkers.forEach(function(m) { if (map.hasLayer(m)) map.removeLayer(m); });
        mapMarkers = [];
        map.setView([lat, lng], 15);
        
        var clinicIcon = L.divIcon({
            html: '<div style="background-color: #fd7e14; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">K</div>',
            className: "clinic-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });
        
        currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
        currentClinicMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">' + namaKlinik + '</h5>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Alamat:</strong> ' + alamat + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + kecamatan + '</div>' +
            '<div><strong>Kelurahan:</strong> ' + kelurahan + '</div>' +
            '<div><strong>Koordinat:</strong> ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</div>' +
            '<div><strong>Telepon:</strong> ' + telepon + '</div>' +
            '<div><strong>Dokter:</strong> ' + jumlahDokter + ' orang</div>' +
            '<div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentClinicMarker);
        
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
    
    dataTable = $("#klinikTable").DataTable({
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
                        text: 'LAPORAN DATA KLINIK HEWAN',
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
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA KLINIK HEWAN</h2>' +
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
        if (map && currentClinicMarker) {
            var latlng = currentClinicMarker.getLatLng();
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
        
        var updatedData = {
            id: id,
            nama_klinik: $("#edit_nama").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            alamat: $("#edit_alamat").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            telepon: $("#edit_telepon").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            jumlah_dokter: parseInt($("#edit_dokter").val()),
            jenis_layanan: $("#edit_layanan").val(),
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