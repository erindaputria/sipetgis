/**
 * Input Pemotongan Unggas
 * SIPETGIS - Kota Surabaya
 * Mengikuti pola yang sama dengan P_Input_Pengobatan
 */

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
    
    // Initialize DataTable dengan custom buttons termasuk Print
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
            { orderable: false, targets: [8] }
        ],
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();
            
            // Hitung total untuk setiap kolom
            let totalAyam = api.column(2, { page: 'current' }).data().reduce(function (a, b) {
                let val = typeof b === 'string' ? parseFloat(b.toString().replace(/\./g, '')) : parseFloat(b);
                return a + (isNaN(val) ? 0 : val);
            }, 0);
            
            let totalItik = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                let val = typeof b === 'string' ? parseFloat(b.toString().replace(/\./g, '')) : parseFloat(b);
                return a + (isNaN(val) ? 0 : val);
            }, 0);
            
            let totalDst = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                let val = typeof b === 'string' ? parseFloat(b.toString().replace(/\./g, '')) : parseFloat(b);
                return a + (isNaN(val) ? 0 : val);
            }, 0);
            
            let totalSemua = totalAyam + totalItik + totalDst;
            
            // Update footer
            $(api.column(2).footer()).html(totalAyam.toLocaleString('id-ID'));
            $(api.column(3).footer()).html(totalItik.toLocaleString('id-ID'));
            $(api.column(4).footer()).html(totalDst.toLocaleString('id-ID'));
            $(api.column(5).footer()).html(totalSemua.toLocaleString('id-ID'));
        }
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
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
        
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

    // Filter functions
    function filterData() {
        let search = "";
        const daerahAsal = $("#filterDaerahAsal").val();
        const periode = $("#filterPeriode").val();
        
        if (daerahAsal !== "all") search += daerahAsal + " ";
        if (periode !== "all") search += periode;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterDaerahAsal, #filterPeriode").val("all");
        dataTable.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formPemotongan').submit(function(e) {
        e.preventDefault();
        
        // Validasi minimal satu jenis unggas diisi
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

// Fungsi Print/PDF - SAMA PERSIS DENGAN LAPORAN_PENGOBATAN
function printWithCurrentData() {
    var title = $('#reportTitle').length ? $('#reportTitle').html() : 'DATA PEMOTONGAN UNGGAS';
    var subtitle = $('#reportSubtitle').length ? $('#reportSubtitle').html() : 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Pemotongan Unggas</title>');
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
    
    var tableContent = document.getElementById('pemotonganTable').cloneNode(true);
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