/**
 * Input Pelaku Usaha
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Initialize DataTable
    let dataTable = $('#pelakuUsahaTable').DataTable({
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
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50, 100],
        responsive: true,
        order: [[0, 'asc']],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
            { 
                extend: 'print', 
                text: '<i class="fas fa-print"></i> Print', 
                className: 'btn btn-sm btn-info',
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ]
    });
    
    // Toggle Form
    $('#toggleFormBtn').click(function() {
        const formContainer = $('#formContainer');
        formContainer.toggleClass('show');
        if (formContainer.hasClass('show')) {
            $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM');
            $('html, body').animate({ scrollTop: formContainer.offset().top - 50 }, 500);
        } else {
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
    });

    // Get Location
    $('#btnGetLocation').click(function() {
        if (navigator.geolocation) {
            const btn = $(this);
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengambil...').prop('disabled', true);
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude.toFixed(6);
                    const lng = pos.coords.longitude.toFixed(6);
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);
                    $('#latDisplay').text(lat);
                    $('#lngDisplay').text(lng);
                    $('#accuracyInfo').text('Akurasi: ' + Math.round(pos.coords.accuracy) + ' meter');
                    $('#coordinateInfo').show();
                    btn.html(originalText).prop('disabled', false);
                    showAlert('success', 'Lokasi berhasil diambil');
                },
                function(error) {
                    let msg = 'Gagal mengambil lokasi. ';
                    if (error.code === 1) msg += 'Izin ditolak.';
                    else if (error.code === 2) msg += 'Lokasi tidak tersedia.';
                    else msg += 'Coba lagi.';
                    btn.html(originalText).prop('disabled', false);
                    showAlert('danger', msg);
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            showAlert('danger', 'Browser tidak mendukung geolocation');
        }
    });

    // Photo Upload
    $('#foto').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                showAlert('danger', 'Ukuran file maksimal 5MB');
                $(this).val('');
                return;
            }
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (validTypes.indexOf(file.type) === -1) {
                showAlert('danger', 'Format harus JPG/PNG');
                $(this).val('');
                return;
            } 
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').attr('src', e.target.result).show();
                $('#photoPlaceholder').hide();
                $('#btnRemovePhoto').show();
            };
            reader.readAsDataURL(file);
        }
    });

    $('#btnRemovePhoto').click(function() {
        $('#foto').val('');
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $(this).hide();
    });

    // NIK Validation
    $('#nik').on('input', function() {
        let nik = $(this).val().replace(/\D/g, '').slice(0, 16);
        $(this).val(nik);
        
        if (nik.length === 16) {
            checkNIK(nik);
        } else {
            $('#nik-status').html('');
            $('#nik').removeClass('is-invalid');
        }
    });

    // Telepon - hanya angka
    $('#telepon').on('input', function() {
        let telepon = $(this).val().replace(/\D/g, '');
        $(this).val(telepon);
    });

    // Check NIK duplicate via AJAX
    function checkNIK(nik) {
        $.ajax({
            url: base_url + 'P_input_pelaku_usaha/check_nik',
            type: 'POST',
            data: { nik: nik, csrf_token_name: $('input[name="' + csrf_token_name + '"]').val() },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'exist') {
                    $('#nik-status').html('<span class="text-danger"><i class="fas fa-times-circle me-1"></i>' + res.message + '</span>');
                    $('#nik').addClass('is-invalid');
                } else {
                    $('#nik-status').html('<span class="text-success"><i class="fas fa-check-circle me-1"></i>NIK tersedia</span>');
                    $('#nik').removeClass('is-invalid');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking NIK:', error);
            }
        });
    }

    function resetForm() {
        $('#formPelakuUsaha')[0].reset();
        $('#coordinateInfo').hide();
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $('#btnRemovePhoto').hide();
        $('#nik-status').html('');
        $('.is-invalid').removeClass('is-invalid');
        
        // Load kelurahan untuk kecamatan yang sudah ditentukan
        loadKelurahan(user_kecamatan);
    }
    
    // Load kelurahan based on kecamatan
    function loadKelurahan(kecamatan) {
        if (!kecamatan || kecamatan === '') {
            $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
            return;
        }
        
        $('#kelurahan').empty().append('<option value="">Memuat kelurahan...</option>');
        
        $.ajax({
            url: base_url + 'P_input_pelaku_usaha/get_kelurahan_by_kecamatan',
            type: 'POST',
            data: { 
                kecamatan: kecamatan,
                csrf_token_name: $('input[name="' + csrf_token_name + '"]').val()
            },
            dataType: 'json',
            success: function(data) {
                var $kelurahanSelect = $('#kelurahan');
                $kelurahanSelect.empty();
                $kelurahanSelect.append('<option value="">Pilih Kelurahan</option>');
                
                if (data && data.length > 0) {
                    $.each(data, function(index, kel) {
                        $kelurahanSelect.append('<option value="' + kel + '">' + kel + '</option>');
                    });
                } else {
                    $kelurahanSelect.append('<option value="">Tidak ada kelurahan</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading kelurahan:', error);
                $('#kelurahan').empty().append('<option value="">Gagal memuat kelurahan</option>');
            }
        });
    }
    
    // Event listener untuk perubahan kecamatan
    $('#kecamatan').change(function() {
        var selectedKec = $(this).val();
        if (selectedKec && selectedKec !== '') {
            loadKelurahan(selectedKec);
        } else {
            $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
        }
    });
    
    // Load kelurahan awal
    if ($('#kecamatan').val() && $('#kecamatan').val() !== '') {
        loadKelurahan($('#kecamatan').val());
    }

    // ========== FILTER FUNCTIONS ==========
    
    // Filter Data
    function filterData() {
        let kelurahan = $('#filterKelurahan').val();
        let periode = $('#filterPeriode').val();
        
        // Reset semua filter di DataTable terlebih dahulu
        dataTable.search('').columns().search('');
        
        // Filter berdasarkan kelurahan (kolom index 5 - Kelurahan)
        if (kelurahan && kelurahan !== 'all') {
            dataTable.column(5).search(kelurahan).draw();
        } else {
            dataTable.column(5).search('').draw();
        }
        
        // Filter berdasarkan periode (tahun) dari kolom created_at atau tanggal_input
        // Karena tanggal tidak ditampilkan di tabel, kita perlu reload halaman dengan parameter tahun
        if (periode && periode !== 'all') {
            // Reload halaman dengan parameter tahun
            window.location.href = base_url + 'P_input_pelaku_usaha/index?tahun=' + periode;
        }
    }
    
    // Reset Filter
    function resetFilter() {
        // Reset select elements
        $('#filterKelurahan').val('all');
        $('#filterPeriode').val('all');
        
        // Reload halaman tanpa parameter
        window.location.href = base_url + 'P_input_pelaku_usaha';
    }
    
    // Event listeners untuk filter
    $('#filterBtn').click(filterData);
    $('#resetBtn').click(resetFilter);
    
    // Jika ada parameter tahun di URL, set filter periode sesuai
    let urlParams = new URLSearchParams(window.location.search);
    let tahunParam = urlParams.get('tahun');
    if (tahunParam) {
        $('#filterPeriode').val(tahunParam);
    }

    // ========== FORM SUBMIT ==========
    
    $('#formPelakuUsaha').submit(function(e) {
        e.preventDefault();
        
        let isValid = true;
        const fields = ['nama', 'nik', 'alamat', 'kecamatan', 'kelurahan', 'latitude', 'longitude', 'nama_petugas'];
        
        fields.forEach(f => { 
            $('#' + f).removeClass('is-invalid'); 
        });
        
        fields.forEach(f => { 
            const val = $('#' + f).val();
            if (!val || val.trim() === '') { 
                $('#' + f).addClass('is-invalid'); 
                isValid = false; 
            } 
        });
        
        const nikValue = $('#nik').val();
        if (nikValue.length !== 16) {
            $('#nik').addClass('is-invalid');
            isValid = false;
            showAlert('danger', 'NIK harus 16 digit angka');
        }
        
        const teleponValue = $('#telepon').val();
        if (teleponValue && teleponValue.length > 0 && !/^\d+$/.test(teleponValue)) {
            $('#telepon').addClass('is-invalid');
            isValid = false;
            showAlert('danger', 'Telepon harus berupa angka');
        } else {
            $('#telepon').removeClass('is-invalid');
        }
        
        if (!isValid) {
            showAlert('danger', 'Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
        var formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
        
        $.ajax({
            url: base_url + 'P_input_pelaku_usaha/save',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    showAlert('success', response.message);
                    resetForm();
                    $('#formContainer').removeClass('show');
                    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                let errorMsg = 'Terjadi kesalahan saat menyimpan data';
                if (xhr.responseText) {
                    const match = xhr.responseText.match(/<p>(.*?)<\/p>/);
                    if (match && match[1]) {
                        errorMsg = match[1];
                    }
                }
                showAlert('danger', errorMsg);
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    function showAlert(type, msg) {
        $('#alert-container').html('<div class="alert alert-' + type + ' alert-dismissible fade show">' + msg + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        setTimeout(function() { $('.alert').alert('close'); }, 5000);
    }

    window.showFoto = function(url) {
        $('#fotoModalImg').attr('src', url);
        $('#fotoModal').modal('show');
    };
});

// Fungsi Print/PDF - Menghapus kolom foto
function printWithCurrentData() {
    var title = $('#reportTitle').length ? $('#reportTitle').html() : 'DATA PELAKU USAHA';
    var subtitle = $('#reportSubtitle').length ? $('#reportSubtitle').html() : 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Pelaku Usaha</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.badge-secondary { background-color: #6c757d; color: white; padding: 2px 6px; border-radius: 4px; }');
    printWindow.document.write('.foto-thumbnail { max-width: 50px; max-height: 50px; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('pelakuUsahaTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    
    // HAPUS KOLOM FOTO (kolom terakhir)
    $(tableContent).find('thead tr').each(function() {
        $(this).find('th:last-child').remove();
    });
    
    $(tableContent).find('tbody tr').each(function() {
        $(this).find('td:last-child').remove();
    });
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + title + '</h2>');
    printWindow.document.write('<p>' + subtitle + '</p>');
    printWindow.document.write('<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}