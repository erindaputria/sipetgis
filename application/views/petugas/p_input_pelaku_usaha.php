<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Pelaku Usaha - SIPETGIS</title>
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
        /* CSS DASAR */
        .form-header {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        /* INI YANG PENTING - Form Container */
        .form-container {
            display: none !important;
            transition: all 0.5s ease;
        }
        
        .form-container.show {
            display: block !important;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .form-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .btn-toggle-form {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            font-weight: 600;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }
        
        .btn-toggle-form:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1a73e8 100%);
            color: white;
        }
        
        .btn-submit {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
        }
        
        .btn-get-location {
            background: #34a853;
            color: white;
            border: none;
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
        
        .action-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-status.active {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .badge-status.inactive {
            background-color: #f8d7da;
            color: #842029;
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
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px;">SIPETGIS</div>
                    </a>
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
                        <li class="nav-item active">
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
                            <a href="<?php echo base_url(); ?>P_Input_Penjual_Pakan">
                                <i class="fas fa-seedling"></i>
                                <p>Penjual Pakan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Klinik_Hewan">
                                <i class="fas fa-stethoscope"></i>
                                <p>Klinik Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>P_Input_Penjual_Obat_Hewan">
                                <i class="fas fa-pills"></i>
                                <p>Penjual Obat Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_input_rpu">
                                <i class="fas fa-cut"></i>
                                <p>RPU</p>
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
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/petugas lapangan.png" class="avatar-img rounded-circle" />
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
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">Pelaku Usaha</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>, Surabaya</h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Action Card + Input -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <!-- Card untuk Tombol Input -->
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container - AWALNYA HIDDEN -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA PELAKU USAHA BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPelakuUsaha" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            
                                            <div class="row">
                                                <!-- Nama -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Pelaku Usaha</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required />
                                                    <div class="invalid-feedback">Nama pelaku usaha harus diisi</div>
                                                </div>

                                                <!-- NIK -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">NIK</label>
                                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="16 digit NIK" maxlength="16" required />
                                                    <div class="invalid-feedback">NIK harus diisi 16 digit angka</div>
                                                    <small class="text-muted">16 digit angka</small>
                                                    <div id="nik-status" class="mt-1"></div>
                                                </div>

                                                <!-- Telepon -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Telepon</label>
                                                    <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor telepon" maxlength="15" />
                                                </div>

                                                <!-- Jenis Usaha -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Jenis Usaha</label>
                                                    <select class="form-control" id="jenis_usaha" name="jenis_usaha" required>
                                                        <option value="">Pilih Jenis Usaha</option>
                                                        <option value="Peternak Sapi Potong">Peternak Sapi Potong</option>
                                                        <option value="Peternak Sapi Perah">Peternak Sapi Perah</option>
                                                        <option value="Peternak Kerbau">Peternak Kerbau</option>
                                                        <option value="Peternak Kambing">Peternak Kambing</option>
                                                        <option value="Peternak Domba">Peternak Domba</option>
                                                        <option value="Peternak Ayam Ras Petelur">Peternak Ayam Ras Petelur</option>
                                                        <option value="Peternak Ayam Ras Pedaging">Peternak Ayam Ras Pedaging</option>
                                                        <option value="Peternak Ayam Kampung">Peternak Ayam Kampung</option>
                                                        <option value="Peternak Itik">Peternak Itik</option>
                                                        <option value="Penggemukan Sapi">Penggemukan Sapi</option>
                                                        <option value="Pembibitan Ternak">Pembibitan Ternak</option>
                                                        <option value="Pedagang Ternak">Pedagang Ternak</option>
                                                        <option value="Pengolah Hasil Ternak">Pengolah Hasil Ternak</option>
                                                        <option value="Distributor Pakan">Distributor Pakan</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                    <div class="invalid-feedback">Jenis usaha harus dipilih</div>
                                                </div>
                                            </div>

                                            <!-- Alamat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-map-marker-alt me-2 text-success"></i>ALAMAT
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label required-field">Alamat Lengkap</label>
                                                                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                                                    <div class="invalid-feedback">Alamat harus diisi</div>
                                                                </div>
                                                                
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kecamatan</label>
                                                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>" readonly />
                                                                </div>

                                                                <!-- Kelurahan Dropdown - PERBAIKAN -->
<div class="col-md-6 mb-3">
    <label class="form-label required-field">Kelurahan</label>
    <select class="form-control" id="kelurahan" name="kelurahan" required>
        <option value="">Pilih Kelurahan</option>
        <?php 
        $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
        
        // Debug: cek apakah $kel_list ada
        if (isset($kel_list) && !empty($kel_list)) {
            // Cek apakah kecamatan ada di array
            if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])) {
                foreach ($kel_list[$user_kec] as $kel) {
                    echo '<option value="' . htmlspecialchars($kel) . '">' . htmlspecialchars($kel) . '</option>';
                }
            } else {
                // Fallback jika kecamatan tidak ditemukan
                echo '<option value="Benowo">Benowo</option>';
                echo '<option value="Kandangan">Kandangan</option>';
                echo '<option value="Romokalisari">Romokalisari</option>';
                echo '<option value="Sememi">Sememi</option>';
                echo '<option value="Tambak Osowilangun">Tambak Osowilangun</option>';
            }
        } else {
            // Fallback jika $kel_list kosong
            echo '<option value="Benowo">Benowo</option>';
            echo '<option value="Kandangan">Kandangan</option>';
            echo '<option value="Romokalisari">Romokalisari</option>';
            echo '<option value="Sememi">Sememi</option>';
            echo '<option value="Tambak Osowilangun">Tambak Osowilangun</option>';
        }
        ?>
    </select>
    <div class="invalid-feedback">Kelurahan harus dipilih</div>
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
                                                                    <div class="invalid-feedback">Latitude harus diisi</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Longitude</label>
                                                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Longitude harus diisi</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <button class="btn btn-get-location" type="button" id="btnGetLocation">
                                                                        <i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi
                                                                    </button>
                                                                    <div class="coordinate-info mt-2" id="coordinateInfo" style="display: none">
                                                                        <small>
                                                                            <i class="fas fa-info-circle me-1"></i>
                                                                            Koordinat: <span id="latDisplay"></span>, <span id="lngDisplay"></span>
                                                                            <br /><span id="accuracyInfo"></span>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status dan Foto -->
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-info-circle me-2 text-success"></i>STATUS
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label class="form-label">Status Usaha</label>
                                                                <select class="form-control" id="status" name="status">
                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Non-Aktif">Non-Aktif</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-camera me-2 text-success"></i>FOTO
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start">
                                                                <div class="me-3">
                                                                    <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto').click()">
                                                                        <div class="text-center">
                                                                            <i class="fas fa-camera fa-2x mb-2"></i>
                                                                            <div>Klik untuk upload</div>
                                                                        </div>
                                                                    </div>
                                                                    <img id="photoPreview" class="photo-preview" alt="Preview Foto" />
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <input type="file" class="form-control d-none" id="foto" name="foto" accept="image/jpeg, image/jpg, image/png" />
                                                                    <small class="text-muted d-block mb-2">Upload foto (maks. 5MB, format: JPG, PNG)</small>
                                                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('foto').click()">
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
                                <label class="form-label fw-bold">Filter Jenis Usaha:</label>
                                <select class="form-select" id="filterJenisUsaha">
                                    <option value="all">Semua Jenis Usaha</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Filter Kelurahan:</label>
                                <select class="form-select" id="filterKelurahan">
                                    <option value="all">Semua Kelurahan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Filter Periode:</label>
                                <select class="form-select" id="filterPeriode">
                                    <option value="all">Semua Periode</option>
                                    <option value="2026">Tahun 2026</option>
                                    <option value="2025">Tahun 2025</option>
                                    <option value="2024">Tahun 2024</option>
                                    <option value="2023">Tahun 2023</option>
                                </select>
                            </div>
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pelakuUsahaTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Telepon</th>
                                            <th>Jenis Usaha</th>
                                            <th>Kelurahan</th>
                                            <th>Status</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($pelaku_usaha_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($pelaku_usaha_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['nik'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['telepon'] ?? '-'); ?></td>
                                                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($data['jenis_usaha'] ?? '-'); ?></span></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td>
                                                        <?php if (($data['status'] ?? 'Aktif') == 'Aktif'): ?>
                                                            <span class="badge-status active">Aktif</span>
                                                        <?php else: ?>
                                                            <span class="badge-status inactive">Non-Aktif</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($data['foto'])): ?>
                                                            <a href="javascript:void(0)" onclick="showFoto('<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto']; ?>')">
                                                                <i class="fas fa-image"></i> Lihat
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">No Foto</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>

                    <!-- Modal Foto -->
                    <div class="modal fade" id="fotoModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto Pelaku Usaha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto" style="max-width: 100%; max-height: 80vh;">
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
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // PASTIKAN FORM HIDDEN SAAT PERTAMA KALI
        $('#formContainer').removeClass('show');
        
        // ========== TOGGLE FORM ==========
        $('#toggleFormBtn').on('click', function() {
            $('#formContainer').toggleClass('show');
            
            // Ubah teks tombol
            if ($('#formContainer').hasClass('show')) {
                $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM');
            } else {
                $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
            }
        });

        // ========== CANCEL BUTTON ==========
        $('#btnCancel').on('click', function() {
            resetForm();
            $('#formContainer').removeClass('show');
            $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
        });

        // ========== GEOLOCATION ==========
        $('#btnGetLocation').on('click', function() {
            if (navigator.geolocation) {
                let btn = $(this);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...').prop('disabled', true);

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        let lat = position.coords.latitude.toFixed(6);
                        let lng = position.coords.longitude.toFixed(6);
                        
                        $('#latitude, #longitude').val(lat).removeClass('is-invalid');
                        $('#latDisplay, #lngDisplay').text(lat);
                        $('#accuracyInfo').text('Akurasi: ±' + Math.round(position.coords.accuracy) + ' meter');
                        $('#coordinateInfo').show();
                        btn.html('<i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi').prop('disabled', false);
                        showAlert('success', 'Lokasi berhasil diambil!');
                    },
                    function(error) {
                        let msg = 'Gagal mengambil lokasi. ';
                        switch(error.code) {
                            case 1: msg += 'Izin ditolak'; break;
                            case 2: msg += 'Tidak tersedia'; break;
                            case 3: msg += 'Timeout'; break;
                        }
                        showAlert('danger', msg);
                        btn.html('<i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi').prop('disabled', false);
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                showAlert('danger', 'Browser tidak mendukung geolocation');
            }
        });

        // ========== FOTO UPLOAD ==========
        $('#foto').on('change', function(e) {
            let file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('danger', 'Ukuran file maksimal 5MB');
                    $(this).val('');
                    return;
                }
                if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                    showAlert('danger', 'Format file harus JPG/PNG');
                    $(this).val('');
                    return;
                }
                
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#photoPreview').attr('src', e.target.result).show();
                    $('#photoPlaceholder').hide();
                    $('#btnRemovePhoto').show();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#btnRemovePhoto').on('click', function() {
            $('#foto').val('');
            $('#photoPreview').attr('src', '').hide();
            $('#photoPlaceholder').show();
            $(this).hide();
        });

        // ========== VALIDASI NIK ==========
        $('#nik').on('input', function() {
            let nik = $(this).val().replace(/\D/g, '').slice(0, 16);
            $(this).val(nik);
        });

        // ========== TELEPON VALIDATION ==========
        $('#telepon').on('input', function() {
            let telepon = $(this).val().replace(/\D/g, '');
            $(this).val(telepon);
        });

        // ========== FORM SUBMIT ==========
        $('#formPelakuUsaha').on('submit', function(e) {
            e.preventDefault();
            
            // Validasi sederhana
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            
            let fields = ['nama', 'nik', 'alamat', 'kelurahan', 'jenis_usaha', 'latitude', 'longitude'];
            fields.forEach(function(id) {
                if (!$('#' + id).val()) {
                    $('#' + id).addClass('is-invalid');
                    isValid = false;
                }
            });

            if ($('#nik').val().length !== 16) {
                $('#nik').addClass('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                showAlert('danger', 'Harap lengkapi semua field wajib');
                return;
            }

            // Submit AJAX
            let btn = $(this).find('button[type="submit"]');
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);

            $.ajax({
                url: '<?php echo base_url("P_Input_Pelaku_Usaha/save"); ?>',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        showAlert('success', res.message);
                        resetForm();
                        $('#formContainer').removeClass('show');
                        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert('danger', res.message);
                    }
                },
                error: function(xhr) {
                    showAlert('danger', 'Error: ' + xhr.responseText);
                },
                complete: function() {
                    btn.html('<i class="fas fa-save me-1"></i>Simpan Data').prop('disabled', false);
                }
            });
        });

        // ========== RESET FORM ==========
        function resetForm() {
            $('#formPelakuUsaha')[0].reset();
            $('#kecamatan').val('<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>');
            $('#coordinateInfo').hide();
            $('#photoPreview').hide();
            $('#photoPlaceholder').show();
            $('#btnRemovePhoto').hide();
            $('#nik-status').html('');
            $('.is-invalid').removeClass('is-invalid');
        }

        // ========== ALERT ==========
        function showAlert(type, message) {
            $('#alert-container').html(`
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            setTimeout(() => $('.alert').alert('close'), 5000);
        }

        // ========== SHOW FOTO MODAL ==========
        window.showFoto = function(url) {
            $('#fotoModalImg').attr('src', url);
            $('#fotoModal').modal('show');
        };

        // ========== DATATABLE ==========
        $('#pelakuUsahaTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                zeroRecords: "Tidak ada data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10
        });
    });
    </script>
</body>
</html>