/**
 * Input Pengobatan Ternak
 * SIPETGIS - Kota Surabaya
 */

$(document).ready(function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_pengobatan').val(today);
    
    // Initialize DataTable dengan custom buttons termasuk Print
    let dataTable = $('#pengobatanTable').DataTable({
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
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PENGOBATAN');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
    });

    // Add Komoditas Row
    function addKomoditasRow() {
        const newRow = `
            <tr class="komoditas-row">
                <td>
                    <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                        <option value="">Pilih Komoditas</option>
                        <option value="Sapi Potong">Sapi Potong</option>
                        <option value="Sapi Perah">Sapi Perah</option>
                        <option value="Kerbau">Kerbau</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Domba">Domba</option>
                        <option value="Kura-Kura">Kura-Kura</option>
                        <option value="Kuda">Kuda</option>
                        <option value="Kelinci">Kelinci</option>
                        <option value="Ayam">Ayam</option>
                        <option value="Itik">Itik</option>
                        <option value="Kucing">Kucing</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control gejala_klinis" name="gejala_klinis[]" rows="2" placeholder="Gejala klinis" required></textarea>
                </td>
                <td>
                    <textarea class="form-control jenis_pengobatan" name="jenis_pengobatan[]" rows="2" placeholder="Jenis pengobatan" required></textarea>
                </td>
                <td>
                    <input type="number" class="form-control jumlah" name="jumlah[]" min="1" required />
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row"><i class="fas fa-trash"></i></button>
                </td>
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
            const komoditas = $(this).find('.komoditas_ternak').val();
            const gejala = $(this).find('.gejala_klinis').val();
            const jenis = $(this).find('.jenis_pengobatan').val();
            const jumlah = $(this).find('.jumlah').val();
            
            $(this).find('.komoditas_ternak, .gejala_klinis, .jenis_pengobatan, .jumlah').removeClass('is-invalid');
            
            if (!komoditas) {
                $(this).find('.komoditas_ternak').addClass('is-invalid');
                isValid = false;
            }
            if (!gejala || gejala.trim() === '') {
                $(this).find('.gejala_klinis').addClass('is-invalid');
                isValid = false;
            }
            if (!jenis || jenis.trim() === '') {
                $(this).find('.jenis_pengobatan').addClass('is-invalid');
                isValid = false;
            }
            if (!jumlah || parseInt(jumlah) < 1) {
                $(this).find('.jumlah').addClass('is-invalid');
                isValid = false;
            }
        });
        if (!isValid) showAlert('danger', 'Harap lengkapi data komoditas');
        return isValid;
    }

    // Reset Form
    function resetForm() {
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PENGOBATAN');
        
        $('#komoditasBody').empty();
        const defaultRow = `
            <tr class="komoditas-row">
                <td>
                    <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                        <option value="">Pilih Komoditas</option>
                        <option value="Sapi Potong">Sapi Potong</option>
                        <option value="Sapi Perah">Sapi Perah</option>
                        <option value="Kerbau">Kerbau</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Domba">Domba</option>
                        <option value="Kura-Kura">Kura-Kura</option>
                        <option value="Kuda">Kuda</option>
                        <option value="Kelinci">Kelinci</option>
                        <option value="Ayam">Ayam</option>
                        <option value="Itik">Itik</option>
                        <option value="Kucing">Kucing</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control gejala_klinis" name="gejala_klinis[]" rows="2" placeholder="Gejala klinis" required></textarea>
                </td>
                <td>
                    <textarea class="form-control jenis_pengobatan" name="jenis_pengobatan[]" rows="2" placeholder="Jenis pengobatan" required></textarea>
                </td>
                <td>
                    <input type="number" class="form-control jumlah" name="jumlah[]" min="1" required />
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-sm btn-remove-row" style="display: none;"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#komoditasBody').html(defaultRow);
        updateRemoveButtons();
        
        $('#formPengobatan')[0].reset();
        $('#kecamatan').val(user_kecamatan);
        $('#tanggal_pengobatan').val(new Date().toISOString().split('T')[0]);
        $('#coordinateInfo').hide();
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $('#btnRemovePhoto').hide();
        $('#alamat').val('');
        $('.is-invalid').removeClass('is-invalid');
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
    $('#foto_pengobatan').change(function(e) {
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
        $('#foto_pengobatan').val('');
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $(this).hide();
    });

    // Filter
    function filterData() {
        let search = "";
        const komoditas = $("#filterKomoditas").val();
        const kelurahan = $("#filterKelurahan").val();
        const periode = $("#filterPeriode").val();
        if (komoditas !== "all") search += komoditas;
        if (kelurahan !== "all") search += (search ? " " : "") + kelurahan;
        if (periode !== "all") search += (search ? " " : "") + periode;
        dataTable.search(search).draw();
    }
    function resetFilter() {
        $("#filterKomoditas, #filterKelurahan, #filterPeriode").val("all");
        dataTable.search("").draw();
    }
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formPengobatan').submit(function(e) {
        e.preventDefault();
        let isValid = true;
        
        // Validasi field wajib termasuk ALAMAT
        const fields = ['nama_peternak', 'nama_petugas', 'tanggal_pengobatan', 'bantuan_prov', 'kelurahan', 'latitude', 'longitude', 'alamat'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        
        fields.forEach(f => { 
            if (!$('#' + f).val()) { 
                $('#' + f).addClass('is-invalid'); 
                isValid = false; 
            } 
        });
        
        if (!$('#keterangan').val()) {
            $('#keterangan').addClass('is-invalid');
            isValid = false;
        } else {
            $('#keterangan').removeClass('is-invalid');
        }
        
        if (!validateKomoditasRows()) isValid = false;
        if (!isValid) return;
        
        const btn = $(this).find('button[type="submit"]');
        const original = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
        
        var formData = new FormData(this);
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        if (csrfHash) {
            formData.append(csrf_token_name, csrfHash);
        }
        
        var saveUrl = base_url + 'P_Input_Pengobatan/save';
        
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
    var title = $('#reportTitle').length ? $('#reportTitle').html() : 'DATA PENGOBATAN TERNAK';
    var subtitle = $('#reportSubtitle').length ? $('#reportSubtitle').html() : 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Pengobatan Ternak</title>');
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
    printWindow.document.write('<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}