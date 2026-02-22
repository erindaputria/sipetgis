<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Pelaku Usaha Ternak - SIPETGIS</title>
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
        /* Style untuk multiple komoditas */
        .komoditas-table th {
            background-color: #e9f0fa;
            font-size: 0.9rem;
        }
        .btn-add-row {
            background-color: #28a745;
            color: white;
        }
        .btn-add-row:hover {
            background-color: #218838;
            color: white;
        }
        .btn-remove-row {
            background-color: #dc3545;
            color: white;
        }
        .btn-remove-row:hover {
            background-color: #c82333;
            color: white;
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

    <!-- Pelaku Usaha -->
    <li class="nav-item active">
        <a href="<?php echo base_url(); ?>P_Input_Pelaku_Usaha">
            <i class="fas fa-users"></i>
            <p>Pelaku Usaha Ternak</p>
        </a>
    </li>

    <!-- Penjual Pakan -->
    <li class="nav-item">
        <a href="<?php echo base_url(); ?>P_Input_Penjual_Pakan">
            <i class="fas fa-seedling"></i>
            <p>Penjual Pakan</p>
        </a>
    </li>

    <!-- Klinik Hewan -->
    <li class="nav-item">
        <a href="<?php echo base_url(); ?>P_Input_Klinik_Hewan">
            <i class="fas fa-stethoscope"></i>
            <p>Klinik Hewan</p>
        </a>
    </li>

    <!-- Penjual Obat Hewan -->
    <li class="nav-item">
        <a href="<?php echo base_url(); ?>P_Input_Penjual_Obat_Hewan">
            <i class="fas fa-pills"></i>
            <p>Penjual Obat Hewan</p>
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
                            <h3 class="fw-bold mb-1">Pelaku Usaha Ternak</h3>
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
                                        <i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA PELAKU USAHA BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPelakuUsaha" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="kecamatan_session" id="kecamatan_session" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>">
                                            
                                            <div class="row">
                                                <!-- Nama Peternak -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Peternak</label>
                                                    <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" placeholder="Masukkan nama peternak" required />
                                                    <div class="invalid-feedback">Nama peternak harus diisi</div>
                                                </div>

                                                <!-- NIK -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">NIK</label>
                                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" />
                                                </div>

                                                <!-- NAMA PETUGAS -->
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
                                                    </select>
                                                    <div class="invalid-feedback">Nama petugas harus dipilih</div>
                                                </div>

                                                <!-- Tanggal Input -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal Input</label>
                                                    <input type="date" class="form-control" id="tanggal_input" name="tanggal_input" required />
                                                    <div class="invalid-feedback">Tanggal input harus diisi</div>
                                                </div>

                                                <!-- No Telepon -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukkan telepon" />
                                                </div>

                                                <!-- Keterangan -->
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                                                </div>
                                            </div>

                                            <!-- MULTIPLE KOMODITAS SECTION -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-list me-2 text-success"></i>DATA KOMODITAS TERNAK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered komoditas-table" id="komoditasTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="25%">Komoditas Ternak <span class="text-danger">*</span></th>
                                                                            <th width="15%">Jumlah Tambah <span class="text-danger">*</span></th>
                                                                            <th width="15%">Jumlah Kurang <span class="text-danger">*</span></th>
                                                                            <th width="15%">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="komoditasBody">
                                                                        <tr class="komoditas-row">
                                                                            <td>
                                                                                <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                                                                                    <option value="">Pilih Komoditas</option>
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
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control jumlah_tambah" name="jumlah_tambah[]" min="0" placeholder="0" required />
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control jumlah_kurang" name="jumlah_kurang[]" min="0" placeholder="0" required />
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                                <button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris" style="display: none;">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card Alamat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-map-marker-alt me-2 text-success"></i>ALAMAT USAHA TERNAK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <!-- Kecamatan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kecamatan</label>
                                                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>" readonly />
                                                                </div>

                                                                <!-- Kelurahan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kelurahan</label>
                                                                    <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                                        <option value="">Pilih Kelurahan</option>
                                                                        <?php 
                                                                        $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
                                                                        if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): 
                                                                            foreach ($kel_list[$user_kec] as $kel): ?>
                                                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                                                        <?php endforeach; 
                                                                        endif; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback">Kelurahan harus dipilih</div>
                                                                </div>

                                                                <!-- RT -->
                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">RT</label>
                                                                    <input type="text" class="form-control" id="rt" name="rt" placeholder="RT" />
                                                                </div>
                                                                
                                                                <!-- RW -->
                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">RW</label>
                                                                    <input type="text" class="form-control" id="rw" name="rw" placeholder="RW" />
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

                                            <!-- Foto -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-camera me-2 text-success"></i>FOTO USAHA TERNAK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="me-3">
                                                                            <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto_usaha').click()">
                                                                                <div class="text-center">
                                                                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                                                                    <div>Klik untuk upload foto</div>
                                                                                </div>
                                                                            </div>
                                                                            <img id="photoPreview" class="photo-preview" alt="Preview Foto" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <input type="file" class="form-control d-none" id="foto_usaha" name="foto_usaha" accept="image/jpeg, image/jpg, image/png" />
                                                                            <small class="text-muted d-block mb-2">Upload foto (maks. 5MB, format: JPG, PNG)</small>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('foto_usaha').click()">
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
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Komoditas:</label>
                                    <select class="form-select" id="filterKomoditas">
                                        <option selected value="all">Semua Komoditas</option>
                                        <?php 
                                        if (!empty($pelaku_usaha_data)) {
                                            $komoditas_list = array_unique(array_column($pelaku_usaha_data, 'komoditas_ternak'));
                                            sort($komoditas_list);
                                            foreach ($komoditas_list as $kom): 
                                                if (!empty($kom)): ?>
                                                    <option value="<?php echo $kom; ?>"><?php echo $kom; ?></option>
                                                <?php endif;
                                            endforeach;
                                        }
                                        ?>
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
                                <table id="pelakuUsahaTable" class="table table-bordered table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peternak</th>
                                            <th>Komoditas</th>
                                            <th>Jumlah Tambah</th>
                                            <th>Jumlah Kurang</th>
                                            <th>Kelurahan</th>
                                            <th>Tanggal Input</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <?php if (!empty($pelaku_usaha_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($pelaku_usaha_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama_peternak'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['komoditas_ternak'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['jumlah_tambah'] ?? '0'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['jumlah_kurang'] ?? '0'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td><?php echo isset($data['tanggal_input']) ? date('d-m-Y', strtotime($data['tanggal_input'])) : '-'; ?></td>
                                                    <td>
                                                        <?php if (!empty($data['foto_usaha'])): ?>
                                                            <a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto_usaha']; ?>')">
                                                                <i class="fas fa-image me-1"></i>Lihat
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">No Foto</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data pelaku usaha</td>
                                            </tr>
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
                                    <h5 class="modal-title">Foto Usaha Ternak</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto Usaha" style="max-width: 100%; max-height: 80vh;">
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
        // Set today's date
        $('#tanggal_input').val(new Date().toISOString().split('T')[0]);
        
        // Initialize DataTable
        let dataTable = $('#pelakuUsahaTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                zeroRecords: "Tidak ada data ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary' },
                { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success' },
                { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info' }
            ]
        });

        // Toggle Form
        $('#toggleFormBtn').click(function() {
            $('#formContainer').toggleClass('show');
            $(this).html($('#formContainer').hasClass('show') ? 
                '<i class="fas fa-minus-circle me-2"></i> TUTUP FORM' : 
                '<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK');
        });

        // Cancel Button
        $('#btnCancel').click(function() {
            resetForm();
            $('#formContainer').removeClass('show');
            $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK');
        });

        // Add Row
        function addKomoditasRow() {
            let newRow = $('.komoditas-row:first').clone();
            newRow.find('select, input').val('');
            newRow.find('.btn-remove-row').show();
            $('#komoditasBody').append(newRow);
            updateRemoveButtons();
        }

        // Remove Row
        function removeKomoditasRow(btn) {
            if ($('.komoditas-row').length > 1) {
                $(btn).closest('tr').remove();
                updateRemoveButtons();
            }
        }

        function updateRemoveButtons() {
            $('.btn-remove-row').toggle($('.komoditas-row').length > 1);
        }

        $(document).on('click', '.btn-add-row', function(e) {
            e.preventDefault();
            addKomoditasRow();
        });

        $(document).on('click', '.btn-remove-row', function(e) {
            e.preventDefault();
            removeKomoditasRow(this);
        });

        updateRemoveButtons();

        // Geolocation
        $('#btnGetLocation').click(function() {
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

        // Photo Upload
        $('#foto_usaha').change(function(e) {
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
                    $('#photoPlaceholder, #btnRemovePhoto').toggle();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#btnRemovePhoto').click(function() {
            $('#foto_usaha, #photoPreview').val('').hide();
            $('#photoPlaceholder, #btnRemovePhoto').toggle();
        });

        // Filter
        $('#filterBtn').click(function() {
            let search = [];
            if ($('#filterKomoditas').val() != 'all') search.push($('#filterKomoditas').val());
            if ($('#filterKelurahan').val() != 'all') search.push($('#filterKelurahan').val());
            if ($('#filterPeriode').val() != 'all') search.push($('#filterPeriode').val());
            dataTable.search(search.join(' ')).draw();
        });

        $('#resetBtn').click(function() {
            $('#filterKomoditas, #filterKelurahan, #filterPeriode').val('all');
            dataTable.search('').draw();
        });

        // Form Submit
        $('#formPelakuUsaha').submit(function(e) {
            e.preventDefault();
            
            // Validasi
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            
            ['nama_peternak', 'nama_petugas', 'tanggal_input', 'kelurahan', 'latitude', 'longitude'].forEach(id => {
                if (!$('#' + id).val()) $('#' + id).addClass('is-invalid'), isValid = false;
            });

            $('.komoditas-row').each(function(i) {
                let komoditas = $(this).find('.komoditas_ternak').val();
                let tambah = $(this).find('.jumlah_tambah').val();
                let kurang = $(this).find('.jumlah_kurang').val();
                
                if (!komoditas) $(this).find('.komoditas_ternak').addClass('is-invalid'), isValid = false;
                if (tambah === '') $(this).find('.jumlah_tambah').addClass('is-invalid'), isValid = false;
                if (kurang === '') $(this).find('.jumlah_kurang').addClass('is-invalid'), isValid = false;
            });

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
                        $('#formContainer, #toggleFormBtn').removeClass('show');
                        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK');
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

        // Reset Form
        function resetForm() {
            $('#formPelakuUsaha')[0].reset();
            $('#kecamatan').val('<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>');
            $('#tanggal_input').val(new Date().toISOString().split('T')[0]);
            
            $('#komoditasBody').empty().html(`
                <tr class="komoditas-row">
                    <td><select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                        <option value="">Pilih Komoditas</option>
                        <option value="Sapi Potong">Sapi Potong</option>
                        <option value="Sapi Perah">Sapi Perah</option>
                        <option value="Kerbau">Kerbau</option>
                        <option value="Kambing">Kambing</option>
                        <option value="Domba">Domba</option>
                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                    </select></td>
                    <td><input type="number" class="form-control jumlah_tambah" name="jumlah_tambah[]" min="0" required></td>
                    <td><input type="number" class="form-control jumlah_kurang" name="jumlah_kurang[]" min="0" required></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm btn-add-row"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display: none;"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `);
            updateRemoveButtons();
            
            $('#coordinateInfo, #photoPreview, #btnRemovePhoto').hide();
            $('#photoPlaceholder').show();
            $('.is-invalid').removeClass('is-invalid');
        }

        // Alert
        function showAlert(type, message) {
            $('#alert-container').html(`
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            setTimeout(() => $('.alert').alert('close'), 5000);
        }

        // Show Foto Modal
        window.showFoto = function(url) {
            $('#fotoModalImg').attr('src', url);
            $('#fotoModal').modal('show');
        };
    });
    </script>
</body>
</html>