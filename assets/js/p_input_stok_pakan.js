

$(document).ready(function() {
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal').val(today);
    
    // Hancurkan DataTable jika sudah ada
    if ($.fn.DataTable.isDataTable('#stokPakanTable')) {
        $('#stokPakanTable').DataTable().destroy();
    }
    
    // Initialize DataTable dengan custom buttons termasuk Print
    let dataTable = $('#stokPakanTable').DataTable({
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
            { orderable: false, targets: [0] }
        ]
    });
    
    // Populate merk filter from existing data
    function populateMerkFilter() {
        let merkSet = new Set();
        $('#stokPakanTable tbody tr').each(function() {
            let merk = $(this).find('td:eq(5)').text().trim();
            if (merk && merk !== '-') {
                merkSet.add(merk);
            }
        });
        
        let merkOptions = '<option selected value="all">Semua Merk</option>';
        merkSet.forEach(function(merk) {
            merkOptions += '<option value="' + merk + '">' + merk + '</option>';
        });
        $('#filterMerk').html(merkOptions);
    }
    populateMerkFilter();
    
    // Toggle Form
    $('#toggleFormBtn').click(function() {
        const formContainer = $('#formContainer');
        formContainer.toggleClass('show');
        if (formContainer.hasClass('show')) {
            $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM');
            $('html, body').animate({ scrollTop: formContainer.offset().top - 50 }, 500);
        } else {
            $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
        }
    });

    // Cancel Button
    $('#btnCancel').click(function() {
        resetForm();
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
    });

    // Hitung stok akhir otomatis
    function hitungStokAkhir() {
        const stokAwal = parseFloat($('#stok_awal').val()) || 0;
        const stokMasuk = parseFloat($('#stok_masuk').val()) || 0;
        const stokKeluar = parseFloat($('#stok_keluar').val()) || 0;
        
        const stokAkhir = stokAwal + stokMasuk - stokKeluar;
        
        $('#stok_akhir_display').text(stokAkhir.toLocaleString('id-ID'));
        $('#stok_akhir').val(stokAkhir);
        $('#stokAkhirInfo').show();
        
        // Warna berdasarkan nilai
        if (stokAkhir > 0) {
            $('#stok_akhir_display').removeClass('text-danger').addClass('text-success');
        } else if (stokAkhir === 0) {
            $('#stok_akhir_display').removeClass('text-success text-danger');
        } else {
            $('#stok_akhir_display').removeClass('text-success').addClass('text-danger');
        }
    }

    // Event listeners untuk input stok
    $('#stok_awal, #stok_masuk, #stok_keluar').on('input', function() {
        hitungStokAkhir();
    });

    // Reset Form
    function resetForm() {
        $('#formContainer').removeClass('show');
        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
        
        $('#formStokPakan')[0].reset();
        $('#tanggal').val(new Date().toISOString().split('T')[0]);
        $('#stokAkhirInfo').hide();
        $('.is-invalid').removeClass('is-invalid');
    }

    // Filter functions
    function filterData() {
        let search = "";
        const jenisPakan = $("#filterJenisPakan").val();
        const merk = $("#filterMerk").val();
        const periode = $("#filterPeriode").val();
        
        if (jenisPakan !== "all") search += jenisPakan + " ";
        if (merk !== "all" && merk !== "") search += merk + " ";
        if (periode !== "all") search += periode;
        
        dataTable.search(search.trim()).draw();
    }
    
    function resetFilter() {
        $("#filterJenisPakan, #filterMerk, #filterPeriode").val("all");
        dataTable.search("").draw();
    }
    
    $("#filterBtn").click(filterData);
    $("#resetBtn").click(resetFilter);

    // Form Submit
    $('#formStokPakan').submit(function(e) {
        e.preventDefault();
        let isValid = true;
        const fields = ['id_demplot', 'tanggal', 'jenis_pakan', 'merk_pakan', 'stok_awal', 'stok_masuk', 'stok_keluar'];
        fields.forEach(f => { $('#' + f).removeClass('is-invalid'); });
        fields.forEach(f => { if (!$('#' + f).val()) { $('#' + f).addClass('is-invalid'); isValid = false; } });
        
        // Validasi stok akhir tidak negatif
        const stokAkhir = parseFloat($('#stok_akhir').val()) || 0;
        if (stokAkhir < 0) {
            showAlert('danger', 'Stok akhir tidak boleh negatif. Periksa kembali stok keluar!');
            isValid = false;
        }
        
        if (!isValid) return;
        
        const btn = $(this).find('button[type="submit"]');
        const original = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
        
        var formData = $(this).serialize();
        var csrfHash = $('input[name="' + csrf_token_name + '"]').val();
        
        var saveUrl = base_url + 'P_input_stok_pakan/save';
        
        $.ajax({
            url: saveUrl,
            type: 'POST',
            data: formData + '&' + csrf_token_name + '=' + csrfHash,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    showAlert('success', res.message);
                    resetForm();
                    $('#formContainer').removeClass('show');
                    $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
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

// Fungsi Print/PDF - SAMA PERSIS DENGAN LAPORAN_PENGOBATAN
function printWithCurrentData() {
    var title = $('#reportTitle').length ? $('#reportTitle').html() : 'DATA STOK PAKAN TERNAK';
    var subtitle = $('#reportSubtitle').length ? $('#reportSubtitle').html() : 'Kota Surabaya';
    
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Data Stok Pakan Ternak</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('.text-end { text-align: right; }');
    printWindow.document.write('.fw-bold { font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('stokPakanTable').cloneNode(true);
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