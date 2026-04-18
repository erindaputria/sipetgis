<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Pemotongan Unggas - SIPETGIS</title>
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
    <!-- Hapus link buttons CSS -->

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
        
        /* Summary Cards */
        .summary-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .summary-card.ayam {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .summary-card.itik {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .summary-card.dst {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .summary-card.total {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .summary-icon {
            font-size: 48px;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        
        /* Profile */
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
        
        /* Filter section */
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        /* DataTables buttons - dihapus */
        
        /* Pagination */
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
        
        .foto-link { color: #1a73e8; text-decoration: none; cursor: pointer; }
        .foto-link:hover { text-decoration: underline; color: #0d47a1; }
        
        /* Layout */
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        /* Hapus dt-buttons style */
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

                        <li class="nav-item active">
                            <a href="<?php echo base_url(); ?>p_input_pemotongan_unggas">
                                <i class="fas fa-cut"></i>
                                <p>Pemotongan Unggas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>p_input_demplot">
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

                            <!-- User Dropdown -->
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
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">Pemotongan Unggas</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>, Surabaya</h6>
                        </div>
                    </div>

                    <!-- Alert Container -->
                    <div id="alert-container"></div>

               

                    <!-- Action Card -->
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container (Hidden by default) -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA PEMOTONGAN UNGGAS BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPemotongan" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            
                                            <div class="row">
                                                <!-- Tanggal Pemotongan -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal Pemotongan</label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                                                    <div class="invalid-feedback">Tanggal pemotongan harus diisi</div>
                                                </div>

                                                <!-- Nama Petugas -->
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

                                                <!-- Daerah Asal -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Daerah Asal Unggas</label>
                                                    <input type="text" class="form-control" id="daerah_asal" name="daerah_asal" placeholder="Contoh: Surabaya, Sidoarjo, Gresik" required />
                                                    <div class="invalid-feedback">Daerah asal unggas harus diisi</div>
                                                </div>

                                                <!-- ID RPU (opsional) - DIUBAH MENJADI DROPDOWN -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">ID RPU (Optional)</label>
                                                    <select class="form-control" id="id_rpu" name="id_rpu">
                                                        <option value="">-- Pilih RPU (Opsional) --</option>
                                                        <?php if (!empty($rpu_list)): ?>
                                                            <?php foreach ($rpu_list as $rpu): ?>
                                                                <option value="<?php echo $rpu['id']; ?>">
                                                                    <?php echo htmlspecialchars($rpu['nama_rpu']); ?> 
                                                                    (Kec. <?php echo htmlspecialchars($rpu['kecamatan']); ?>)
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                    <small class="text-muted">Pilih RPU yang terkait dengan pemotongan ini (kosongkan jika tidak terkait)</small>
                                                </div>
                                            </div>

                                            <!-- Jumlah Unggas Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card border-success">
                                                        <div class=" text-white">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-drumstick-bite me-2"></i>JUMLAH UNGGAS DIPOTONG
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Ayam (Ekor)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="fas fa-drumstick-bite"></i></span>
                                                                        <input type="number" class="form-control" id="ayam" name="ayam" min="0" value="0" />
                                                                    </div>
                                                                    <small class="text-muted">Masukkan 0 jika tidak ada</small>
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Itik (Ekor)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="fas fa-dove"></i></span>
                                                                        <input type="number" class="form-control" id="itik" name="itik" min="0" value="0" />
                                                                    </div>
                                                                    <small class="text-muted">Masukkan 0 jika tidak ada</small>
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Lainnya (Ekor)</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i class="fas fa-feather-alt"></i></span>
                                                                        <input type="number" class="form-control" id="dst" name="dst" min="0" value="0" />
                                                                    </div>
                                                                    <small class="text-muted">Entok, burung, dll</small>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <div class="alert alert-info py-2">
                                                                        <strong>Total Unggas:</strong> <span id="totalUnggas">0</span> Ekor
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Keterangan -->
                                            <div class="row mt-3">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Masukkan keterangan tambahan jika ada"></textarea>
                                                </div>
                                            </div>

                                            <!-- Foto Kegiatan -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card border-info">
                                                        <div class="">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-camera me-2"></i>FOTO KEGIATAN
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="me-3">
                                                                            <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto_kegiatan').click()">
                                                                                <div class="text-center">
                                                                                    <i class="fas fa-camera fa-2x mb-2"></i>
                                                                                    <div>Klik untuk upload foto</div>
                                                                                </div>
                                                                            </div>
                                                                            <img id="photoPreview" class="photo-preview" alt="Preview Foto" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <input type="file" class="form-control d-none" id="foto_kegiatan" name="foto_kegiatan" accept="image/jpeg, image/jpg, image/png" />
                                                                            <small class="text-muted d-block mb-2">Upload foto kegiatan pemotongan (maks. 5MB, format: JPG, PNG)</small>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('foto_kegiatan').click()">
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
                                    <label for="filterDaerahAsal" class="form-label fw-bold">Filter Daerah Asal:</label>
                                    <select class="form-select" id="filterDaerahAsal">
                                        <option selected value="all">Semua Daerah Asal</option>
                                        <?php foreach ($daerah_asal_list as $daerah): ?>
                                            <option value="<?php echo $daerah['daerah_asal']; ?>"><?php echo $daerah['daerah_asal']; ?></option>
                                        <?php endforeach; ?>
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
                            <div class="col-md-6 text-end">
                                <button id="filterBtn" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter Data</button>
                                <button id="resetBtn" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pemotonganTable" class="table table-bordered table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Ayam</th>
                                            <th>Itik</th>
                                            <th>Lainnya</th>
                                            <th>Total</th>
                                            <th>Daerah Asal</th>
                                            <th>Petugas</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <?php if (!empty($pemotongan_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($pemotongan_data as $data): ?>
                                                <?php 
                                                $total = ($data['ayam'] ?? 0) + ($data['itik'] ?? 0) + ($data['dst'] ?? 0);
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo isset($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                                                    <td class="text-end"><?php echo number_format($data['ayam'] ?? 0, 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?php echo number_format($data['itik'] ?? 0, 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?php echo number_format($data['dst'] ?? 0, 0, ',', '.'); ?></td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total, 0, ',', '.'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['daerah_asal'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama_petugas'] ?? '-'); ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($data['foto_kegiatan'])): ?>
                                                            <a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/pemotongan_unggas/<?php echo $data['foto_kegiatan']; ?>')">
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
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <th colspan="2" class="text-end">Total:</th>
                                            <th class="text-end" id="totalAyamFoot">0</th>
                                            <th class="text-end" id="totalItikFoot">0</th>
                                            <th class="text-end" id="totalDstFoot">0</th>
                                            <th class="text-end" id="totalSemuaFoot">0</th>
                                            <th colspan="3"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Foto -->
                    <div class="modal fade modal-foto" id="fotoModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Foto Kegiatan Pemotongan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto Kegiatan" style="max-width: 100%; max-height: 80vh;">
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
    
    <!-- Hapus semua script DataTables Buttons -->
    
    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
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
            
            // Initialize DataTable tanpa buttons
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
                // Hapus bagian dom dan buttons
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();
                    
                    // Hitung total untuk setiap kolom
                    let totalAyam = api.column(2, { page: 'current' }).data().reduce(function (a, b) {
                        return a + (parseFloat(b.toString().replace(/\./g, '')) || 0);
                    }, 0);
                    
                    let totalItik = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                        return a + (parseFloat(b.toString().replace(/\./g, '')) || 0);
                    }, 0);
                    
                    let totalDst = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                        return a + (parseFloat(b.toString().replace(/\./g, '')) || 0);
                    }, 0);
                    
                    let totalSemua = totalAyam + totalItik + totalDst;
                    
                    // Update footer
                    $(api.column(2).footer()).html(totalAyam.toLocaleString('id-ID'));
                    $(api.column(3).footer()).html(totalItik.toLocaleString('id-ID'));
                    $(api.column(4).footer()).html(totalDst.toLocaleString('id-ID'));
                    $(api.column(5).footer()).html(totalSemua.toLocaleString('id-ID'));
                }
            });
            
            // Toggle Form Visibility
            $('#toggleFormBtn').click(function() {
                const formContainer = $('#formContainer');
                formContainer.toggleClass('show');

                if (formContainer.hasClass('show')) {
                    $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT PEMOTONGAN');
                    $('html, body').animate({
                        scrollTop: formContainer.offset().top - 50
                    }, 500);
                } else {
                    $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
                }
            });

            // Cancel Button
            $('#btnCancel').click(function() {
                resetForm();
            });

            // Fungsi reset form
            function resetForm() {
                $('#formContainer').removeClass('show');
                $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PEMOTONGAN UNGGAS');
                
                $('#formPemotongan')[0].reset();
                const today = new Date().toISOString().split('T')[0];
                $('#tanggal').val(today);
                $('#ayam, #itik, #dst').val(0);
                $('#totalUnggas').text('0');
                
                // Reset UI elements
                $('#photoPreview').hide();
                $('#photoPlaceholder').show();
                $('#btnRemovePhoto').hide();
                
                // Remove invalid class
                $('.is-invalid').removeClass('is-invalid');
            }

            // Photo Upload Functionality
            $('#foto_kegiatan').change(function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        showAlert('danger', 'Ukuran file maksimal 5MB');
                        $(this).val('');
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        showAlert('danger', 'Format file harus JPG atau PNG');
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

            // Remove Photo
            $('#btnRemovePhoto').click(function() {
                $('#foto_kegiatan').val('');
                $('#photoPreview').hide();
                $('#photoPlaceholder').show();
                $(this).hide();
            });

            // FILTER FUNCTION
            function filterData() {
                const daerahAsal = $("#filterDaerahAsal").val();
                const periode = $("#filterPeriode").val();
                
                let searchTerm = "";
                
                if (daerahAsal !== "all") {
                    searchTerm += daerahAsal;
                }
                
                if (periode !== "all") {
                    if (searchTerm) searchTerm += " ";
                    searchTerm += periode;
                }
                
                dataTable.search(searchTerm).draw();
            }

            // RESET FILTER
            function resetFilter() {
                $("#filterDaerahAsal").val("all");
                $("#filterPeriode").val("all");
                dataTable.search("").draw();
            }

            // Event listeners untuk filter
            $("#filterBtn").click(filterData);
            $("#resetBtn").click(resetFilter);

            // Form Submission dengan AJAX
            $('#formPemotongan').submit(function(e) {
                e.preventDefault();

                // Validasi minimal satu jenis unggas diisi
                const ayam = parseInt($('#ayam').val()) || 0;
                const itik = parseInt($('#itik').val()) || 0;
                const dst = parseInt($('#dst').val()) || 0;
                
                if (ayam <= 0 && itik <= 0 && dst <= 0) {
                    showAlert('danger', 'Minimal satu jenis unggas harus diisi dengan jumlah > 0');
                    return;
                }

                // Validasi field umum
                const commonFields = [
                    'tanggal',
                    'daerah_asal',
                    'nama_petugas'
                ];
                
                let isValid = true;

                commonFields.forEach(function(fieldId) {
                    $('#' + fieldId).removeClass('is-invalid');
                });

                commonFields.forEach(function(fieldId) {
                    const field = $('#' + fieldId);
                    if (!field.val() || field.val() === '') {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    return;
                }

                // Tampilkan loading
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();

                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);

                $.ajax({
                    url: '<?php echo base_url("p_input_pemotongan_unggas/save"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert('success', response.message);
                            
                            resetForm();
                            
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