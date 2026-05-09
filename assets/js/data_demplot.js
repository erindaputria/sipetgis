// ================ BASE URL ================
var base_url = window.base_url || "";

// ================ VARIABLES ================
let map = null;
let mapMarkers = [];
let currentView = "map";
let currentDemplotMarker = null;
let dataTable = null;
let deleteId = null;
let allData = [];

// ================ FUNGSI AMBIL DATA DARI SERVER ================
function loadDataFromServer() {
    $("#demplotTable tbody").html('<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><br>Memuat data...<\/td><\/tr>');

    $.ajax({
        url: base_url + 'index.php/Data_demplot/get_data',
        type: 'GET',
        dataType: 'json',
        timeout: 30000,
        success: function(response) {
            if (response && response.length > 0) {
                allData = response;
                console.log('Total data dimuat:', allData.length);
            } else {
                allData = [];
                console.log('Tidak ada data dari server');
            }
            renderTable(allData);
            updateFilterOptions();
            loadStatistik();
        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
            console.error('Status:', xhr.status);
            allData = [];
            renderTable(allData);
            alert('Gagal memuat data. Error: ' + error);
        }
    });
}

// ================ UPDATE FILTER OPTIONS ================
function updateFilterOptions() {
    var kecamatanSet = new Set();
    var jenisHewanSet = new Set();
    var kelurahanSet = new Set();

    allData.forEach(function(item) {
        if (item.kecamatan && item.kecamatan !== '') {
            kecamatanSet.add(item.kecamatan);
        }
        if (item.jenis_hewan && item.jenis_hewan !== '') {
            jenisHewanSet.add(item.jenis_hewan);
        }
        if (item.kelurahan && item.kelurahan !== '') {
            kelurahanSet.add(item.kelurahan);
        }
    });

    var kecamatanOptions = '<option selected value="all">Semua Kecamatan</option>';
    var sortedKecamatan = Array.from(kecamatanSet).sort();
    sortedKecamatan.forEach(function(kecamatan) {
        kecamatanOptions += '<option value="' + escapeHtml(kecamatan) + '">' + escapeHtml(kecamatan) + '</option>';
    });
    $("#filterKecamatan").html(kecamatanOptions);

    var jenisHewanOptions = '<option selected value="all">Semua Jenis Hewan</option>';
    var sortedJenisHewan = Array.from(jenisHewanSet).sort();
    sortedJenisHewan.forEach(function(jenis) {
        jenisHewanOptions += '<option value="' + escapeHtml(jenis) + '">' + escapeHtml(jenis) + '</option>';
    });
    $("#filterJenisHewan").html(jenisHewanOptions);

    var kelurahanOptions = '<option selected value="all">Semua Kelurahan</option>';
    var sortedKelurahan = Array.from(kelurahanSet).sort();
    sortedKelurahan.forEach(function(kelurahan) {
        kelurahanOptions += '<option value="' + escapeHtml(kelurahan) + '">' + escapeHtml(kelurahan) + '</option>';
    });
    $("#filterKelurahan").html(kelurahanOptions);

    console.log('Filter options updated');
}

// ================ RENDER TABLE ================
function renderTable(data) {
    console.log('Rendering table with', data.length, 'rows');
    
    if (dataTable) {
        try {
            dataTable.destroy();
        } catch(e) {}
        dataTable = null;
    }
    
    $("#demplotTable tbody").empty();
    
    if (!data || data.length === 0) {
        $("#demplotTable tbody").html('<tr><td colspan="11" class="text-center py-5"><i class="fas fa-store fa-3x text-muted mb-3 d-block"></i>Tidak ada data demplot<\/td><\/tr>');
        
        dataTable = $("#demplotTable").DataTable({
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6,7,8] } },
                { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }, action: function(e, dt, button, config) { printWithCurrentData(); } }
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
            columnDefs: [{ orderable: false, targets: [9, 10] }],
            order: [[0, 'asc']]
        });
        return;
    }
    
    var html = "";
    for (var idx = 0; idx < data.length; idx++) {
        var item = data[idx];
        var no = idx + 1;
        
        var safeNama = escapeHtml(String(item.nama_demplot || '-'));
        var safeAlamat = escapeHtml(String(item.alamat || '-'));
        var safeKecamatan = escapeHtml(String(item.kecamatan || '-'));
        var safeKelurahan = escapeHtml(String(item.kelurahan || '-'));
        var safeJenisHewan = escapeHtml(String(item.jenis_hewan || '-'));
        var safeStokPakan = escapeHtml(String(item.stok_pakan || '-'));
        
        var luas = parseFloat(item.luas_m2 || 0).toFixed(2);
        var jumlahHewan = item.jumlah_hewan || 0;
        
        var fotoPath = item.foto_demplot;
        var fotoLink = (fotoPath && fotoPath != '') ? 
            '<img src="' + base_url + 'uploads/demplot/' + escapeHtml(fotoPath) + '" alt="Foto" class="photo-thumbnail" onclick="showFotoPreview(this.src)" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;">' : 
            '<span class="text-muted">-</span>';
        
        html += '<tr>' +
            '<td class="text-center" style="width: 40px;">' + no + '</td>' +
            '<td style="min-width: 180px;"><span class="fw-bold">' + safeNama + '</span><br><small class="text-muted">Petugas: ' + escapeHtml(String(item.nama_petugas || '-')) + '</small></td>' +
            '<td style="min-width: 160px;">' + safeAlamat + '</td>' +
            '<td style="min-width: 140px;">' + safeKecamatan + '</td>' +
            '<td style="min-width: 140px;">' + safeKelurahan + '</td>' +
            '<td class="text-center" style="min-width: 100px;"><span class="badge-luas">' + luas + '</span> m²</span></td>' +
            '<td class="text-center" style="min-width: 120px;"><span class="badge-hewan">' + safeJenisHewan + '</span></td>' +
            '<td class="text-center" style="min-width: 100px;"><span class="badge-hewan">' + jumlahHewan + '</span> ekor</span></td>' +
            '<td style="min-width: 140px;"><span class="badge-pakan">' + safeStokPakan + '</span></td>' +
            '<td class="text-center">' + fotoLink + '</td>' +
            '<td class="text-center">' +
            '<div class="btn-action-group">' +
            '<button class="btn btn-action btn-edit" onclick="editData(' + item.id_demplot + ')" title="Edit"><i class="fas fa-edit"></i></button>' +
            '<button class="btn btn-action btn-delete" onclick="deleteData(' + item.id_demplot + ', \'' + escapeForAttribute(safeNama) + '\')" title="Hapus"><i class="fas fa-trash"></i></button>' +
            '</div>' +
            '</td>' +
            '</tr>';
    }
    
    $("#demplotTable tbody").html(html);
    
    dataTable = $("#demplotTable").DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3,4,5,6,7,8] } },
            { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }, action: function(e, dt, button, config) { printWithCurrentData(); } }
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
        columnDefs: [{ orderable: false, targets: [9, 10] }],
        order: [[0, 'asc']]
    });
    
    console.log('Table rendered successfully');
}

// ================ FUNCTION ESCAPE ================
function escapeForAttribute(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/'/g, "\\'")
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
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

// ================ FUNCTION FILTER ================
function filterData() {
    console.log('=== FILTER DATA DITEKAN ===');
    var kecamatan = $("#filterKecamatan").val();
    var jenisHewan = $("#filterJenisHewan").val();
    var kelurahan = $("#filterKelurahan").val();
    var minLuas = $("#minLuas").val();
    var maxLuas = $("#maxLuas").val();

    console.log('Filter values - Kecamatan:', kecamatan, 'Jenis Hewan:', jenisHewan, 'Kelurahan:', kelurahan, 'Luas:', minLuas, '-', maxLuas);

    if (dataTable) {
        try { dataTable.destroy(); } catch(e) {}
        dataTable = null;
    }

    var filteredData = [];

    for (var i = 0; i < allData.length; i++) {
        var item = allData[i];
        var matchKecamatan = true;
        var matchJenisHewan = true;
        var matchKelurahan = true;
        var matchLuas = true;

        if (kecamatan !== "all") {
            matchKecamatan = (item.kecamatan && item.kecamatan === kecamatan);
        }

        if (jenisHewan !== "all") {
            matchJenisHewan = (item.jenis_hewan && item.jenis_hewan === jenisHewan);
        }

        if (kelurahan !== "all") {
            matchKelurahan = (item.kelurahan && item.kelurahan === kelurahan);
        }

        var luasItem = parseFloat(item.luas_m2 || 0);
        if (minLuas && !isNaN(parseFloat(minLuas))) {
            matchLuas = matchLuas && luasItem >= parseFloat(minLuas);
        }
        if (maxLuas && !isNaN(parseFloat(maxLuas))) {
            matchLuas = matchLuas && luasItem <= parseFloat(maxLuas);
        }

        if (matchKecamatan && matchJenisHewan && matchKelurahan && matchLuas) {
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

    $("#filterKecamatan").val("all");
    $("#filterJenisHewan").val("all");
    $("#filterKelurahan").val("all");
    $("#minLuas").val("");
    $("#maxLuas").val("");
    
    if (dataTable) {
        try { dataTable.destroy(); } catch(e) {}
        dataTable = null;
    }
    
    renderTable(allData);
    
    console.log('Reset selesai, menampilkan semua', allData.length, 'data');
}

// ================ FUNCTION PRINT ================
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var table = $('#demplotTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    var totalHewan = 0;
    var totalLuas = 0;
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        
        var hewanText = stripHtml(row[7] || '0');
        var hewanMatch = hewanText.match(/(\d+)/);
        if (hewanMatch) {
            totalHewan += parseInt(hewanMatch[0]) || 0;
        }
        
        var luasText = stripHtml(row[5] || '0');
        var luasMatch = luasText.match(/([\d,]+\.?\d*)/);
        if (luasMatch) {
            totalLuas += parseFloat(luasMatch[0].replace(/,/g, '')) || 0;
        }
    }
    
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
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA DEMPLOT</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
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
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var luasText = stripHtml(row[5] || '0');
        var luasMatch = luasText.match(/([\d,]+\.?\d*)/);
        var luas = luasMatch ? luasMatch[0] : '0';
        
        var hewanText = stripHtml(row[7] || '0');
        var hewanMatch = hewanText.match(/(\d+)/);
        var hewan = hewanMatch ? hewanMatch[0] : '0';
        
        var jenisHewan = stripHtml(row[6] || '-');
        var stokPakan = stripHtml(row[8] || '-');
        
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[4] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + parseFloat(luas).toFixed(2) + ' m²' + '</td>');
        printWindow.document.write('<td align="left">' + jenisHewan + '</td>');
        printWindow.document.write('<td align="center">' + hewan + ' Ekor' + '</td>');
        printWindow.document.write('<td align="left">' + stokPakan + '</td>');
        printWindow.document.write('</td>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="5" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalLuas) + ' m²</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalHewan) + ' Ekor</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Demplot</strong></td>');
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

// ================ SHOW FOTO PREVIEW ================
function showFotoPreview(src) {
    $('#modalFoto').attr('src', src);
    $('#fotoModal').modal('show');
}

// ================ EDIT DATA (FINAL FIX - NO ID VALIDATION) ================
function editData(id) {
    console.log('Edit data ID:', id);
    
    $('#editModal').modal('show');
    $('#editModal .modal-body').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div><br>Memuat data...</div>');
    $('#editModal .modal-footer').html(`
        <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
        <button type="button" class="btn btn-primary-custom btn-sm" id="saveEditBtn" disabled><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
    `);
    
    $.ajax({
        url: base_url + 'index.php/Data_demplot/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            if (response && response.status === 'success' && response.data) {
                var d = response.data;
                
                var formHtml = `
                    <form id="formEdit">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Demplot <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama" name="nama_demplot" value="${escapeHtml(String(d.nama_demplot || ''))}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_alamat" name="alamat" value="${escapeHtml(String(d.alamat || ''))}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_kecamatan" name="kecamatan" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <option value="Asemrowo" ${d.kecamatan == 'Asemrowo' ? 'selected' : ''}>Asemrowo</option>
                                    <option value="Benowo" ${d.kecamatan == 'Benowo' ? 'selected' : ''}>Benowo</option>
                                    <option value="Bubutan" ${d.kecamatan == 'Bubutan' ? 'selected' : ''}>Bubutan</option>
                                    <option value="Bulak" ${d.kecamatan == 'Bulak' ? 'selected' : ''}>Bulak</option>
                                    <option value="Dukuh Pakis" ${d.kecamatan == 'Dukuh Pakis' ? 'selected' : ''}>Dukuh Pakis</option>
                                    <option value="Gayungan" ${d.kecamatan == 'Gayungan' ? 'selected' : ''}>Gayungan</option>
                                    <option value="Genteng" ${d.kecamatan == 'Genteng' ? 'selected' : ''}>Genteng</option>
                                    <option value="Gubeng" ${d.kecamatan == 'Gubeng' ? 'selected' : ''}>Gubeng</option>
                                    <option value="Gunung Anyar" ${d.kecamatan == 'Gunung Anyar' ? 'selected' : ''}>Gunung Anyar</option>
                                    <option value="Jambangan" ${d.kecamatan == 'Jambangan' ? 'selected' : ''}>Jambangan</option>
                                    <option value="Karang Pilang" ${d.kecamatan == 'Karang Pilang' ? 'selected' : ''}>Karang Pilang</option>
                                    <option value="Kenjeran" ${d.kecamatan == 'Kenjeran' ? 'selected' : ''}>Kenjeran</option>
                                    <option value="Krembangan" ${d.kecamatan == 'Krembangan' ? 'selected' : ''}>Krembangan</option>
                                    <option value="Lakarsantri" ${d.kecamatan == 'Lakarsantri' ? 'selected' : ''}>Lakarsantri</option>
                                    <option value="Mulyorejo" ${d.kecamatan == 'Mulyorejo' ? 'selected' : ''}>Mulyorejo</option>
                                    <option value="Pabean Cantian" ${d.kecamatan == 'Pabean Cantian' ? 'selected' : ''}>Pabean Cantian</option>
                                    <option value="Pakal" ${d.kecamatan == 'Pakal' ? 'selected' : ''}>Pakal</option>
                                    <option value="Rungkut" ${d.kecamatan == 'Rungkut' ? 'selected' : ''}>Rungkut</option>
                                    <option value="Sambikerep" ${d.kecamatan == 'Sambikerep' ? 'selected' : ''}>Sambikerep</option>
                                    <option value="Sawahan" ${d.kecamatan == 'Sawahan' ? 'selected' : ''}>Sawahan</option>
                                    <option value="Semampir" ${d.kecamatan == 'Semampir' ? 'selected' : ''}>Semampir</option>
                                    <option value="Simokerto" ${d.kecamatan == 'Simokerto' ? 'selected' : ''}>Simokerto</option>
                                    <option value="Sukolilo" ${d.kecamatan == 'Sukolilo' ? 'selected' : ''}>Sukolilo</option>
                                    <option value="Sukomanunggal" ${d.kecamatan == 'Sukomanunggal' ? 'selected' : ''}>Sukomanunggal</option>
                                    <option value="Tambaksari" ${d.kecamatan == 'Tambaksari' ? 'selected' : ''}>Tambaksari</option>
                                    <option value="Tandes" ${d.kecamatan == 'Tandes' ? 'selected' : ''}>Tandes</option>
                                    <option value="Tegalsari" ${d.kecamatan == 'Tegalsari' ? 'selected' : ''}>Tegalsari</option>
                                    <option value="Tenggilis Mejoyo" ${d.kecamatan == 'Tenggilis Mejoyo' ? 'selected' : ''}>Tenggilis Mejoyo</option>
                                    <option value="Wiyung" ${d.kecamatan == 'Wiyung' ? 'selected' : ''}>Wiyung</option>
                                    <option value="Wonocolo" ${d.kecamatan == 'Wonocolo' ? 'selected' : ''}>Wonocolo</option>
                                    <option value="Wonokromo" ${d.kecamatan == 'Wonokromo' ? 'selected' : ''}>Wonokromo</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kelurahan" name="kelurahan" value="${escapeHtml(String(d.kelurahan || ''))}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="edit_latitude" name="latitude" value="${escapeHtml(String(d.latitude || ''))}" placeholder="-7.2574719">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="edit_longitude" name="longitude" value="${escapeHtml(String(d.longitude || ''))}" placeholder="112.7520883">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Luas (m²)</label>
                                <input type="number" class="form-control" id="edit_luas" name="luas_m2" value="${d.luas_m2 || 0}" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Hewan</label>
                                <input type="text" class="form-control" id="edit_jenis_hewan" name="jenis_hewan" value="${escapeHtml(String(d.jenis_hewan || ''))}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Hewan</label>
                                <input type="number" class="form-control" id="edit_jumlah_hewan" name="jumlah_hewan" value="${d.jumlah_hewan || 0}" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok Pakan</label>
                                <input type="text" class="form-control" id="edit_stok_pakan" name="stok_pakan" value="${escapeHtml(String(d.stok_pakan || ''))}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Petugas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_petugas" name="nama_petugas" value="${escapeHtml(String(d.nama_petugas || ''))}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="2">${escapeHtml(String(d.keterangan || ''))}</textarea>
                            </div>
                        </div>
                    </form>
                `;
                
                $('#editModal .modal-body').html(formHtml);
                $('#editModal .modal-footer').html(`
                    <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                    <button type="button" class="btn btn-primary-custom btn-sm" id="saveEditBtn"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                `);
                
                // Tombol simpan - LANGSUNG PAKAI ID DARI PARAMETER
                $('#saveEditBtn').off('click').on('click', function() {
                    var formData = {
                        id_demplot: id,  // LANGSUNG PAKAI ID PARAMETER, BUKAN DARI FORM
                        nama_demplot: $('#edit_nama').val(),
                        alamat: $('#edit_alamat').val(),
                        kecamatan: $('#edit_kecamatan').val(),
                        kelurahan: $('#edit_kelurahan').val(),
                        luas_m2: $('#edit_luas').val(),
                        jenis_hewan: $('#edit_jenis_hewan').val(),
                        jumlah_hewan: $('#edit_jumlah_hewan').val(),
                        stok_pakan: $('#edit_stok_pakan').val(),
                        nama_petugas: $('#edit_petugas').val(),
                        latitude: $('#edit_latitude').val(),
                        longitude: $('#edit_longitude').val(),
                        keterangan: $('#edit_keterangan').val()
                    };
                    
                    $('#saveEditBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                    
                    $.ajax({
                        url: base_url + 'index.php/Data_demplot/update',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        timeout: 15000,
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#editModal').modal('hide');
                                alert('Data berhasil diupdate');
                                loadDataFromServer();
                            } else {
                                alert(response.message || 'Gagal update data');
                                $('#saveEditBtn').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Gagal menyimpan perubahan: ' + error);
                            $('#saveEditBtn').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan Perubahan');
                        }
                    });
                });
                
            } else {
                $('#editModal .modal-body').html('<div class="alert alert-danger">Data tidak ditemukan</div>');
                $('#saveEditBtn').prop('disabled', true);
            }
        },
        error: function(xhr, status, error) {
            $('#editModal .modal-body').html('<div class="alert alert-danger">Gagal memuat data. Error: ' + error + '</div>');
            $('#saveEditBtn').prop('disabled', true);
        }
    });
}

// ================ DELETE DATA ================
function deleteData(id, namaDemplot) {
    if (confirm("Apakah Anda yakin ingin menghapus data demplot: " + namaDemplot + "?")) {
        window.location.href = base_url + "index.php/Data_demplot/hapus/" + id;
    }
}

// ================ SHOW DETAIL ================
function showDetail(id) {
    $.ajax({
        url: base_url + 'index.php/Data_demplot/get_detail/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.status === 'success' && response.data) {
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
                    '<tr><td width="35%"><strong>Nama Demplot</strong></td><td width="5%">:</td><td>' + escapeHtml(data.nama_demplot) + '</span></td></tr>' +
                    '<tr><td><strong>Alamat</strong></td><td>:</td><td>' + escapeHtml(data.alamat || '-') + '</td>' +
                    '</tr><tr><td><strong>Kecamatan</strong></td><td>:</td><td>' + escapeHtml(data.kecamatan) + '</td>' +
                    '</tr><tr><td><strong>Kelurahan</strong></td><td>:</td><td>' + escapeHtml(data.kelurahan) + '</td>' +
                    '</tr><tr><td><strong>Nama Petugas</strong></td><td>:</td><td>' + escapeHtml(data.nama_petugas) + '</td>' +
                    '</tr></table>'
                );

                $("#detailLokasiInfo").html(
                    '<div class="row"><div class="col-md-6">' +
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Alamat Lengkap</strong></td><td width="5%">:</td><td>' + escapeHtml(data.alamat || '-') + '</td></tr>' +
                    '<tr><td><strong>Kecamatan</strong></td><td>:</td><td>' + escapeHtml(data.kecamatan) + '</td></tr>' +
                    '<tr><td><strong>Kelurahan</strong></td><td>:</td><td>' + escapeHtml(data.kelurahan) + '</td></tr>' +
                    '</table></div>' +
                    '<div class="col-md-6">' +
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Latitude</strong></td><td width="5%">:</td><td><code>' + escapeHtml(data.latitude || '-') + '</code></td></tr>' +
                    '<tr><td><strong>Longitude</strong></td><td>:</td><td><code>' + escapeHtml(data.longitude || '-') + '</code></td></tr>' +
                    (data.latitude && data.longitude ? 
                    '<tr><td colspan="3"><button class="btn btn-sm btn-primary-custom mt-2" onclick="showMap(\'' + escapeHtml(data.nama_demplot) + '\', \'' + escapeHtml(data.alamat || '') + '\', \'' + escapeHtml(data.kecamatan) + '\', \'' + escapeHtml(data.kelurahan) + '\', \'' + data.latitude + ', ' + data.longitude + '\', \'' + escapeHtml(data.jenis_hewan || '') + '\', \'' + (data.jumlah_hewan || 0) + '\', \'' + parseFloat(data.luas_m2 || 0).toFixed(2) + '\', \'' + escapeHtml(data.stok_pakan || '') + '\', ' + data.id_demplot + ')"><i class="fas fa-map-marker-alt me-1"></i>Lihat di Peta</button></td></tr>' : '') +
                    '</table></div></div>'
                );

                $("#detailHewanInfo").html(
                    '<table class="table table-sm table-borderless">' +
                    '<tr><td width="35%"><strong>Jenis Hewan</strong></td><td width="5%">:</td><td>' + escapeHtml(data.jenis_hewan || '-') + '</td></tr>' +
                    '<tr><td><strong>Jumlah Hewan</strong></td><td>:</td><td>' + (data.jumlah_hewan || 0) + ' ekor</td></tr>' +
                    '<tr><td><strong>Luas Area</strong></td><td>:</td><td>' + parseFloat(data.luas_m2 || 0).toFixed(2) + ' m²</td></tr>' +
                    '<tr><td><strong>Stok Pakan</strong></td><td>:</td><td>' + escapeHtml(data.stok_pakan || '-') + '</td></tr>' +
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

// ================ SHOW MAP ================
function showMap(namaDemplot, alamat, kecamatan, kelurahan, coordinates, jenisHewan, jumlahHewan, luas, stokPakan, id) {
    var coords = coordinates.split(",").map(function(coord) { return parseFloat(coord.trim()); });
    var lat = coords[0];
    var lng = coords[1];

    if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
        alert("Koordinat tidak valid");
        return;
    }

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
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(map);
    } else {
        L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
            attribution: "Tiles &copy; Esri",
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

// ================ FUNCTION LOAD STATISTIK ================
function loadStatistik() {
    $.ajax({
        url: base_url + 'index.php/Data_demplot/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalDemplot').text(data.total_demplot || 0);
            $('#totalHewan').text(data.total_hewan || 0);
            $('#totalLuas').text((data.total_luas || 0).toFixed(2));
            $('#totalJenisHewan').text(data.total_jenis_hewan || 0);
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    console.log('Document ready, loading data...');
    loadDataFromServer();

    $("#filterBtn").off('click').on('click', function(e) {
        e.preventDefault();
        filterData();
    });

    $("#resetBtn").off('click').on('click', function(e) {
        e.preventDefault();
        resetFilter();
    });

    $("#closeDetailBtn").off('click').on('click', function() {
        $("#detailSection").hide();
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
        if (map && currentDemplotMarker) {
            var latlng = currentDemplotMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
        }
    });

    $("#confirmDelete").off('click').on('click', function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });
});