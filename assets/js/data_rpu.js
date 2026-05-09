// ================ BASE URL ================
var base_url = window.base_url || "";

// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentRpuMarker = null;
let dataTable = null;
let allData = [];

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#rpuTable tbody").html('<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...<\/td><\/tr>');

    $.ajax({
        url: base_url + 'index.php/data_rpu/get_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.length > 0) {
                allData = response;
                console.log('Total data dimuat:', allData.length);
            } else {
                allData = [];
            }
            renderTable(allData);
            updateFilterOptions();
        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
            allData = [];
            renderTable(allData);
            alert('Gagal memuat data. Silahkan refresh halaman.');
        }
    });
}

// ================ UPDATE FILTER OPTIONS (DINAMIS DARI DATA) ================
function updateFilterOptions() {
    var pejagalSet = new Set();
    var komoditasSet = new Set();
    var kecamatanSet = new Set();

    allData.forEach(function(item) {
        if (item.pejagal && item.pejagal !== '') {
            pejagalSet.add(item.pejagal);
        }
        if (item.kecamatan && item.kecamatan !== '') {
            kecamatanSet.add(item.kecamatan);
        }
        if (item.komoditas_list && item.komoditas_list !== '') {
            var komoditasList = item.komoditas_list.split(' | ');
            for (var i = 0; i < komoditasList.length; i++) {
                var komoditasItem = komoditasList[i].split(':')[0];
                if (komoditasItem && komoditasItem !== '') {
                    komoditasSet.add(komoditasItem.trim());
                }
            }
        }
    });

    // Update filter RPU
    var pejagalOptions = '<option selected value="all">Semua RPU</option>';
    Array.from(pejagalSet).sort().forEach(function(pejagal) {
        pejagalOptions += '<option value="' + escapeHtml(pejagal) + '">' + escapeHtml(pejagal) + '</option>';
    });
    $("#filterPejagal").html(pejagalOptions);

    // Update filter Komoditas
    var komoditasOptions = '<option selected value="all">Semua Komoditas</option>';
    Array.from(komoditasSet).sort().forEach(function(komoditas) {
        komoditasOptions += '<option value="' + escapeHtml(komoditas) + '">' + escapeHtml(komoditas) + '</option>';
    });
    $("#filterKomoditas").html(komoditasOptions);

    // Update filter Kecamatan
    var kecamatanOptions = '<option selected value="all">Semua Kecamatan</option>';
    Array.from(kecamatanSet).sort().forEach(function(kecamatan) {
        kecamatanOptions += '<option value="' + escapeHtml(kecamatan) + '">' + escapeHtml(kecamatan) + '</option>';
    });
    $("#filterKecamatan").html(kecamatanOptions);

    console.log('Filter options updated - RPU:', Array.from(pejagalSet), 'Komoditas:', Array.from(komoditasSet), 'Kecamatan:', Array.from(kecamatanSet));
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }
    
    var html = "";
    if (data && data.length > 0) {
        for (var idx = 0; idx < data.length; idx++) {
            var item = data[idx];
            var no = idx + 1;
            
            var koordinatText = (item.latitude && item.longitude && item.latitude != '' && item.longitude != '') ? 
                '<div class="mb-1 small"><span class="coord-badge">' + (item.latitude.substring(0, 8) || '') + '... , ' + (item.longitude.substring(0, 8) || '') + '...</span></div>' +
                '<button class="btn btn-sm btn-outline-primary-custom" onclick="showMap(\'' + escapeHtml(item.pejagal || '') + '\', \'' + escapeHtml(item.kecamatan || '') + '\', \'' + escapeHtml(item.kelurahan || '') + '\', \'' + item.latitude + ', ' + item.longitude + '\', \'' + escapeHtml(item.lokasi || '') + '\', \'' + escapeHtml(item.telp_pj || '') + '\', \'' + (item.total_ekor || 0) + '\', \'' + parseFloat(item.total_berat || 0).toFixed(2) + '\', ' + item.id + ')" title="Lihat Peta">' +
                '<i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>' : 
                '<span class="empty-coord">-</span>';
            
            html += '<tr>' +
                '<td class="text-center">' + no + '</td>' +
                '<td class="text-center">' + formatDate(item.tanggal_rpu) + '</td>' +
                '<td><span class="fw-bold">' + escapeHtml(item.pejagal || '-') + '</span><br><small class="text-muted">Petugas: ' + escapeHtml(item.nama_petugas || '-') + '</small></td>' +
                '<td>' + escapeHtml(item.nama_pj || '-') + '<br><small class="text-muted">' + escapeHtml(item.nik_pj || '-') + '</small></td>' +
                '<td>' + escapeHtml(item.kecamatan || '-') + '</td>' +
                '<td>' + escapeHtml(item.kelurahan || '-') + '</td>' +
                '<td><small>' + (item.komoditas_list ? escapeHtml(item.komoditas_list.substring(0, 50)) : '-') + '</small></td>' +
                '<td class="text-center"><span class="badge-ekor">' + (item.total_ekor || 0) + '</span> ekor<br><span class="badge-berat">' + parseFloat(item.total_berat || 0).toFixed(2) + ' kg</span><br><span class="badge-asal">' + escapeHtml(item.asal_unggas || '-') + '</span></td>' +
                '<td class="text-center">' + koordinatText + '</td>' +
                '<td class="text-center">' +
                '<div class="btn-action-group">' +
                '<button class="btn btn-action btn-edit" onclick="editData(' + item.id + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
                '<button class="btn btn-action btn-delete" onclick="deleteData(' + item.id + ', \'' + escapeHtml(item.pejagal || '') + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</td>' +
                '</tr>';
        }
    } else {
        html = '<tr><td colspan="10" class="text-center py-5"><i class="fas fa-warehouse fa-3x text-muted mb-3 d-block"></i>Tidak ada data RPU<\/td><\/tr>';
    }
    
    $("#rpuTable tbody").html(html);
    
    dataTable = $("#rpuTable").DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6,7,9] }, action: function(e, dt, button, config) { printWithCurrentData(); } }
        ],
        language: {
            search: "Cari:",
            searchPlaceholder: "Ketik kata kunci...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
        },
        pageLength: 15,
        lengthChange: false,
        scrollX: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [8, 9] },
            { className: "text-nowrap", targets: [0, 1, 2, 3, 4, 5, 6, 7] }
        ],
        order: [[1, 'desc']]
    });
}

// ================ FUNCTION FILTER (SEMUA FILTER BERFUNGSI) ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    var pejagal = $("#filterPejagal").val();
    var komoditas = $("#filterKomoditas").val();
    var kecamatan = $("#filterKecamatan").val();
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();

    console.log('Filter values - RPU:', pejagal, 'Komoditas:', komoditas, 'Kecamatan:', kecamatan, 'Tanggal:', startDate, '-', endDate);
    console.log('Total data sebelum filter:', allData.length);

    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }

    var filteredData = [];

    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchPejagal = true;
        var matchKomoditas = true;
        var matchKecamatan = true;
        var matchTanggal = true;

        // Filter RPU/Pejagal
        if (pejagal !== "all") {
            matchPejagal = (item.pejagal && item.pejagal === pejagal);
        }

        // Filter komoditas (case insensitive, contains)
        if (komoditas !== "all") {
            if (item.komoditas_list) {
                matchKomoditas = item.komoditas_list.toLowerCase().includes(komoditas.toLowerCase());
            } else {
                matchKomoditas = false;
            }
        }

        // Filter kecamatan
        if (kecamatan !== "all") {
            matchKecamatan = (item.kecamatan && item.kecamatan === kecamatan);
        }

        // Filter tanggal
        if (startDate && endDate) {
            if (item.tanggal_rpu) {
                matchTanggal = (item.tanggal_rpu >= startDate && item.tanggal_rpu <= endDate);
            } else {
                matchTanggal = false;
            }
        }

        if (matchPejagal && matchKomoditas && matchKecamatan && matchTanggal) {
            filteredData.push(item);
        }
    }

    console.log('Data setelah filter:', filteredData.length, 'dari', allData.length);
    renderTable(filteredData);
    
    if (filteredData.length === 0 && allData.length > 0) {
        alert('Tidak ada data yang sesuai dengan filter yang dipilih');
    }
}

// ================ FUNCTION RESET FILTER ================
function resetFilter() {
    console.log('=== RESET FILTER DITEKAN ===');

    $("#filterPejagal").val("all");
    $("#filterKomoditas").val("all");
    $("#filterKecamatan").val("all");
    
    var today = new Date();
    var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    $("#startDate").val(firstDay.toISOString().split('T')[0]);
    $("#endDate").val(lastDay.toISOString().split('T')[0]);

    if (dataTable) {
        dataTable.destroy();
        dataTable = null;
    }

    renderTable(allData);

    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
}

// ================ FUNCTION PRINT ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var table = $('#rpuTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalEkor = 0;
    var totalBerat = 0;
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var totalText = stripHtml(row[7] || '0');
        
        var ekorMatch = totalText.match(/(\d+)\s*ekor/i);
        if (ekorMatch) {
            totalEkor += parseInt(ekorMatch[1]) || 0;
        }
        
        var beratMatch = totalText.match(/([\d,]+\.?\d*)\s*kg/i);
        if (beratMatch) {
            var berat = beratMatch[1].replace(/,/g, '');
            totalBerat += parseFloat(berat) || 0;
        }
    }
    
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
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA RUMAH POTONG UNGGAS (RPU)</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
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
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var totalText = stripHtml(row[7] || '0');
        var ekor = '0';
        var berat = '0';
        
        var ekorMatch = totalText.match(/(\d+)\s*ekor/i);
        if (ekorMatch) {
            ekor = ekorMatch[1];
        }
        
        var beratMatch = totalText.match(/([\d,]+\.?\d*)\s*kg/i);
        if (beratMatch) {
            berat = beratMatch[1].replace(/,/g, '');
        }
        
        printWindow.document.write('</tr>');
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
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="7" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalEkor) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalBerat) + ' kg</strong></td>');
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

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    var d = new Date(dateString);
    if (isNaN(d.getTime())) return dateString;
    var day = String(d.getDate()).padStart(2, '0');
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var year = d.getFullYear();
    return day + '-' + month + '-' + year;
}

// ================ EDIT DATA ================
function editData(id) {
    var item = null;
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].id == id) {
            item = allData[i];
            break;
        }
    }
    
    if (item) {
        $('#edit_id').val(item.id);
        $('#edit_pejagal').val(item.pejagal || '');
        $('#edit_tanggal').val(item.tanggal_rpu || '');
        $('#edit_nama_pj').val(item.nama_pj || '');
        $('#edit_nik').val(item.nik_pj || '');
        $('#edit_petugas').val(item.nama_petugas || '');
        $('#edit_kecamatan').val(item.kecamatan || '');
        $('#edit_kelurahan').val(item.kelurahan || '');
        $('#edit_rt').val(item.rt || '');
        $('#edit_rw').val(item.rw || '');
        $('#edit_lokasi').val(item.lokasi || '');
        $('#edit_latitude').val(item.latitude || '');
        $('#edit_longitude').val(item.longitude || '');
        $('#edit_telepon').val(item.telp_pj || '');
        $('#edit_keterangan').val(item.keterangan || '');
        $('#editModal').modal('show');
    } else {
        $.ajax({
            url: base_url + 'index.php/data_rpu/detail/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    var d = response.data;
                    $('#edit_id').val(d.id);
                    $('#edit_pejagal').val(d.pejagal || '');
                    $('#edit_tanggal').val(d.tanggal_rpu || '');
                    $('#edit_nama_pj').val(d.nama_pj || '');
                    $('#edit_nik').val(d.nik_pj || '');
                    $('#edit_petugas').val(d.nama_petugas || '');
                    $('#edit_kecamatan').val(d.kecamatan || '');
                    $('#edit_kelurahan').val(d.kelurahan || '');
                    $('#edit_rt').val(d.rt || '');
                    $('#edit_rw').val(d.rw || '');
                    $('#edit_lokasi').val(d.lokasi || '');
                    $('#edit_latitude').val(d.latitude || '');
                    $('#edit_longitude').val(d.longitude || '');
                    $('#edit_telepon').val(d.telp_pj || '');
                    $('#edit_keterangan').val(d.keterangan || '');
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
}

// ================ DELETE DATA ================
function deleteData(id, namaRpu) {
    if (confirm("Apakah Anda yakin ingin menghapus data RPU: " + namaRpu + "?")) {
        $.ajax({
            url: base_url + 'index.php/data_rpu/hapus/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data berhasil dihapus');
                    loadDataFromServer();
                } else {
                    alert('Gagal menghapus data');
                }
            },
            error: function() {
                alert('Gagal menghapus data');
            }
        });
    }
}

// ================ MAP FUNCTIONS ================
function showMap(namaRpu, kecamatan, kelurahan, coordinates, alamat, telp, totalEkor, totalBerat, id) {
    var coords = coordinates.split(",").map(function(c) { return parseFloat(c.trim()); });
    var lat = coords[0];
    var lng = coords[1];

    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }

    $("#mapTitle").html('<i class="fas fa-warehouse me-2"></i>' + escapeHtml(namaRpu));
    $("#mapInfo").html(
        '<div class="row">' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-warehouse me-1"></i> RPU:</span> ' + escapeHtml(namaRpu) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Kecamatan:</span> ' + escapeHtml(kecamatan) + '<br>' +
        '<span class="fw-bold"><i class="fas fa-building me-1"></i> Kelurahan:</span> ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="col-md-6"><span class="fw-bold"><i class="fas fa-map-pin me-1"></i> Koordinat:</span> <span class="coord-badge">' + coordinates + '</span><br>' +
        '<span class="fw-bold"><i class="fas fa-phone-alt me-1"></i> Telepon:</span> ' + (telp || '-') + '<br>' +
        '<span class="fw-bold"><i class="fas fa-chicken me-1"></i> Potongan:</span> ' + totalEkor + ' ekor (' + totalBerat + ' kg)</div>' +
        '</div>'
    );

    $("#clinicInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-warehouse me-2"></i>Nama RPU:</span><br><span class="text-primary fw-bold fs-5">' + escapeHtml(namaRpu) + '</span></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-map-marker-alt me-2"></i>Kecamatan/Kelurahan:</span><br>' + escapeHtml(kecamatan) + ' - ' + escapeHtml(kelurahan) + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-location-dot me-2"></i>Alamat:</span><br>' + escapeHtml(alamat || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-phone-alt me-2"></i>Kontak:</span><br>' + (telp || '-') + '</div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-chicken me-2"></i>Total Potong:</span><br><span class="badge-ekor">' + totalEkor + ' ekor</span> <span class="badge-berat">' + totalBerat + ' kg</span></div>'
    );

    $("#coordInfo").html(
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-up me-2"></i>Latitude:</span><br><code class="bg-light p-1 rounded">' + lat.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-arrow-right me-2"></i>Longitude:</span><br><code class="bg-light p-1 rounded">' + lng.toFixed(6) + '</code></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-globe me-2"></i>Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>' +
        '<div class="mb-2"><span class="fw-bold"><i class="fas fa-satellite me-2"></i>Akurasi:</span><br><small>GPS ± 5 meter</small></div>'
    );

    $.ajax({
        url: base_url + 'index.php/data_rpu/detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data.komoditas) {
                var komoditasHtml = '<div class="row">';
                for (var i = 0; i < response.data.komoditas.length; i++) {
                    var k = response.data.komoditas[i];
                    komoditasHtml += '<div class="col-md-4 col-sm-6 mb-2"><div class="komoditas-card p-2 text-center"><i class="fas fa-paw me-1"></i> <strong>' + escapeHtml(k.komoditas) + '</strong><br><small>' + k.jumlah_ekor + ' ekor (' + parseFloat(k.berat_kg).toFixed(2) + ' kg)</small><br><span class="badge-asal">' + escapeHtml(k.asal_unggas || '-') + '</span></div></div>';
                }
                komoditasHtml += '</div>';
                $("#komoditasMapInfo").html(komoditasHtml);
            } else {
                $("#komoditasMapInfo").html('<p class="text-muted text-center">Tidak ada data komoditas</p>');
            }
        }
    });

    if (!map) {
        $("#mapContainer").css("height", "500px");
        setTimeout(function() {
            map = L.map("mapContainer").setView([lat, lng], 15);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { attribution: '&copy; OpenStreetMap' }).addTo(map);
            var rpuIcon = L.divIcon({ html: '<div style="background-color:#832706;width:32px;height:32px;border-radius:50%;border:3px solid white;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;"><i class="fas fa-warehouse"></i></div>', iconSize: [32, 32], iconAnchor: [16, 16] });
            currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
            currentRpuMarker.bindPopup('<div style="min-width:250px;"><h6 style="color:#832706;">' + escapeHtml(namaRpu) + '</h6><hr><strong>Alamat:</strong> ' + escapeHtml(alamat) + '<br><strong>Telepon:</strong> ' + (telp || '-') + '<br><strong>Potongan:</strong> ' + totalEkor + ' ekor (' + totalBerat + ' kg)</div>').openPopup();
            L.circle([lat, lng], { color: "#832706", fillOpacity: 0.1, radius: 300 }).addTo(map);
            setTimeout(function() { map.invalidateSize(); }, 100);
        }, 100);
    } else {
        map.setView([lat, lng], 15);
        if (currentRpuMarker) map.removeLayer(currentRpuMarker);
        var rpuIcon = L.divIcon({ html: '<div style="background-color:#832706;width:32px;height:32px;border-radius:50%;border:3px solid white;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;"><i class="fas fa-warehouse"></i></div>', iconSize: [32, 32], iconAnchor: [16, 16] });
        currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
        currentRpuMarker.bindPopup('<div style="min-width:250px;"><h6>' + escapeHtml(namaRpu) + '</h6><hr><strong>Alamat:</strong> ' + escapeHtml(alamat) + '<br><strong>Telepon:</strong> ' + (telp || '-') + '<br><strong>Potongan:</strong> ' + totalEkor + ' ekor (' + totalBerat + ' kg)</div>').openPopup();
        L.circle([lat, lng], { color: "#832706", fillOpacity: 0.1, radius: 300 }).addTo(map);
        setTimeout(function() { map.invalidateSize(); }, 50);
    }
    $("#mapSection").show();
    $("html, body").animate({ scrollTop: $("#mapSection").offset().top - 20 }, 500);
}

function updateMapView() {
    if (!map) return;
    map.eachLayer(function(layer) { if (layer instanceof L.TileLayer) map.removeLayer(layer); });
    if (currentView === "map") {
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { attribution: '&copy; OpenStreetMap', maxZoom: 19 }).addTo(map);
    } else {
        L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", { attribution: "Tiles &copy; Esri", maxZoom: 19 }).addTo(map);
    }
    setTimeout(function() { map.invalidateSize(); }, 50);
}

function closeMap() {
    $("#mapSection").hide();
    if (map) { map.remove(); map = null; }
}

// ================ FORM EDIT SUBMIT ================
$(document).on('submit', '#formEdit', function(e) {
    e.preventDefault();
    var id = $('#edit_id').val();
    var formData = $(this).serialize();
    
    $("#editModal .btn-primary-custom").prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
    
    $.ajax({
        url: base_url + 'index.php/data_rpu/update/' + id,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            $("#editModal .btn-primary-custom").prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
            if (response.status === 'success') {
                $("#editModal").modal('hide');
                alert('Data berhasil diupdate');
                loadDataFromServer();
            }
        },
        error: function() {
            $("#editModal .btn-primary-custom").prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
        }
    });
});

// ================ DOCUMENT READY ================
$(document).ready(function() {
    console.log('Document ready, loading data...');
    loadDataFromServer();

    $("#filterBtn").on('click', function(e) { 
        e.preventDefault(); 
        filterData(); 
    });
    
    $("#resetBtn").on('click', function(e) { 
        e.preventDefault(); 
        resetFilter(); 
    });
    
    $("#closeMapBtn").on('click', closeMap);
    
    $("#btnMapView").on('click', function() { 
        currentView = "map"; 
        updateMapView(); 
        $(this).addClass("active"); 
        $("#btnSatelliteView").removeClass("active"); 
    });
    
    $("#btnSatelliteView").on('click', function() { 
        currentView = "satellite"; 
        updateMapView(); 
        $(this).addClass("active"); 
        $("#btnMapView").removeClass("active"); 
    });
    
    $("#btnResetView").on('click', function() { 
        if (map && currentRpuMarker) { 
            map.setView(currentRpuMarker.getLatLng(), 15); 
        } 
    });
});