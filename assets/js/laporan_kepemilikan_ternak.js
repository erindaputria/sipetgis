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
        paging: false,
        info: false, 
        language: {
            search: "Cari:",
            zeroRecords: "Tidak ada data ditemukan"
        }
    });
    
    // LOAD DATA OTOMATIS SAAT HALAMAN PERTAMA KALI DIBUKA
    var firstYear = $("#filterTahun option:eq(1)").val();
    if(firstYear) {
        currentData.tahun = firstYear;
        currentData.bulan = '';
        currentData.kecamatan = 'semua';
        currentData.jenis_data = 'peternak';
        
        $("#filterTahun").val(firstYear);
        $("#filterBulan").val('');
        $("#filterKecamatan").val('semua');
        $("#filterJenisData").val('peternak');
        
        loadData();
    }
    
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

    // ================ TOMBOL RESET (BENAR) ================
    $("#btnReset").click(function() {
        // Reset semua filter ke nilai default
        $("#filterTahun").val('');
        $("#filterBulan").val('');
        $("#filterKecamatan").val('semua');
        $("#filterJenisData").val('peternak');
        
        // Ambil tahun pertama dari dropdown
        var firstYear = $("#filterTahun option:eq(1)").val();
        
        if(firstYear) {
            // Set currentData dengan tahun pertama
            currentData = {
                tahun: firstYear,
                bulan: '',
                kecamatan: 'semua',
                jenis_data: 'peternak'
            };
            
            // Update dropdown values
            $("#filterTahun").val(firstYear);
            $("#filterBulan").val('');
            $("#filterKecamatan").val('semua');
            $("#filterJenisData").val('peternak');
            
            // Load data untuk semua kecamatan
            loadData();
        } else {
            // Jika tidak ada tahun, tampilkan pesan
            currentData = {
                tahun: '',
                bulan: '',
                kecamatan: 'semua',
                jenis_data: 'peternak'
            };
            
            $("#kepemilikanTable tbody").empty();
            $("#kepemilikanTable tbody").html('<tr><td colspan="11" class="text-center">Tidak ada data tahun tersedia</td></tr>');
            
            $("#reportTitle").html('REKAP DATA JUMLAH PETERNAK');
            $("#reportSubtitle").html('Kota Surabaya');
        }
    });

    // ================ TOMBOL REFRESH ================
    $("#refreshBtn").click(function() {
        if(currentData.tahun && currentData.tahun !== '') {
            // Jika sudah ada filter yang dipilih, refresh dengan filter yang sama
            loadData();
        } else {
            // Jika belum ada filter, ambil tahun pertama dari dropdown
            var firstYear = $("#filterTahun option:eq(1)").val();
            if(firstYear) {
                currentData.tahun = firstYear;
                currentData.bulan = '';
                currentData.kecamatan = 'semua';
                currentData.jenis_data = 'peternak';
                
                $("#filterTahun").val(firstYear);
                $("#filterBulan").val('');
                $("#filterKecamatan").val('semua');
                $("#filterJenisData").val('peternak');
                
                loadData();
            } else {
                alert("Tidak ada data tahun yang tersedia. Silakan input data terlebih dahulu.");
            }
        }
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    bulan: '',
    kecamatan: 'semua',
    jenis_data: 'peternak'
};

// Fungsi untuk export Excel
function exportWithParams(format) {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var url = base_url + 'laporan_kepemilikan_ternak/export_excel';
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
    printWindow.document.write('.positive-value { color: #832706 !important; font-weight: bold; }');
    printWindow.document.write('.zero-value { color: #000000 !important; }');
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
            if(response.status === 'error') {
                alert("Error: " + response.message);
                $("#loadingOverlay").fadeOut();
                return;
            }
            
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
            
            $("#kepemilikanTable tbody tr").each(function(index, row) {
                if($(row).hasClass('total-row-bottom')) return;
                
                var kecamatanNama = $(row).find("td:eq(1)").text().trim();
                var item = dataMap[kecamatanNama];
                
                var sapiPotong = item ? parseInt(item.sapi_potong) || 0 : 0;
                var sapiPerah = item ? parseInt(item.sapi_perah) || 0 : 0;
                var kambing = item ? parseInt(item.kambing) || 0 : 0;
                var domba = item ? parseInt(item.domba) || 0 : 0;
                var ayam = item ? parseInt(item.ayam) || 0 : 0;
                var itik = item ? parseInt(item.itik) || 0 : 0;
                var angsa = item ? parseInt(item.angsa) || 0 : 0;
                var kalkun = item ? parseInt(item.kalkun) || 0 : 0;
                var burung = item ? parseInt(item.burung) || 0 : 0;
                
                var classSapiPotong = sapiPotong > 0 ? 'positive-value' : 'zero-value';
                var classSapiPerah = sapiPerah > 0 ? 'positive-value' : 'zero-value';
                var classKambing = kambing > 0 ? 'positive-value' : 'zero-value';
                var classDomba = domba > 0 ? 'positive-value' : 'zero-value';
                var classAyam = ayam > 0 ? 'positive-value' : 'zero-value';
                var classItik = itik > 0 ? 'positive-value' : 'zero-value';
                var classAngsa = angsa > 0 ? 'positive-value' : 'zero-value';
                var classKalkun = kalkun > 0 ? 'positive-value' : 'zero-value';
                var classBurung = burung > 0 ? 'positive-value' : 'zero-value';
                
                totalSapiPotong += sapiPotong;
                totalSapiPerah += sapiPerah;
                totalKambing += kambing;
                totalDomba += domba;
                totalAyam += ayam;
                totalItik += itik;
                totalAngsa += angsa;
                totalKalkun += kalkun;
                totalBurung += burung;
                
                var baseUrlDetail = base_url + 'laporan_kepemilikan_ternak/detail_kecamatan/' + encodeURIComponent(kecamatanNama) + "/";
                var tahunParam = tahun ? '?tahun=' + tahun : '';
                if(bulan) tahunParam += (tahunParam ? '&' : '?') + 'bulan=' + bulan;
                
                $(row).find("td:eq(2)").html('<a href="'+ baseUrlDetail + 'Sapi Potong' + tahunParam +'" class="data-link ' + classSapiPotong + '" target="_blank">' + formatNumber(sapiPotong) + '</a>');
                $(row).find("td:eq(3)").html('<a href="'+ baseUrlDetail + 'SapiPerah' + tahunParam +'" class="data-link ' + classSapiPerah + '" target="_blank">' + formatNumber(sapiPerah) + '</a>');
                $(row).find("td:eq(4)").html('<a href="'+ baseUrlDetail + 'Kambing' + tahunParam +'" class="data-link ' + classKambing + '" target="_blank">' + formatNumber(kambing) + '</a>');
                $(row).find("td:eq(5)").html('<a href="'+ baseUrlDetail + 'Domba' + tahunParam +'" class="data-link ' + classDomba + '" target="_blank">' + formatNumber(domba) + '</a>');
                $(row).find("td:eq(6)").html('<a href="'+ baseUrlDetail + 'Ayam' + tahunParam +'" class="data-link ' + classAyam + '" target="_blank">' + formatNumber(ayam) + '</a>');
                $(row).find("td:eq(7)").html('<a href="'+ baseUrlDetail + 'Itik' + tahunParam +'" class="data-link ' + classItik + '" target="_blank">' + formatNumber(itik) + '</a>');
                $(row).find("td:eq(8)").html('<a href="'+ baseUrlDetail + 'Angsa' + tahunParam +'" class="data-link ' + classAngsa + '" target="_blank">' + formatNumber(angsa) + '</a>');
                $(row).find("td:eq(9)").html('<a href="'+ baseUrlDetail + 'Kalkun' + tahunParam +'" class="data-link ' + classKalkun + '" target="_blank">' + formatNumber(kalkun) + '</a>');
                $(row).find("td:eq(10)").html('<a href="'+ baseUrlDetail + 'Burung' + tahunParam +'" class="data-link ' + classBurung + '" target="_blank">' + formatNumber(burung) + '</a>');
            });
            
            $("#kepemilikanTable tbody tr.total-row-bottom").remove();
            
            var totalClassSP = totalSapiPotong > 0 ? 'positive-value' : 'zero-value';
            var totalClassSPerah = totalSapiPerah > 0 ? 'positive-value' : 'zero-value';
            var totalClassKambing = totalKambing > 0 ? 'positive-value' : 'zero-value';
            var totalClassDomba = totalDomba > 0 ? 'positive-value' : 'zero-value';
            var totalClassAyam = totalAyam > 0 ? 'positive-value' : 'zero-value';
            var totalClassItik = totalItik > 0 ? 'positive-value' : 'zero-value';
            var totalClassAngsa = totalAngsa > 0 ? 'positive-value' : 'zero-value';
            var totalClassKalkun = totalKalkun > 0 ? 'positive-value' : 'zero-value';
            var totalClassBurung = totalBurung > 0 ? 'positive-value' : 'zero-value';
            
            $("#kepemilikanTable tbody").append(
                '<tr class="total-row-bottom" style="background-color: #e8f5e9; font-weight: bold;">' +
                '   <td colspan="2" style="text-align: center;"><strong>TOTAL KESELURUHAN</strong></td>' +
                '   <td><strong class="' + totalClassSP + '">' + formatNumber(totalSapiPotong) + '</strong></td>' +
                '   <td><strong class="' + totalClassSPerah + '">' + formatNumber(totalSapiPerah) + '</strong></td>' +
                '   <td><strong class="' + totalClassKambing + '">' + formatNumber(totalKambing) + '</strong></td>' +
                '   <td><strong class="' + totalClassDomba + '">' + formatNumber(totalDomba) + '</strong></td>' +
                '   <td><strong class="' + totalClassAyam + '">' + formatNumber(totalAyam) + '</strong></td>' +
                '   <td><strong class="' + totalClassItik + '">' + formatNumber(totalItik) + '</strong></td>' +
                '   <td><strong class="' + totalClassAngsa + '">' + formatNumber(totalAngsa) + '</strong></td>' +
                '   <td><strong class="' + totalClassKalkun + '">' + formatNumber(totalKalkun) + '</strong></td>' +
                '   <td><strong class="' + totalClassBurung + '">' + formatNumber(totalBurung) + '</strong></td>' +
                '  </td>'
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