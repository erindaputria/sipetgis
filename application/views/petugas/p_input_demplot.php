<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Demplot - SIPETGIS</title>
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
        .btn-get-location {
            background: #34a853;
            color: white;
            border: none;
        }
        .btn-get-location:hover {
            background: #2e8b47;
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
        .btn-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        .photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px dashed #ddd;
            display: none;
        }
        .photo-placeholder {
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
        }
        .coordinate-info {
            background: #f8f9fa;
            border-left: 4px solid #1a73e8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .address-card {
            border-left: 4px solid #34a853;
            margin-bottom: 20px;
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
        .card-header-address {
            background: #f8f9fa;
            border-bottom: 2px solid #34a853;
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
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        /* Tambahan style untuk profile */
        .profile-username {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .kecamatan-badge {
            background-color: #1a73e8;
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
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
        .dt-buttons .btn-primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: white !important;
        }
        .dt-buttons .btn-success {
            background-color: #198754 !important;
            border-color: #198754 !important;
            color: white !important;
        }
        .dt-buttons .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }
        .dt-buttons .btn-info {
            background-color: #0dcaf0 !important;
            border-color: #0dcaf0 !important;
            color: white !important;
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
        .pagination .page-link:hover {
            background-color: #f8f9fa;
        }
        
        .btn-action { margin: 0 2px; }
        .foto-link { color: #1a73e8; text-decoration: none; cursor: pointer; }
        .foto-link:hover { text-decoration: underline; color: #0d47a1; }
        
        /* Layout */
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        .dt-buttons { float: left !important; margin-right: 10px; }
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

                        <li class="nav-item active">
                            <a href="<?php echo base_url(); ?>P_Input_Demplot">
                                <i class="fas fa-seedling"></i>
                                <p>Demplot</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_input_stok_pakan">
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
                            <h3 class="fw-bold mb-1">Demplot (Demonstration Plot)</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>, Surabaya</h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Action Card + Input Demplot -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <!-- Card untuk Tombol Input -->
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT DEMPLOT
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container (Awalnya Tersembunyi) -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA DEMPLOT BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formDemplot" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            
                                            <div class="row">
                                                <!-- Nama Demplot -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Demplot</label>
                                                    <input type="text" class="form-control" id="nama_demplot" name="nama_demplot" placeholder="Masukkan nama demplot" required />
                                                    <div class="invalid-feedback">Nama demplot harus diisi</div>
                                                </div>

                                                <!-- NAMA PETUGAS - DROPDOWN -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Petugas</label>
                                                    <select class="form-control" id="nama_petugas" name="nama_petugas" required>
                                                        <option value="">Pilih Petugas</option>
                                                        <option value="Drh. Sunarno Aristono, M.Si">Drh. Sunarno Aristono, M.Si</option>
                                                        <option value="Drh. Gagat Rahino H S, M.SI">Drh. Gagat Rahino H S, M.SI</option>
                                                        <option value="Drh. Wafiroh">Drh. Wafiroh</option>
                                                        <option value="Samsul Arifin">Samsul Arifin</option>
                                                        <option value="Drh. Arfiandy Noorrahman">Drh. Arfiandy Noorrahman</option>
                                                        <option value="Drh. Kartika Eka Paksi">Drh. Kartika Eka Paksi</option>
                                                        <option value="Drh. Romadhony Arif">Drh. Romadhony Arif</option>
                                                        <option value="Drh. Rinenggo Palupi">Drh. Rinenggo Palupi</option>
                                                        <option value="Drh. Rieska Nursita">Drh. Rieska Nursita</option>
                                                        <option value="Drh. Albert Fabio S">Drh. Albert Fabio S</option>
                                                        <option value="Drh. Rizal Maulana I">Drh. Rizal Maulana I</option>
                                                        <option value="Drh. Moch Rozali">Drh. Moch Rozali</option>
                                                        <option value="Drh. Arsanti Arsy">Drh. Arsanti Arsy</option>
                                                        <option value="Drh. Richa Putri A">Drh. Richa Putri A</option>
                                                        <option value="Drh. Niken Rahmawati">Drh. Niken Rahmawati</option>
                                                    </select>
                                                    <div class="invalid-feedback">Nama petugas harus dipilih</div>
                                                </div>
                                            </div>

                                            <!-- Card Alamat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-map-marker-alt me-2 text-success"></i>ALAMAT DEMPLOT
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <!-- Kecamatan - Diisi manual -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kecamatan</label>
                                                                    <select class="form-control" id="kecamatan" name="kecamatan" required>
                                                                        <option value="">Pilih Kecamatan</option>
                                                                        <?php 
                                                                        $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
                                                                        $all_kec = array_keys($kel_list);
                                                                        sort($all_kec);
                                                                        foreach ($all_kec as $kec): ?>
                                                                            <option value="<?php echo $kec; ?>" <?php echo ($kec == $user_kec) ? 'selected' : ''; ?>><?php echo $kec; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback">Kecamatan harus dipilih</div>
                                                                </div>

                                                                <!-- Kelurahan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kelurahan</label>
                                                                    <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                                        <option value="">Pilih Kelurahan</option>
                                                                        <?php 
                                                                        if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): 
                                                                            foreach ($kel_list[$user_kec] as $kel): ?>
                                                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                                                        <?php endforeach; 
                                                                        endif; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback">Kelurahan harus dipilih</div>
                                                                </div>

                                                                <!-- Alamat Lengkap -->
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label required-field">Alamat Lengkap</label>
                                                                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap demplot" required></textarea>
                                                                    <div class="invalid-feedback">Alamat harus diisi</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Data Lahan dan Ternak -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-chart-bar me-2 text-success"></i>DATA LAHAN DAN TERNAK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <!-- Luas Lahan (m2) -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Luas Lahan (m²)</label>
                                                                    <input type="number" class="form-control" id="luas_m2" name="luas_m2" placeholder="Luas lahan dalam m²" min="1" step="0.01" required />
                                                                    <div class="invalid-feedback">Luas lahan harus diisi (minimal 1 m²)</div>
                                                                </div>

                                                                <!-- Jenis Hewan -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Jenis Hewan</label>
                                                                    <select class="form-control" id="jenis_hewan" name="jenis_hewan" required>
                                                                        <option value="">Pilih Jenis Hewan</option>
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
                                                                        <option value="Kucing">Kucing</option>
                                                                        <option value="Anjing">Anjing</option>
                                                                    </select>
                                                                    <div class="invalid-feedback">Jenis hewan harus dipilih</div>
                                                                </div>

                                                                <!-- Jumlah Hewan -->
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Jumlah Hewan (Ekor)</label>
                                                                    <input type="number" class="form-control" id="jumlah_hewan" name="jumlah_hewan" placeholder="Jumlah hewan" min="1" required />
                                                                    <div class="invalid-feedback">Jumlah hewan harus diisi (minimal 1)</div>
                                                                </div>

                                                                <!-- Stok Pakan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Stok Pakan</label>
                                                                    <input type="text" class="form-control" id="stok_pakan" name="stok_pakan" placeholder="Contoh: 500 kg konsentrat, 2 ton hijauan" required />
                                                                    <div class="invalid-feedback">Stok pakan harus diisi</div>
                                                                </div>

                                                                <!-- Keterangan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Keterangan</label>
                                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Titik Koordinat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-globe me-2 text-success"></i>TITIK KOORDINAT
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Latitude</label>
                                                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Latitude harus diisi. Klik tombol 'Ambil Lokasi'</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Longitude</label>
                                                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Longitude harus diisi. Klik tombol 'Ambil Lokasi'</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <button class="btn btn-get-location" type="button" id="btnGetLocation">
                                                                        <i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi
                                                                    </button>
                                                                    <div class="coordinate-info mt-2" id="coordinateInfo" style="display: none">
                                                                        <small>
                                                                            <i class="fas fa-info-circle me-1"></i>
                                                                            Koordinat berhasil diambil:
                                                                            <span id="latDisplay"></span>,
                                                                            <span id="lngDisplay"></span>
                                                                            <br />
                                                                            <span id="accuracyInfo"></span>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Foto -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-camera me-2 text-success"></i>FOTO DEMPLOT
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="me-3">
                                                                            <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto_demplot').click()">
                                                                                <div class="text-center">
                                                                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                                                                    <div>Klik untuk upload foto</div>
                                                                                </div>
                                                                            </div>
                                                                            <img id="photoPreview" class="photo-preview" alt="Preview Foto" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <input type="file" class="form-control d-none" id="foto_demplot" name="foto_demplot" accept="image/jpeg, image/jpg, image/png" />
                                                                            <small class="text-muted d-block mb-2">Upload foto demplot (maks. 5MB, format: JPG, PNG)</small>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('foto_demplot').click()">
                                                                                <i class="fas fa-upload me-1"></i>Pilih File
                                                                            </button>
                                                                            <button type="button" class="btn btn-outline-danger btn-sm ms-2" id="btnRemovePhoto" style="display: none">
                                                                                <i class="fas fa-trash me-1"></i>Hapus
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                    <label for="filterJenisHewan" class="form-label fw-bold">Filter Jenis Hewan:</label>
                                    <select class="form-select" id="filterJenisHewan">
                                        <option selected value="all">Semua Jenis Hewan</option>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKelurahan" class="form-label fw-bold">Filter Kelurahan:</label>
                                    <select class="form-select" id="filterKelurahan">
                                        <option selected value="all">Semua Kelurahan</option>
                                        <?php 
                                        if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): 
                                            foreach ($kel_list[$user_kec] as $kel): ?>
                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                        <?php endforeach; 
                                        endif; ?>
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
                                <table id="demplotTable" class="table table-bordered table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Demplot</th>
                                            <th>Alamat</th>
                                            <th>Kelurahan</th>
                                            <th>Luas (m²)</th>
                                            <th>Jenis Hewan</th>
                                            <th>Jumlah</th>
                                            <th>Stok Pakan</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <?php if (!empty($demplot_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($demplot_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama_demplot'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['alamat'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['luas_m2'] ?? '0'); ?> m²</td>
                                                    <td><?php echo htmlspecialchars($data['jenis_hewan'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['jumlah_hewan'] ?? '0'); ?> ekor</td>
                                                    <td><?php echo htmlspecialchars($data['stok_pakan'] ?? '-'); ?></td>
                                                    <td>
                                                        <?php if (!empty($data['foto_demplot'])): ?>
                                                            <a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/demplot/<?php echo $data['foto_demplot']; ?>')">
                                                                <i class="fas fa-image me-1"></i>Lihat
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">No Foto</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>

                    <!-- Modal Foto -->
                    <div class="modal fade modal-foto" id="fotoModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto Demplot</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto Demplot" style="max-width: 100%; max-height: 80vh;">
                                </div>
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
    
    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let dataTable = $('#demplotTable').DataTable({
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
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-info'
                    }
                ]
            });
            
            // Toggle Form Visibility
            $('#toggleFormBtn').click(function() {
                const formContainer = $('#formContainer');
                formContainer.toggleClass('show');

                if (formContainer.hasClass('show')) {
                    $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT DEMPLOT');
                    $('html, body').animate({
                        scrollTop: formContainer.offset().top - 50
                    }, 500);
                } else {
                    $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT DEMPLOT');
                }
            });

            // Cancel Button
            $('#btnCancel').click(function() {
                resetForm();
            });

            // Update kelurahan based on kecamatan selection
            $('#kecamatan').change(function() {
                const kecamatan = $(this).val();
                const kelSelect = $('#kelurahan');
                
                kelSelect.html('<option value="">Loading...</option>');
                
                $.ajax({
                    url: '<?php echo base_url("P_Input_Demplot/get_kelurahan_by_kecamatan"); ?>',
                    type: 'POST',
                    data: { kecamatan: kecamatan },
                    dataType: 'json',
                    success: function(data) {
                        let options = '<option value="">Pilih Kelurahan</option>';
                        if (data && data.length > 0) {
                            data.forEach(function(kel) {
                                options += '<option value="' + kel + '">' + kel + '</option>';
                            });
                        }
                        kelSelect.html(options);
                    },
                    error: function() {
                        kelSelect.html('<option value="">Pilih Kelurahan</option>');
                    }
                });
            });

            // Fungsi reset form
            function resetForm() {
                $('#formContainer').removeClass('show');
                $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT DEMPLOT');
                
                // Reset form
                $('#formDemplot')[0].reset();
                
                // Reset UI elements
                $('#coordinateInfo').hide();
                $('#photoPreview').hide();
                $('#photoPlaceholder').show();
                $('#btnRemovePhoto').hide();
                
                // Remove invalid class
                $('.is-invalid').removeClass('is-invalid');
            }

            // Geolocation Function
            $('#btnGetLocation').click(function() {
                if (navigator.geolocation) {
                    const btn = $(this);
                    const originalText = btn.html();

                    btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...');
                    btn.prop('disabled', true);

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            const accuracy = position.coords.accuracy;

                            // Format koordinat
                            const formattedLat = lat.toFixed(6);
                            const formattedLng = lng.toFixed(6);

                            // Set nilai ke input
                            $('#latitude').val(formattedLat);
                            $('#longitude').val(formattedLng);
                            
                            // Hapus class invalid
                            $('#latitude, #longitude').removeClass('is-invalid');

                            // Tampilkan informasi
                            $('#latDisplay').text(formattedLat);
                            $('#lngDisplay').text(formattedLng);
                            $('#accuracyInfo').text(`Akurasi: ±${Math.round(accuracy)} meter`);
                            $('#coordinateInfo').show();

                            // Reset button
                            btn.html(originalText);
                            btn.prop('disabled', false);

                            showAlert('success', 'Lokasi berhasil diambil!');
                        },
                        function(error) {
                            let errorMessage = 'Gagal mendapatkan lokasi. ';

                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage += 'Izin lokasi ditolak. Harap izinkan akses lokasi di browser Anda.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage += 'Informasi lokasi tidak tersedia.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage += 'Waktu permintaan lokasi habis.';
                                    break;
                                default:
                                    errorMessage += 'Terjadi kesalahan yang tidak diketahui.';
                            }

                            // Reset button
                            btn.html(originalText);
                            btn.prop('disabled', false);

                            showAlert('danger', errorMessage);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    showAlert('danger', 'Browser Anda tidak mendukung geolocation.');
                }
            });

            // Photo Upload Functionality
            $('#foto_demplot').change(function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    // Validasi file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        showAlert('danger', 'Ukuran file maksimal 5MB');
                        $(this).val('');
                        return;
                    }

                    // Validasi file type
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        showAlert('danger', 'Format file harus JPG atau PNG');
                        $(this).val('');
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#photoPreview').attr('src', e.target.result).show();
                        $('#photoPlaceholder').hide();
                        $('#btnRemovePhoto').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove Photo
            $('#btnRemovePhoto').click(function() {
                $('#foto_demplot').val('');
                $('#photoPreview').hide();
                $('#photoPlaceholder').show();
                $(this).hide();
            });

            // FILTER FUNCTION
            function filterData() {
                const jenisHewan = $("#filterJenisHewan").val();
                const kelurahan = $("#filterKelurahan").val();
                const periode = $("#filterPeriode").val();
                
                let searchTerm = "";
                
                if (jenisHewan !== "all") {
                    searchTerm += jenisHewan;
                }
                
                if (kelurahan !== "all") {
                    if (searchTerm) searchTerm += " ";
                    searchTerm += kelurahan;
                }
                
                if (periode !== "all") {
                    if (searchTerm) searchTerm += " ";
                    searchTerm += periode;
                }
                
                dataTable.search(searchTerm).draw();
            }

            // RESET FILTER
            function resetFilter() {
                $("#filterJenisHewan").val("all");
                $("#filterKelurahan").val("all");
                $("#filterPeriode").val("all");
                dataTable.search("").draw();
            }

            // Event listeners untuk filter
            $("#filterBtn").click(filterData);
            $("#resetBtn").click(resetFilter);

            // Form Submission dengan AJAX
            $('#formDemplot').submit(function(e) {
                e.preventDefault();

                // Validasi field umum
                const commonFields = [
                    'nama_demplot',
                    'nama_petugas',
                    'kecamatan',
                    'kelurahan',
                    'alamat',
                    'luas_m2',
                    'jenis_hewan',
                    'jumlah_hewan',
                    'stok_pakan',
                    'latitude',
                    'longitude'
                ];
                
                let isValid = true;

                // Reset error pada field umum
                commonFields.forEach(function(fieldId) {
                    $('#' + fieldId).removeClass('is-invalid');
                });

                // Cek field umum yang kosong
                commonFields.forEach(function(fieldId) {
                    const field = $('#' + fieldId);
                    if (!field.val() || field.val() === '') {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                });

                // Validasi luas_m2 minimal 1
                const luas = $('#luas_m2').val();
                if (luas && parseFloat(luas) < 1) {
                    $('#luas_m2').addClass('is-invalid');
                    isValid = false;
                    showAlert('danger', 'Luas lahan minimal 1 m²');
                }

                // Validasi jumlah_hewan minimal 1
                const jumlah = $('#jumlah_hewan').val();
                if (jumlah && parseInt(jumlah) < 1) {
                    $('#jumlah_hewan').addClass('is-invalid');
                    isValid = false;
                    showAlert('danger', 'Jumlah hewan minimal 1 ekor');
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
                var formData = new FormData(this);

                $.ajax({
                    url: '<?php echo base_url("P_Input_Demplot/save"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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

            // Show Foto Function
            window.showFoto = function(url) {
                $('#fotoModalImg').attr('src', url);
                $('#fotoModal').modal('show');
            };
        });
    </script>
</body>
</html>