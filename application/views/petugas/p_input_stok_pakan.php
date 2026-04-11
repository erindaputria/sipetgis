<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Stok Pakan - SIPETGIS</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" />

    <style>
        .form-header {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
        }
        .btn-submit:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1a73e8 100%);
            color: white;
        }
        .btn-toggle-form {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            font-weight: 600;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-toggle-form:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1a73e8 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
            color: white;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .table-custom th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .action-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .action-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        .form-container {
            display: none;
            overflow: hidden;
            transition: all 0.5s ease;
        }
        .form-container.show {
            display: block;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        .profile-username {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #1a73e8;
        }
        .topbar-user .dropdown-toggle::after {
            display: none;
        }
        
        /* Style untuk filter periode */
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        /* Style untuk tombol DataTables */
        .dt-buttons .btn {
            border-radius: 5px;
            margin-right: 5px;
            transition: all 0.3s;
        }
        .dt-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Pagination styling */
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
        
        /* DataTables layout */
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        .dt-buttons { float: left !important; margin-right: 10px; }
        
        /* Info card */
        .info-card {
            background: #f0f9ff;
            border-left: 4px solid #0d6efd;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .stok-akhir {
            font-weight: bold;
            color: #0d6efd;
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>p_dashboard_petugas" class="logo" style="text-decoration: none">
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing: 0.5px; line-height: 1;">
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
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_dashboard_petugas">
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
                            <a href="<?php echo base_url(); ?>P_Input_Pengobatan">
                                <i class="fas fa-heartbeat"></i>
                                <p>Pengobatan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Vaksinasi">
                                <i class="fas fa-syringe"></i>
                                <p>Vaksinasi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Pelaku_Usaha">
                                <i class="fas fa-users"></i>
                                <p>Pelaku Usaha</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Jenis_Usaha">
                                <i class="fas fa-store"></i>
                                <p>Jenis Usaha</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Penjual">
                                <i class="fas fa-store-alt"></i>
                                <p>Penjual</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Klinik_Hewan">
                                <i class="fas fa-stethoscope"></i>
                                <p>Klinik Hewan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_input_rpu">
                                <i class="fas fa-chart-line"></i>
                                <p>RPU</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_input_pemotongan_unggas">
                                <i class="fas fa-cut"></i>
                                <p>Pemotongan Unggas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Demplot">
                                <i class="fas fa-seedling"></i>
                                <p>Demplot</p>
                            </a>
                        </li>

                        <li class="nav-item active">
                            <a href="<?php echo base_url(); ?>P_Input_Stok_Pakan">
                                <i class="fas fa-warehouse"></i>
                                <p>Stok Pakan</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
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

                            <!-- User Dropdown dengan data dari session -->
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/petugas lapangan.png" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold">Petugas Lapangan</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="u-text">
                                                    <h4>Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?></h4>
                                                    <p class="text-muted"><?php echo $this->session->userdata('username'); ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">
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
                    <!-- Page Header dengan data dari session -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">Stok Pakan Ternak</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>, Surabaya</h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Action Card + Input Stok Pakan -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <!-- Card untuk Tombol Input -->
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container (Awalnya Tersembunyi) -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA STOK PAKAN BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formStokPakan">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            
                                            <div class="row">
                                                <!-- Pilih Demplot -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Demplot</label>
                                                    <select class="form-control" id="id_demplot" name="id_demplot" required>
                                                        <option value="">Pilih Demplot</option>
                                                        <?php if (!empty($demplot_list)): ?>
                                                            <?php foreach ($demplot_list as $demplot): ?>
                                                                <option value="<?php echo $demplot['id_demplot']; ?>">
                                                                    <?php echo htmlspecialchars($demplot['nama_demplot']); ?> - <?php echo htmlspecialchars($demplot['kelurahan']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                    <div class="invalid-feedback">Demplot harus dipilih</div>
                                                </div>

                                                <!-- Tanggal -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal</label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                                                    <div class="invalid-feedback">Tanggal harus diisi</div>
                                                </div>

                                                <!-- Jenis Pakan -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Jenis Pakan</label>
                                                    <select class="form-control" id="jenis_pakan" name="jenis_pakan" required>
                                                        <option value="">Pilih Jenis Pakan</option>
                                                        <option value="Konsentrat">Konsentrat</option>
                                                        <option value="Hijauan">Hijauan</option>
                                                        <option value="Silase">Silase</option>
                                                        <option value="Hay">Hay</option>
                                                        <option value="Pakan Fermentasi">Pakan Fermentasi</option>
                                                        <option value="Pakan Tambahan">Pakan Tambahan</option>
                                                        <option value="Vitamin">Vitamin</option>
                                                        <option value="Mineral">Mineral</option>
                                                        <option value="Pakan Ayam">Pakan Ayam</option>
                                                        <option value="Pakan Itik">Pakan Itik</option>
                                                        <option value="Pakan Kambing">Pakan Kambing</option>
                                                        <option value="Pakan Sapi">Pakan Sapi</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                    <div class="invalid-feedback">Jenis pakan harus dipilih</div>
                                                </div>

                                                <!-- Merk Pakan -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Merk Pakan</label>
                                                    <input type="text" class="form-control" id="merk_pakan" name="merk_pakan" placeholder="Masukkan merk pakan" required />
                                                    <div class="invalid-feedback">Merk pakan harus diisi</div>
                                                </div>
                                            </div>

                                            <!-- Card Stok -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-left-color: #fd7e14;">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-cubes me-2 text-warning"></i>DATA STOK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <!-- Stok Awal -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Awal (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_awal" name="stok_awal" placeholder="Stok awal" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok awal harus diisi (minimal 0)</div>
                                                                </div>

                                                                <!-- Stok Masuk -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Masuk (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_masuk" name="stok_masuk" placeholder="Stok masuk" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok masuk harus diisi (minimal 0)</div>
                                                                </div>

                                                                <!-- Stok Keluar -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Keluar (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_keluar" name="stok_keluar" placeholder="Stok keluar" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok keluar harus diisi (minimal 0)</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Info Stok Akhir -->
                                                            <div class="info-card" id="stokAkhirInfo" style="display: none;">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-6">
                                                                        <span>Stok Akhir (perhitungan otomatis):</span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <span class="stok-akhir" id="stok_akhir_display">0</span> kg
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="stok_akhir" name="stok_akhir" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="row mt-3">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-light me-2" id="btnCancel">
                                                            <i class="fas fa-times me-1"></i>Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-submit">
                                                            <i class="fas fa-save me-1"></i>Simpan Data
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER SECTION -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterJenisPakan" class="form-label fw-bold">Filter Jenis Pakan:</label>
                                    <select class="form-select" id="filterJenisPakan">
                                        <option selected value="all">Semua Jenis Pakan</option>
                                        <option value="Konsentrat">Konsentrat</option>
                                        <option value="Hijauan">Hijauan</option>
                                        <option value="Silase">Silase</option>
                                        <option value="Hay">Hay</option>
                                        <option value="Pakan Fermentasi">Pakan Fermentasi</option>
                                        <option value="Pakan Tambahan">Pakan Tambahan</option>
                                        <option value="Vitamin">Vitamin</option>
                                        <option value="Mineral">Mineral</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterMerk" class="form-label fw-bold">Filter Merk:</label>
                                    <select class="form-select" id="filterMerk">
                                        <option selected value="all">Semua Merk</option>
                                        <!-- Akan diisi via JS jika diperlukan -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterPeriode" class="form-label fw-bold">Filter Periode:</label>
                                    <select class="form-select" id="filterPeriode">
                                        <option selected value="all">Semua Periode</option>
                                        <option value="2026">Tahun 2026</option>
                                        <option value="2025">Tahun 2025</option>
                                        <option value="2024">Tahun 2024</option>
                                        <option value="2023">Tahun 2023</option>
                                        <option value="2022">Tahun 2022</option>
                                        <option value="2021">Tahun 2021</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter Data</button>
                                <button id="resetBtn" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                   <!-- Data Table -->
<div class="card form-card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="stokPakanTable" class="table table-bordered table-hover table-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Demplot</th>
                        <th>Kelurahan</th>
                        <th>Jenis Pakan</th>
                        <th>Merk</th>
                        <th>Stok Awal</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Stok Akhir</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="dataTableBody">
                    <?php if (!empty($stok_pakan_data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($stok_pakan_data as $data): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo isset($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                                <td><?php echo htmlspecialchars($data['nama_demplot'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($data['jenis_pakan'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($data['merk_pakan'] ?? '-'); ?></td>
                                <td class="text-end"><?php echo number_format($data['stok_awal'] ?? 0, 0, ',', '.'); ?> kg</td>
                                <td class="text-end"><?php echo number_format($data['stok_masuk'] ?? 0, 0, ',', '.'); ?> kg</td>
                                <td class="text-end"><?php echo number_format($data['stok_keluar'] ?? 0, 0, ',', '.'); ?> kg</td>
                                <td class="text-end fw-bold <?php echo ($data['stok_akhir'] ?? 0) > 0 ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo number_format($data['stok_akhir'] ?? 0, 0, ',', '.'); ?> kg
                                </td>
                                <td><?php echo htmlspecialchars($data['keterangan'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
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

    <!-- Core JS Files -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    
    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
        $(document).ready(function() {
            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            $('#tanggal').val(today);
            
            // Initialize DataTable
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
    responsive: true
    // Bagian buttons telah dihapus
});
            
            // Toggle Form Visibility
            $('#toggleFormBtn').click(function() {
                const formContainer = $('#formContainer');
                formContainer.toggleClass('show');

                if (formContainer.hasClass('show')) {
                    $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT STOK PAKAN');
                    $('html, body').animate({
                        scrollTop: formContainer.offset().top - 50
                    }, 500);
                } else {
                    $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
                }
            });

            // Cancel Button
            $('#btnCancel').click(function() {
                resetForm();
            });

            // Hitung stok akhir otomatis
            function hitungStokAkhir() {
                const stokAwal = parseFloat($('#stok_awal').val()) || 0;
                const stokMasuk = parseFloat($('#stok_masuk').val()) || 0;
                const stokKeluar = parseFloat($('#stok_keluar').val()) || 0;
                
                const stokAkhir = stokAwal + stokMasuk - stokKeluar;
                
                if (stokAkhir >= 0) {
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
                } else {
                    $('#stok_akhir_display').text(stokAkhir.toLocaleString('id-ID'));
                    $('#stok_akhir').val(stokAkhir);
                    $('#stokAkhirInfo').show();
                    $('#stok_akhir_display').removeClass('text-success').addClass('text-danger');
                }
            }

            // Event listeners untuk input stok
            $('#stok_awal, #stok_masuk, #stok_keluar').on('input', function() {
                hitungStokAkhir();
            });

            // Fungsi reset form
            function resetForm() {
                $('#formContainer').removeClass('show');
                $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT STOK PAKAN');
                
                // Reset form
                $('#formStokPakan')[0].reset();
                $('#stokAkhirInfo').hide();
                
                // Set today's date
                $('#tanggal').val(today);
                
                // Remove invalid class
                $('.is-invalid').removeClass('is-invalid');
            }

            // FILTER FUNCTION
            function filterData() {
                const jenisPakan = $("#filterJenisPakan").val();
                const merk = $("#filterMerk").val();
                const periode = $("#filterPeriode").val();
                
                let searchTerm = "";
                
                if (jenisPakan !== "all") {
                    searchTerm += jenisPakan;
                }
                
                if (merk !== "all" && merk !== "") {
                    if (searchTerm) searchTerm += " ";
                    searchTerm += merk;
                }
                
                if (periode !== "all") {
                    if (searchTerm) searchTerm += " ";
                    searchTerm += periode;
                }
                
                dataTable.search(searchTerm).draw();
            }

            // RESET FILTER
            function resetFilter() {
                $("#filterJenisPakan").val("all");
                $("#filterMerk").val("all");
                $("#filterPeriode").val("all");
                dataTable.search("").draw();
            }

            // Event listeners untuk filter
            $("#filterBtn").click(filterData);
            $("#resetBtn").click(resetFilter);

            // Form Submission dengan AJAX
            $('#formStokPakan').submit(function(e) {
                e.preventDefault();

                // Validasi field
                const fields = [
                    'id_demplot',
                    'tanggal',
                    'jenis_pakan',
                    'merk_pakan',
                    'stok_awal',
                    'stok_masuk',
                    'stok_keluar'
                ];
                
                let isValid = true;

                // Reset error
                fields.forEach(function(fieldId) {
                    $('#' + fieldId).removeClass('is-invalid');
                });

                // Cek field kosong
                fields.forEach(function(fieldId) {
                    const field = $('#' + fieldId);
                    if (!field.val() || field.val() === '') {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                });

                // Validasi stok akhir tidak negatif
                const stokAkhir = parseFloat($('#stok_akhir').val()) || 0;
                if (stokAkhir < 0) {
                    showAlert('danger', 'Stok akhir tidak boleh negatif. Periksa kembali stok keluar!');
                    isValid = false;
                }

                if (!isValid) {
                    return;
                }

                // Tampilkan loading
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
                submitBtn.prop('disabled', true);

                // Kirim data dengan AJAX
                var formData = $(this).serialize();

                $.ajax({
                    url: '<?php echo base_url("P_Input_Stok_Pakan/save"); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert('success', response.message);
                            
                            // Reset form
                            resetForm();
                            
                            // Reload page setelah 1.5 detik
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        showAlert('danger', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
                    },
                    complete: function() {
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            // Alert Function
            function showAlert(type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                $('#alert-container').html(alertHtml);

                // Auto dismiss after 5 seconds
                setTimeout(function() {
                    $('.alert-dismissible').alert('close');
                }, 5000);
            }
        });
    </script>
</body>
</html>