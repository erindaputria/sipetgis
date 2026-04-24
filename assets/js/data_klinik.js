// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentClinicMarker = null;
let dataTable = null;
let deleteId = null;
let allData = [];

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#dataTableBody").html('<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...</td></tr>');
    
    var apiUrl = base_url + 'index.php/data_klinik/get_all_data';
    
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
            if (dataTable) {
                dataTable.clear();
                dataTable.rows.add($("#dataTableBody tr"));
                dataTable.draw();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.status, error);
            $.ajax({
                url: base_url + 'data_klinik/get_all_data',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && !response.error) {
                        allData = Array.isArray(response) ? response : [];
                    } else {
                        allData = [];
                    }
                    renderTable(allData);
                    if (dataTable) {
                        dataTable.clear();
                        dataTable.rows.add($("#dataTableBody tr"));
                        dataTable.draw();
                    }
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
            
            var statusIjin = item.surat_ijin === 'Y' ? 
                '<span class="badge-status badge-ijin"><i class="fas fa-check-circle me-1"></i>Y</span>' : 
                '<span class="badge-status badge-belum-ijin"><i class="fas fa-times-circle me-1"></i>N</span>';
            
            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(' + item.id + ')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta' +
                '</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia">' +
                '<i class="fas fa-map-marker-alt me-1"></i>No Koordinat' +
                '</button>';
            
            var teleponDisplay = item.telp ? 
                '<a href="tel:' + item.telp + '" style="color: #212529; text-decoration: none;">' + item.telp + '</a>' : 
                '<span class="text-muted">-</span>';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td><span class="fw-bold">' + escapeHtml(item.nama_klinik || '-') + '</span><br><small class="text-muted">' + (item.jenis_layanan ? item.jenis_layanan.substring(0, 15) : '-') + '</small></td>' +
                '<td>' + escapeHtml(item.kecamatan || '-') + '</td>' +
                '<td>' + escapeHtml(item.kelurahan || '-') + '</td>' +
                '<td title="' + escapeHtml(item.alamat || '') + '">' + truncateText(item.alamat, 25) + '<br><small>RT ' + (item.rt || '-') + '/RW ' + (item.rw || '-') + '</small></td>' +
                '<td>' + teleponDisplay + '</td>' +
                '<td><span class="badge-dokter"><i class="fas fa-user-md me-1"></i>' + (item.jumlah_dokter || '0') + ' Dokter</span></td>' +
                '<td>' + escapeHtml(item.jenis_layanan || '-') + '</td>' +
                '<td class="text-center">' + statusIjin + '</td>' +
                '<td class="text-center">' + btnMap + '</td>' +
                '<td class="text-center">' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="confirmDelete(' + item.id + ', \'' + escapeHtml(item.nama_klinik || '') + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        });
    } else {
        html = '<tr><td colspan="11" class="text-center py-5"><i class="fas fa-clinic-medical fa-3x text-muted mb-3 d-block"></i>Tidak ada data klinik hewan</td></tr>';
    }
    
    $("#dataTableBody").html(html);
    
    if (dataTable) {
        dataTable.destroy();
    }
    
    dataTable = $("#klinikTable").DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID');
                    doc.content.unshift({
                        text: 'LAPORAN DATA KLINIK HEWAN',
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
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
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
            { orderable: false, targets: [9, 10] },
            { className: "text-nowrap", targets: [1, 2, 3, 4, 5, 6, 7] }
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
        url: base_url + 'index.php/data_klinik/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(item) {
            if (item && !item.error) {
                $('#edit_id').val(item.id);
                $('#edit_nama').val(item.nama_klinik || '');
                $('#edit_kecamatan').val(item.kecamatan || '');
                $('#edit_kelurahan').val(item.kelurahan || '');
                $('#edit_alamat').val(item.alamat || '');
                $('#edit_rt').val(item.rt || '');
                $('#edit_rw').val(item.rw || '');
                $('#edit_telepon').val(item.telp || '');
                $('#edit_latitude').val(item.latitude || '');
                $('#edit_longitude').val(item.longitude || '');
                $('#edit_dokter').val(item.jumlah_dokter || '');
                $('#edit_layanan').val(item.jenis_layanan || '');
                $('#edit_status').val(item.surat_ijin || 'Y');
                $('#edit_keterangan').val(item.keterangan || '');
                
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

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").html('<i class="fas fa-clinic-medical me-2"></i>' + escapeHtml(nama));
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    $.ajax({
        url: base_url + 'index.php/data_klinik/delete/' + id,
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
            return item.jenis_layanan && item.jenis_layanan.toLowerCase().includes(layanan.toLowerCase());
        });
    }
    
    renderTable(filteredData);
}

function resetFilter() {
    $("#filterKecamatan").val("all");
    $("#filterIjin").val("all");
    $("#filterLayanan").val("all");
    renderTable(allData);
}

// ================ MAP FUNCTION (PERBAIKAN) ================
function showMap(id) {
    console.log("ID yang diklik:", id);
    console.log("All Data:", allData);
    
    // Cari data berdasarkan id (pastikan id dari database ada)
    var item = allData.find(function(d) { 
        return parseInt(d.id) === parseInt(id); 
    });
    
    if (!item) {
        console.error("Data tidak ditemukan untuk ID:", id);
        alert("Data tidak ditemukan untuk ID: " + id);
        return;
    }
    
    console.log("Data ditemukan:", item);
    
    var lat = parseFloat(item.latitude);
    var lng = parseFloat(item.longitude);
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid untuk klinik ini");
        return;
    }
    
    var namaKlinik = item.nama_klinik || '-';
    var kecamatan = item.kecamatan || '-';
    var kelurahan = item.kelurahan || '-';
    var alamat = item.alamat || '-';
    var rt = item.rt || '-';
    var rw = item.rw || '-';
    var telepon = item.telp || '-';
    var jumlahDokter = item.jumlah_dokter || '0';
    var jenisLayanan = item.jenis_layanan || '-';
    var suratIjin = item.surat_ijin || 'N';
    var keterangan = item.keterangan || '';
    
    var alamatLengkap = alamat + ', RT ' + rt + '/RW ' + rw;
    
    $("#mapTitle").html('<i class="fas fa-clinic-medical me-2"></i>' + escapeHtml(namaKlinik));
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6">' +
        '<span class="fw-bold"><i class="fas fa-clinic-medical me-1"></i> Klinik:</span> ' + escapeHtml(namaKlinik) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Kecamatan:</span> ' + escapeHtml(kecamatan) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-building me-1"></i> Kelurahan:</span> ' + escapeHtml(kelurahan) +
        '</div>' +
        '<div class="col-md-6">' +
        '<span class="fw-bold"><i class="fas fa-map-pin me-1"></i> Koordinat:</span> <span class="coord-badge">' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</span><br>' +
        '<span class="fw-bold"><i class="fas fa-phone-alt me-1"></i> Telepon:</span> ' + escapeHtml(telepon) +
        '</div>' +
        '</div>'
    );
    
    $("#clinicInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-clinic-medical me-2"></i>Nama Klinik:</span><br><span class="text-primary fw-bold fs-5">' + escapeHtml(namaKlinik) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Kecamatan/Kelurahan:</span><br>' + escapeHtml(kecamatan) + ' - ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-location-dot me-2"></i>Alamat:</span><br>' + escapeHtml(alamatLengkap) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-phone-alt me-2"></i>Kontak:</span><br>' + escapeHtml(telepon) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-user-md me-2"></i>Jumlah Dokter:</span><br><span class="badge-dokter">' + escapeHtml(jumlahDokter) + ' Dokter</span></div>' +
        (keterangan ? '<div class="mb-2"><span class="fw-bold"><i class="fas fa-info-circle me-2"></i>Keterangan:</span><br>' + escapeHtml(keterangan) + '</div>' : '')
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-up me-2"></i>Latitude:</span><br><code class="bg-light p-1 rounded">' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-right me-2"></i>Longitude:</span><br><code class="bg-light p-1 rounded">' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-globe me-2"></i>Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-satellite me-2"></i>Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    var statusIjinText = (suratIjin === 'Y') ? 'Memiliki Ijin' : 'Belum Memiliki Ijin';
    var statusBadge = (suratIjin === 'Y') ? 
        '<span class="badge-status badge-ijin"><i class="fas fa-check-circle me-1"></i>' + statusIjinText + '</span>' : 
        '<span class="badge-status badge-belum-ijin"><i class="fas fa-times-circle me-1"></i>' + statusIjinText + '</span>';
    
    var layananArray = jenisLayanan.split(','); 
    var layananHtml = '<div class="row">';
    for (var i = 0; i < layananArray.length; i++) {
        layananHtml += '<div class="col-md-4 mb-2"><div class="layanan-card p-2 text-center"><i class="fas fa-stethoscope me-1 text-primary-custom"></i> ' + escapeHtml(layananArray[i].trim()) + '</div></div>';
    }
    layananHtml += '<div class="col-md-12 mt-2"><hr><div class="mt-2"><span class="fw-bold"><i class="fas fa-file-alt me-2"></i>Status Ijin:</span> ' + statusBadge + '</div></div>';
    layananHtml += '</div>';
    $("#layananInfo").html(layananHtml);
    
    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 16);
            L.control.zoom({ position: "topright" }).addTo(map);
            L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
            updateMapView();
            
            var clinicIcon = L.divIcon({
                html: '<div style="background-color: #832706; width: 36px; height: 36px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-clinic-medical"></i></div>',
                className: "clinic-marker",
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -18]
            });
            
            currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
            currentClinicMarker.bindPopup(
                '<div style="min-width: 250px; font-family: inherit;">' +
                '<h6 style="margin: 0 0 8px 0; color: #832706; text-align: center; font-weight: 700;">' + escapeHtml(namaKlinik) + '</h6>' +
                '<hr style="margin: 5px 0;">' +
                '<div><i class="fas fa-map-marker-alt fa-fw me-2 text-muted"></i><strong>Alamat:</strong> ' + escapeHtml(alamatLengkap) + '</div>' +
                '<div><i class="fas fa-map-pin fa-fw me-2 text-muted"></i><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
                '<div><i class="fas fa-building fa-fw me-2 text-muted"></i><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
                '<div><i class="fas fa-phone-alt fa-fw me-2 text-muted"></i><strong>Telepon:</strong> ' + escapeHtml(telepon) + '</div>' +
                '<div><i class="fas fa-user-md fa-fw me-2 text-muted"></i><strong>Dokter:</strong> ' + escapeHtml(jumlahDokter) + ' orang</div>' +
                '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentClinicMarker);
            
            var circle = L.circle([lat, lng], { 
                color: "#832706", 
                fillColor: "#832706", 
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
        
        var clinicIcon = L.divIcon({
            html: '<div style="background-color: #832706; width: 36px; height: 36px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-clinic-medical"></i></div>',
            className: "clinic-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -18]
        });
        
        currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
        currentClinicMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h6 style="margin: 0 0 8px 0; color: #832706; text-align: center; font-weight: 700;">' + escapeHtml(namaKlinik) + '</h6>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Alamat:</strong> ' + escapeHtml(alamatLengkap) + '</div>' +
            '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
            '<div><strong>Kelurahan:</strong> ' + escapeHtml(kelurahan) + '</div>' +
            '<div><strong>Telepon:</strong> ' + escapeHtml(telepon) + '</div>' +
            '<div><strong>Dokter:</strong> ' + escapeHtml(jumlahDokter) + ' orang</div>' +
            '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentClinicMarker);
        
        var circle = L.circle([lat, lng], { color: "#832706", fillColor: "#832706", fillOpacity: 0.1, radius: 200 }).addTo(map);
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
        if (map && currentClinicMarker) {
            var latlng = currentClinicMarker.getLatLng();
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
            nama_klinik: $("#edit_nama").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            alamat: $("#edit_alamat").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            telepon: $("#edit_telepon").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            jumlah_dokter: $("#edit_dokter").val(),
            jenis_layanan: $("#edit_layanan").val(),
            surat_ijin: $("#edit_status").val(),
            keterangan: $("#edit_keterangan").val()
        };
        
        $("#editModal .btn-primary-custom").prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
        
        $.ajax({
            url: base_url + 'index.php/data_klinik/update/' + id,
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