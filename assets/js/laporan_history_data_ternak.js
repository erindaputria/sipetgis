/**
 * Laporan History Data Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#historyTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel', 
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('excel');
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ],
        ordering: false,
        searching: true,
        paging: true,
        pageLength: 15,
        lengthMenu: [10, 15, 25, 50, 100],
        info: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            zeroRecords: "Tidak ada data ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        }
    });
    
    // Load semua data saat halaman pertama kali dibuka
    loadAllData();
    
    // Tombol Filter - TIDAK WAJIB ADA TAHUN DAN BULAN
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.bulan = $("#filterBulan").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        
        loadDataWithFilter();
    });
    
    // Tombol Reset
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterBulan").val('');
        $("#filterKecamatan").val('semua');
        
        currentData = {
            tahun: '',
            bulan: '',
            kecamatan: 'semua'
        };
        
        loadAllData();
    });
    
    // Tombol Refresh
    $("#refreshBtn").click(function() {
        if(currentData.tahun || currentData.bulan || (currentData.kecamatan && currentData.kecamatan !== 'semua')) {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    bulan: '',
    kecamatan: 'semua'
};

var bulanNama = {
    '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
    '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
    '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
};

// ================ FUNGSI EXPORT EXCEL ================
function exportWithParams(format) {
    var tahun = $("#filterTahun").val();
    var bulan = $("#filterBulan").val();
    var kecamatan = $("#filterKecamatan").val();
    
    var url = base_url + 'laporan_history_data_ternak/export_excel';
    url += "?tahun=" + (tahun || '');
    url += "&bulan=" + (bulan || '');
    url += "&kecamatan=" + (kecamatan || 'semua');
    
    window.location.href = url;
}

// ================ FUNGSI PRINT ================
function printWithCurrentData() {
    var tahun = $("#filterTahun").val();
    var bulan = $("#filterBulan").val();
    var kecamatan = $("#filterKecamatan").val();
    var bulanText = (bulan && bulan !== '') ? bulanNama[bulan] : 'Semua Bulan';
    var tahunText = (tahun && tahun !== '') ? tahun : 'Semua Tahun';
    var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
    var periodeText = (tahun && tahun !== '') ? bulanText + ' ' + tahun : 'Semua Periode';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan History Data Ternak</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #832706; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.peternak-link { color: black !important; text-decoration: none !important; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('historyTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN HISTORY DATA TERNAK</h2>');
    printWindow.document.write('<p>Kota Surabaya - ' + kecamatanText + '</p>');
    printWindow.document.write('<p>' + periodeText + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// ================ LOAD SEMUA DATA (TANPA FILTER) ================
function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_ternak/get_all_data',
        type: "POST",
        data: {},
        dataType: "json",
        success: function(response) {
            displayData(response, 'Semua Periode', 'Seluruh Kecamatan');
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

// ================ LOAD DATA DENGAN FILTER ================
function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var bulan = currentData.bulan;
    var kecamatan = currentData.kecamatan;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_ternak/get_data',
        type: "POST",
        data: {
            tahun: tahun || '',
            bulan: bulan || '',
            kecamatan: kecamatan || 'semua'
        },
        dataType: "json",
        success: function(response) {
            var bulanText = (bulan && bulan !== '') ? bulanNama[bulan] : 'Semua Bulan';
            var tahunText = (tahun && tahun !== '') ? tahun : 'Semua Tahun';
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            var periodeText = (tahun && tahun !== '') ? bulanText + ' ' + tahun : 'Semua Periode';
            
            displayData(response, periodeText, kecamatanText);
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

// ================ DISPLAY DATA KE TABEL ================
function displayData(response, periodeText, kecamatanText) {
    dataTable.clear().draw();
    
    $('#reportTitle').html('LAPORAN HISTORY DATA TERNAK');
    $('#reportSubtitle').html('Kota Surabaya - ' + kecamatanText + '<br>' + periodeText);
    
    if(response.data && response.data.length > 0) {
        var flattenedData = [];
        
        $.each(response.data, function(index, peternak) {
            var hewanList = [
                { nama: 'Sapi Potong', jantan: peternak.sapi_potong_jantan, betina: peternak.sapi_potong_betina },
                { nama: 'Sapi Perah', jantan: peternak.sapi_perah_jantan, betina: peternak.sapi_perah_betina },
                { nama: 'Kambing', jantan: peternak.kambing_jantan, betina: peternak.kambing_betina },
                { nama: 'Domba', jantan: peternak.domba_jantan, betina: peternak.domba_betina },
                { nama: 'Kerbau', jantan: peternak.kerbau_jantan, betina: peternak.kerbau_betina },
                { nama: 'Kuda', jantan: peternak.kuda_jantan, betina: peternak.kuda_betina },
                { nama: 'Ayam Buras', jantan: 0, betina: 0, total: peternak.ayam_buras || 0 },
                { nama: 'Ayam Broiler', jantan: 0, betina: 0, total: peternak.ayam_broiler || 0 },
                { nama: 'Ayam Layer', jantan: 0, betina: 0, total: peternak.ayam_layer || 0 },
                { nama: 'Itik', jantan: 0, betina: 0, total: peternak.itik || 0 },
                { nama: 'Angsa', jantan: 0, betina: 0, total: peternak.angsa || 0 },
                { nama: 'Kalkun', jantan: 0, betina: 0, total: peternak.kalkun || 0 },
                { nama: 'Burung', jantan: 0, betina: 0, total: peternak.burung || 0 }
            ];
            
            var activeHewan = hewanList.filter(function(hewan) {
                if(hewan.hasOwnProperty('total')) {
                    return hewan.total > 0;
                } else {
                    return (hewan.jantan > 0 || hewan.betina > 0);
                }
            });
            
            if(activeHewan.length === 0) {
                activeHewan = [{ nama: '-', jantan: 0, betina: 0, total: 0 }];
            }
            
            $.each(activeHewan, function(hewanIndex, hewan) {
                var tanggal = peternak.tanggal_input ? new Date(peternak.tanggal_input).toLocaleDateString('id-ID') : '-';
                var totalHewan = hewan.hasOwnProperty('total') ? hewan.total : (hewan.jantan + hewan.betina);
                var detailUrl = base_url + 'laporan_history_data_ternak/detail_peternak/' + encodeURIComponent(peternak.nik);
                var namaLink = '<a href="'+ detailUrl +'" class="peternak-link" target="_blank">' + (peternak.nama_peternak || '-') + '</a>';
                
                flattenedData.push({
                    tanggal: tanggal,
                    nik: peternak.nik,
                    nama_peternak: namaLink,
                    alamat: peternak.alamat || '-',
                    kecamatan: peternak.kecamatan || '-',
                    kelurahan: peternak.kelurahan || '-',
                    jenis_hewan: hewan.nama,
                    jantan: hewan.hasOwnProperty('total') ? 0 : (hewan.jantan || 0),
                    betina: hewan.hasOwnProperty('total') ? 0 : (hewan.betina || 0),
                    total: totalHewan
                });
            });
        });
        
        $.each(flattenedData, function(index, item) {
            dataTable.row.add([
                (index + 1),
                item.tanggal,
                item.nik || '-',
                item.nama_peternak,
                item.alamat,
                item.kecamatan,
                item.kelurahan,
                item.jenis_hewan,
                formatNumber(item.jantan),
                formatNumber(item.betina),
                formatNumber(item.total)
            ]).draw(false);
        });
    } else {
        dataTable.row.add([
            '1', '-', '-', 'Tidak ada data', '-', '-', '-', '-', '0', '0', '0'
        ]).draw(false);
    }
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}