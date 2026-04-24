/**
 * Input Jenis Usaha
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_input').val(today);
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#jenisUsahaTable')) {
        $('#jenisUsahaTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan custom buttons termasuk Print
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
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
            { 
                extend: 'pdf', 
                text: '<i class="fas fa-file-pdf"></i> PDF', 
                className: 'btn btn-sm btn-danger',
                action: function(e, dt, button, config) {
                    printWithCurrentData();
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
        columnDefs: [
            { orderable: false, targets: [7] }
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
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
    });

    // Add Jenis Usaha Row
    function addJenisUsahaRow() {
        const newRow = `
            <tr class="jenis-usaha-row">
                <tr>
                    <select class="form-control jenis_usaha" name="jenis_usaha[]" required>
                        <option value="">Pilih Jenis Usaha</option>
                        <option value="Peternak Ayam">Peternak Ayam</option>
                        <option value="Peternak Domba">Peternak Domba</option>
                        <option value="Peternak Kambing">Peternak Kambing</option>
                        <option value="Peternak Kerbau">Peternak Kerbau</option>
                        <option value="Peternak Kuda">Peternak Kuda</option>
                        <option value="Peternak Sapi">Peternak Sapi</option>
                        <option value="Peternak Unggas">Peternak Unggas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <tr>
                    <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                        <option value="">Pilih Komoditas Ternak</option>
                        <option value="Sapi Potong">Sapi Potong</option>
                        <option value="Sapi Perah">Sapi Perah</option>
                        <option value="Kerbau">Kerbau</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Domba">Domba</option>
                        <option value="Babi">Babi</option>
                        <option value="Kuda">Kuda</option>
                        <option value="Kelinci">Kelinci</option>
                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                        <option value="Ayam Ras Pedaging">Ayam Ras Pedaging</option>
                        <option value="Ayam Kampung">Ayam Kampung</option>
                        <option value="Itik">Itik</option>
                        <option value="Entok">Entok</option>
                        <option value="Burung Puyuh">Burung Puyuh</option>
                        <option value="Campuran">Campuran</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control jumlah" name="jumlah[]" min="0" step="1" placeholder="0" required />
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#jenisUsahaBody').append(newRow);
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

    // ========== PERBAIKAN UTAMA: EVENT HANDLER UNTUK JUMLAH ==========
    // Event 'input' untuk menangani perubahan nilai secara realtime
    $(document).on('input', '.jumlah', function() {
        let val = $(this).val();
        
        // Jika kosong, biarkan kosong (akan divalidasi saat submit)
        if (val === '' || val === null) {
            return;
        }
        
        // Konversi ke number
        let numVal = parseInt(val);
        
        // Jika bukan angka, kosongkan
        if (isNaN(numVal)) {
            $(this).val('');
            return;
        }
        
        // Hanya cegah nilai negatif dengan mengubah ke 0
        if (numVal < 0) {
            $(this).val(0);
            showAlert('warning', 'Jumlah tidak boleh negatif');
            return;
        }
        
        // Untuk nilai positif, biarkan apa adanya (JANGAN DIUBAH)
        // Hilangkan karakter desimal jika ada (karena step="1")
        if (val.includes('.') || val.includes(',')) {
            $(this).val(numVal);
        }
    });
    
    // Event 'blur' untuk membersihkan input kosong menjadi 0
    $(document).on('blur', '.jumlah', function() {
        let val = $(this).val();
        if (val === '' || val === null) {
            $(this).val(0);
        }
    });
    
    // Event 'change' untuk logging (debug) - bisa dihapus jika tidak perlu
    $(document).on('change', '.jumlah', function() {
        console.log('Jumlah changed to:', $(this).val());
    });
    // ========== END PERBAIKAN ==========

    // Input validation for NIK and Telepon (only numbers)
    $('#nik').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, '').slice(0, 16));
    });
    
    $('#telepon').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });

    // Reset Form
    function resetForm() {
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT JENIS USAHA');
        
        $('#jenisUsahaBody').empty();
        const defaultRow = `
            <tr class="jenis-usaha-row">
                <tr>
                    <select class="form-control jenis_usaha" name="jenis_usaha[]" required>
                        <option value="">Pilih Jenis Usaha</option>
                        <option value="Peternak Ayam">Peternak Ayam</option>
                        <option value="Peternak Domba">Peternak Domba</option>
                        <option value="Peternak Kambing">Peternak Kambing</option>
                        <option value="Peternak Kerbau">Peternak Kerbau</option>
                        <option value="Peternak Kuda">Peternak Kuda</option>
                        <option value="Peternak Sapi">Peternak Sapi</option>
                        <option value="Peternak Unggas">Peternak Unggas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <td>
                    <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                        <option value="">Pilih Komoditas Ternak</option>
                        <option value="Sapi Potong">Sapi Potong</option>
                        <option value="Sapi Perah">Sapi Perah</option>
                        <option value="Kerbau">Kerbau</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Domba">Domba</option>
                        <option value="Babi">Babi</option>
                        <option value="Kuda">Kuda</option>
                        <option value="Kelinci">Kelinci</option>
                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                        <option value="Ayam Ras Pedaging">Ayam Ras Pedaging</option>
                        <option value="Ayam Kampung">Ayam Kampung</option>
                        <option value="Itik">Itik</option>
                        <option value="Entok">Entok</option>
                        <option value="Burung Puyuh">Burung Puyuh</option>
                        <option value="Campuran">Campuran</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control jumlah" name="jumlah[]" min="0" step="1" placeholder="0" required />
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row" style="display: none;"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#jenisUsahaBody').html(defaultRow);
        updateRemoveButtons();
        
        $('#formJenisUsaha')[0].reset();
        $('#kecamatan').val(user_kecamatan);
        $('#tanggal_input').val(new Date().toISOString().split('T')[0]);
        $('#coordinateInfo').hide();
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $('#btnRemovePhoto').hide();
        $('.is-invalid').removeClass('is-invalid');
    }

    // Validate Jenis Usaha Rows (TIDAK mengubah nilai jumlah)
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
            
            // PERBAIKAN: Hanya validasi, JANGAN UBAH NILAI
            if (jumlah === '' || jumlah === null || jumlah === undefined) {
                $(this).find('.jumlah').addClass('is-invalid');
                isValid = false;
            } else {
                let numJumlah = parseInt(jumlah);
                if (isNaN(numJumlah)) {
                    $(this).find('.jumlah').addClass('is-invalid');
                    isValid = false;
                } else if (numJumlah < 0) {
                    $(this).find('.jumlah').addClass('is-invalid');
                    isValid = false;
                }
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

    // Photo Upload
    $('#foto_usaha').change(function(e) {
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
        $('#foto_usaha').val('');
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $(this).hide();
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

    // Form Submit dengan logging untuk debugging
    $('#formJenisUsaha').submit(function(e) {
        e.preventDefault();
        
        // LOG: Cek nilai jumlah sebelum submit
        console.log("=== NILAI JUMLAH SEBELUM SUBMIT ===");
        $('.jumlah').each(function(i) {
            console.log(`Baris ${i+1}: ${$(this).val()}`);
        });
        
        let isValid = true;
        const fields = ['nama_peternak', 'nama_petugas', 'tanggal_input', 'kelurahan', 'latitude', 'longitude'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        fields.forEach(f => { if (!$('#' + f).val()) { $('#' + f).addClass('is-invalid'); isValid = false; } });
        
        if (!validateJenisUsahaRows()) isValid = false;
        if (!isValid) return;
        
        // Hitung jumlah baris yang akan diinsert
        let totalRows = $('.jenis-usaha-row').length;
        
        const btn = $(this).find('button[type="submit"]');
        const original = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan ' + totalRows + ' data...').prop('disabled', true);
        
        var formData = new FormData(this);
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        if (csrfHash) {
            formData.append(csrf_token_name, csrfHash);
        }
        
        var saveUrl = base_url + 'P_Input_Jenis_Usaha/save';
        
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

    window.showFoto = function(url) {
        $('#fotoModalImg').attr('src', url);
        $('#fotoModal').modal('show');
    };
});

// Fungsi Print/PDF
function printWithCurrentData() {
    var title = $('#reportTitle').length ? $('#reportTitle').html() : 'DATA JENIS USAHA';
    var subtitle = $('#reportSubtitle').length ? $('#reportSubtitle').html() : 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Jenis Usaha</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.badge-secondary { background-color: #6c757d; color: white; padding: 2px 6px; border-radius: 4px; }');
    printWindow.document.write('.foto-link { color: black; text-decoration: none; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('jenisUsahaTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove(); 
    $(tableContent).find('.dataTables_paginate').remove();
    
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