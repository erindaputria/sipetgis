/**
 * Laporan History Data Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#historyTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'copy',
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: {
            //         columns: ':visible'
            //     }
            // },
            // {
            //     extend: 'csv',
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     action: function(e, dt, button, config) {
            //         exportWithParams('csv');
            //     }
            // },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel', 
                className: 'btn btn-sm btn-success',
                action: function(e, dt, button, config) {
                    exportWithParams('excel');
                }
            },
            // {
            //     extend: 'pdf',
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     action: function(e, dt, button, config) {
            //         exportWithParams('pdf');
            //     }
            // },
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
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.bulan = $("#filterBulan").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        
        if(!currentData.tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        if(!currentData.bulan) {
            alert("Silakan pilih bulan terlebih dahulu!");
            return;
        }
        
        loadData();
    });
    
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
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun && currentData.bulan) {
            loadData();
        } else {
            loadAllData();
        }
    });
    
    // Load all data on page load
    loadAllData();
});

var dataTable = null;
var currentData = {
    tahun: '',
    bulan: '',
    kecamatan: 'semua'
};

function exportWithParams(format) {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    if(!currentData.bulan) {
        alert("Silakan pilih bulan terlebih dahulu!");
        return;
    }
    
    var url = base_url + 'laporan_history_data_ternak/export_' + format;
    url += "?tahun=" + currentData.tahun;
    url += "&bulan=" + (currentData.bulan || '');
    url += "&kecamatan=" + currentData.kecamatan;
    
    window.location.href = url;
}

function printWithCurrentData() {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    if(!currentData.bulan) {
        alert("Silakan pilih bulan terlebih dahulu!");
        return;
    }
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan History Data Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
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
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML.replace('<br>', ' - ') + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_ternak/get_all_data',
        type: "POST",
        data: {},
        dataType: "json",
        success: function(response) {
            displayData(response, 'Semua Periode', 'Semua Kecamatan');
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function loadData() {
    var tahun = currentData.tahun;
    var bulan = currentData.bulan;
    var kecamatan = currentData.kecamatan;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_history_data_ternak/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            bulan: bulan,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            var bulanText = bulanNama[bulan] || bulan;
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            var periodeText = 'Periode: ' + bulanText + ' ' + tahun;
            
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

function displayData(response, periodeText, kecamatanText) {
    // Clear table
    dataTable.clear().draw();
    
    // Update title
    $('#reportTitle').html('Data Peternak dan Populasi Ternak');
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
                { nama: 'Ayam Buras', jantan: 0, betina: 0, total: peternak.ayam_buras },
                { nama: 'Ayam Broiler', jantan: 0, betina: 0, total: peternak.ayam_broiler },
                { nama: 'Ayam Layer', jantan: 0, betina: 0, total: peternak.ayam_layer },
                { nama: 'Itik', jantan: 0, betina: 0, total: peternak.itik },
                { nama: 'Angsa', jantan: 0, betina: 0, total: peternak.angsa },
                { nama: 'Kalkun', jantan: 0, betina: 0, total: peternak.kalkun },
                { nama: 'Burung', jantan: 0, betina: 0, total: peternak.burung }
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
                    jantan: hewan.hasOwnProperty('total') ? 0 : hewan.jantan,
                    betina: hewan.hasOwnProperty('total') ? 0 : hewan.betina,
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
            '1', '-', '-', '-', '-', '-', '-', '-', '0', '0', '0'
        ]).draw(false);
    }
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}