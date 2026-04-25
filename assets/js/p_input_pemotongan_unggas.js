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
    
    // Initialize DataTable
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
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
            { 
                extend: 'pdf', 
                text: '<i class="fas fa-file-pdf"></i> PDF', 
                className: 'btn btn-sm btn-danger',
                action: function(e, dt, button, config) {
                    printData();
                }
            },
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
        ],
        order: [[1, 'desc']]
    });
    
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
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $('#btnRemovePhoto').hide();
        $('.is-invalid').removeClass('is-invalid');
    }

    // Photo Upload
    $('#foto_kegiatan').change(function(e) {
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
        $('#foto_kegiatan').val('');
        $('#photoPreview').hide();
        $('#photoPlaceholder').show();
        $(this).hide();
    });

    // Filter functions dengan tanggal tunggal
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
                let tanggalTabel = data[1]; // kolom tanggal (index 1)
                
                if (!tanggalTabel || tanggalTabel === '-') return false;
                
                // Konversi format tanggal dari dd-mm-yyyy ke yyyy-mm-dd
                let parts = tanggalTabel.split('-');
                let tanggalData = parts[2] + '-' + parts[1] + '-' + parts[0];
                
                // Cek apakah tanggal sama
                return tanggalData === tanggalFilter;
            });
        }
        
        // Filter berdasarkan daerah asal dan periode
        if (daerahAsal !== "all") search += daerahAsal + " ";
        if (periode !== "all") search += periode;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        // Reset semua input filter
        $("#filterDaerahAsal, #filterPeriode").val("all");
        $("#filterTanggal").val("");
        
        // Hapus filter custom
        $.fn.dataTable.ext.search.pop();
        
        // Reset search dan redraw
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

    window.showFoto = function(url) {
        $('#fotoModalImg').attr('src', url);
        $('#fotoModal').modal('show');
    };
});

// Fungsi Print
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
    printWindow.document.write('.badge-secondary { background-color: #6c757d; color: white; padding: 2px 6px; border-radius: 4px; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('pemotonganTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    $(tableContent).find('.dt-buttons').remove();
    $(tableContent).find('.dataTables_filter').remove();
    $(tableContent).find('.dataTables_length').remove();
    $(tableContent).find('.dataTables_info').remove();
    $(tableContent).find('.dataTables_paginate').remove();
    $(tableContent).find('.dataTables_wrapper').removeClass();
    
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