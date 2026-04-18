/**
 * Input Vaksinasi Ternak
 * SIPETGIS - Kota Surabaya
 */

// VARIABEL GLOBAL
var dataTable = null;

// ==================== FUNGSI VALIDASI KOMODITAS ====================
function validateKomoditasRows() {
    var isValid = true;
    var errorMessage = '';
    
    $('.komoditas-row').each(function(index) {
        var komoditas = $(this).find('select[name="komoditas_ternak[]"]').val();
        var jenisVaksin = $(this).find('select[name="jenis_vaksinasi[]"]').val();
        var dosis = $(this).find('select[name="dosis[]"]').val();
        var jumlah = $(this).find('input[name="jumlah[]"]').val();
        
        if (!komoditas || komoditas === '') {
            isValid = false;
            errorMessage = 'Jenis hewan baris ke-' + (index + 1) + ' harus diisi';
            return false;
        }
        
        if (!jenisVaksin || jenisVaksin === '') {
            isValid = false;
            errorMessage = 'Jenis vaksinasi baris ke-' + (index + 1) + ' harus dipilih';
            return false;
        }
        
        if (!dosis || dosis === '') {
            isValid = false;
            errorMessage = 'Dosis baris ke-' + (index + 1) + ' harus dipilih';
            return false;
        }
        
        if (!jumlah || parseInt(jumlah) < 1) {
            isValid = false;
            errorMessage = 'Jumlah baris ke-' + (index + 1) + ' harus diisi (minimal 1)';
            return false;
        }
    });
    
    if (!isValid) {
        alert(errorMessage);
        return false;
    }
    return true;
}

// ==================== FUNGSI LAINNYA ====================
function toggleForm() {
    var formContainer = document.getElementById('formContainer');
    var toggleBtn = document.getElementById('toggleFormBtn');
    
    if (formContainer.classList.contains('show')) {
        formContainer.classList.remove('show');
        toggleBtn.innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI';
    } else {
        formContainer.classList.add('show');
        toggleBtn.innerHTML = '<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT VAKSINASI';
        setTimeout(function() {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
}

function batalForm() {
    resetForm();
    document.getElementById('formContainer').classList.remove('show');
    document.getElementById('toggleFormBtn').innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI';
}

function ambilLokasi() {
    if (navigator.geolocation) {
        var btn = document.getElementById('btnGetLocation');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var accuracy = position.coords.accuracy;
                var formattedLat = lat.toFixed(6);
                var formattedLng = lng.toFixed(6);

                document.getElementById('latitude').value = formattedLat;
                document.getElementById('longitude').value = formattedLng;
                document.getElementById('latitude').classList.remove('is-invalid');
                document.getElementById('longitude').classList.remove('is-invalid');
                document.getElementById('latDisplay').innerText = formattedLat;
                document.getElementById('lngDisplay').innerText = formattedLng;
                document.getElementById('accuracyInfo').innerText = 'Akurasi: ±' + Math.round(accuracy) + ' meter';
                document.getElementById('coordinateInfo').style.display = 'block';
                btn.innerHTML = originalText;
                btn.disabled = false;
                showAlert('success', 'Lokasi berhasil diambil!');
            },
            function(error) {
                var errorMessage = 'Gagal mendapatkan lokasi. ';
                switch(error.code) {
                    case error.PERMISSION_DENIED: errorMessage += 'Izin lokasi ditolak.'; break;
                    case error.POSITION_UNAVAILABLE: errorMessage += 'Informasi lokasi tidak tersedia.'; break;
                    case error.TIMEOUT: errorMessage += 'Waktu permintaan lokasi habis.'; break;
                    default: errorMessage += 'Terjadi kesalahan.';
                }
                btn.innerHTML = originalText;
                btn.disabled = false;
                showAlert('danger', errorMessage);
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        showAlert('danger', 'Browser Anda tidak mendukung geolocation.');
    }
}

function previewFoto(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        if (file.size > 5 * 1024 * 1024) {
            showAlert('danger', 'Ukuran file maksimal 5MB');
            input.value = '';
            return;
        }
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (validTypes.indexOf(file.type) === -1) {
            showAlert('danger', 'Format file harus JPG atau PNG');
            input.value = '';
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
            document.getElementById('photoPlaceholder').style.display = 'none';
            document.getElementById('btnRemovePhoto').style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    }
}

function hapusFoto() {
    document.getElementById('foto_vaksinasi').value = '';
    document.getElementById('photoPreview').style.display = 'none';
    document.getElementById('photoPlaceholder').style.display = 'flex';
    document.getElementById('btnRemovePhoto').style.display = 'none';
}

function filterData() {
    var komoditas = document.getElementById('filterKomoditas').value;
    var kelurahan = document.getElementById('filterKelurahan').value;
    var periode = document.getElementById('filterPeriode').value;
    
    filterTable(komoditas, kelurahan, periode);
}

function resetFilter() {
    document.getElementById('filterKomoditas').value = "all";
    document.getElementById('filterKelurahan').value = "all";
    document.getElementById('filterPeriode').value = "all";
    
    filterTable("all", "all", "all");
}

function filterTable(komoditas, kelurahan, periode) {
    var table = document.getElementById('vaksinasiTable');
    var tr = table.getElementsByTagName('tr');
    
    for (var i = 1; i < tr.length; i++) {
        var tdKomoditas = tr[i].getElementsByTagName('td')[2];
        var tdKelurahan = tr[i].getElementsByTagName('td')[6];
        var tdTahun = tr[i].getElementsByTagName('td')[5];
        
        var show = true;
        
        if (tdKomoditas && komoditas !== "all") {
            if (tdKomoditas.textContent !== komoditas) {
                show = false;
            }
        }
        
        if (tdKelurahan && kelurahan !== "all") {
            if (tdKelurahan.textContent !== kelurahan) {
                show = false;
            }
        }
        
        if (tdTahun && periode !== "all") {
            if (tdTahun.textContent !== periode) {
                show = false;
            }
        }
        
        if (show) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

function resetForm() {
    $('#formContainer').removeClass('show');
    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI');
    $('#formVaksinasi')[0].reset();
    $('#komoditasBody').empty();
    const defaultRow = `<tr class="komoditas-row"><td><select class="form-control komoditas_ternak" name="komoditas_ternak[]" required><option value="">Pilih Hewan</option><option value="Sapi Potong">Sapi Potong</option><option value="Sapi Perah">Sapi Perah</option><option value="Kambing">Kambing</option><option value="Ayam">Ayam</option><option value="Itik">Itik</option><option value="Angsa">Angsa</option><option value="Kalkun">Kalkun</option><option value="Burung">Burung</option></select></td><td><select class="form-control jenis_vaksinasi" name="jenis_vaksinasi[]" required><option value="">Pilih Vaksinasi</option><option value="Vaksinasi PMK">Vaksinasi PMK</option><option value="Vaksinasi ND-AI">Vaksinasi ND-AI</option><option value="Vaksinasi LSD">Vaksinasi LSD</option></select></td><td><select class="form-control dosis" name="dosis[]" required><option value="">Pilih Dosis</option><option value="1">1 (Dosis Pertama)</option><option value="2">2 (Dosis Kedua)</option><option value="Booster">Booster</option></select></td><td><input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Jumlah" min="1" required /></td><td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris"><i class="fas fa-plus"></i></button><button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display: none;" title="Hapus baris"><i class="fas fa-trash"></i></button></td></tr>`;
    $('#komoditasBody').html(defaultRow);
    updateRemoveButtons();
    $('#kecamatan').val(user_kecamatan);
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_vaksinasi').val(today);
    $('#coordinateInfo').hide();
    $('#photoPreview').hide();
    $('#photoPlaceholder').show();
    $('#btnRemovePhoto').hide();
    $('.is-invalid').removeClass('is-invalid');
}

function showAlert(type, message) {
    var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
    $('#alert-container').html(alertHtml);
    setTimeout(function() { 
        $('.alert-dismissible').alert('close'); 
    }, 5000);
}

function showFoto(url) {
    $('#fotoModalImg').attr('src', url);
    $('#fotoModal').modal('show');
}

function updateRemoveButtons() {
    if ($('.komoditas-row').length > 1) {
        $('.btn-remove-row').show();
    } else {
        $('.btn-remove-row').hide();
    }
}

function addKomoditasRow() {
    const newRow = `<tr class="komoditas-row"><td><select class="form-control komoditas_ternak" name="komoditas_ternak[]" required><option value="">Pilih Hewan</option><option value="Sapi Potong">Sapi Potong</option><option value="Sapi Perah">Sapi Perah</option><option value="Kambing">Kambing</option><option value="Ayam">Ayam</option><option value="Itik">Itik</option><option value="Angsa">Angsa</option><option value="Kalkun">Kalkun</option><option value="Burung">Burung</option></select></td><td><select class="form-control jenis_vaksinasi" name="jenis_vaksinasi[]" required><option value="">Pilih Vaksinasi</option><option value="Vaksinasi PMK">Vaksinasi PMK</option><option value="Vaksinasi ND-AI">Vaksinasi ND-AI</option><option value="Vaksinasi LSD">Vaksinasi LSD</option></select></td><td><select class="form-control dosis" name="dosis[]" required><option value="">Pilih Dosis</option><option value="1">1 (Dosis Pertama)</option><option value="2">2 (Dosis Kedua)</option><option value="Booster">Booster</option></select></td><td><input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Jumlah" min="1" required /></td><td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris"><i class="fas fa-plus"></i></button><button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris"><i class="fas fa-trash"></i></button></td></tr>`;
    $('#komoditasBody').append(newRow);
    updateRemoveButtons();
}

function removeKomoditasRow(btn) {
    if ($('.komoditas-row').length > 1) {
        $(btn).closest('tr').remove();
        updateRemoveButtons();
    }
}

// Inisialisasi saat halaman siap
$(document).ready(function() {
    // Set today's date
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_vaksinasi').val(today);
    
    updateRemoveButtons();
    
    // Event untuk tombol add/remove row
    $(document).off('click', '.btn-add-row').on('click', '.btn-add-row', function(e) {
        e.preventDefault();
        addKomoditasRow();
    });
    
    $(document).off('click', '.btn-remove-row').on('click', '.btn-remove-row', function(e) {
        e.preventDefault();
        removeKomoditasRow(this);
    });
    
    // Event untuk tombol filter
    $('#filterBtn').off('click').on('click', function() {
        filterData();
    });
    
    $('#resetBtn').off('click').on('click', function() {
        resetFilter();
    });
    
    console.log("Halaman Input Vaksinasi siap!");
});

// Form Submission
$('#formVaksinasi').off('submit').on('submit', function(e) {
    e.preventDefault();

    const commonFields = ['nama_peternak', 'nama_petugas', 'tanggal_vaksinasi', 'bantuan_prov', 'alamat', 'kelurahan', 'latitude', 'longitude'];
    let isValid = true;

    commonFields.forEach(function(fieldId) {
        $('#' + fieldId).removeClass('is-invalid');
    });

    commonFields.forEach(function(fieldId) {
        const field = $('#' + fieldId);
        if (!field.val() || field.val() === '') {
            field.addClass('is-invalid');
            isValid = false;
        }
    });

    if (!validateKomoditasRows()) {
        isValid = false;
    }

    if (!isValid) {
        showAlert('danger', 'Harap lengkapi semua field yang wajib diisi!');
        return;
    }

    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
    submitBtn.prop('disabled', true);

    var formData = new FormData(this);
    var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
    if (csrfHash) {
        formData.append(csrf_token_name, csrfHash);
    }

    var saveUrl = base_url + 'P_Input_Vaksinasi/save';

    $.ajax({
        url: saveUrl,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                showAlert('success', response.message);
                resetForm();
                $('#formContainer').removeClass('show');
                $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI');
                setTimeout(function() { location.reload(); }, 1500);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            if (xhr.status === 403) {
                showAlert('danger', 'Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
            } else {
                showAlert('danger', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            }
        },
        complete: function() {
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
        }
    });
});