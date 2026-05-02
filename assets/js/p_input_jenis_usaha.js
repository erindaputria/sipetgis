/**
 * Input Kepemilikan Jenis Usaha
 * SIPETGIS - Kota Surabaya
 */

// ========== VARIABEL GLOBAL ==========
let selectedFiles = [];
const MAX_FILES = 5;
const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

// ========== FUNGSI GLOBAL (di luar document ready) ==========

// Fungsi lihat foto multiple
function lihatFoto(basePath, fotoString) {
    console.log('Base Path:', basePath);
    console.log('Foto String:', fotoString);
    
    if (!fotoString || fotoString === '') {
        alert('Tidak ada foto');
        return;
    }
    
    const fotoList = fotoString.split(',');
    console.log('Jumlah foto:', fotoList.length);
    
    let modalHtml = `
        <div class="modal fade" id="modalLihatFoto" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #832706 0%, #6b2005 100%);">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-images me-2"></i>Foto Usaha (${fotoList.length} foto)
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="text-align: center; background: #f8fafc;">
                        <div id="fotoSlider" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="sliderInner"></div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#fotoSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#fotoSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    if ($('#modalLihatFoto').length) {
        $('#modalLihatFoto').remove();
    }
    $('body').append(modalHtml);
    
    const sliderInner = $('#sliderInner');
    sliderInner.empty();
    
    fotoList.forEach((foto, index) => {
        const isActive = index === 0 ? 'active' : '';
        const fotoUrl = basePath + foto;
        
        sliderInner.append(`
            <div class="carousel-item ${isActive}">
                <img src="${fotoUrl}" class="d-block w-100" alt="Foto ${index + 1}" style="max-height: 500px; object-fit: contain;">
                <div class="carousel-caption bg-dark bg-opacity-50 rounded">
                    <p>Foto ${index + 1} dari ${fotoList.length}</p>
                </div>
            </div>
        `);
    });
    
    $('#modalLihatFoto').modal('show');
    
    $('#modalLihatFoto').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

// Fungsi Print/PDF - Menghapus kolom foto
function printWithCurrentData() {
    var title = 'DATA KEPEMILIKAN JENIS USAHA';
    var subtitle = 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Kepemilikan Jenis Usaha</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('jenisUsahaTable').cloneNode(true);
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

// ========== DOCUMENT READY ==========
$(document).ready(function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_input').val(today);
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#jenisUsahaTable')) {
        $('#jenisUsahaTable').DataTable().destroy();
    }
     
    // Initialize DataTable
    let dataTable = $('#jenisUsahaTable').DataTable({
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
        ],
        columnDefs: [
            { orderable: false, targets: [7] }
        ]
    });
    
    // ========== MULTIPLE PHOTO UPLOAD ==========

    // Handle multiple file selection
    $('#foto_usaha').on('change', function(e) {
        const files = Array.from(e.target.files);
        
        if (selectedFiles.length + files.length > MAX_FILES) {
            showAlert('danger', `Maksimal ${MAX_FILES} foto yang dapat diupload. Anda sudah memilih ${selectedFiles.length} foto.`);
            $(this).val('');
            return;
        }
        
        let validFiles = [];
        let errorMessages = [];
        
        for (let file of files) {
            if (file.size > MAX_FILE_SIZE) {
                errorMessages.push(`${file.name} > 5MB`);
                continue;
            }
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                errorMessages.push(`${file.name} (format harus JPG/PNG)`);
                continue;
            }
            validFiles.push(file);
        }
        
        if (errorMessages.length > 0) {
            showAlert('warning', `File tidak valid: ${errorMessages.join(', ')}`);
        }
        
        if (validFiles.length > 0) {
            selectedFiles = [...selectedFiles, ...validFiles];
            updatePhotoPreview();
            updatePhotoCount();
        }
        
        $(this).val('');
    });

    // Update photo preview
    function updatePhotoPreview() {
        const container = $('#photoPreviewContainer');
        container.empty();
        
        if (selectedFiles.length === 0) {
            $('#multiplePhotoContainer').show();
            $('#btnRemoveAllPhotos').hide();
            return;
        }
        
        $('#multiplePhotoContainer').hide();
        $('#btnRemoveAllPhotos').show();
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = $(`
                    <div class="photo-preview-item" data-index="${index}">
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <button type="button" class="btn-remove-photo" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="file-name">${file.name.substring(0, 20)}${file.name.length > 20 ? '...' : ''}</div>
                    </div>
                `);
                container.append(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove single photo
    $(document).on('click', '.btn-remove-photo', function() {
        const index = $(this).data('index');
        selectedFiles.splice(index, 1);
        updatePhotoPreview();
        updatePhotoCount();
        if (selectedFiles.length === 0) {
            $('#multiplePhotoContainer').show();
            $('#btnRemoveAllPhotos').hide();
        }
    });

    // Remove all photos
    $('#btnRemoveAllPhotos').click(function() {
        selectedFiles = [];
        updatePhotoPreview();
        updatePhotoCount();
        $('#multiplePhotoContainer').show();
        $(this).hide();
    });

    // Update photo count display
    function updatePhotoCount() {
        $('#photoCountInfo').text(`${selectedFiles.length} dari ${MAX_FILES} foto dipilih`);
    }
    
    // Toggle Form
    $('#toggleFormBtn').click(function() {
        const formContainer = $('#formContainer');
        formContainer.toggleClass('show');
        if (formContainer.hasClass('show')) {
            $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM');
            $('html, body').animate({ scrollTop: formContainer.offset().top - 50 }, 500);
        } else {
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
    });

    // ========== AUTO FILL DATA PELAKU USAHA BERDASARKAN NIK ==========
    // Event NIK - hanya angka, maksimal 16 digit, dan auto-fill saat 16 digit
    $('#nik').on('input', function() {
        let nik = $(this).val().replace(/\D/g, '').slice(0, 16);
        $(this).val(nik);
        
        if (nik.length === 16) {
            // Panggil fungsi untuk mengambil data pelaku usaha
            getDataPelakuUsahaByNIK(nik);
        } else if (nik.length === 0) {
            // Reset field jika NIK kosong
            resetAutoFillFields();
            $('#nik-status').html('');
        }
    });

    // Fungsi untuk reset field auto-fill
    function resetAutoFillFields() {
        $('#nama_peternak').val('');
        $('#telepon').val('');
        $('#alamat').val('');
        $('#kelurahan').val('');
        $('#rt').val('');
        $('#rw').val('');
    }

    // Fungsi untuk mengambil data pelaku usaha berdasarkan NIK via AJAX
    function getDataPelakuUsahaByNIK(nik) {
        $.ajax({
            url: base_url + 'P_input_jenis_usaha/get_pelaku_usaha_by_nik',
            type: 'POST',
            data: { 
                nik: nik,
                csrf_token_name: $('input[name="' + csrf_token_name + '"]').val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#nik-status').html('<span class="text-info"><i class="fas fa-spinner fa-spin me-1"></i>Mencari data...</span>');
            },
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    // Isi field dengan data yang didapat - FIELD TETAP BISA DIEDIT
                    $('#nama_peternak').val(res.data.nama || '');
                    $('#telepon').val(res.data.telepon || '');
                    $('#alamat').val(res.data.alamat || '');
                    
                    // Set kelurahan jika ada
                    if (res.data.kelurahan) {
                        $('#kelurahan').val(res.data.kelurahan);
                    }
                    
                    $('#rt').val(res.data.rt || '');
                    $('#rw').val(res.data.rw || '');
                    
                    $('#nik-status').html('<span class="text-success"><i class="fas fa-check-circle me-1"></i>Data ditemukan, field terisi otomatis. Anda masih bisa mengedit.</span>');
                    showAlert('success', 'Data pelaku usaha ditemukan, field terisi otomatis. Anda masih bisa mengedit jika perlu.');
                } else {
                    // Kosongkan field jika NIK tidak ditemukan
                    resetAutoFillFields();
                    $('#nik-status').html('<span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>NIK belum terdaftar. Silakan isi manual.</span>');
                    showAlert('warning', 'NIK belum terdaftar di data Pelaku Usaha. Silakan isi manual.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error getting data:', error);
                resetAutoFillFields();
                $('#nik-status').html('<span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Gagal mengambil data. Silakan isi manual.</span>');
            }
        });
    }

    // Validasi NIK dan field lainnya
    $('#formJenisUsaha').on('submit', function(e) {
        const nik = $('#nik').val();
        if (nik && nik.length > 0 && nik.length !== 16) {
            e.preventDefault();
            $('#nik').addClass('is-invalid');
            showAlert('danger', 'NIK harus 16 digit angka');
            return false;
        }
        return true;
    });

    // Add Jenis Usaha Row - VERSI MANUAL MENGGUNAKAN JQUERY
    function addJenisUsahaRow() {
        // Buat elemen baru dengan jQuery
        var $newRow = $('<tr>').addClass('jenis-usaha-row');
        
        // Kolom Jenis Usaha (select)
        var $jenisUsahaTd = $('<tr>');
        var $jenisUsahaSelect = $('<select>').addClass('form-control jenis_usaha').attr('name', 'jenis_usaha[]').attr('required', true);
        var jenisUsahaOptions = [
            {value: '', text: 'Pilih Jenis Usaha'},
            {value: 'Peternak Ayam', text: 'Peternak Ayam'},
            {value: 'Peternak Domba', text: 'Peternak Domba'},
            {value: 'Peternak Kambing', text: 'Peternak Kambing'},
            {value: 'Peternak Kerbau', text: 'Peternak Kerbau'},
            {value: 'Peternak Kuda', text: 'Peternak Kuda'},
            {value: 'Peternak Sapi', text: 'Peternak Sapi'},
            {value: 'Peternak Unggas', text: 'Peternak Unggas'},
            {value: 'Lainnya', text: 'Lainnya'}
        ];
        $.each(jenisUsahaOptions, function(i, opt) {
            $jenisUsahaSelect.append($('<option>').val(opt.value).text(opt.text));
        });
        $jenisUsahaTd.append($jenisUsahaSelect);
        $newRow.append($jenisUsahaTd);
        
        // Kolom Komoditas (select)
        var $komoditasTd = $('</table>');
        var $komoditasSelect = $('<select>').addClass('form-control komoditas_ternak').attr('name', 'komoditas_ternak[]').attr('required', true);
        var komoditasOptions = [
            {value: '', text: 'Pilih Komoditas Ternak'},
            {value: 'Sapi Potong', text: 'Sapi Potong'},
            {value: 'Sapi Perah', text: 'Sapi Perah'},
            {value: 'Kerbau', text: 'Kerbau'},
            {value: 'Kambing', text: 'Kambing'},
            {value: 'Domba', text: 'Domba'},
            {value: 'Babi', text: 'Babi'},
            {value: 'Kuda', text: 'Kuda'},
            {value: 'Kelinci', text: 'Kelinci'},
            {value: 'Ayam Ras Petelur', text: 'Ayam Ras Petelur'},
            {value: 'Ayam Ras Pedaging', text: 'Ayam Ras Pedaging'},
            {value: 'Ayam Kampung', text: 'Ayam Kampung'},
            {value: 'Itik', text: 'Itik'},
            {value: 'Entok', text: 'Entok'},
            {value: 'Burung Puyuh', text: 'Burung Puyuh'},
            {value: 'Campuran', text: 'Campuran'}
        ];
        $.each(komoditasOptions, function(i, opt) {
            $komoditasSelect.append($('<option>').val(opt.value).text(opt.text));
        });
        $komoditasTd.append($komoditasSelect);
        $newRow.append($komoditasTd);
        
        // Kolom Jumlah (input number)
        var $jumlahTd = $('<tr>');
        var $jumlahInput = $('<input>').addClass('form-control jumlah').attr({
            type: 'number',
            name: 'jumlah[]',
            min: 0,
            step: 1,
            placeholder: '0',
            required: true
        });
        $jumlahTd.append($jumlahInput);
        $newRow.append($jumlahTd);
        
        // Kolom Aksi (button)
        var $aksiTd = $('<tr>').addClass('text-center');
        var $btnAdd = $('<button>').addClass('btn btn-sm btn-add-row').attr('type', 'button').html('<i class="fas fa-plus"></i>');
        var $btnRemove = $('<button>').addClass('btn btn-sm btn-remove-row').attr('type', 'button').html('<i class="fas fa-trash"></i>');
        $aksiTd.append($btnAdd, $btnRemove);
        $newRow.append($aksiTd);
        
        // Append ke body tabel
        $('#jenisUsahaBody').append($newRow);
        updateRemoveButtons();
    }

    // Remove Jenis Usaha Row
    function removeJenisUsahaRow(btn) {
        if ($('.jenis-usaha-row').length > 1) {
            $(btn).closest('tr').remove();
            updateRemoveButtons();
        }
    }

    // Update Remove Buttons
    function updateRemoveButtons() {
        if ($('.jenis-usaha-row').length > 1) {
            $('.btn-remove-row').show();
        } else {
            $('.btn-remove-row').hide();
        }
    }

    // Event handlers
    $(document).on('click', '.btn-add-row', function() { addJenisUsahaRow(); });
    $(document).on('click', '.btn-remove-row', function() { removeJenisUsahaRow(this); });

    // Input validation for Telepon
    $('#telepon').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    // Reset Form
    function resetForm() {
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
        
        $('#jenisUsahaBody').empty();
        
        // Buat default row menggunakan jQuery
        var $defaultRow = $('<tr>').addClass('jenis-usaha-row');
        
        // Kolom Jenis Usaha
        var $jenisUsahaTd = $('<tr>');
        var $jenisUsahaSelect = $('<select>').addClass('form-control jenis_usaha').attr('name', 'jenis_usaha[]').attr('required', true);
        var jenisUsahaOptions = [
            {value: '', text: 'Pilih Jenis Usaha'},
            {value: 'Peternak Ayam', text: 'Peternak Ayam'},
            {value: 'Peternak Domba', text: 'Peternak Domba'},
            {value: 'Peternak Kambing', text: 'Peternak Kambing'},
            {value: 'Peternak Kerbau', text: 'Peternak Kerbau'},
            {value: 'Peternak Kuda', text: 'Peternak Kuda'},
            {value: 'Peternak Sapi', text: 'Peternak Sapi'},
            {value: 'Peternak Unggas', text: 'Peternak Unggas'},
            {value: 'Lainnya', text: 'Lainnya'}
        ];
        $.each(jenisUsahaOptions, function(i, opt) {
            $jenisUsahaSelect.append($('<option>').val(opt.value).text(opt.text));
        });
        $jenisUsahaTd.append($jenisUsahaSelect);
        $defaultRow.append($jenisUsahaTd);
        
        // Kolom Komoditas
        var $komoditasTd = $('<tr>');
        var $komoditasSelect = $('<select>').addClass('form-control komoditas_ternak').attr('name', 'komoditas_ternak[]').attr('required', true);
        var komoditasOptions = [
            {value: '', text: 'Pilih Komoditas Ternak'},
            {value: 'Sapi Potong', text: 'Sapi Potong'},
            {value: 'Sapi Perah', text: 'Sapi Perah'},
            {value: 'Kerbau', text: 'Kerbau'},
            {value: 'Kambing', text: 'Kambing'},
            {value: 'Domba', text: 'Domba'},
            {value: 'Babi', text: 'Babi'},
            {value: 'Kuda', text: 'Kuda'},
            {value: 'Kelinci', text: 'Kelinci'},
            {value: 'Ayam Ras Petelur', text: 'Ayam Ras Petelur'},
            {value: 'Ayam Ras Pedaging', text: 'Ayam Ras Pedaging'},
            {value: 'Ayam Kampung', text: 'Ayam Kampung'},
            {value: 'Itik', text: 'Itik'},
            {value: 'Entok', text: 'Entok'},
            {value: 'Burung Puyuh', text: 'Burung Puyuh'},
            {value: 'Campuran', text: 'Campuran'}
        ];
        $.each(komoditasOptions, function(i, opt) {
            $komoditasSelect.append($('<option>').val(opt.value).text(opt.text));
        });
        $komoditasTd.append($komoditasSelect);
        $defaultRow.append($komoditasTd);
        
        // Kolom Jumlah
        var $jumlahTd = $('<tr>');
        var $jumlahInput = $('<input>').addClass('form-control jumlah').attr({
            type: 'number',
            name: 'jumlah[]',
            min: 0,
            step: 1,
            placeholder: '0',
            required: true
        });
        $jumlahTd.append($jumlahInput);
        $defaultRow.append($jumlahTd);
        
        // Kolom Aksi
        var $aksiTd = $('<tr>').addClass('text-center');
        var $btnAdd = $('<button>').addClass('btn btn-sm btn-add-row').attr('type', 'button').html('<i class="fas fa-plus"></i>');
        var $btnRemove = $('<button>').addClass('btn btn-sm btn-remove-row').attr('type', 'button').css('display', 'none').html('<i class="fas fa-trash"></i>');
        $aksiTd.append($btnAdd, $btnRemove);
        $defaultRow.append($aksiTd);
        
        $('#jenisUsahaBody').append($defaultRow);
        updateRemoveButtons();
        
        // Reset form lainnya
        $('#formJenisUsaha')[0].reset();
        $('#kecamatan').val(user_kecamatan);
        $('#tanggal_input').val(new Date().toISOString().split('T')[0]);
        $('#coordinateInfo').hide();
        $('#nik-status').html('');
        
        // Reset multiple photos
        selectedFiles = [];
        updatePhotoPreview();
        updatePhotoCount();
        $('#multiplePhotoContainer').show();
        $('#photoPreviewContainer').empty();
        $('#btnRemoveAllPhotos').hide();
        $('#foto_usaha').val('');
        
        $('.is-invalid').removeClass('is-invalid');
    }

    // Validate Jenis Usaha Rows
    function validateJenisUsahaRows() {
        let isValid = true;
        $('.jenis-usaha-row').each(function(index) {
            const jenisUsaha = $(this).find('.jenis_usaha').val();
            const komoditas = $(this).find('.komoditas_ternak').val();
            let jumlah = $(this).find('.jumlah').val();
            
            $(this).find('.jenis_usaha, .komoditas_ternak, .jumlah').removeClass('is-invalid');
            
            if (!jenisUsaha) {
                $(this).find('.jenis_usaha').addClass('is-invalid');
                isValid = false;
            }
            if (!komoditas) {
                $(this).find('.komoditas_ternak').addClass('is-invalid');
                isValid = false;
            }
            if (jumlah === '' || jumlah === null || jumlah === undefined || parseInt(jumlah) < 0) {
                $(this).find('.jumlah').addClass('is-invalid');
                isValid = false;
            }
        });
        if (!isValid) showAlert('danger', 'Harap lengkapi data jenis usaha dan komoditas');
        return isValid;
    }

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

    // Filter functions
    function filterData() {
        let search = "";
        const jenisUsaha = $("#filterJenisUsaha").val();
        const komoditas = $("#filterKomoditas").val();
        const kelurahan = $("#filterKelurahan").val();
        
        if (jenisUsaha !== "all") search += jenisUsaha + " ";
        if (komoditas !== "all") search += komoditas + " ";
        if (kelurahan !== "all") search += kelurahan;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterJenisUsaha, #filterKomoditas, #filterKelurahan").val("all");
        dataTable.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formJenisUsaha').submit(function(e) {
        e.preventDefault();
        
        let isValid = true;
        const fields = ['nama_peternak', 'nama_petugas', 'tanggal_input', 'alamat', 'kelurahan', 'latitude', 'longitude', 'nik'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        fields.forEach(f => { if (!$('#' + f).val()) { $('#' + f).addClass('is-invalid'); isValid = false; } });
        
        // Validasi NIK harus 16 digit jika diisi
        const nikValue = $('#nik').val();
        if (nikValue && nikValue.length > 0 && nikValue.length !== 16) {
            $('#nik').addClass('is-invalid');
            isValid = false;
            showAlert('danger', 'NIK harus 16 digit angka');
        }
        
        if (!validateJenisUsahaRows()) isValid = false;
        if (!isValid) return;
        
        const btn = $(this).find('button[type="submit"]');
        const original = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
        
        var formData = new FormData(this);
        
        // Remove existing foto_usaha files from FormData
        formData.delete('foto_usaha[]');
        
        // Add multiple files
        for (let i = 0; i < selectedFiles.length; i++) {
            formData.append('foto_usaha[]', selectedFiles[i]);
        }
        
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        if (csrfHash) {
            formData.append(csrf_token_name, csrfHash);
        }
        
        var saveUrl = base_url + 'P_input_jenis_usaha/save';
        
        $.ajax({
            url: saveUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    showAlert('success', res.message);
                    resetForm();
                    $('#formContainer').removeClass('show');
                    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                if (xhr.status === 403) {
                    showAlert('danger', 'Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
                } else {
                    showAlert('danger', 'Gagal menyimpan data. Silakan coba lagi.');
                }
            },
            complete: function() { btn.html(original).prop('disabled', false); } 
        });
    });

    function showAlert(type, msg) {
        $('#alert-container').html('<div class="alert alert-' + type + ' alert-dismissible fade show">' + msg + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
        setTimeout(function() { $('.alert').alert('close'); }, 5000);
    }
});