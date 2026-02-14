<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $title ?? 'Input Pelaku Usaha Ternak - SIPETGIS'; ?></title>
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
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <!-- Logo Header -->
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
                <!-- End Logo Header -->
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
                            <a href="<?php echo base_url(); ?>p_input_pelaku_usaha">
                                <i class="fas fa-user-tie"></i>
                                <p>Pelaku Usaha Ternak</p>
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
                                                    <h4>Kecamatan Sawahan</h4>
                                                    <p class="text-muted">petugas@sawahan.go.id</p>
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
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">Pelaku Usaha Ternak</h3>
                            <h6 class="op-7 mb-0">Kecamatan Sawahan, Surabaya</h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Loading Spinner -->
                    <div class="loading-spinner" id="loadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data...</p>
                    </div>

                    <!-- Existing Data Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card form-card">
                                <div class="card-body">
                                    <div class="table-container">
                                        <table class="table table-bordered table-hover table-custom">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Peternak</th>
                                                    <th>Komoditas Ternak</th>
                                                    <th>Jumlah Tambah</th>
                                                    <th>Jumlah Kurang</th>
                                                    <th>Tanggal Input</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTableBody">
                                                <?php if (!empty($pelaku_usaha_data)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($pelaku_usaha_data as $data): ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo htmlspecialchars($data['nama_peternak']); ?></td>
                                                            <td><?php echo htmlspecialchars($data['komoditas_ternak']); ?></td>
                                                            <td><?php echo htmlspecialchars($data['jumlah_tambah']); ?></td>
                                                            <td><?php echo htmlspecialchars($data['jumlah_kurang']); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($data['tanggal_input'])); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada data pelaku usaha</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Card + Input Pelaku Usaha -->
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

                            <!-- Form Container (Awalnya Tersembunyi) -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header">
                                        <h4 class="card-title">INPUT DATA PELAKU USAHA TERNAK</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPelakuUsaha" enctype="multipart/form-data">
                                            <?php 
                                            // Generate CSRF token
                                            $csrf = array(
                                                'name' => $this->security->get_csrf_token_name(),
                                                'hash' => $this->security->get_csrf_hash()
                                            );
                                            ?>
                                            <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>">
                                            
                                            <div class="row">
                                                <!-- Nama Peternak -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Peternak</label>
                                                    <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" placeholder="Masukkan nama peternak" required />
                                                    <div class="invalid-feedback">Nama peternak harus diisi</div>
                                                </div>

                                                <!-- Komoditas Ternak -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Komoditas Ternak</label>
                                                    <select class="form-control" id="komoditas_ternak" name="komoditas_ternak" required>
                                                        <option value="">Pilih Komoditas</option>
                                                        <option value="Sapi Potong">Sapi Potong</option>
                                                        <option value="Kambing">Kambing</option>
                                                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                                                        <option value="Ayam Kampung">Ayam Kampung</option>
                                                        <option value="Itik">Itik</option>
                                                    </select>
                                                    <div class="invalid-feedback">Komoditas ternak harus dipilih</div>
                                                </div>

                                                <!-- Jumlah Tambah -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Jumlah Tambah</label>
                                                    <input type="number" class="form-control" id="jumlah_tambah" name="jumlah_tambah" placeholder="Masukkan jumlah ternak (tambah)" min="0" required />
                                                    <div class="invalid-feedback">Jumlah tambah harus diisi</div>
                                                </div>

                                                <!-- Jumlah Kurang -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Jumlah Kurang</label>
                                                    <input type="number" class="form-control" id="jumlah_kurang" name="jumlah_kurang" placeholder="Masukkan jumlah ternak (kurang)" min="0" required />
                                                    <div class="invalid-feedback">Jumlah kurang harus diisi</div>
                                                </div>

                                                <!-- Tanggal Input -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal Input</label>
                                                    <input type="date" class="form-control" id="tanggal_input" name="tanggal_input" required />
                                                    <div class="invalid-feedback">Tanggal input harus diisi</div>
                                                </div>

                                                <!-- Keterangan -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Masukkan keterangan tambahan"></textarea>
                                                </div>
                                            </div>

                                            <!-- Card Alamat -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0">
                                                                <i class="fas fa-map-marker-alt me-2 text-success"></i>ALAMAT PELAKU USAHA
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <!-- Kecamatan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kecamatan</label>
                                                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="Sawahan" readonly />
                                                                </div>

                                                                <!-- Desa/Kelurahan -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Desa/Kelurahan</label>
                                                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" placeholder="Masukkan nama desa/kelurahan" required />
                                                                    <div class="invalid-feedback">Desa/kelurahan harus diisi</div>
                                                                </div>

                                                                <!-- RT/RW -->
                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">RT</label>
                                                                    <input type="text" class="form-control" id="rt" name="rt" placeholder="RT" />
                                                                </div>
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

                                            <!-- Foto -->
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Foto Usaha Ternak</label>
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
                                                            <input type="file" class="form-control d-none" id="foto_usaha" name="foto_usaha" accept="image/*" />
                                                            <small class="text-muted d-block mb-2">Upload foto usaha ternak (maks. 5MB, format: JPG, PNG)</small>
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

                                            <!-- Submit Button -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-light me-2" id="btnCancel">
                                                            <i class="fas fa-times me-1"></i>Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-submit">
                                                            <i class="fas fa-save me-1"></i>Kirim Data
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
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
        // Set today's date as default
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("tanggal_input").value = today;
            
            // Hide loading spinner
            document.getElementById("loadingSpinner").style.display = "none";
        });

        // Toggle Form Visibility
        document.getElementById("toggleFormBtn").addEventListener("click", function () {
            const formContainer = document.getElementById("formContainer");
            formContainer.classList.toggle("show");

            if (formContainer.classList.contains("show")) {
                this.innerHTML = '<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT PELAKU USAHA';
                this.scrollIntoView({ behavior: "smooth" });
            } else {
                this.innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK';
            }
        });

        // Cancel Button
        document.getElementById("btnCancel").addEventListener("click", function () {
            document.getElementById("formContainer").classList.remove("show");
            document.getElementById("toggleFormBtn").innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK';
            document.getElementById("formPelakuUsaha").reset();
            document.getElementById("kecamatan").value = "Sawahan";
            document.getElementById("coordinateInfo").style.display = "none";
            document.getElementById("photoPreview").style.display = "none";
            document.getElementById("photoPlaceholder").style.display = "flex";
            document.getElementById("btnRemovePhoto").style.display = "none";
            
            // Set tanggal ke hari ini
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("tanggal_input").value = today;
            
            // Hapus class invalid
            const invalidFields = document.querySelectorAll('.is-invalid');
            invalidFields.forEach(field => {
                field.classList.remove('is-invalid');
            });
        });

        // Geolocation Function
        document.getElementById("btnGetLocation").addEventListener("click", function () {
            if (navigator.geolocation) {
                const btn = this;
                const originalText = btn.innerHTML;

                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy;

                        // Format koordinat
                        const formattedLat = lat.toFixed(6);
                        const formattedLng = lng.toFixed(6);

                        // Set nilai ke input
                        document.getElementById("latitude").value = formattedLat;
                        document.getElementById("longitude").value = formattedLng;
                        
                        // Hapus class invalid
                        document.getElementById("latitude").classList.remove("is-invalid");
                        document.getElementById("longitude").classList.remove("is-invalid");

                        // Tampilkan informasi
                        document.getElementById("latDisplay").textContent = formattedLat;
                        document.getElementById("lngDisplay").textContent = formattedLng;
                        document.getElementById("accuracyInfo").textContent = `Akurasi: ±${Math.round(accuracy)} meter`;
                        document.getElementById("coordinateInfo").style.display = "block";

                        // Reset button
                        btn.innerHTML = originalText;
                        btn.disabled = false;

                        // Success message
                        showAlert("success", "Lokasi berhasil diambil!");
                    },
                    function (error) {
                        let errorMessage = "Gagal mendapatkan lokasi. ";

                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += "Izin lokasi ditolak. Harap izinkan akses lokasi di browser Anda.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                errorMessage += "Waktu permintaan lokasi habis.";
                                break;
                            default:
                                errorMessage += "Terjadi kesalahan yang tidak diketahui.";
                        }

                        // Reset button
                        btn.innerHTML = originalText;
                        btn.disabled = false;

                        showAlert("danger", errorMessage);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0,
                    }
                );
            } else {
                showAlert("danger", "Browser Anda tidak mendukung geolocation.");
            }
        });

        // Photo Upload Functionality
        document.getElementById("foto_usaha").addEventListener("change", function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById("photoPreview");
            const placeholder = document.getElementById("photoPlaceholder");
            const removeBtn = document.getElementById("btnRemovePhoto");

            if (file) {
                // Validasi file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showAlert("danger", "Ukuran file maksimal 5MB");
                    this.value = "";
                    return;
                }

                // Validasi file type
                const validTypes = ["image/jpeg", "image/jpg", "image/png"];
                if (!validTypes.includes(file.type)) {
                    showAlert("danger", "Format file harus JPG atau PNG");
                    this.value = "";
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    placeholder.style.display = "none";
                    removeBtn.style.display = "inline-block";
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove Photo
        document.getElementById("btnRemovePhoto").addEventListener("click", function () {
            document.getElementById("foto_usaha").value = "";
            document.getElementById("photoPreview").style.display = "none";
            document.getElementById("photoPlaceholder").style.display = "flex";
            this.style.display = "none";
        });

        // Form Submission dengan AJAX
        document.getElementById("formPelakuUsaha").addEventListener("submit", function (e) {
            e.preventDefault();

            // Validasi form
            const requiredFields = [
                "nama_peternak",
                "komoditas_ternak",
                "jumlah_tambah",
                "jumlah_kurang",
                "tanggal_input",
                "kelurahan",
                "latitude",
                "longitude"
            ];
            
            let isValid = true;

            // Reset semua error
            requiredFields.forEach((fieldId) => {
                const field = document.getElementById(fieldId);
                field.classList.remove("is-invalid");
            });

            // Cek field yang kosong
            requiredFields.forEach((fieldId) => {
                const field = document.getElementById(fieldId);
                if (!field.value || field.value === "") {
                    field.classList.add("is-invalid");
                    isValid = false;
                }
            });

            if (!isValid) {
                showAlert("danger", "Harap isi semua field yang wajib diisi!");
                return;
            }

            // Tampilkan loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            submitBtn.disabled = true;

            // Kirim data dengan AJAX menggunakan jQuery
            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo base_url('P_Input_Pelaku_Usaha/save'); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        showAlert("success", response.message);
                        
                        // Reset form
                        document.getElementById("formPelakuUsaha").reset();
                        document.getElementById("formContainer").classList.remove("show");
                        document.getElementById("toggleFormBtn").innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT PELAKU USAHA TERNAK';
                        document.getElementById("kecamatan").value = "Sawahan";
                        document.getElementById("coordinateInfo").style.display = "none";
                        document.getElementById("photoPreview").style.display = "none";
                        document.getElementById("photoPlaceholder").style.display = "flex";
                        document.getElementById("btnRemovePhoto").style.display = "none";
                        
                        // Set tanggal ke hari ini
                        const today = new Date().toISOString().split("T")[0];
                        document.getElementById("tanggal_input").value = today;
                        
                        // Reload page untuk update tabel
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        
                    } else {
                        showAlert("danger", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    showAlert("danger", "Terjadi kesalahan saat menyimpan data.");
                },
                complete: function() {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        });

        // Alert Function
        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlert = document.querySelector(".alert-dismissible");
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            const alertContainer = document.getElementById("alert-container");
            alertContainer.innerHTML = alertHtml;

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector(".alert-dismissible");
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    </script>
</body>
</html>