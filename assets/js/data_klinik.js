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
    
    $.ajax({
        url: base_url + 'index.php/data_klinik/get_all_data',
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

// ================ RENDER TABLE (HANYA EXCEL & PRINT AKTIF) ================
function renderTable(data) {
    var html = "";
    if (data && data.length > 0) {
        $.each(data, function(index, item) {
            var no = index + 1;
            
            var statusIjin = (item.surat_ijin === 'Y') ? 
                '<span class="badge-status badge-active"><i class="fas fa-check-circle me-1"></i>Memiliki Ijin</span>' : 
                '<span class="badge-status badge-inactive"><i class="fas fa-times-circle me-1"></i>Belum Ijin</span>';
            
            var btnMap = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.nama_klinik || '') + '\', \'' + escapeHtml(item.kecamatan || '') + '\', \'' + escapeHtml(item.kelurahan || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\', \'' + escapeHtml(item.alamat || '') + '\', \'' + escapeHtml(item.telepon || '') + '\', \'' + escapeHtml(item.jumlah_dokter || '0') + '\', \'' + escapeHtml(item.jenis_layanan || '') + '\', ' + item.id + ')" title="Lihat Peta"><i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' : 
                '<button class="btn btn-sm btn-outline-secondary-custom" disabled title="Koordinat tidak tersedia"><i class="fas fa-map-marker-alt me-1"></i>No Koordinat</button>';
            
            var teleponDisplay = item.telepon ? 
                '<a href="tel:' + item.telepon + '" class="telp-link" style="color: #212529; text-decoration: none;">' + item.telepon + '</a>' : 
                '<span class="text-muted">-</span>';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td><span class="fw-bold">' + escapeHtml(item.nama_klinik || '-') + '</span></td>' +
                '<td>' + escapeHtml(item.kecamatan || '-') + '</td>' +
                '<td>' + escapeHtml(item.kelurahan || '-') + '</td>' +
                '<td title="' + escapeHtml(item.alamat || '') + '">' + truncateText(item.alamat, 30) + '</td>' +
                '<td class="text-center">' + teleponDisplay + '</td>' +
                '<td class="text-center">' + (item.jumlah_dokter || 0) + ' Dokter' + '</td>' +
                '<td class="text-center"><small>' + escapeHtml(item.jenis_layanan || '-') + '</small></td>' +
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
        html = '<tr><td colspan="11" class="text-center py-5"><i class="fas fa-clinic-medical fa-3x text-muted mb-3 d-block"></i>Tidak ada data klinik他wan</td></tr>';
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
            // {
            //     extend: 'copy',
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            // {
            //     extend: 'csv',
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            },
            // {
            //     extend: 'pdf',
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] }
            // },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9] },
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
            { orderable: false, targets: [9, 10] },
            { className: "text-nowrap", targets: [1, 2, 3, 4] }
        ],
        order: [[0, 'asc']]
    });
}

// ================ FUNCTION PRINT RAPI (SAMA PERSIS PELAKU USAHA) ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel yang tampil di layar
    var table = $('#klinikTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalDokter = 0;
    
    // Hitung total dokter
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var dokterText = stripHtml(row[6] || '0');
        var dokter = parseInt(dokterText.replace(/\./g, '')) || 0;
        totalDokter += dokter;
    }
    
    // Current date
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Data Klinik Hewan</title>');
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
    printWindow.document.write('<h2>LAPORAN DATA KLINIK HEWAN</h2>');
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
    printWindow.document.write('<th>Nama Klinik</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Kelurahan</th>');
    printWindow.document.write('<th>Alamat</th>');
    printWindow.document.write('<th>Telepon</th>');
    printWindow.document.write('<th>Jumlah Dokter</th>');
    printWindow.document.write('<th>Jenis Layanan</th>');
    printWindow.document.write('<th>Status Ijin</th>');
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
        printWindow.document.write('<td align="center">' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[6] || '0') + ' Dokter' + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[7] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[8] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="6" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalDokter) + ' Dokter</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalData) + ' Klinik</strong></td>');
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
                $('#edit_latitude').val(item.latitude || '');
                $('#edit_longitude').val(item.longitude || '');
                $('#edit_status').val(item.surat_ijin === 'Y' ? 'Y' : 'N');
                $('#edit_telepon').val(item.telepon || '');
                $('#edit_dokter').val(item.jumlah_dokter || 0);
                $('#edit_layanan').val(item.jenis_layanan || '');
                $('#edit_rt').val(item.rt || '');
                $('#edit_rw').val(item.rw || '');
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

// ================ DELETE DATA ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").html('<i class="fas fa-clinic-medical me-2"></i>' + escapeHtml(nama));
    $("#deleteModal").modal("show");
}

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
    var statusIjin = $("#filterIjin").val();
    var layanan = $("#filterLayanan").val();
    
    var filteredData = allData.slice();
    
    if (kecamatan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.kecamatan === kecamatan;
        });
    }
    
    if (statusIjin !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.surat_ijin === statusIjin;
        });
    }
    
    if (layanan !== "all") {
        filteredData = filteredData.filter(function(item) {
            return item.jenis_layanan && item.jenis_layanan.includes(layanan);
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

// ================ MAP FUNCTION ================
function showMap(namaKlinik, kecamatan, kelurahan, coordinates, alamat, telepon, jumlahDokter, layanan, id) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];
    
    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }
    
    $("#mapTitle").html('<i class="fas fa-clinic-medical me-2"></i>' + escapeHtml(namaKlinik));
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-clinic-medical me-1"></i> Klinik:</span> ' + escapeHtml(namaKlinik) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Kecamatan:</span> ' + escapeHtml(kecamatan) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-building me-1"></i> Kelurahan:</span> ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-map-pin me-1"></i> Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold"><i class="fas fa-phone-alt me-1"></i> Telepon:</span> ' + (telepon || '-') + '<br>' +
        '<span class="fw-bold"><i class="fas fa-user-md me-1"></i> Dokter:</span> ' + jumlahDokter + ' orang</div>' +
        '</div>'
    );
    
    $("#clinicInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-clinic-medical me-2"></i>Nama Klinik:</span><br><span class="text-primary fw-bold fs-5">' + escapeHtml(namaKlinik) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Kecamatan/Kelurahan:</span><br>' + escapeHtml(kecamatan) + ' - ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-location-dot me-2"></i>Alamat:</span><br>' + escapeHtml(alamat || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-phone-alt me-2"></i>Kontak:</span><br>' + (telepon || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-user-md me-2"></i>Jumlah Dokter:</span><br>' + jumlahDokter + ' orang</div>'
    );
    
    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-up me-2"></i>Latitude:</span><br><code class="bg-light p-1 rounded">' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-right me-2"></i>Longitude:</span><br><code class="bg-light p-1 rounded">' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-globe me-2"></i>Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-satellite me-2"></i>Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );
    
    var layananList = layanan ? layanan.split(',').map(function(l) { return l.trim(); }) : [];
    var layananHtml = '<div class="row">';
    if (layananList.length > 0) {
        for (var i = 0; i < layananList.length; i++) {
            layananHtml += '<div class="col-md-4 col-sm-6 mb-2"><div class="layanan-card p-2 text-center"><i class="fas fa-stethoscope me-1 text-primary-custom"></i> <span class="fw-bold">' + escapeHtml(layananList[i]) + '</span></div></div>';
        }
    } else {
        layananHtml += '<div class="col-12 text-center py-3"><i class="fas fa-info-circle fa-2x text-muted mb-2 d-block"></i><span class="text-muted">Informasi layanan tidak tersedia</span></div>';
    }
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
                html: '<div style="background-color: #17a2b8; width: 32px; height: 32px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-clinic-medical"></i></div>',
                className: "clinic-marker",
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });
            
            currentShopMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
            currentShopMarker.bindPopup(
                '<div style="min-width: 250px; font-family: inherit;">' +
                '<h6 style="margin: 0 0 8px 0; color: #17a2b8; text-align: center; font-weight: 700;">' + escapeHtml(namaKlinik) + '</h6>' +
                '<hr style="margin: 5px 0;">' +
                '<div><i class="fas fa-map-marker-alt fa-fw me-2 text-muted"></i><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
                '<div><i class="fas fa-location-dot fa-fw me-2 text-muted"></i><strong>Alamat:</strong> ' + escapeHtml(alamat) + '</div>' +
                '<div><i class="fas fa-phone-alt fa-fw me-2 text-muted"></i><strong>Telepon:</strong> ' + (telepon || '-') + '</div>' +
                '<div><i class="fas fa-user-md fa-fw me-2 text-muted"></i><strong>Dokter:</strong> ' + jumlahDokter + ' orang</div>' +
                '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
                '</div>'
            ).openPopup();
            mapMarkers.push(currentShopMarker);
            
            var circle = L.circle([lat, lng], { 
                color: "#17a2b8", 
                fillColor: "#17a2b8", 
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
            html: '<div style="background-color: #17a2b8; width: 32px; height: 32px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;"><i class="fas fa-clinic-medical"></i></div>',
            className: "clinic-marker",
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });
        
        currentShopMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
        currentShopMarker.bindPopup(
            '<div style="min-width: 250px;">' +
            '<h6 style="margin: 0 0 8px 0; color: #17a2b8; text-align: center; font-weight: 700;">' + escapeHtml(namaKlinik) + '</h6>' +
            '<hr style="margin: 5px 0;">' +
            '<div><strong>Kecamatan:</strong> ' + escapeHtml(kecamatan) + '</div>' +
            '<div><strong>Alamat:</strong> ' + escapeHtml(alamat) + '</div>' +
            '<div><strong>Telepon:</strong> ' + (telepon || '-') + '</div>' +
            '<div><strong>Dokter:</strong> ' + jumlahDokter + ' orang</div>' +
            '<div class="text-center mt-2"><small class="text-muted">Klik di luar untuk menutup</small></div>' +
            '</div>'
        ).openPopup();
        mapMarkers.push(currentShopMarker);
        
        var circle = L.circle([lat, lng], { color: "#17a2b8", fillColor: "#17a2b8", fillOpacity: 0.1, radius: 200 }).addTo(map);
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
            nama_klinik: $("#edit_nama").val(),
            kecamatan: $("#edit_kecamatan").val(),
            kelurahan: $("#edit_kelurahan").val(),
            alamat: $("#edit_alamat").val(),
            rt: $("#edit_rt").val(),
            rw: $("#edit_rw").val(),
            latitude: $("#edit_latitude").val(),
            longitude: $("#edit_longitude").val(),
            telepon: $("#edit_telepon").val(),
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