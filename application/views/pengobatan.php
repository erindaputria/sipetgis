<!doctype html>
<html lang="id_obat">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Pengobatan - SIPETGIS</title>
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

        /* Badge untuk jenis obat */
        .badge-jenis-obat {
            font-size: 11px;
            font-weight: 500;
            padding: 3px 8px;
            border-radius: 15px;
            white-space: nowrap;
        }

        .badge-antibiotik {
            background-color: #ffeaea;
            color: #d32f2f;
        }

        .badge-vitamin {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .badge-vaksin {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-antiparasit {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-lainnya {
            background-color: #fff3e0;
            color: #f57c00;
        }

        /* Badge untuk tahun */
        .badge-tahun {
            background-color: #e0f7fa;
            color: #006064;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 8px;
            border-radius: 15px;
            white-space: nowrap;
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
                                    <li>
                                        <a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('pengobatan') ?>" class="nav-link active">Pengobatan</a>
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
                                        <a href="<?= site_url('data_nama_pengobatan') ?>" class="nav-link">Pengobatan Ternak</a>
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
                                            <a class="dropdown-item" href="login.html">
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
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1">Master Data</h3>
                            <h6 class="op-7 mb-0">Kelola Data Pengobatan</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <button class="btn btn-primary-custom text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#tambahDataModal">
                                <i class="fas fa-plus me-2"></i>Tambah Data
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="pengobatanTable" class="table table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Nama Pengobatan</th>
                                                    <th>Jenis Obat</th>
                                                    <th>Tahun</th>
                                                    <th>Bantuan Provinsi</th>
                                                    <th>Keterangan</th>
                                                    <th width="100">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($pengobatan)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach($pengobatan as $row): ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= htmlspecialchars($row->nama_pengobatan ?? ''); ?></td>
                                                            <td>
                                                                <span class="badge-jenis-obat 
                                                                    <?php 
                                                                        $jenis = strtolower($row->jenis_obat ?? '');
                                                                        if(strpos($jenis, 'antibiotik') !== false) echo 'badge-antibiotik';
                                                                        elseif(strpos($jenis, 'vitamin') !== false) echo 'badge-vitamin';
                                                                        elseif(strpos($jenis, 'vaksin') !== false) echo 'badge-vaksin';
                                                                        elseif(strpos($jenis, 'antiparasit') !== false || strpos($jenis, 'parasit') !== false) echo 'badge-antiparasit';
                                                                        else echo 'badge-lainnya';
                                                                    ?>">
                                                                    <?= htmlspecialchars($row->jenis_obat ?? ''); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge-tahun"><?= htmlspecialchars($row->tahun ?? ''); ?></span>
                                                            </td>
                                                            <td><?= htmlspecialchars($row->bantuan_prov ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->keterangan ?? ''); ?></td>
                                                            <td>
                                                                <button class="btn btn-action btn-edit" title="Edit"
                                                                        data-id="<?= $row->id_obat ?? ''; ?>"
                                                                        data-pengobatan="<?= htmlspecialchars($row->nama_pengobatan ?? ''); ?>"
                                                                        data-jenis="<?= htmlspecialchars($row->jenis_obat ?? ''); ?>"
                                                                        data-tahun="<?= htmlspecialchars($row->tahun ?? ''); ?>"
                                                                        data-bantuan="<?= htmlspecialchars($row->bantuan_prov ?? ''); ?>"
                                                                        data-keterangan="<?= htmlspecialchars($row->keterangan ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-action btn-delete" title="Hapus"
                                                                        data-id="<?= $row->id_obat ?? ''; ?>">
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

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-form">
                <form action="<?= base_url('pengobatan/simpan'); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-plus me-2"></i>Tambah Data Pengobatan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Nama Pengobatan <span class="text-danger">*</span></label>
                                    <textarea name="nama_pengobatan" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Jenis Obat <span class="text-danger">*</span></label>
                                    <select name="jenis_obat" class="form-control" required>
                                        <option value="">Pilih Jenis Obat</option>
                                        <option value="Antibiotik">Antibiotik</option>
                                        <option value="Vitamin">Vitamin</option>
                                        <option value="Vaksin">Vaksin</option>
                                        <option value="Antiparasit">Antiparasit</option>
                                        <option value="Obat Cacing">Obat Cacing</option>
                                        <option value="Desinfektan">Desinfektan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Tahun <span class="text-danger">*</span></label>
                                    <select name="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun</option>
                                        <?php 
                                        $current_year = date('Y');
                                        for($i = $current_year; $i >= 2020; $i--): 
                                        ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Bantuan Provinsi <span class="text-danger">*</span></label>
                                    <select name="bantuan_prov" class="form-control" required>
                                        <option value="">Pilih Bantuan Provinsi</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Keterangan <span class="text-danger">*</span></label>
                                    <textarea name="keterangan" class="form-control" rows="3" required></textarea>
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
                <form action="<?= base_url('pengobatan/update'); ?>" method="post">
                    <input type="hidden" id="edit_id" name="id_obat">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-edit me-2"></i>Edit Data Pengobatan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Nama Pengobatan <span class="text-danger">*</span></label>
                                    <textarea id="edit_pengobatan" name="nama_pengobatan" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Jenis Obat <span class="text-danger">*</span></label>
                                    <select id="edit_jenis" name="jenis_obat" class="form-control" required>
                                        <option value="">Pilih Jenis Obat</option>
                                        <option value="Antibiotik">Antibiotik</option>
                                        <option value="Vitamin">Vitamin</option>
                                        <option value="Vaksin">Vaksin</option>
                                        <option value="Antiparasit">Antiparasit</option>
                                        <option value="Obat Cacing">Obat Cacing</option>
                                        <option value="Desinfektan">Desinfektan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Tahun <span class="text-danger">*</span></label>
                                    <select id="edit_tahun" name="tahun" class="form-control" required>
                                        <option value="">Pilih Tahun</option>
                                        <?php 
                                        $current_year = date('Y');
                                        for($i = $current_year; $i >= 2020; $i--): 
                                        ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Bantuan Provinsi <span class="text-danger">*</span></label>
                                    <select id="edit_bantuan" name="bantuan_prov" class="form-control" required>
                                        <option value="">Pilih Bantuan Provinsi</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Keterangan <span class="text-danger">*</span></label>
                                    <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3" required></textarea>
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
            var table = $("#pengobatanTable").DataTable({
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
            
            // Event untuk tombol edit
            $(document).on("click", ".btn-edit", function () {
                var id = $(this).data('id');
                var pengobatan = $(this).data('pengobatan');
                var jenis = $(this).data('jenis');
                var tahun = $(this).data('tahun');
                var bantuan = $(this).data('bantuan');
                var keterangan = $(this).data('keterangan');
                
                // Isi form edit
                $('#edit_id').val(id);
                $('#edit_pengobatan').val(pengobatan);
                $('#edit_jenis').val(jenis);
                $('#edit_tahun').val(tahun);
                $('#edit_bantuan').val(bantuan);
                $('#edit_keterangan').val(keterangan);
                
                // Tampilkan modal edit
                $('#editDataModal').modal('show');
            });
            
            // Event untuk tombol hapus
            $(document).on("click", ".btn-delete", function () {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                
                if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                    // Kirim request hapus ke server
                    $.ajax({
                        url: "<?= base_url('pengobatan/hapus'); ?>",
                        method: "POST",
                        data: { id: id },
                        success: function(response) {
                            alert("Data berhasil dihapus");
                            // Hapus row dari DataTable
                            table.row(row).remove().draw();
                        },
                        error: function() {
                            alert("Terjadi kesalahan saat menghapus data");
                        }
                    });
                }
            });
            
            // Refresh halaman setelah modal ditutup
            $('#tambahDataModal, #editDataModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
</body>
</html>