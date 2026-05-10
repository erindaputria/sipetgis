/**
 * Laporan Data Klinik Hewan
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable with custom buttons
    klinikTable = $('#klinikTable').DataTable({
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
    
    // ========== LANGSUNG LOAD SEMUA DATA SAAT HALAMAN DIBUKA ==========
    loadAllData();
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        
        if(currentData.tahun === '') {
            loadAllData();
        } else {
            loadDataWithFilter();
        }
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('');
        $("#filterKecamatan").val('semua');
        
        currentData = {
            tahun: '',
            kecamatan: 'semua'
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

var klinikTable = null;
var currentData = {
    tahun: '',
    kecamatan: 'semua'
};

function exportWithParams(format) {
    var tahun = currentData.tahun || 'all';
    var kecamatan = currentData.kecamatan || 'semua';
    
    var url = base_url + 'laporan_data_klinik_hewan/export_' + format;
    url += "?tahun=" + encodeURIComponent(tahun);
    url += "&kecamatan=" + encodeURIComponent(kecamatan);
    
    window.location.href = url;
}

// ========== FUNGSI PRINT YANG DIPERBAIKI (UNTUK ADMIN & KEPALA) ==========
function printWithCurrentData() {
    var title = $('#reportTitle').html();
    var subtitle = $('#reportSubtitle').html();
    
    var printWindow = window.open('', '_blank');
    if (!printWindow) {
        alert("Mohon izinkan pop-up window untuk mencetak!");
        return;
    }
    
    printWindow.document.write('<!DOCTYPE html>');
    printWindow.document.write('<html><head><title>Laporan Data Klinik Hewan</title>');
    printWindow.document.write('<meta charset="UTF-8">');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; background: white; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #832706; font-size: 18px; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #333; font-size: 12px; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; font-weight: bold; text-align: center; }');
    printWindow.document.write('td { text-align: left; }');
    printWindow.document.write('td.text-center { text-align: center; }');
    printWindow.document.write('td.text-right { text-align: right; }');
    printWindow.document.write('.badge-sertifikat-ada { background-color: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 12px; display: inline-block; }');
    printWindow.document.write('.badge-sertifikat-tidak { background-color: #ffebee; color: #c62828; padding: 2px 8px; border-radius: 12px; display: inline-block; }');
    printWindow.document.write('.positive-value { color: #832706 !important; font-weight: bold; }');
    printWindow.document.write('.kecamatan-cell { font-weight: bold; background-color: #fef3ef; }');
    printWindow.document.write('.nama-klinik { font-weight: 600; }');
    printWindow.document.write('.data-link-rekap { text-decoration: none; color: #000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } body { margin: 0; padding: 10px; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // ========== 1. HEADER LAPORAN ==========
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + escapeHtml(title) + '</h2>');
    printWindow.document.write('<p>' + escapeHtml(subtitle) + '</p>');
    printWindow.document.write('</div>');
    
    // ========== 2. TABEL DETAIL KLINIK HEWAN ==========
    printWindow.document.write('<h3 style="margin-top: 20px; color: #832706;">A. DATA KLINIK HEWAN</h3>');
    
    // Clone main table
    var tableContent = document.getElementById('klinikTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    // Hapus input search jika ada
    $(tableContent).find('input').remove();
    $(tableContent).find('label').remove();
    
    printWindow.document.write(tableContent.outerHTML);
    
    // ========== 3. TABEL REKAP PER KECAMATAN (HANYA JIKA ADA) ==========
    // PERBAIKAN: Cek apakah elemen rekapKecamatanTable ada
    if ($('#rekapKecamatanTable').length > 0) {
        printWindow.document.write('<div style="margin-top: 30px;">');
        printWindow.document.write('<h3 style="color: #832706;">B. REKAP KLINIK HEWAN PER KECAMATAN</h3>');
        printWindow.document.write('</div>');
        
        // Clone rekap table
        var rekapTable = $('#rekapKecamatanTable').clone();
        $(rekapTable).find('.dataTables_empty').remove();
        $(rekapTable).find('.dt-buttons').remove();
        $(rekapTable).find('.dataTables_filter').remove();
        $(rekapTable).find('.dataTables_length').remove();
        $(rekapTable).find('.dataTables_info').remove();
        $(rekapTable).find('.dataTables_paginate').remove();
        
        // Tampilkan tfoot (total)
        rekapTable.find('tfoot').show();
        
        printWindow.document.write(rekapTable[0].outerHTML);
    }
    
    // ========== 4. FOOTER ==========
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px;">');
    printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
    printWindow.document.write('Surabaya, ' + formattedDateTime);
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    
    // Tunggu sebentar sebelum print
    setTimeout(function() {
        printWindow.print();
        printWindow.close();
    }, 500);
}

function loadAllData() {
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_data_klinik_hewan/get_all_data',
        type: "POST",
        dataType: "json",
        success: function(response) {
            $("#reportTitle").html('DATA KLINIK HEWAN KOTA SURABAYA');
            $("#reportSubtitle").html('Seluruh Kecamatan - Semua Tahun');
            
            // Update tabel detail
            klinikTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var sertifikatHtml = (item.sertifikat_standar === 'Ada' || item.sertifikat_standar === 'Ya')
                        ? '<span class="badge-sertifikat-ada">Ada</span>' 
                        : '<span class="badge-sertifikat-tidak">Tidak Ada</span>';
                    
                    var kelasDokter = (parseInt(item.jumlah_dokter) > 0) ? 'positive-value' : 'zero-value';
                    
                    klinikTable.row.add([
                        no,
                        '<span class="nama-klinik">' + escapeHtml(item.nama_klinik) + '</span>',
                        escapeHtml(item.nib) || '-',
                        sertifikatHtml,
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        '<span class="' + kelasDokter + '">' + formatNumber(item.jumlah_dokter || 0) + ' Dokter</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.no_wa) || '-'
                    ]);
                    no++;
                });
                
                klinikTable.draw();
            } else {
                klinikTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                klinikTable.draw();
            }
            
            // Update tabel rekap (hanya jika ada)
            if ($('#rekapKecamatanTable').length > 0) {
                if(response.rekap_kecamatan && response.rekap_kecamatan.length > 0) {
                    updateRekapTable(response.rekap_kecamatan, response.total_rekap);
                } else {
                    updateRekapTable([], {});
                }
            }
            
            // Set current data untuk export
            currentData.tahun = '';
            currentData.kecamatan = 'semua';
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error loading data:", error);
            $("#loadingOverlay").fadeOut();
            alert("Gagal memuat data: " + error);
        }
    });
}

function loadDataWithFilter() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + 'laporan_data_klinik_hewan/get_data',
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            var tahunText = 'TAHUN ' + tahun;
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            $("#reportTitle").html('DATA KLINIK HEWAN KOTA SURABAYA');
            $("#reportSubtitle").html(kecamatanText + ' - ' + tahunText);
            
            // Update tabel detail
            klinikTable.clear().draw();
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                
                $.each(response.data, function(index, item) {
                    var sertifikatHtml = (item.sertifikat_standar === 'Ada' || item.sertifikat_standar === 'Ya')
                        ? '<span class="badge-sertifikat-ada">Ada</span>' 
                        : '<span class="badge-sertifikat-tidak">Tidak Ada</span>';
                    
                    var kelasDokter = (parseInt(item.jumlah_dokter) > 0) ? 'positive-value' : 'zero-value';
                    
                    klinikTable.row.add([
                        no,
                        '<span class="nama-klinik">' + escapeHtml(item.nama_klinik) + '</span>',
                        escapeHtml(item.nib) || '-',
                        sertifikatHtml,
                        escapeHtml(item.alamat) || '-',
                        escapeHtml(item.kecamatan) || '-',
                        escapeHtml(item.kelurahan) || '-',
                        '<span class="' + kelasDokter + '">' + formatNumber(item.jumlah_dokter || 0) + ' Dokter</span>',
                        escapeHtml(item.nama_pemilik) || '-',
                        escapeHtml(item.no_wa) || '-'
                    ]);
                    no++;
                });
                
                klinikTable.draw();
            } else {
                klinikTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
                klinikTable.draw();
            }
            
            // Update tabel rekap (hanya jika ada)
            if ($('#rekapKecamatanTable').length > 0) {
                if(response.rekap_kecamatan && response.rekap_kecamatan.length > 0) {
                    updateRekapTable(response.rekap_kecamatan, response.total_rekap);
                } else {
                    updateRekapTable([], {});
                }
            }
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error loading data:", error);
            $("#loadingOverlay").fadeOut();
            alert("Gagal memuat data: " + error);
        }
    });
}

// Fungsi update tabel rekap
function updateRekapTable(data, totals) {
    if(!data || data.length === 0) {
        $('#rekapTableBody').html('<tr><td colspan="3" class="text-center text-muted">Tidak ada data</td><td style="display:none"></td><td style="display:none"></td></tr>');
        
        var footerRow = '<tr>' +
            '<td colspan="2" class="text-center"><strong>TOTAL</strong></td>' +
            '<td class="text-center"><strong>0</strong></td>' +
            '</tr>';
        $('#rekapKecamatanFooter').html(footerRow);
        return;
    }
    
    var tbody = '';
    var no = 1;
    var totalKlinik = 0;
    
    for(var i = 0; i < data.length; i++) {
        var item = data[i];
        var jumlah = parseInt(item.jumlah_klinik) || 0;
        totalKlinik += jumlah;
        
        var kelas = jumlah > 0 ? 'positive-value' : '';
        var baseUrl = base_url + 'laporan_data_klinik_hewan/detail_kecamatan/' + encodeURIComponent(item.kecamatan);
        var tahunParam = currentData.tahun ? '?tahun=' + currentData.tahun : '';
        
        tbody += '<tr>' +
            '<td class="text-center">' + no++ + '</td>' +
            '<td class="kecamatan-cell">' + escapeHtml(item.kecamatan) + '</td>' +
            '<td class="text-center"><a href="' + baseUrl + tahunParam + '" class="data-link-rekap ' + kelas + '" target="_blank">' + formatNumber(jumlah) + '</a></td>' +
            '</tr>';
    }
    
    $('#rekapTableBody').html(tbody);
    
    // Update footer total
    var footerRow = '<tr>' +
        '<td colspan="2" class="text-center"><strong>TOTAL</strong></td>' +
        '<td class="text-center"><strong>' + formatNumber(totalKlinik) + '</strong></td>' +
        '</tr>';
    $('#rekapKecamatanFooter').html(footerRow);
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function escapeHtml(text) {
    if(!text) return '-';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}