/**
 * Master Kepemilikan Jenis Usaha
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Gunakan variable dari view
    var baseUrl = BASE_URL;
    var csrfName = CSRF_NAME;
    var csrfToken = CSRF_HASH;
    
    // Pastikan dropdown parent benar
    var $tambahModal = $('#tambahDataModal');
    
    // Fungsi escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Fungsi untuk mengosongkan cache Select2 dan reload data
    function clearSelect2Cache() {
        // Hapus cache dari Select2
        if ($('#nik_select').data('select2')) {
            $('#nik_select').select2('destroy');
        }
        
        // Re-initialize Select2 dengan cache: false
        $('#nik_select').select2({
            dropdownParent: $tambahModal,
            theme: 'bootstrap-5',
            placeholder: '-- Ketik NIK atau Nama Pelaku Usaha (minimal 2 karakter) --',
            allowClear: true,
            minimumInputLength: 2,
            width: '100%',
            ajax: {
                url: baseUrl + 'kepemilikan_jenis_usaha/search_pelaku_usaha',
                dataType: 'json',
                type: 'GET',
                delay: 300,
                cache: false, // PASTIKAN false agar selalu ambil data baru
                data: function(params) {
                    var query = {
                        q: params.term,
                        [csrfName]: csrfToken
                    };
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                }
            },
            templateResult: function(data) {
                if (data.loading) {
                    return data.text;
                }
                if (!data.nik) {
                    return data.text;
                }
                var $container = $('<div><strong class="select2-result-name">' + escapeHtml(data.nama) + '</strong><br><small class="select2-result-nik">NIK: ' + escapeHtml(data.nik) + '</small></div>');
                return $container;
            },
            templateSelection: function(data) {
                if (!data.nik) {
                    return data.text;
                }
                return data.nama + ' - ' + data.nik;
            }
        });
    }
    
    // Initialize Select2 pertama kali
    clearSelect2Cache();
    
    // ========== SINKRONISASI: Cek localStorage setiap 1 detik ==========
    var lastUpdate = localStorage.getItem('pelakuUsahaUpdated') || 0;
    
    function checkForUpdates() {
        var currentUpdate = localStorage.getItem('pelakuUsahaUpdated');
        if (currentUpdate && currentUpdate !== lastUpdate) {
            lastUpdate = currentUpdate;
            // Refresh Select2
            clearSelect2Cache();
            // Tampilkan notifikasi
            showNotification('Data pelaku usaha telah diperbarui! Silakan cari NIK/Nama baru.', 'success');
            // Hapus flag
            localStorage.removeItem('pelakuUsahaNeedRefresh');
        }
    }
    
    // Cek setiap 1 detik
    setInterval(checkForUpdates, 1000);
    
    // Juga saat modal tambah data dibuka, refresh Select2
    $('#tambahDataModal').on('show.bs.modal', function() {
        clearSelect2Cache();
        // Reset form jika perlu
        $('#nama_peternak').val('');
        $('#btnSimpan').prop('disabled', false);
    });
    
    // Fungsi notifikasi
    function showNotification(message, type) {
        // Hapus notifikasi lama
        $('.alert-floating').remove();
        
        var icon = type === 'success' ? 'check-circle' : 'info-circle';
        var bgColor = type === 'success' ? '#28a745' : '#17a2b8';
        
        var notification = $('<div class="alert-floating alert alert-' + type + ' alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999; min-width: 300px; background-color: ' + bgColor + '; color: white; border: none;" role="alert">' +
            '<i class="fas fa-' + icon + ' me-2"></i>' +
            message +
            '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>' +
            '</div>');
        $('body').append(notification);
        
        setTimeout(function() {
            notification.fadeOut(500, function() { $(this).remove(); });
        }, 3000);
    }
    
    // Tombol Simpan Data LANGSUNG AKTIF (warna coklat) saat form dibuka
    $('#btnSimpan').prop('disabled', false);
    
    // Ketika item dipilih - update nama_peternak
    $('#nik_select').on('change', function() {
        var selectedData = $(this).select2('data')[0];
        if (selectedData && selectedData.nik) {
            $('#nama_peternak').val(selectedData.nama);
        } else {
            $('#nama_peternak').val('');
        }
    });
    
    // Reset modal saat ditutup
    $('#tambahDataModal').on('hidden.bs.modal', function() {
        $('#formTambah')[0].reset();
        $('#nik_select').val(null).trigger('change');
        $('#btnSimpan').prop('disabled', false);
        $('#nama_peternak').val('');
        
        // Refresh CSRF token
        $.get(baseUrl + 'kepemilikan_jenis_usaha/get_csrf', function(data) {
            if (data.csrf_token) {
                csrfToken = data.csrf_token;
                $('meta[name="csrf-token"]').attr('content', csrfToken);
                $('input[name="' + csrfName + '"]').val(csrfToken);
            }
        });
    });
    
    // Initialize DataTable
    var table = $("#kepemilikanJenisUsahaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                action: function(e, dt, button, config) {
                    window.location.href = baseUrl + "kepemilikan_jenis_usaha/export_excel";
                }
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3,4,5,6] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        lengthChange: false,
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { width: '200px', targets: 5 }
        ]
    });
    
    // Edit button
    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        var nik = $(this).data('nik');
        var nama = $(this).data('nama_peternak');
        var jenis = $(this).data('jenis_usaha');
        var jumlah = $(this).data('jumlah');
        var alamat = $(this).data('alamat');
        var kecamatan = $(this).data('kecamatan');
        var kelurahan = $(this).data('kelurahan');
        var rw = $(this).data('rw');
        var rt = $(this).data('rt');
        var gis_lat = $(this).data('gis_lat');
        var gis_long = $(this).data('gis_long');
        
        $('#edit_id').val(id || '');
        $('#edit_nik').val(nik || '');
        $('#edit_nik_display').val(nik || '');
        $('#edit_nama_peternak').val(nama || '');
        $('#edit_jenis_usaha').val(jenis || '');
        $('#edit_jumlah').val(jumlah || 0);
        $('#edit_alamat').val(alamat || '');
        $('#edit_kecamatan').val(kecamatan || '');
        $('#edit_kelurahan').val(kelurahan || '');
        $('#edit_rw').val(rw || '');
        $('#edit_rt').val(rt || '');
        $('#edit_gis_lat').val((gis_lat && gis_lat !== 'NULL' && gis_lat !== null) ? gis_lat : '');
        $('#edit_gis_long').val((gis_long && gis_long !== 'NULL' && gis_long !== null) ? gis_long : '');
        
        $('#editDataModal').modal('show');
    });
    
    // Delete button
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (confirm("Apakah Anda yakin ingin menghapus data kepemilikan jenis usaha: " + nama + "?")) {
            window.location.href = baseUrl + "kepemilikan_jenis_usaha/hapus/" + id;
        }
    });
    
    // Validate jumlah
    $("input[name='jumlah'], #edit_jumlah").on("input", function() {
        if ($(this).val() < 0) $(this).val(0);
    });
    
    // Filter functions
    function filterData() {
        var search = "";
        var jenisUsaha = $("#filterJenisUsaha").val();
        var kecamatan = $("#filterKecamatan").val();
        
        if (jenisUsaha !== "all") search += jenisUsaha + " ";
        if (kecamatan !== "all") search += kecamatan;
        
        table.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterJenisUsaha, #filterKecamatan").val("all");
        table.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);
    
    // Auto close alerts
    setTimeout(function() { $('.alert').alert('close'); }, 5000);
});

// ========== FUNCTION PRINT ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var tableData = [];
    var totalData = 0;
    var totalJumlah = 0;
    
    var table = $('#kepemilikanJenisUsahaTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
        var jumlah = parseInt(stripHtml(rowData[4]).replace(/\./g, '')) || 0;
        totalJumlah += jumlah;
    });
    
    totalData = tableData.length;
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan Kepemilikan Jenis Usaha</title>');
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
    printWindow.document.write('.total-row td { color: #000000; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA KEPEMILIKAN JENIS USAHA</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>NIK</th>');
    printWindow.document.write('<th>Nama Pelaku Usaha</th>');
    printWindow.document.write('<th>Jenis Usaha</th>');
    printWindow.document.write('<th>Jumlah</th>');
    printWindow.document.write('<th>Kecamatan</th>');
    printWindow.document.write('<th>Alamat</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[4] || '0') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[5] || '-') + '</td>');
        printWindow.document.write('<td>' + stripHtml(row[6] || '-') + '<tr>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="4" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalJumlah) + '</strong></td>');
    printWindow.document.write('<td colspan="2" align="center"><strong>' + formatNumber(totalData) + ' Data</strong></td>');
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