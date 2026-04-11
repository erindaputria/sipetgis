<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan History Data Ternak - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?php echo base_url(); ?>assets/SIPETGIS/assets/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/kaiadmin.min.css" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    
    <style>
        .filter-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .report-title {
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 5px;
            color: #1e3a8a;
        }
        
        .report-subtitle {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .dataTables_wrapper {
            padding: 0;
        }
        
        .dataTables_length select {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 5px 10px;
        }
        
        .dataTables_filter input {
            border-radius: 5px;
            border: 1px solid #dee2e6;
            padding: 5px 10px;
            width: 200px;
        }
        
        table.dataTable {
            border-collapse: collapse !important;
            width: 100%;
        }
        
        table.dataTable thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 12px 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            white-space: nowrap;
        }
        
        table.dataTable tbody td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: middle;
            text-align: center;
        }
        
        table.dataTable tbody td:first-child {
            text-align: center;
            font-weight: 500;
        }
        
        table.dataTable tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .total-row {
            background-color: #e8f5e9 !important;
            font-weight: bold;
        }
        
        .total-row td {
            background-color: #e8f5e9 !important;
            font-weight: bold;
        }
        
        .dt-buttons .btn {
            border-radius: 6px;
            margin-right: 5px;
            transition: all 0.3s;
        }
        
        .dt-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            color: white;
        }
        
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #3a56d4 0%, #3046b8 100%);
            transform: translateY(-2px);
            color: white;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .form-select, .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            .main-panel {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .card {
                box-shadow: none !important;
                border: none !important;
            }
            table.dataTable thead th {
                background-color: #f8f9fa !important;
                color: black !important;
            }
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .nav-link.active {
            color: #4361ee !important;
            font-weight: 600;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .data-link {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
        }
        
        .data-link:hover {
            color: #000000;
            text-decoration: underline;
            background-color: #f0f0f0;
            transform: scale(1.05);
        }
        
        .peternak-link {
            color: #4361ee;
            text-decoration: none;
            font-weight: 500;
        }
        
        .peternak-link:hover {
            text-decoration: underline;
            color: #1e3a8a;
        }
        
        .header-group {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px;">
                            SIPETGIS
                        </div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Utama</h4>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#masterDataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-database me-2"></i>
                                    <span>Master Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('pelaku_usaha') ?>">Pelaku Usaha</a></li>
                                    <li><a href="<?= site_url('jenis_usaha') ?>">Jenis Usaha</a></li>
                                    <li><a href="<?= site_url('akses_pengguna') ?>">Akses Pengguna</a></li>
                                    <li><a href="<?= site_url('obat') ?>">Obat</a></li>
                                    <li><a href="<?= site_url('vaksin') ?>">Vaksin</a></li>
                                    <li><a href="<?= site_url('komoditas') ?>">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>">Layanan Klinik</a></li>
                                    <li><a href="<?= site_url('rpu') ?>">RPU</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2"></i>
                                    <span>Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('data_kepemilikan') ?>">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('data_history_ternak') ?>">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('data_vaksinasi') ?>">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('data_history_vaksinasi') ?>">History Vaksinasi</a></li>
                                    <li><a href="<?= site_url('data_pengobatan') ?>">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('data_penjual_pakan') ?>">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('data_klinik') ?>">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('data_rpu') ?>">TPU/RPU</a></li>
                                    <li><a href="<?= site_url('data_pemotongan_unggas') ?>">Pemotongan Unggas</a></li>
                                    <li><a href="<?= site_url('data_demplot') ?>">Demplot</a></li>
                                    <li><a href="<?= site_url('data_stok_pakan') ?>">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <span>Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse show" id="laporanSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_ternak') ?>" class="active">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_vaksinasi') ?>">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_vaksinasi') ?>">History Data Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('laporan_demplot_peternakan') ?>">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>peta-sebaran">
                                <i class="fas fa-map-marked-alt"></i>
                                <p>Peta Sebaran</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold">Administrator</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="u-text">
                                                    <h4>Administrator</h4>
                                                    <p class="text-muted">admin@dkppsby.go.id</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>login">
                                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container">
                <div class="page-inner">
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1">Laporan History Data Ternak</h3>
                            <h6 class="op-7 mb-0">Detail Perubahan Data Peternak dan Populasi Ternak Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section no-print">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="filterTahun">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php foreach($tahun as $t): ?>
                                        <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select class="form-select" id="filterBulan">
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php foreach($bulan as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select> 
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select class="form-select" id="filterKecamatan">
                                    <option value="semua">Semua Kecamatan</option>
                                    <?php foreach($kecamatan as $k): ?>
                                        <option value="<?= $k->kecamatan ?>"><?= $k->kecamatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary-custom" id="btnFilter">
                                    <i class="fas fa-search me-2"></i>Tampilkan Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Report Title -->
                    <div class="report-title" id="reportTitle">
                        Data Peternak dan Populasi Ternak
                    </div>
                    <div class="report-subtitle" id="reportSubtitle">
                        Kota Surabaya
                    </div>

                   <!-- Main Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="historyTable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal Update</th>
                        <th>NIK</th>
                        <th>Nama Peternak</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Jenis Hewan</th>
                        <th>Jantan</th>
                        <th>Betina</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
                <!-- TFoot tidak perlu karena tidak ada total keseluruhan di baris bawah -->
            </table>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

   <script>
        var table;
        var bulanNama = {
            '01': 'Januari', '02': 'Februari', '03': 'Maret',
            '04': 'April', '05': 'Mei', '06': 'Juni',
            '07': 'Juli', '08': 'Agustus', '09': 'September',
            '10': 'Oktober', '11': 'November', '12': 'Desember'
        };
        
        $(document).ready(function() {
            // Initialize DataTable
            table = $("#historyTable").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "copy",
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary'
                    },
                    {
                        extend: "csv",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: "pdf",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger'
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-info'
                    }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                },
                pageLength: 15,
                lengthChange: true,
                lengthMenu: [10, 15, 25, 50, 100],
                ordering: false,
                searching: true,
                responsive: false,
                scrollX: true,
                autoWidth: false,
                destroy: true
            });
            
            // Load data otomatis saat halaman dimuat
            loadAllData();
            
            // Filter button click
            $("#btnFilter").click(function() {
                loadDataWithFilter();
            });
        });
        
        // Fungsi untuk load SEMUA data (tanpa filter tahun/bulan)
        function loadAllData() {
            $("#loadingOverlay").fadeIn();
            
            console.log("Loading semua data (tanpa filter)");
            
            $.ajax({
                url: "<?= base_url('laporan_history_data_ternak/get_all_data') ?>",
                type: "POST",
                data: {},
                dataType: "json",
                success: function(response) {
                    console.log("Response semua data:", response);
                    displayData(response, 'Semua Periode', 'Semua Kecamatan');
                    $("#loadingOverlay").fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Gagal memuat data. Silakan coba lagi. Error: " + error);
                    $("#loadingOverlay").fadeOut();
                }
            });
        }
        
        // Fungsi untuk load data DENGAN filter
        function loadDataWithFilter() {
            var tahun = $("#filterTahun").val();
            var bulan = $("#filterBulan").val();
            var kecamatan = $("#filterKecamatan").val();
            
            if(!tahun || tahun === '') {
                alert("Silakan pilih tahun terlebih dahulu!");
                return;
            }
            
            if(!bulan || bulan === '') {
                alert("Silakan pilih bulan terlebih dahulu!");
                return;
            }
            
            $("#loadingOverlay").fadeIn();
            
            console.log("Mengirim request dengan filter:", {tahun: tahun, bulan: bulan, kecamatan: kecamatan});
            
            $.ajax({
                url: "<?= base_url('laporan_history_data_ternak/get_data') ?>",
                type: "POST",
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    kecamatan: kecamatan
                },
                dataType: "json",
                success: function(response) {
                    console.log("Response dengan filter:", response);
                    
                    var bulanText = bulanNama[bulan] || bulan;
                    var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
                    var periodeText = 'Periode: ' + bulanText + ' ' + tahun;
                    
                    displayData(response, periodeText, kecamatanText);
                    $("#loadingOverlay").fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Gagal memuat data. Silakan coba lagi. Error: " + error);
                    $("#loadingOverlay").fadeOut();
                }
            });
        }
        
        // Fungsi untuk menampilkan data ke tabel
        function displayData(response, periodeText, kecamatanText) {
            // Clear table
            table.clear().draw();
            
            var tahunText = periodeText.includes('Tahun') ? periodeText.split('Tahun')[1] : '';
            $("#reportTitle").html('Data Peternak dan Populasi Ternak' + tahunText);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + '<br>' + periodeText);
            
            if(response.data && response.data.length > 0) {
                console.log("Jumlah data:", response.data.length);
                
                // Untuk menyimpan data per baris (karena satu peternak bisa punya banyak jenis hewan)
                var flattenedData = [];
                
                $.each(response.data, function(index, peternak) {
                    // Daftar semua jenis hewan beserta Jantan, Betina, dan Total
                    var hewanList = [
                        { nama: 'Sapi Potong', jantan: peternak.sapi_potong_jantan, betina: peternak.sapi_potong_betina },
                        { nama: 'Sapi Perah', jantan: peternak.sapi_perah_jantan, betina: peternak.sapi_perah_betina },
                        { nama: 'Kambing', jantan: peternak.kambing_jantan, betina: peternak.kambing_betina },
                        { nama: 'Domba', jantan: peternak.domba_jantan, betina: peternak.domba_betina },
                        { nama: 'Kerbau', jantan: peternak.kerbau_jantan, betina: peternak.kerbau_betina },
                        { nama: 'Kuda', jantan: peternak.kuda_jantan, betina: peternak.kuda_betina },
                        { nama: 'Ayam Buras', jantan: 0, betina: 0, total: peternak.ayam_buras },
                        { nama: 'Ayam Broiler', jantan: 0, betina: 0, total: peternak.ayam_broiler },
                        { nama: 'Ayam Layer', jantan: 0, betina: 0, total: peternak.ayam_layer },
                        { nama: 'Itik', jantan: 0, betina: 0, total: peternak.itik },
                        { nama: 'Angsa', jantan: 0, betina: 0, total: peternak.angsa },
                        { nama: 'Kalkun', jantan: 0, betina: 0, total: peternak.kalkun },
                        { nama: 'Burung', jantan: 0, betina: 0, total: peternak.burung }
                    ];
                    
                    // Filter hanya yang memiliki jumlah > 0
                    var activeHewan = hewanList.filter(function(hewan) {
                        if(hewan.hasOwnProperty('total')) {
                            return hewan.total > 0;
                        } else {
                            return (hewan.jantan > 0 || hewan.betina > 0);
                        }
                    });
                    
                    // Jika tidak ada hewan sama sekali, tetap tampilkan satu baris dengan data 0
                    if(activeHewan.length === 0) {
                        activeHewan = [{ nama: '-', jantan: 0, betina: 0, total: 0 }];
                    }
                    
                    // Untuk setiap jenis hewan, buat baris terpisah
                    $.each(activeHewan, function(hewanIndex, hewan) {
                        var tanggal = peternak.tanggal_input ? new Date(peternak.tanggal_input).toLocaleDateString('id-ID') : '-';
                        var totalHewan = hewan.hasOwnProperty('total') ? hewan.total : (hewan.jantan + hewan.betina);
                        
                        flattenedData.push({
                            no: flattenedData.length + 1,
                            tanggal: tanggal,
                            nik: peternak.nik,
                            nama_peternak: peternak.nama_peternak,
                            alamat: peternak.alamat,
                            kecamatan: peternak.kecamatan,
                            kelurahan: peternak.kelurahan,
                            jenis_hewan: hewan.nama,
                            jantan: hewan.hasOwnProperty('total') ? 0 : hewan.jantan,
                            betina: hewan.hasOwnProperty('total') ? 0 : hewan.betina,
                            total: totalHewan
                        });
                    });
                });
                
                // Tampilkan data ke tabel
                $.each(flattenedData, function(index, item) {
                    var detailUrl = "<?= base_url('laporan_history_data_ternak/detail_peternak/') ?>" + encodeURIComponent(item.nik);
                    var namaLink = '<a href="'+ detailUrl +'" class="peternak-link" target="_blank">' + (item.nama_peternak || '-') + '</a>';
                    
                    table.row.add([
                        (index + 1),
                        item.tanggal,
                        item.nik || '-',
                        namaLink,
                        item.alamat || '-',
                        item.kecamatan || '-',
                        item.kelurahan || '-',
                        item.jenis_hewan,
                        formatNumber(item.jantan),
                        formatNumber(item.betina),
                        formatNumber(item.total)
                    ]).draw(false);
                });
                
            } else {
                console.log("Tidak ada data dari server");
                table.row.add([
                    '1', '-', '-', '-', '-', '-', '-', '-', '0', '0', '0'
                ]).draw(false);
            }
        }
        
        function formatNumber(num) {
            if(num === null || num === undefined || num === 0) return '0';
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</body>
</html>