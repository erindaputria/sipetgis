/**
 * Laporan Kepemilikan Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#kepemilikanTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('csv');
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('excel');
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                action: function(e, dt, button, config) {
                    exportWithParams('pdf');
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
        paging: false,
        info: false,
        language: {
            search: "Cari:",
            zeroRecords: "Tidak ada data ditemukan"
        }
    });
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.bulan = $("#filterBulan").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.jenis_data = $("#filterJenisData").val();
        
        if(!currentData.tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        loadData();
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    bulan: '',
    kecamatan: 'semua',
    jenis_data: 'peternak'
};

function exportWithParams(format) {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var url = base_url + 'laporan_kepemilikan_ternak/export_' + format;
    url += "?tahun=" + currentData.tahun;
    url += "&bulan=" + (currentData.bulan || '');
    url += "&kecamatan=" + currentData.kecamatan;
    url += "&jenis_data=" + currentData.jenis_data;
    
    window.location.href = url;
}

function printWithCurrentData() {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Kepemilikan Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.kecamatan-cell { text-align: left; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.data-link { color: black !important; text-decoration: none !important; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('kepemilikanTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML.replace('<br>', ' - ') + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadData() {
    var tahun = currentData.tahun;
    var bulan = currentData.bulan;
    var kecamatan = currentData.kecamatan;
    var jenisData = currentData.jenis_data;
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_kepemilikan_ternak/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            bulan: bulan,
            kecamatan: kecamatan,
            jenis_data: jenisData
        },
        dataType: "json",
        success: function(response) {
            var jenisDataText = jenisData === 'peternak' ? 'PETERNAK' : 'POPULASI TERNAK';
            var bulanText = (bulan && bulan !== '') ? bulanNama[bulan] : 'Semua Bulan';
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            
            $("#reportTitle").html('REKAP DATA JUMLAH ' + jenisDataText);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + '<br>Periode: ' + bulanText + ' ' + tahun);
            
            var dataMap = {};
            if(response.data && response.data.length > 0) {
                $.each(response.data, function(index, item) {
                    dataMap[item.kecamatan] = item;
                });
            }
            
            var totalSapiPotong = 0, totalSapiPerah = 0, totalKambing = 0, totalDomba = 0;
            var totalAyam = 0, totalItik = 0, totalAngsa = 0, totalKalkun = 0, totalBurung = 0;
            
            // Update setiap baris sesuai urutan asli
            $("#kepemilikanTable tbody tr").each(function(index, row) {
                if($(row).hasClass('total-row-bottom')) return;
                
                var kecamatanNama = $(row).find("td:eq(1)").text().trim();
                var item = dataMap[kecamatanNama];
                
                var sapiPotong = item ? parseInt(item.sapi_potong) : 0;
                var sapiPerah = item ? parseInt(item.sapi_perah) : 0;
                var kambing = item ? parseInt(item.kambing) : 0;
                var domba = item ? parseInt(item.domba) : 0;
                var ayam = item ? parseInt(item.ayam) : 0;
                var itik = item ? parseInt(item.itik) : 0;
                var angsa = item ? parseInt(item.angsa) : 0;
                var kalkun = item ? parseInt(item.kalkun) : 0;
                var burung = item ? parseInt(item.burung) : 0;
                
                totalSapiPotong += sapiPotong;
                totalSapiPerah += sapiPerah;
                totalKambing += kambing;
                totalDomba += domba;
                totalAyam += ayam;
                totalItik += itik;
                totalAngsa += angsa;
                totalKalkun += kalkun;
                totalBurung += burung;
                
                // Buat URL spesifik untuk setiap jenis ternak
                var baseUrlDetail = base_url + 'laporan_kepemilikan_ternak/detail_kecamatan/' + encodeURIComponent(kecamatanNama) + "/";
                
                // Update Sapi Potong
                var urlSapiPotong = baseUrlDetail + "Sapi%20Potong";
                $(row).find("td:eq(2)").html('<a href="'+ urlSapiPotong +'" class="data-link" target="_blank">' + formatNumber(sapiPotong) + '</a>');
                
                // Update Sapi Perah
                var urlSapiPerah = baseUrlDetail + "Sapi%20Perah";
                $(row).find("td:eq(3)").html('<a href="'+ urlSapiPerah +'" class="data-link" target="_blank">' + formatNumber(sapiPerah) + '</a>');
                
                // Update Kambing
                var urlKambing = baseUrlDetail + "Kambing";
                $(row).find("td:eq(4)").html('<a href="'+ urlKambing +'" class="data-link" target="_blank">' + formatNumber(kambing) + '</a>');
                
                // Update Domba
                var urlDomba = baseUrlDetail + "Domba";
                $(row).find("td:eq(5)").html('<a href="'+ urlDomba +'" class="data-link" target="_blank">' + formatNumber(domba) + '</a>');
                
                // Update Ayam
                var urlAyam = baseUrlDetail + "Ayam";
                $(row).find("td:eq(6)").html('<a href="'+ urlAyam +'" class="data-link" target="_blank">' + formatNumber(ayam) + '</a>');
                
                // Update Itik
                var urlItik = baseUrlDetail + "Itik";
                $(row).find("td:eq(7)").html('<a href="'+ urlItik +'" class="data-link" target="_blank">' + formatNumber(itik) + '</a>');
                
                // Update Angsa
                var urlAngsa = baseUrlDetail + "Angsa";
                $(row).find("td:eq(8)").html('<a href="'+ urlAngsa +'" class="data-link" target="_blank">' + formatNumber(angsa) + '</a>');
                
                // Update Kalkun
                var urlKalkun = baseUrlDetail + "Kalkun";
                $(row).find("td:eq(9)").html('<a href="'+ urlKalkun +'" class="data-link" target="_blank">' + formatNumber(kalkun) + '</a>');
                
                // Update Burung
                var urlBurung = baseUrlDetail + "Burung";
                $(row).find("td:eq(10)").html('<a href="'+ urlBurung +'" class="data-link" target="_blank">' + formatNumber(burung) + '</a>');
            });
            
            // Hapus baris total sebelumnya jika ada
            $("#kepemilikanTable tbody tr.total-row-bottom").remove();
            
            // Tambahkan baris total di tbody dengan TOTAL di tengah (colspan)
            $("#kepemilikanTable tbody").append(
                '<tr class="total-row-bottom" style="background-color: #e8f5e9; font-weight: bold;">' +
                '   <td colspan="2" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>' +
                '   <td><strong>' + formatNumber(totalSapiPotong) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalSapiPerah) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalKambing) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalDomba) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalAyam) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalItik) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalAngsa) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalKalkun) + '</strong></td>' +
                '   <td><strong>' + formatNumber(totalBurung) + '</strong></td>' +
                '</tr>'
            );
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}