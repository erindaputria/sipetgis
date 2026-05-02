/**
 * Input RPU (Rumah Potong Unggas)
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
                            <i class="fas fa-images me-2"></i>Foto Kegiatan RPU (${fotoList.length} foto)
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
    var title = 'DATA RPU (RUMAH POTONG UNGGAS)';
    var subtitle = 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data RPU</title>');
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
    
    var tableContent = document.getElementById('rpuTable').cloneNode(true);
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
    $('#tanggal_rpu').val(today);
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#rpuTable')) {
        $('#rpuTable').DataTable().destroy();
    }
    
    // Initialize DataTable
    let dataTable = $('#rpuTable').DataTable({
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
            { orderable: false, targets: [8] }
        ]
    });
    
    // ========== MULTIPLE PHOTO UPLOAD ==========

    // Handle multiple file selection
    $('#foto_kegiatan').on('change', function(e) {
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
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT RPU');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT RPU');
    });

       // Add Komoditas Row
    function addKomoditasRow() {
        const newRow = `
            <tr class="komoditas-row">
                <td>
                    <select class="form-control komoditas" name="komoditas[]" required>
                        <option value="">Pilih Komoditas</option>
                        <option value="Ayam Kampung">Ayam Kampung</option>
                        <option value="Ayam Broiler">Ayam Broiler</option>
                        <option value="Layer Afkir">Layer Afkir</option>
                        <option value="Layer Jantan">Layer Jantan</option>
                        <option value="Itik">Itik</option>
                        <option value="Entok">Entok</option>
                    </select>
                 </th>
                <td>
                    <input type="number" class="form-control jumlah_ekor" name="jumlah_ekor[]" min="1" placeholder="Ekor" required />
                 </th>
                <td>
                    <input type="number" step="0.1" class="form-control berat_kg" name="berat_kg[]" min="0.1" placeholder="Kg" required />
                 </th>
                <td>
                    <select class="form-control asal_unggas" name="asal_unggas[]" required>
                        <option value="">Pilih Asal</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Luar Surabaya">Luar Surabaya</option>
                    </select>
                 </th>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row"><i class="fas fa-trash"></i></button>
                 </th>
             </tr>
        `;
        $('#komoditasBody').append(newRow);
        updateRemoveButtons();
    }

    // Remove Komoditas Row
    function removeKomoditasRow(btn) {
        if ($('.komoditas-row').length > 1) {
            $(btn).closest('tr').remove();
            updateRemoveButtons();
        }
    }

    // Update Remove Buttons
    function updateRemoveButtons() {
        if ($('.komoditas-row').length > 1) {
            $('.btn-remove-row').show();
        } else {
            $('.btn-remove-row').hide();
        }
    }

    // Event handlers
    $(document).on('click', '.btn-add-row', function() { addKomoditasRow(); });
    $(document).on('click', '.btn-remove-row', function() { removeKomoditasRow(this); });

        // Validate Komoditas Rows
    function validateKomoditasRows() {
        let isValid = true;
        $('.komoditas-row').each(function(index) {
            const komoditas = $(this).find('select[name="komoditas[]"]').val();
            const jumlah = $(this).find('input[name="jumlah_ekor[]"]').val();
            const berat = $(this).find('input[name="berat_kg[]"]').val();
            const asal = $(this).find('select[name="asal_unggas[]"]').val();
            
            $(this).find('select[name="komoditas[]"], input[name="jumlah_ekor[]"], input[name="berat_kg[]"], select[name="asal_unggas[]"]').removeClass('is-invalid');
            
            if (!komoditas) {
                $(this).find('select[name="komoditas[]"]').addClass('is-invalid');
                isValid = false;
            }
            if (!jumlah || parseInt(jumlah) < 1) {
                $(this).find('input[name="jumlah_ekor[]"]').addClass('is-invalid');
                isValid = false;
            }
            if (!berat || parseFloat(berat) <= 0) {
                $(this).find('input[name="berat_kg[]"]').addClass('is-invalid');
                isValid = false;
            }
            if (!asal) {
                $(this).find('select[name="asal_unggas[]"]').addClass('is-invalid');
                isValid = false;
            }
        });
        if (!isValid) showAlert('danger', 'Harap lengkapi data komoditas');
        return isValid;
    }

    // Handle RPU Baru option
    $('#pejagal').on('change', function() {
        if ($(this).val() === 'RPU Baru') {
            $('#rpuBaruContainer').show();
            $('#pejagal_baru').prop('required', true);
        } else {
            $('#rpuBaruContainer').hide();
            $('#pejagal_baru').prop('required', false);
        }
    });

    // NIK Validation
    $('#nik_pj').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, '').slice(0, 16));
    });

    const defaultRow = `
            <tr class="komoditas-row"> 
                <td>
                    <select class="form-control komoditas" name="komoditas[]" required>
                        <option value="">Pilih Komoditas</option>
                        <option value="Ayam Kampung">Ayam Kampung</option>
                        <option value="Ayam Broiler">Ayam Broiler</option>
                        <option value="Layer Afkir">Layer Afkir</option>
                        <option value="Layer Jantan">Layer Jantan</option>
                        <option value="Itik">Itik</option>
                        <option value="Entok">Entok</option>
                    </select>
                 </th>
                <td>
                    <input type="number" class="form-control jumlah_ekor" name="jumlah_ekor[]" min="1" placeholder="Ekor" required />
                 </th>
                <td>
                    <input type="number" step="0.1" class="form-control berat_kg" name="berat_kg[]" min="0.1" placeholder="Kg" required />
                 </th>
                <td>
                    <select class="form-control asal_unggas" name="asal_unggas[]" required>
                        <option value="">Pilih Asal</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Luar Surabaya">Luar Surabaya</option>
                    </select>
                 </th>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row" style="display: none;"><i class="fas fa-trash"></i></button>
                 </th>
             </tr>
        `;

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
        const pejagal = $("#filterPejagal").val();
        const komoditas = $("#filterKomoditas").val();
        const kelurahan = $("#filterKelurahan").val();
        
        if (pejagal !== "all") search += pejagal + " ";
        if (komoditas !== "all") search += komoditas + " ";
        if (kelurahan !== "all") search += kelurahan;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterPejagal, #filterKomoditas, #filterKelurahan").val("all");
        dataTable.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formRpu').submit(function(e) {
        e.preventDefault();
        let isValid = true;
        
        const fields = ['tanggal_rpu', 'nama_pj', 'nama_petugas', 'lokasi', 'kelurahan', 'latitude', 'longitude'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        fields.forEach(f => { if (!$('#' + f).val()) { $('#' + f).addClass('is-invalid'); isValid = false; } });
        
        const pejagal = $('#pejagal').val();
        if (!pejagal) {
            $('#pejagal').addClass('is-invalid');
            isValid = false;
        }
        
        if (pejagal === 'RPU Baru') {
            const pejagalBaru = $('#pejagal_baru').val();
            if (!pejagalBaru) {
                $('#pejagal_baru').addClass('is-invalid');
                isValid = false;
            }
        }
        
        if (!validateKomoditasRows()) isValid = false;
        if (!isValid) return;
        
        const btn = $(this).find('button[type="submit"]');
        const original = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
        
        var formData = new FormData(this);
        
        // Remove existing foto_kegiatan files from FormData
        formData.delete('foto_kegiatan[]');
        
        // Add multiple files
        for (let i = 0; i < selectedFiles.length; i++) {
            formData.append('foto_kegiatan[]', selectedFiles[i]);
        }
        
        // Jika memilih RPU Baru, gunakan nilai dari input baru
        if (pejagal === 'RPU Baru') {
            formData.set('pejagal', $('#pejagal_baru').val());
        }
        
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        if (csrfHash) {
            formData.append(csrf_token_name, csrfHash);
        }
        
        var saveUrl = base_url + 'p_input_rpu/save';
        
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
                    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT RPU');
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