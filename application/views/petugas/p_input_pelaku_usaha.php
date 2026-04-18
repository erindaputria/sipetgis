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

    <style>
        .form-header {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .form-container {
            display: none;
            transition: all 0.5s ease;
        }
        
        .form-container.show {
            display: block;
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
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .foto-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #ddd;
        }
        
        .foto-thumbnail:hover {
            opacity: 0.8;
        }
        
        .badge-no-foto {
            background-color: #6c757d;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
        }
        
        .alamat-cell {
            max-width: 250px;
            white-space: normal;
            word-wrap: break-word;
        }
        
        .dataTables_wrapper {
            padding: 10px 0;
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
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 10px;
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
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA
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
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Pelaku Usaha</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required />
                                                    <div class="invalid-feedback">Nama pelaku usaha harus diisi</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">NIK</label>
                                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="16 digit NIK" maxlength="16" required />
                                                    <div class="invalid-feedback">NIK harus diisi 16 digit angka</div>
                                                    <small class="text-muted">16 digit angka</small>
                                                    <div id="nik-status" class="mt-1"></div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Telepon</label>
                                                    <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomor telepon" maxlength="15" />
                                                </div>
                                            </div>

                                            <!-- Alamat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header">
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

                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kelurahan</label>
                                                                    <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                                        <option value="">Pilih Kelurahan</option>
                                                                        <?php 
                                                                        $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
                                                                        
                                                                        if (isset($kel_list) && !empty($kel_list) && isset($kel_list[$user_kec])) {
                                                                            foreach ($kel_list[$user_kec] as $kel) {
                                                                                echo '<option value="' . htmlspecialchars($kel) . '">' . htmlspecialchars($kel) . '</option>';
                                                                            }
                                                                        } else {
                                                                            $fallback_kel = array('Benowo', 'Kandangan', 'Romokalisari', 'Sememi', 'Tambak Osowilangun');
                                                                            foreach ($fallback_kel as $kel) {
                                                                                echo '<option value="' . $kel . '">' . $kel . '</option>';
                                                                            }
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
                                                        <div class="card-header">
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
                                                        <div class="card-header">
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
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Filter Kelurahan:</label>
                                <select class="form-select" id="filterKelurahan">
                                    <option value="all">Semua Kelurahan</option>
                                    <?php 
                                    $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
                                    if (isset($kel_list[$user_kec])) {
                                        foreach ($kel_list[$user_kec] as $kel) {
                                            echo '<option value="' . htmlspecialchars($kel) . '">' . htmlspecialchars($kel) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Filter Periode:</label>
                                <select class="form-select" id="filterPeriode">
                                    <option value="all">Semua Periode</option>
                                    <option value="2026">Tahun 2026</option>
                                    <option value="2025">Tahun 2025</option>
                                    <option value="2024">Tahun 2024</option>
                                    <option value="2023">Tahun 2023</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-end">
                                <button id="filterBtn" class="btn btn-primary mt-4"><i class="fas fa-filter me-2"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-outline-secondary mt-4"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pelakuUsahaTable" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                            <th>Kelurahan</th>
                                            <th width="80">Foto</th>
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
                                                    <td class="alamat-cell"><?php echo htmlspecialchars($data['alamat'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($data['foto'])): ?>
                                                            <img src="<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto']; ?>" 
                                                                 class="foto-thumbnail" 
                                                                 onclick="showFoto('<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto']; ?>')"
                                                                 title="Klik untuk perbesar"
                                                                 style="cursor: pointer;">
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
    var baseUrl = '<?php echo base_url(); ?>';
    var userKecamatan = '<?php echo addslashes($this->session->userdata('kecamatan') ?: 'Benowo'); ?>';

    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';
        
        var table;
        
        try {
            if ($.fn.DataTable.isDataTable('#pelakuUsahaTable')) {
                $('#pelakuUsahaTable').DataTable().destroy();
            }
            
            var hasData = $('#pelakuUsahaTable tbody tr').length > 0;
            
            if (hasData) {
                table = $('#pelakuUsahaTable').DataTable({
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
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
                    lengthMenu: [5, 10, 25, 50, 100],
                    order: [[0, 'asc']],
                    destroy: true,
                    retrieve: true
                });
            }
        } catch (e) {
            console.error('Error inisialisasi DataTable:', e);
        }

        $('#formContainer').removeClass('show');
        
        $('#toggleFormBtn').on('click', function() {
            $('#formContainer').toggleClass('show');
            
            if ($('#formContainer').hasClass('show')) {
                $(this).html('<i class="fas fa-minus-circle me-2"></i> TUTUP FORM');
            } else {
                $(this).html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
            }
        });

        $('#btnCancel').on('click', function() {
            resetForm();
            $('#formContainer').removeClass('show');
            $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
        });

        $('#btnGetLocation').on('click', function() {
            if (navigator.geolocation) {
                let btn = $(this);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...').prop('disabled', true);

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        let lat = position.coords.latitude.toFixed(6);
                        let lng = position.coords.longitude.toFixed(6);
                        
                        $('#latitude').val(lat).removeClass('is-invalid');
                        $('#longitude').val(lng).removeClass('is-invalid');
                        
                        $('#latDisplay').text(lat);
                        $('#lngDisplay').text(lng);
                        $('#accuracyInfo').text('Akurasi: ±' + Math.round(position.coords.accuracy) + ' meter');
                        $('#coordinateInfo').show();
                        
                        btn.html('<i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi').prop('disabled', false);
                        showAlert('success', 'Lokasi berhasil diambil!');
                    },
                    function(error) {
                        let msg = 'Gagal mengambil lokasi. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                msg += 'Izin lokasi ditolak. Silakan izinkan akses lokasi.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                msg += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                msg += 'Waktu pengambilan lokasi habis.';
                                break;
                            default:
                                msg += 'Terjadi kesalahan tidak dikenal.';
                        }
                        showAlert('danger', msg);
                        btn.html('<i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi').prop('disabled', false);
                    },
                    { 
                        enableHighAccuracy: true, 
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showAlert('danger', 'Browser Anda tidak mendukung geolocation');
            }
        });

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

        $('#nik').on('input', function() {
            let nik = $(this).val().replace(/\D/g, '').slice(0, 16);
            $(this).val(nik);
            
            if (nik.length === 16) {
                checkNIK(nik);
            } else {
                $('#nik-status').html('');
                $('#nik').removeClass('is-invalid');
            }
        });

        function checkNIK(nik) {
            $.ajax({
                url: baseUrl + 'P_Input_Pelaku_Usaha/check_nik',
                type: 'POST',
                data: { nik: nik },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'exist') {
                        $('#nik-status').html('<span class="text-danger"><i class="fas fa-times-circle me-1"></i>' + res.message + '</span>');
                        $('#nik').addClass('is-invalid');
                    } else {
                        $('#nik-status').html('<span class="text-success"><i class="fas fa-check-circle me-1"></i>NIK tersedia</span>');
                        $('#nik').removeClass('is-invalid');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking NIK:', error);
                }
            });
        }

        $('#telepon').on('input', function() {
            let telepon = $(this).val().replace(/\D/g, '');
            $(this).val(telepon);
        });

        $('#formPelakuUsaha').on('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            $('.is-invalid').removeClass('is-invalid');
            
            let fields = ['nama', 'nik', 'alamat', 'kelurahan', 'latitude', 'longitude'];
            fields.forEach(function(id) {
                let value = $('#' + id).val();
                if (!value || value.trim() === '') {
                    $('#' + id).addClass('is-invalid');
                    isValid = false;
                }
            });

            let nikValue = $('#nik').val();
            if (nikValue.length !== 16) {
                $('#nik').addClass('is-invalid');
                isValid = false;
                showAlert('danger', 'NIK harus 16 digit angka');
            }

            if (!isValid) {
                showAlert('danger', 'Harap lengkapi semua field wajib');
                return;
            }

            let btn = $(this).find('button[type="submit"]');
            let originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);

            let formData = new FormData(this);

            $.ajax({
                url: baseUrl + 'P_Input_Pelaku_Usaha/save',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        showAlert('success', res.message);
                        resetForm();
                        $('#formContainer').removeClass('show');
                        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA');
                        
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('danger', res.message);
                        btn.html(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    let errorMsg = 'Terjadi kesalahan server. ';
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMsg = response.message;
                        }
                    } catch(e) {
                        errorMsg += xhr.responseText;
                    }
                    showAlert('danger', errorMsg);
                    btn.html(originalText).prop('disabled', false);
                }
            });
        });

        function resetForm() {
            $('#formPelakuUsaha')[0].reset();
            $('#kecamatan').val(userKecamatan);
            $('#coordinateInfo').hide();
            $('#photoPreview').hide();
            $('#photoPlaceholder').show();
            $('#btnRemovePhoto').hide();
            $('#nik-status').html('');
            $('.is-invalid').removeClass('is-invalid');
        }

        function showAlert(type, message) {
            $('#alert-container').html(`
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            setTimeout(() => $('.alert').alert('close'), 5000);
        }

        window.showFoto = function(url) {
            $('#fotoModalImg').attr('src', url);
            $('#fotoModal').modal('show');
        };

        $('#filterBtn').on('click', function() {
            let kelurahan = $('#filterKelurahan').val();
            let periode = $('#filterPeriode').val();
            
            if (periode !== 'all') {
                window.location.href = baseUrl + 'P_Input_Pelaku_Usaha/index?tahun=' + periode;
                return;
            }
            
            if (kelurahan !== 'all' && table) {
                table.column(5).search(kelurahan).draw();
            } else if (table) {
                table.search('').columns().search('').draw();
            }
        });

        $('#resetBtn').on('click', function() {
            $('#filterKelurahan').val('all');
            $('#filterPeriode').val('all');
            window.location.href = baseUrl + 'P_Input_Pelaku_Usaha';
        });
    });
    </script>
</body>
</html>