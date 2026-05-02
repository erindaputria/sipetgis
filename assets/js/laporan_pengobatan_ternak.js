/**
 * Laporan Pengobatan Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    dataTable = $('#pengobatanTable').DataTable({
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
    
    // Load semua data saat halaman pertama kali dibuka
    loadAllData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.jenis_hewan = $("#filterJenisHewan").val();
        
        if(currentData.tahun === '') {
            loadAllData();
        } else {
            loadDataWithFilter();
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        $("#filterJenisHewan").val('semua');
        
        currentData = {
            tahun: '',
            kecamatan: 'semua',
            jenis_hewan: 'semua'
        };
        
        loadAllData();
    });
    
    $("#refreshBtn").click(function() {
        if(currentData.tahun) {
            loadDataWithFilter();
        } else {
            loadAllData();
        }
    });
});

var dataTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua',
    jenis_hewan: 'semua'
};

function exportWithParams(format) {
    var url = base_url + 'laporan_pengobatan_ternak/export_' + format;
    
    if(currentData.tahun) {
        url += "?tahun=" + currentData.tahun;
        url += "&kecamatan=" + currentData.kecamatan;
        url += "&jenis_hewan=" + currentData.jenis_hewan;
    } else {
        url += "?tahun=all";
        url += "&kecamatan=" + currentData.kecamatan;
        url += "&jenis_hewan=" + currentData.jenis_hewan;
    }
    
    window.location.href = url;
}

function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Pengobatan Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.badge-diagnosa { background-color: #fff3e0; color: #e67e22; padding: 2px 6px; border-radius: 12px; }');
    printWindow.document.write('.badge-tindakan { background-color: #e8f5e9; color: #27ae60; padding: 2px 6px; border-radius: 12px; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.kecamatan-cell { font-weight: bold; background-color: #fef3ef; }');
    printWindow.document.write('.data-link-rekap { text-decoration: none; }');
    printWindow.document.write('.positive-value { color: #832706 !important; font-weight: bold; }');
    printWindow.document.write('.zero-value { color: #000000 !important; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Clone main table
    var tableContent = document.getElementById('pengobatanTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + title + '</h2>');
    printWindow.document.write('<p>' + subtitle + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
     
    // Clone rekap table
    printWindow.document.write('<div class="header" style="margin-top: 30px;">');
    printWindow.document.write('<h3>REKAP PENGOBATAN PER KECAMATAN</h3>');
    printWindow.document.write('</div>');
    
    var rekapTable = $('#rekapPengobatanTable').clone();
    $(rekapTable).find('.dataTables_empty').remove();
    rekapTable.find('tfoot').show();
    printWindow.document.write(rekapTable[0].outerHTML);
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_pengobatan_ternak/get_all_data',
        type: "POST",
        dataType: "json",
        success: function(response) {
            $("#reportTitle").html('REKAP DATA PENGOBATAN TERNAK');
            $("#reportSubtitle").html('Kota Surabaya - Seluruh Data');
            
            // Update tabel detail
            dataTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                var totalJumlah = 0;
                
                $.each(response.data, function(index, item) {
                    var rowData = [
                        no,
                        formatDate(item.tanggal_pengobatan),
                        escapeHtml(item.nama_petugas || '-'),
                        escapeHtml(item.nama_peternak || '-'),
                        escapeHtml(item.nik || '-'),
                        escapeHtml(item.alamat || '-'),
                        escapeHtml(item.kecamatan || '-'),
                        escapeHtml(item.kelurahan || '-'),
                        escapeHtml(item.komoditas_ternak || '-'),
                        '<span class="badge-diagnosa">' + escapeHtml(item.gejala_klinis || '-') + '</span>',
                        '<span class="badge-tindakan">' + escapeHtml(item.jenis_pengobatan || '-') + '</span>',
                        formatNumber(item.jumlah || 0)
                    ];
                    dataTable.row.add(rowData);
                    totalJumlah += parseInt(item.jumlah) || 0;
                    no++;
                });
                
                dataTable.draw();
                
                var footerHtml = '<tr class="total-row">' +
                    '<td colspan="11" style="text-align: right;"><strong>TOTAL JUMLAH TERNAK</strong></td>' +
                    '<td><strong>' + formatNumber(totalJumlah) + '</strong></td>' +
                    '</tr>';
                $("#tableFooter").html(footerHtml);
                $("#tableFooter").show();
            } else {
                dataTable.clear().draw();
                $("#tableFooter").hide();
            }
            
            // Update tabel rekap dengan data real
            updateRekapTable(response.rekap_breakdown || [], response.total_breakdown || {}, '');
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var jenisHewan = currentData.jenis_hewan;
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_pengobatan_ternak/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan,
            jenis_hewan: jenisHewan
        },
        dataType: "json",
        success: function(response) {
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            var jenisText = (jenisHewan && jenisHewan !== 'semua') ? ' - Jenis Hewan: ' + jenisHewan : '';
            
            $("#reportTitle").html('REKAP DATA PENGOBATAN TERNAK TAHUN ' + tahun);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + jenisText);
            
            dataTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                var totalJumlah = 0;
                
                $.each(response.data, function(index, item) {
                    var rowData = [
                        no,
                        formatDate(item.tanggal_pengobatan),
                        escapeHtml(item.nama_petugas || '-'),
                        escapeHtml(item.nama_peternak || '-'),
                        escapeHtml(item.nik || '-'),
                        escapeHtml(item.alamat || '-'),
                        escapeHtml(item.kecamatan || '-'),
                        escapeHtml(item.kelurahan || '-'),
                        escapeHtml(item.komoditas_ternak || '-'),
                        '<span class="badge-diagnosa">' + escapeHtml(item.gejala_klinis || '-') + '</span>',
                        '<span class="badge-tindakan">' + escapeHtml(item.jenis_pengobatan || '-') + '</span>',
                        formatNumber(item.jumlah || 0)
                    ];
                    dataTable.row.add(rowData);
                    totalJumlah += parseInt(item.jumlah) || 0;
                    no++;
                });
                
                dataTable.draw();
                
                var footerHtml = '<tr class="total-row">' +
                    '<td colspan="11" style="text-align: right;"><strong>TOTAL JUMLAH TERNAK</strong></td>' +
                    '<td><strong>' + formatNumber(totalJumlah) + '</strong></td>' +
                    '</tr>';
                $("#tableFooter").html(footerHtml);
                $("#tableFooter").show();
            } else {
                dataTable.clear().draw();
                $("#tableFooter").hide();
            }
            
            // Update tabel rekap dengan data sesuai filter
            updateRekapTable(response.rekap_breakdown || [], response.total_breakdown || {}, tahun);
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

// ========== FUNGSI UPDATE TABEL REKAP DENGAN ANGKA REAL ==========
function updateRekapTable(data, totals, tahun) {
    if(!data || data.length === 0) {
        $('#rekapTableBody').html('<tr><td colspan="10" class="text-center text-muted">Tidak ada data</td></tr>');
        return;
    }
    
    var tbody = '';
    var no = 1;
    
    $.each(data, function(i, item) {
        var baseUrl = base_url + 'laporan_pengobatan_ternak/detail_kecamatan/' + encodeURIComponent(item.kecamatan) + '/';
        var tahunParam = tahun ? '?tahun=' + tahun : '';
        
        // Ambil nilai
        var sapiPotong = item.sapi_potong || 0;
        var sapiPerah = item.sapi_perah || 0;
        var kambing = item.kambing || 0;
        var domba = item.domba || 0;
        var ayam = item.ayam || 0;
        var itik = item.itik || 0;
        var kelinci = item.kelinci || 0;
        var kucing = item.kucing || 0;
        
        // Tentukan class berdasarkan nilai (0 atau positif)
        var classPotong = sapiPotong > 0 ? 'positive-value' : 'zero-value';
        var classPerah = sapiPerah > 0 ? 'positive-value' : 'zero-value';
        var classKambing = kambing > 0 ? 'positive-value' : 'zero-value';
        var classDomba = domba > 0 ? 'positive-value' : 'zero-value';
        var classAyam = ayam > 0 ? 'positive-value' : 'zero-value';
        var classItik = itik > 0 ? 'positive-value' : 'zero-value';
        var classKelinci = kelinci > 0 ? 'positive-value' : 'zero-value';
        var classKucing = kucing > 0 ? 'positive-value' : 'zero-value';
        
        tbody += '<tr>' +
            '<td class="text-center">' + no++ + '</td>' +
            '<td class="kecamatan-cell">' + escapeHtml(item.kecamatan) + '</td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Sapi Potong' + tahunParam + '" class="data-link-rekap ' + classPotong + '" target="_blank">' + formatNumber(sapiPotong) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Sapi Perah' + tahunParam + '" class="data-link-rekap ' + classPerah + '" target="_blank">' + formatNumber(sapiPerah) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Kambing' + tahunParam + '" class="data-link-rekap ' + classKambing + '" target="_blank">' + formatNumber(kambing) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Domba' + tahunParam + '" class="data-link-rekap ' + classDomba + '" target="_blank">' + formatNumber(domba) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Ayam' + tahunParam + '" class="data-link-rekap ' + classAyam + '" target="_blank">' + formatNumber(ayam) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Itik' + tahunParam + '" class="data-link-rekap ' + classItik + '" target="_blank">' + formatNumber(itik) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Kelinci' + tahunParam + '" class="data-link-rekap ' + classKelinci + '" target="_blank">' + formatNumber(kelinci) + '</a></td>' +
            '<td class="text-center"><a href="' + baseUrl + 'Kucing' + tahunParam + '" class="data-link-rekap ' + classKucing + '" target="_blank">' + formatNumber(kucing) + '</a></td>' +
            '</tr>';
    });
    
    $('#rekapTableBody').html(tbody);
    
    // Update footer total
    if(totals) {
        var footerRow = '<tr style="background-color: #f8f9fa; font-weight: bold;">' +
            '<td colspan="2" class="text-center"><strong style="color: #000000;">TOTAL</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.sapi_potong || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.sapi_perah || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.kambing || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.domba || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.ayam || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.itik || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.kelinci || 0) + '</strong></td>' +
            '<td class="text-center"><strong style="color: #000000;">' + formatNumber(totals.kucing || 0) + '</strong></td>' +
            '</tr>';
        $('#rekapTableFooter').html(footerRow);
    }
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatDate(dateString) {
    if(!dateString) return '-';
    var parts = dateString.split('-');
    if(parts.length === 3) {
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }
    return dateString;
}

function escapeHtml(text) {
    if(!text) return '';
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function populateRekapJenis(data, totalJumlah) {
    var html = '';
    var no = 1;
    
    $.each(data, function(index, item) {
        var persentase = totalJumlah > 0 ? ((item.total_jumlah / totalJumlah) * 100).toFixed(2) : 0;
        html += '<tr>' +
            '<td class="text-center">' + no++ + '</td>' +
            '<td class="text-start">' + escapeHtml(item.jenis_hewan) + '</td>' +
            '<td class="text-center">' + formatNumber(item.jumlah_kasus) + '</td>' +
            '<td class="text-center">' + formatNumber(item.total_jumlah) + '</td>' +
            '<td class="text-center">' + persentase + '%</td>' +
            '</tr>';
    });
    
    if(data.length === 0) {
        html = '<tr><td colspan="5" class="text-center text-muted">Tidak ada数据</td></tr>';
    }
    
    $("#rekapJenisBody").html(html);
}

function populateRekapKecamatan(data, totalJumlah) {
    var html = '';
    var no = 1;
    
    $.each(data, function(index, item) {
        var persentase = totalJumlah > 0 ? ((item.total_jumlah / totalJumlah) * 100).toFixed(2) : 0;
        html += '<tr>' +
            '<td class="text-center">' + no++ + '</td>' +
            '<td class="text-start">' + escapeHtml(item.kecamatan) + '</td>' +
            '<td class="text-center">' + formatNumber(item.jumlah_kasus) + '</td>' +
            '<td class="text-center">' + formatNumber(item.total_jumlah) + '</td>' +
            '<td class="text-center">' + persentase + '%</td>' +
            '</tr>';
    });
    
    if(data.length === 0) {
        html = '<tr><td colspan="5" class="text-center text-muted">Tidak ada数据</td></tr>';
    }
    
    $("#rekapKecamatanBody").html(html);
}