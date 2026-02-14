<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Pelaku Usaha - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url('assets/SIPETGIS/assets/img/kaiadmin/favicon.ico'); ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js'); ?>"></script>
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
                urls: ["<?php echo base_url('assets/SIPETGIS/assets/css/fonts.min.css'); ?>"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/plugins.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/kaiadmin.min.css'); ?>" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    <style>
        /* DataTables Custom Style */
        .dataTables_wrapper {
            padding: 20px;
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
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
        }

        table.dataTable thead th {
            border: none !important;
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 15px 10px;
            white-space: nowrap;
        }

        table.dataTable tbody td {
            background-color: white;
            border: none !important;
            padding: 15px 10px;
            vertical-align: middle;
        }

        table.dataTable tbody tr {
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.3s;
        }

        table.dataTable tbody tr:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 3px;
            transition: all 0.2s;
        }

        .btn-edit {
            background-color: rgba(67, 97, 238, 0.1);
            color: #4361ee;
        }

        .btn-edit:hover {
            background-color: #4361ee;
            color: white;
        }

        .btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #dc3545;
            color: white;
        }

        .dt-buttons .btn {
            border-radius: 5px;
            font-weight: 500;
            padding: 6px 15px;
            margin-right: 5px;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
        }

        .dt-buttons .btn:hover {
            background-color: #f8f9fa;
        }

        .dt-buttons .btn-export-blue {
            background-color: #0d6efd !important;
            color: white !important;
            border-color: #0d6efd !important;
        }

        .dt-buttons .btn-export-blue:hover {
            background-color: #0b5ed7 !important;
        }

        .badge-kelompok {
            background-color: #e3f2fd;
            color: #1976d2;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .pagination .page-link {
            border: none;
            color: #495057;
            margin: 0 3px;
            border-radius: 6px !important;
        }

        .pagination .page-item.active .page-link {
            background-color: #4361ee;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #3a56d4 0%, #3046b8 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        /* ===== CUSTOM PAGINATION CARDS ===== */
        .pagination-cards {
            display: flex;
            gap: 15px;
            margin: 15px 0;
            flex-wrap: wrap;
            align-items: center;
        }

        .pagination-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            min-width: 200px;
        }

        .pagination-card .card-label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            white-space: nowrap;
        }

        .pagination-card .card-value {
            font-weight: 700;
            color: #0d6efd;
            font-size: 15px;
        }

        .page-btn {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 4px 10px;
            margin: 0 2px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            min-width: 32px;
            text-align: center;
        }

        .page-btn:hover:not(:disabled) {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .current-page {
            display: inline-block;
            padding: 4px 12px;
            background: #0d6efd;
            color: white;
            border-radius: 4px;
            margin: 0 5px;
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        .dataTables_info {
            display: none !important;
        }

        /* Advanced Pagination Navigator */
        .advanced-pagination {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .page-navigation {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .page-input {
            width: 70px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px;
            font-size: 14px;
        }

        .page-jump {
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .page-jump:hover {
            background: #0b5ed7;
        }

        .page-range {
            font-weight: 600;
            color: #0d6efd;
            white-space: nowrap;
        }

        .total-pages {
            color: #6c757d;
            font-size: 14px;
        }

        /* Compact Page Buttons */
        .compact-pages {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .compact-pages .page-btn {
            min-width: 28px;
            height: 28px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ellipsis {
            padding: 0 5px;
            color: #6c757d;
        }

        /* Pagination Controls */
        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .nav-control-btn {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-control-btn:hover:not(:disabled) {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .nav-control-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            .pagination-cards {
                flex-direction: column;
                gap: 10px;
            }

            .pagination-card {
                justify-content: space-between;
                min-width: auto;
                width: 100%;
            }

            .page-btn {
                padding: 4px 8px;
                min-width: 28px;
            }

            .advanced-pagination {
                justify-content: center;
            }

            .compact-pages {
                justify-content: center;
            }

            .pagination-controls {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }
        }

        /* Style untuk badge peran */
        .badge-peran {
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .badge-admin {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-kepala {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .badge-petugas {
            background-color: #fff3e0;
            color: #f57c00;
        }

        /* Flash message styles */
        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="white">
                    <a href="index.html" class="logo" style="text-decoration: none">
                        <div style="
                            color: #1e3a8a;
                            font-weight: 800;
                            font-size: 24px;
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            letter-spacing: 0.5px;
                            line-height: 1;
                        ">
                            SIPETGIS
                        </div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="<?php echo site_url('dashboard'); ?>">
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
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#masterDataSubmenu" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-database me-2"></i>
                                    <span>Master Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse show" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li class="nav-item">
                                        <a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('pengobatan') ?>" class="nav-link">Pengobatan</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('vaksinasi') ?>" class="nav-link">Vaksinasi</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2"></i>
                                    <span>Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li>
                                        <a href="<?= site_url('data_kepemilikan') ?>" class="nav-link">Kepemilikan Ternak</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('data_history_ternak') ?>" class="nav-link">History Data Ternak</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('data_vaksinasi') ?>" class="nav-link">Vaksinasi</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('data_history_vaksinasi') ?>" class="nav-link">History Vaksinasi</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('data_pengobatan') ?>" class="nav-link">Pengobatan Ternak</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link"
                                            >Penjual Pakan Ternak</a
                                        >
                                        </li>
                                        <li>
                                        <a href="<?= site_url('data_klinik') ?>" class="nav-link"
                                            >Klinik Hewan</a
                                        >
                                        </li>
                                        <li>
                                        <a href="<?= site_url('data_penjual_obat') ?>" class="nav-link"
                                            >Penjual Obat Hewan</a
                                        >
                                        </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('laporan') ?>">
                                <i class="fas fa-chart-bar"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('peta_sebaran') ?>">
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
                <div class="main-header-logo">
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <!-- Search bar here -->
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url('assets/SIPETGIS/assets/img/logo dkpp.png'); ?>" alt="..." class="avatar-img rounded-circle" />
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
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <!-- Flash Messages -->
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1">Master Data</h3>
                            <h6 class="op-7 mb-0">Kelola Data Pelaku Usaha</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <button class="btn btn-primary-custom text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">
                                <i class="fas fa-plus me-2"></i>Tambah Data
                            </button>
                        </div>
                    </div>

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-form">
                                <form action="<?= base_url('pelaku_usaha/simpan'); ?>" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-user-plus me-2"></i>Tambah Data Pelaku Usaha
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Peternak</label>
                                                    <input type="text" name="nama_peternak" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIK</label>
                                                    <input type="text" name="nik" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alamat Lengkap</label>
                                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                  <label>Kecamatan</label>
                                                  <select name="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    <option value="ASEMROWO">ASEMROWO</option>
                                                    <option value="BENOWO">BENOWO</option>
                                                    <option value="BUBUTAN">BUBUTAN</option>
                                                    <option value="BULAK">BULAK</option>
                                                    <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                                                    <option value="GAYUNGAN">GAYUNGAN</option>
                                                    <option value="GENTENG">GENTENG</option>
                                                    <option value="GUBENG">GUBENG</option>
                                                    <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                                                    <option value="JAMBANGAN">JAMBANGAN</option>
                                                    <option value="KARANG PILANG">KARANG PILANG</option>
                                                    <option value="KENJERAN">KENJERAN</option>
                                                    <option value="KREMBANGAN">KREMBANGAN</option>
                                                    <option value="LAKARSANTRI">LAKARSANTRI</option>
                                                    <option value="MULYOREJO">MULYOREJO</option>
                                                    <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                                                    <option value="PAKAL">PAKAL</option>
                                                    <option value="RUNGKUT">RUNGKUT</option>
                                                    <option value="SAMBIKEREP">SAMBIKEREP</option>
                                                    <option value="SAWAHAN">SAWAHAN</option>
                                                    <option value="SEMAMPIR">SEMAMPIR</option>
                                                    <option value="SIMOKERTO">SIMOKERTO</option>
                                                    <option value="SUKOLILO">SUKOLILO</option>
                                                    <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                                                    <option value="TAMBAKSARI">TAMBAKSARI</option>
                                                    <option value="TANDES">TANDES</option>
                                                    <option value="TEGALSARI">TEGALSARI</option>
                                                    <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                                                    <option value="WIYUNG">WIYUNG</option>
                                                    <option value="WONOCOLO">WONOCOLO</option>
                                                    <option value="WONOKROMO">WONOKROMO</option>
                                                  </select>
                                                  </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kelurahan</label>
                                                    <select name="kelurahan" class="form-control" required>
                                                        <option value="">Pilih Kelurahan</option>
                                                        <option value="Bendul Merisi">Bendul Merisi</option>
                                                        <option value="Jemur Wonosari">Jemur Wonosari</option>
                                                        <option value="Margorejo">Margorejo</option>
                                                        <option value="Sidosermo">Sidosermo</option>
                                                        <option value="Siwalankerto">Siwalankerto</option>
                                                        <option value="Kebraon">Kebraon</option>
                                                        <option value="Kedurus">Kedurus</option>
                                                        <option value="Warugunung">Warugunung</option>
                                                        <option value="Karangpilang">Karangpilang</option>
                                                        <option value="Karang Poh">Karang Poh</option>
                                                        <option value="Balongsari">Balongsari</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Simpan Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="editDataModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-form">
                                <form action="<?= base_url('pelaku_usaha/update'); ?>" method="post">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit me-2"></i>Edit Data Pelaku Usaha
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Peternak</label>
                                                    <input type="text" id="edit_nama_peternak" name="nama_peternak" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>NIK</label>
                                                    <input type="text" id="edit_nik" name="nik" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alamat Lengkap</label>
                                                    <textarea id="edit_alamat" name="alamat" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kecamatan</label>
                                                    <select id="edit_kecamatan" name="kecamatan" class="form-control" required>
                                                        <option value="">Pilih Kecamatan</option>
                                                        <option value="ASEMROWO">ASEMROWO</option>
                                                        <option value="BENOWO">BENOWO</option>
                                                        <option value="BUBUTAN">BUBUTAN</option>
                                                        <option value="BULAK">BULAK</option>
                                                        <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                                                        <option value="GAYUNGAN">GAYUNGAN</option>
                                                        <option value="GENTENG">GENTENG</option>
                                                        <option value="GUBENG">GUBENG</option>
                                                        <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                                                        <option value="JAMBANGAN">JAMBANGAN</option>
                                                        <option value="KARANG PILANG">KARANG PILANG</option>
                                                        <option value="KENJERAN">KENJERAN</option>
                                                        <option value="KREMBANGAN">KREMBANGAN</option>
                                                        <option value="LAKARSANTRI">LAKARSANTRI</option>
                                                        <option value="MULYOREJO">MULYOREJO</option>
                                                        <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                                                        <option value="PAKAL">PAKAL</option>
                                                        <option value="RUNGKUT">RUNGKUT</option>
                                                        <option value="SAMBIKEREP">SAMBIKEREP</option>
                                                        <option value="SAWAHAN">SAWAHAN</option>
                                                        <option value="SEMAMPIR">SEMAMPIR</option>
                                                        <option value="SIMOKERTO">SIMOKERTO</option>
                                                        <option value="SUKOLILO">SUKOLILO</option>
                                                        <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                                                        <option value="TAMBAKSARI">TAMBAKSARI</option>
                                                        <option value="TANDES">TANDES</option>
                                                        <option value="TEGALSARI">TEGALSARI</option>
                                                        <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                                                        <option value="WIYUNG">WIYUNG</option>
                                                        <option value="WONOCOLO">WONOCOLO</option>
                                                        <option value="WONOKROMO">WONOKROMO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Kelurahan</label>
                                                    <select id="edit_kelurahan" name="kelurahan" class="form-control" required>
                                                        <option value="">Pilih Kelurahan</option>
                                                        <option value="Bendul Merisi">Bendul Merisi</option>
                                                        <option value="Jemur Wonosari">Jemur Wonosari</option>
                                                        <option value="Margorejo">Margorejo</option>
                                                        <option value="Sidosermo">Sidosermo</option>
                                                        <option value="Siwalankerto">Siwalankerto</option>
                                                        <option value="Kebraon">Kebraon</option>
                                                        <option value="Kedurus">Kedurus</option>
                                                        <option value="Warugunung">Warugunung</option>
                                                        <option value="Karangpilang">Karangpilang</option>
                                                        <option value="Karang Poh">Karang Poh</option>
                                                        <option value="Balongsari">Balongsari</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Update Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="pelakuUsahaTable" class="table table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Nama Peternak</th>
                                                    <th>Alamat</th>
                                                    <th>Kecamatan</th>
                                                    <th>Kelurahan</th>
                                                    <th>NIK</th>
                                                    <th width="100">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($pelaku_usaha)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach($pelaku_usaha as $row): ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= htmlspecialchars($row->nama_peternak ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->alamat ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->kecamatan ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->kelurahan ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->nik ?? '-'); ?></td>
                                                            <td>
                                                                <button class="btn btn-action btn-edit" title="Edit"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-nama="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>"
                                                                        data-nik="<?= htmlspecialchars($row->nik ?? ''); ?>"
                                                                        data-alamat="<?= htmlspecialchars($row->alamat ?? ''); ?>"
                                                                        data-kecamatan="<?= htmlspecialchars($row->kecamatan ?? ''); ?>"
                                                                        data-kelurahan="<?= htmlspecialchars($row->kelurahan ?? ''); ?>"
                                                                        data-telepon="<?= htmlspecialchars($row->telepon ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-action btn-delete" title="Hapus"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-nama="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/bootstrap.min.js'); ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/kaiadmin.min.js'); ?>"></script>
    
    <!-- DataTables JS -->
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
        $(document).ready(function () {
            // Inisialisasi DataTable
            var table = $("#pelakuUsahaTable").DataTable({
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"B>>',
                buttons: [
                    {
                        extend: "excel",
                        className: "btn btn-export-blue",
                        text: '<i class="fas fa-file-excel me-1"></i>Excel',
                    },
                    {
                        extend: "pdf",
                        className: "btn btn-export-blue",
                        text: '<i class="fas fa-file-pdf me-1"></i>PDF',
                    },
                    {
                        extend: "print",
                        className: "btn btn-export-blue",
                        text: '<i class="fas fa-print me-1"></i>Print',
                    },
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "",
                    info: "",
                    infoEmpty: "",
                    infoFiltered: "",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: {
                        first: "«",
                        last: "»",
                        next: "›",
                        previous: "‹",
                    },
                },
                pageLength: 10,
                lengthChange: false,
                responsive: true,
            });

            // Event untuk tombol edit - SAMA SEPERTI DI AKSES PENGGUNA
            $(document).on("click", ".btn-edit", function () {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var nik = $(this).data('nik');
                var alamat = $(this).data('alamat');
                var kecamatan = $(this).data('kecamatan');
                var kelurahan = $(this).data('kelurahan');
                var telepon = $(this).data('telepon');
                
                $('#edit_id').val(id);
                $('#edit_nama_peternak').val(nama);
                $('#edit_nik').val(nik);
                $('#edit_alamat').val(alamat);
                $('#edit_kecamatan').val(kecamatan);
                $('#edit_kelurahan').val(kelurahan);
                $('#edit_telepon').val(telepon);
                
                $('#editDataModal').modal('show');
            });

            // Event untuk tombol hapus - SAMA SEPERTI DI AKSES PENGGUNA
            $(document).on("click", ".btn-delete", function () {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                
                if (confirm("Apakah Anda yakin ingin menghapus data pelaku usaha: " + nama + "?")) {
                    // Redirect langsung ke controller hapus - SAMA SEPERTI DI AKSES PENGGUNA
                    window.location.href = "<?= base_url('pelaku_usaha/hapus/'); ?>" + id;
                }
            });

            // Event untuk validasi NIK (16 digit)
            $("input[name='nik'], #edit_nik").on("input", function () {
                var nikValue = $(this).val();
                // Hanya angka dan maksimal 16 digit
                $(this).val(nikValue.replace(/\D/g, '').slice(0, 16));
            });
            
            // Event untuk validasi telepon
            $("input[name='telepon'], #edit_telepon").on("input", function () {
                var phoneValue = $(this).val();
                // Hanya angka
                $(this).val(phoneValue.replace(/\D/g, ''));
            });

            // Auto close alerts
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Refresh halaman setelah modal ditutup - SAMA SEPERTI DI AKSES PENGGUNA
            $('#tambahDataModal, #editDataModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
</body>
</html>