$(document).ready(function() {
    // Inisialisasi DataTable
    $("#jenisUsahaTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm',
                exportOptions: { columns: [0,1,2,3,4,5] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm',
                exportOptions: { columns: [0,1,2,3,4,5] },
                title: 'Laporan Data Jenis Usaha'
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm',
                exportOptions: { columns: [0,1,2,3,4,5] }
            }
        ],
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
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "20%", targets: 1 },
            { width: "15%", targets: 2 },
            { width: "10%", targets: 3 },
            { width: "30%", targets: 4 },
            { width: "15%", targets: 5 },
            { width: "5%", targets: 6 }
        ]
    });

    // Event untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama').val($(this).data('nama'));
        $('#edit_jenis_usaha').val($(this).data('jenis_usaha'));
        $('#edit_jumlah').val($(this).data('jumlah'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_kecamatan').val($(this).data('kecamatan'));
        $('#editDataModal').modal('show');
    });

    // Event untuk tombol hapus
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        
        if (confirm("Apakah Anda yakin ingin menghapus data jenis usaha: " + nama + "?")) {
            window.location.href = base_url + "jenis_usaha/hapus/" + id;
        }
    });

    // Auto close alerts
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

// Base URL untuk redirect
var base_url = "<?= base_url() ?>";