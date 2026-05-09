/**
 * Input Pemotongan Unggas
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
                            <i class="fas fa-images me-2"></i>Foto Kegiatan Pemotongan (${fotoList.length} foto)
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

// Fungsi Print - Menghapus kolom foto
function printData() {
    var title = 'DATA PEMOTONGAN UNGGAS';
    var subtitle = 'SIPETGIS - Kecamatan ' + (typeof user_kecamatan !== 'undefined' ? user_kecamatan : 'Benowo');
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Pemotongan Unggas</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #832706; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: left; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('td.text-end { text-align: right; }');
    printWindow.document.write('td.text-center { text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('pemotonganTable').cloneNode(true);
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
    $('#tanggal').val(today);
    
    // Hitung total unggas
    function hitungTotal() {
        const ayam = parseInt($('#ayam').val()) || 0;
        const itik = parseInt($('#itik').val()) || 0;
        const dst = parseInt($('#dst').val()) || 0;
        const total = ayam + itik + dst;
        $('#totalUnggas').text(total);
        return total;
    }
    
    $('#ayam, #itik, #dst').on('input', function() {
        hitungTotal();
    });
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#pemotonganTable')) {
        $('#pemotonganTable').DataTable().destroy();
    }
    
    // Initialize DataTable - URUTAN ASC (1,2,3) bukan DESC
    let dataTable = $('#pemotonganTable').DataTable({
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
                    printData();
                }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [9] }
        ]
        // HAPUS order: [[1, 'desc']] - biar urutannya normal 1,2,3
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
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
    });

    // Reset Form
    function resetForm() {
        $('#formPemotongan')[0].reset();
        $('#tanggal').val(new Date().toISOString().split('T')[0]);
        $('#ayam, #itik, #dst').val(0);
        $('#totalUnggas').text('0');
        
        // Reset multiple photos
        selectedFiles = [];
        updatePhotoPreview();
        updatePhotoCount();
        $('#multiplePhotoContainer').show();
        $('#photoPreviewContainer').empty();
        $('#btnRemoveAllPhotos').hide();
        $('#foto_kegiatan').val('');
        
        $('.is-invalid').removeClass('is-invalid');
    }

    // Filter functions
    function filterData() {
        let search = "";
        const daerahAsal = $("#filterDaerahAsal").val();
        const periode = $("#filterPeriode").val();
        const tanggalFilter = $("#filterTanggal").val();
        
        // Hapus filter custom sebelumnya
        $.fn.dataTable.ext.search.pop();
        
        // Buat filter kustom untuk tanggal
        if (tanggalFilter !== "") {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let tanggalTabel = data[1];
                if (!tanggalTabel || tanggalTabel === '-') return false;
                let parts = tanggalTabel.split('-');
                let tanggalData = parts[2] + '-' + parts[1] + '-' + parts[0];
                return tanggalData === tanggalFilter;
            });
        }
        
        if (daerahAsal !== "all") search += daerahAsal + " ";
        if (periode !== "all") search += periode;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterDaerahAsal, #filterPeriode").val("all");
        $("#filterTanggal").val("");
        $.fn.dataTable.ext.search.pop();
        dataTable.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formPemotongan').submit(function(e) {
        e.preventDefault();
        
        const ayam = parseInt($('#ayam').val()) || 0;
        const itik = parseInt($('#itik').val()) || 0;
        const dst = parseInt($('#dst').val()) || 0;
        
        if (ayam <= 0 && itik <= 0 && dst <= 0) {
            showAlert('danger', 'Minimal satu jenis unggas harus diisi dengan jumlah lebih dari 0');
            return;
        }
        
        let isValid = true;
        const fields = ['tanggal', 'daerah_asal', 'nama_petugas'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        fields.forEach(f => { if (!$('#' + f).val()) { $('#' + f).addClass('is-invalid'); isValid = false; } });
        
        if (!isValid) {
            showAlert('danger', 'Harap lengkapi semua field yang wajib diisi');
            return;
        }
        
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
        
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        if (csrfHash) {
            formData.append(csrf_token_name, csrfHash);
        }
        
        var saveUrl = base_url + 'p_input_pemotongan_unggas/save';
        
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
                    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
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