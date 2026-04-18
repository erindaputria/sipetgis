var dataTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua',
    jenis_vaksin: 'semua',
    jenis_hewan: 'semua'
};

$(document).ready(function() {
    // Initialize DataTable
    dataTable = $('#historyVaksinasiTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: ':visible' }
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
        paging: true,
        pageLength: 10,
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
    
    // Set default tahun ke 2026
    $('#filterTahun').val('2026');
    currentData.tahun = '2026';
    
    // Load data awal
    loadData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.jenis_vaksin = $("#filterJenisVaksin").val();
        currentData.jenis_hewan = $("#filterJenisHewan").val();
        
        if(!currentData.tahun) {
            alert("Silakan pilih tahun terlebih dahulu!");
            return;
        }
        
        loadData();
    });
});

function exportWithParams(format) {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var url = "<?= base_url('laporan_history_data_vaksinasi/export_') ?>" + format;
    url += "?tahun=" + currentData.tahun;
    url += "&kecamatan=" + currentData.kecamatan;
    url += "&jenis_vaksin=" + currentData.jenis_vaksin;
    url += "&jenis_hewan=" + currentData.jenis_hewan;
    window.location.href = url;
}

function printWithCurrentData() {
    if(!currentData.tahun) {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan History Data Vaksinasi</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #1e3a8a; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #6c757d; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; font-weight: bold; text-align: center; }');
    printWindow.document.write('td:first-child { text-align: center; }');
    printWindow.document.write('td:last-child { text-align: center; }');
    printWindow.document.write('td:nth-child(2), td:nth-child(3), td:nth-child(4), td:nth-child(5), td:nth-child(6), td:nth-child(7), td:nth-child(8), td:nth-child(9) { text-align: left; }');
    printWindow.document.write('.total-row td { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML + '</p>');
    printWindow.document.write('</div>');
    
    // Ambil data dari tabel yang sudah ada
    var tableContent = document.getElementById('historyVaksinasiTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write(tableContent.outerHTML);
    
    printWindow.document.write('<div style="margin-top: 30px; font-size: 12px; color: #6c757d;">');
    printWindow.document.write('<p>Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p>');
    printWindow.document.write('<p>Dicetak oleh: Administrator</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadData() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var jenisVaksin = currentData.jenis_vaksin;
    var jenisHewan = currentData.jenis_hewan;
    
    if(!tahun) {
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: "<?= base_url('laporan_history_data_vaksinasi/get_data') ?>",
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan,
            jenis_vaksin: jenisVaksin,
            jenis_hewan: jenisHewan
        },
        dataType: "json",
        success: function(response) {
            console.log("Response:", response);
            
            var titleText = 'REKAPITULASI VAKSINASI';
            if(jenisVaksin && jenisVaksin != 'semua') {
                titleText += ' ' + jenisVaksin;
            }
            titleText += ' TAHUN ' + tahun;
            
            $("#reportTitle").html(titleText);
            
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Kota Surabaya';
            if(jenisHewan && jenisHewan != 'semua') {
                kecamatanText += ' - Jenis Hewan: ' + jenisHewan;
            }
            $("#reportSubtitle").html(kecamatanText);
            
            // Clear table
            dataTable.clear();
            
            var totalDosis = 0;
            var nomor = 1;
            
            if(response.data && response.data.length > 0) {
                for(var i = 0; i < response.data.length; i++) {
                    var item = response.data[i];
                    var rowData = [
                        nomor,
                        item.tanggal,
                        item.petugas,
                        item.peternak,
                        item.nik,
                        item.alamat,
                        item.kecamatan,
                        item.kelurahan,
                        item.jenis_hewan,
                        item.jumlah
                    ];
                    dataTable.row.add(rowData);
                    totalDosis = totalDosis + parseInt(item.jumlah);
                    nomor = nomor + 1;
                }
            } else {
                dataTable.row.add([1, 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '0']);
            }
            
            dataTable.draw();
            
            // Add footer total
            var footerHtml = '<tr class="total-row">' +
                '<td colspan="8"><strong>TOTAL</strong></td>' +
                '<td><strong>' + formatNumber(totalDosis) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalDosis) + '</strong></td>' +
                '</tr>';
            $("#tableFooter").html(footerHtml);
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            console.error("Response Text:", xhr.responseText);
            alert("Gagal memuat data. Silakan coba lagi. Error: " + error);
            $("#loadingOverlay").fadeOut();
        }
    });
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}