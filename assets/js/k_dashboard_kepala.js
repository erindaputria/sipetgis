// ================ FUNGSI PRINT UNTUK DASHBOARD KEPALA DINAS ================
// File ini berisi fungsi-fungsi print untuk mencetak tabel dengan rapi tanpa elemen yang tidak perlu

// Fungsi print untuk modal Pelaku Usaha (tabel sederhana)
function printPelakuUsahaTable() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel modal
    var tableRows = [];
    $('#modalDetailPelakuUsaha tbody tr').each(function() {
        var row = $(this);
        var no = row.find('td:eq(0)').text().trim();
        var kecamatan = row.find('td:eq(1)').text().trim();
        var pelakuUsaha = row.find('td:eq(2)').text().trim();
        tableRows.push({ no: no, kecamatan: kecamatan, pelakuUsaha: pelakuUsaha });
    });
    
    // Ambil total dari footer
    var totalPelaku = $('#modalDetailPelakuUsaha tfoot td:eq(1)').text().trim();
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<!DOCTYPE html>');
    printWindow.document.write('<html><head><title>Data Pelaku Usaha per Kecamatan</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('* { margin: 0; padding: 0; box-sizing: border-box; }');
    printWindow.document.write('body { font-family: "Times New Roman", Arial, sans-serif; margin: 20px; background: white; }');
    printWindow.document.write('.print-container { max-width: 100%; margin: 0 auto; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 25px; }');
    printWindow.document.write('.header h1 { margin: 0; color: #832706; font-size: 22px; letter-spacing: 1px; }');
    printWindow.document.write('.header h2 { margin: 8px 0 5px 0; color: #333; font-size: 16px; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #555; font-size: 14px; font-weight: normal; }');
    printWindow.document.write('.header hr { margin: 10px 0; border: 0.5px solid #832706; }');
    printWindow.document.write('.header p { margin: 8px 0 0 0; color: #666; font-size: 12px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px 10px; }');
    printWindow.document.write('th { background-color: #832706; color: white; text-align: center; font-weight: bold; }');
    printWindow.document.write('td { color: #000; }');
    printWindow.document.write('tbody tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9 !important; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }');
    printWindow.document.write('.text-center { text-align: center; }');
    printWindow.document.write('.text-left { text-align: left; }');
    printWindow.document.write('.text-right { text-align: right; }');
    printWindow.document.write('.fw-bold { font-weight: bold; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="print-container">');
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h1>PEMERINTAH KOTA SURABAYA</h1>');
    printWindow.document.write('<h2>DINAS KETAHANAN PANGAN DAN PERTANIAN</h2>');
    printWindow.document.write('<h3>SISTEM INFORMASI PETERNAKAN (SIPETGIS)</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<h3 style="margin: 20px 0 10px 0; color: #832706;">DATA PELAKU USAHA PER KECAMATAN</h3>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="10%" style="text-align: center;">No</th>');
    printWindow.document.write('<th width="60%" style="text-align: center;">Kecamatan</th>');
    printWindow.document.write('<th width="30%" style="text-align: center;">Pelaku Usaha (Peternak)</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableRows.length; i++) {
        printWindow.document.write('<tr>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].no + '</td>');
        printWindow.document.write('<td class="text-left">' + tableRows[i].kecamatan + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].pelakuUsaha + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="2" class="text-center fw-bold">TOTAL (31 Kecamatan)</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalPelaku + '</td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
    printWindow.document.write('Surabaya, ' + formattedDateTime);
    printWindow.document.write('</div>');
    
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Fungsi print untuk modal Semua Kecamatan (tabel lengkap 31 kecamatan)
function printSemuaKecamatanTable() {
    var printWindow = window.open('', '_blank');
    
    // Ambil data dari tabel modal semua kecamatan
    var tableRows = [];
    $('#modalSemuaKecamatan tbody tr').each(function() {
        var row = $(this);
        // Skip baris total (class table-active) untuk data rows
        if (!row.hasClass('table-active')) {
            var no = row.find('td:eq(0)').text().trim();
            var kecamatan = row.find('td:eq(1)').text().trim();
            var pelakuUsaha = row.find('td:eq(2)').text().trim();
            var jenisTernak = row.find('td:eq(3)').text().trim();
            var vaksinPmk = row.find('td:eq(4)').text().trim();
            var vaksinNdai = row.find('td:eq(5)').text().trim();
            var vaksinLsd = row.find('td:eq(6)').text().trim();
            var klinik = row.find('td:eq(7)').text().trim();
            var penjualObat = row.find('td:eq(8)').text().trim();
            var penjualPakan = row.find('td:eq(9)').text().trim();
            var rpuTpu = row.find('td:eq(10)').text().trim();
            
            tableRows.push({
                no: no, 
                kecamatan: kecamatan, 
                pelakuUsaha: pelakuUsaha,
                jenisTernak: jenisTernak, 
                vaksinPmk: vaksinPmk,
                vaksinNdai: vaksinNdai, 
                vaksinLsd: vaksinLsd,
                klinik: klinik, 
                penjualObat: penjualObat,
                penjualPakan: penjualPakan, 
                rpuTpu: rpuTpu
            });
        }
    });
    
    // Ambil total dari baris terakhir (table-active)
    var totalRow = $('#modalSemuaKecamatan tbody tr.table-active');
    var totalPelaku = totalRow.find('td:eq(2)').text().trim();
    var totalPmk = totalRow.find('td:eq(4)').text().trim();
    var totalNdai = totalRow.find('td:eq(5)').text().trim();
    var totalLsd = totalRow.find('td:eq(6)').text().trim();
    var totalKlinik = totalRow.find('td:eq(7)').text().trim();
    var totalObat = totalRow.find('td:eq(8)').text().trim();
    var totalPakan = totalRow.find('td:eq(9)').text().trim();
    var totalRpu = totalRow.find('td:eq(10)').text().trim();
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<!DOCTYPE html>');
    printWindow.document.write('<html><head><title>Data Seluruh Kecamatan Surabaya (31 Kecamatan)</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('* { margin: 0; padding: 0; box-sizing: border-box; }');
    printWindow.document.write('body { font-family: "Times New Roman", Arial, sans-serif; margin: 15px; background: white; font-size: 11px; }');
    printWindow.document.write('.print-container { max-width: 100%; margin: 0 auto; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h1 { margin: 0; color: #832706; font-size: 18px; letter-spacing: 1px; }');
    printWindow.document.write('.header h2 { margin: 5px 0; color: #333; font-size: 14px; }');
    printWindow.document.write('.header h3 { margin: 3px 0; color: #555; font-size: 12px; font-weight: normal; }');
    printWindow.document.write('.header hr { margin: 8px 0; border: 0.5px solid #832706; }');
    printWindow.document.write('.header p { margin: 5px 0 0 0; color: #666; font-size: 10px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 9px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 5px 4px; }');
    printWindow.document.write('th { background-color: #832706; color: white; text-align: center; font-weight: bold; }');
    printWindow.document.write('td { color: #000; }');
    printWindow.document.write('tbody tr:nth-child(even) { background-color: #f9f9f9; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9 !important; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 20px; font-size: 9px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 10px; }');
    printWindow.document.write('.text-center { text-align: center; }');
    printWindow.document.write('.text-left { text-align: left; }');
    printWindow.document.write('.text-right { text-align: right; }');
    printWindow.document.write('.fw-bold { font-weight: bold; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="print-container">');
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h1>PEMERINTAH KOTA SURABAYA</h1>');
    printWindow.document.write('<h2>DINAS KETAHANAN PANGAN DAN PERTANIAN</h2>');
    printWindow.document.write('<h3>SISTEM INFORMASI PETERNAKAN (SIPETGIS)</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<h3 style="margin: 15px 0 8px 0; color: #832706; font-size: 13px;">DATA SELURUH KECAMATAN DI SURABAYA (31 KECAMATAN)</h3>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="4%">No</th>');
    printWindow.document.write('<th width="12%">Kecamatan</th>');
    printWindow.document.write('<th width="8%">Pelaku Usaha</th>');
    printWindow.document.write('<th width="12%">Jenis Ternak</th>');
    printWindow.document.write('<th width="7%">Vaksinasi PMK</th>');
    printWindow.document.write('<th width="7%">Vaksinasi ND-AI</th>');
    printWindow.document.write('<th width="7%">Vaksinasi LSD</th>');
    printWindow.document.write('<th width="7%">Klinik Hewan</th>');
    printWindow.document.write('<th width="7%">Penjual Obat</th>');
    printWindow.document.write('<th width="7%">Penjual Pakan</th>');
    printWindow.document.write('<th width="7%">RPU/TPU</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableRows.length; i++) {
        printWindow.document.write('<tr>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].no + '</td>');
        printWindow.document.write('<td class="text-left">' + tableRows[i].kecamatan + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].pelakuUsaha + '</td>');
        printWindow.document.write('<td class="text-left">' + (tableRows[i].jenisTernak || '-') + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinPmk + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinNdai + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinLsd + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].klinik + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].penjualObat + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].penjualPakan + '</td>');
        printWindow.document.write('<td class="text-center">' + tableRows[i].rpuTpu + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="2" class="text-center fw-bold">TOTAL (31 Kecamatan)</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalPelaku + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">13 Jenis</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalPmk + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalNdai + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalLsd + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalKlinik + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalObat + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalPakan + '</td>');
    printWindow.document.write('<td class="text-center fw-bold">' + totalRpu + '</td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
    printWindow.document.write('Surabaya, ' + formattedDateTime);
    printWindow.document.write('</div>');
    
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Fungsi print untuk halaman utama dashboard (jika diperlukan)
function printDashboardMain() {
    var printWindow = window.open('', '_blank');
    
    // Clone konten utama yang ingin dicetak
    var mainContent = document.querySelector('.page-inner').cloneNode(true);
    
    // Hapus elemen-elemen yang tidak perlu dari clone
    var elementsToRemove = mainContent.querySelectorAll('.btn, .btn-action-group, .dt-buttons, .filter-section, .modal, .btn-link, .text-end .btn, .chart-container-wrapper .text-end .btn-link, .table-footer .btn-link, .nav-item, .topbar-user, .sidebar, .main-header');
    elementsToRemove.forEach(function(el) {
        if (el) el.remove();
    });
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<!DOCTYPE html>');
    printWindow.document.write('<html><head><title>Dashboard Kepala Dinas DKPP Surabaya</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('* { margin: 0; padding: 0; box-sizing: border-box; }');
    printWindow.document.write('body { font-family: "Times New Roman", Arial, sans-serif; margin: 20px; background: white; }');
    printWindow.document.write('.print-container { max-width: 100%; margin: 0 auto; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 25px; }');
    printWindow.document.write('.header h1 { margin: 0; color: #832706; font-size: 22px; }');
    printWindow.document.write('.header h2 { margin: 5px 0; color: #333; font-size: 16px; }');
    printWindow.document.write('.header h3 { margin: 3px 0; color: #555; font-size: 13px; font-weight: normal; }');
    printWindow.document.write('.header hr { margin: 10px 0; border: 0.5px solid #832706; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #666; font-size: 11px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 15px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 6px 8px; }');
    printWindow.document.write('th { background-color: #832706; color: white; text-align: center; }');
    printWindow.document.write('.footer-note { margin-top: 25px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 12px; }');
    printWindow.document.write('.stat-card, .card, .table-wrapper, .chart-container-wrapper { border: 1px solid #ddd; margin-bottom: 15px; border-radius: 5px; overflow: hidden; }');
    printWindow.document.write('.card-header { background: #f5f5f5; padding: 10px; border-bottom: 1px solid #ddd; }');
    printWindow.document.write('.card-body { padding: 10px; }');
    printWindow.document.write('.badge-ternak { display: inline-block; padding: 3px 10px; background: #eef2ff; color: #832706; border-radius: 15px; margin: 2px; font-size: 10px; }');
    printWindow.document.write('.text-center { text-align: center; }');
    printWindow.document.write('.fw-bold { font-weight: bold; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="print-container">');
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h1>PEMERINTAH KOTA SURABAYA</h1>');
    printWindow.document.write('<h2>DINAS KETAHANAN PANGAN DAN PERTANIAN</h2>');
    printWindow.document.write('<h3>SISTEM INFORMASI PETERNAKAN (SIPETGIS)</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<h3 style="margin: 15px 0 10px 0; color: #832706;">DASHBOARD KEPALA DINAS</h3>');
    
    // Tulis konten yang sudah di-clone
    printWindow.document.write(mainContent.innerHTML);
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
    printWindow.document.write('Surabaya, ' + formattedDateTime);
    printWindow.document.write('</div>');
    
    printWindow.document.write('</div>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Event listener untuk memastikan semua tombol print yang menggunakan class atau id tertentu berfungsi
$(document).ready(function() {
    // Override tombol cetak di modal detail pelaku usaha
    $('#modalDetailPelakuUsaha .btn-primary').off('click').on('click', function(e) {
        e.preventDefault();
        printPelakuUsahaTable();
    });
    
    // Override tombol cetak di modal semua kecamatan
    $('#modalSemuaKecamatan .btn-primary').off('click').on('click', function(e) {
        e.preventDefault();
        printSemuaKecamatanTable();
    });
    
    // Untuk tombol print lain yang mungkin ada di modal lain
    $('.modal .btn-primary').each(function() {
        var modalId = $(this).closest('.modal').attr('id');
        if (modalId && !$(this).hasClass('print-handled')) {
            $(this).addClass('print-handled');
            if (modalId === 'modalDetailPelakuUsaha') {
                $(this).off('click').on('click', function(e) {
                    e.preventDefault();
                    printPelakuUsahaTable();
                });
            } else if (modalId === 'modalSemuaKecamatan') {
                $(this).off('click').on('click', function(e) {
                    e.preventDefault();
                    printSemuaKecamatanTable();
                });
            }
        }
    });
});

// Fungsi tambahan untuk format number (jika belum ada)
function formatNumberPrint(num) {
    if (num === null || num === undefined) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}