<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Pelaku Usaha - SIPETGIS</title>
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
    
    <!-- Custom CSS Input Pelaku Usaha -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/p_input_pelaku_usaha.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white" id="mainSidebar">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url('p_dashboard_petugas'); ?>" class="logo" style="text-decoration: none">
                        <div class="sipetgis-logo">SIPETGIS</div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar" id="toggleSidebarBtn">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler" id="closeSidebarBtn">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more" id="mobileMenuBtn">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_dashboard_petugas'); ?>">
                                <i class="fas fa-home" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                            <h4 class="text-section">Menu Utama</h4>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_input_pengobatan'); ?>">
                                <i class="fas fa-heartbeat" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Pengobatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_input_vaksinasi'); ?>">
                                <i class="fas fa-syringe" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Vaksinasi</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a href="<?php echo base_url('P_input_pelaku_usaha'); ?>">
                                <i class="fas fa-users" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Pelaku Usaha</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_input_jenis_usaha'); ?>">
                                <i class="fas fa-store" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Kepemilikan Jenis Usaha</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_input_penjual'); ?>">
                                <i class="fas fa-store-alt" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Penjual</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_input_klinik_hewan'); ?>">
                                <i class="fas fa-stethoscope" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Klinik Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_input_rpu'); ?>">
                                <i class="fas fa-chart-line" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">RPU</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_input_pemotongan_unggas'); ?>">
                                <i class="fas fa-cut" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Pemotongan Unggas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_input_demplot'); ?>">
                                <i class="fas fa-seedling" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Demplot</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('p_input_stok_pakan'); ?>">
                                <i class="fas fa-warehouse" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Stok Pakan</p>
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
                                        <img src="<?php echo base_url('assets/SIPETGIS/assets/img/petugas lapangan.png'); ?>" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold"><?php echo $this->session->userdata('username') ?: 'Petugas Lapangan'; ?></span>
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Pelaku Usaha</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?></h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Action Card + Input Pelaku Usaha -->
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

                            <!-- Form Container -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header" style="border-bottom: 2px solid #832706;">
                                        <h4 class="card-title" style="color: #832706;">INPUT DATA PELAKU USAHA BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formPelakuUsaha" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="kecamatan_session" id="kecamatan_session" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>">
                                            
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

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Petugas</label>
                                                    <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" placeholder="Masukkan nama petugas" required />
                                                    <div class="invalid-feedback">Nama petugas harus diisi</div>
                                                </div>
                                            </div>

                                            <!-- Alamat Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-map-marker-alt me-2"></i>ALAMAT
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
                                                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" 
                                                                        value="<?php echo ucfirst(strtolower($user_kecamatan)); ?>" 
                                                                        readonly style="background-color: #e9ecef; cursor: not-allowed;" />
                                                                    <small class="text-muted">Kecamatan sesuai dengan wilayah petugas</small>
                                                                    <div class="invalid-feedback">Kecamatan harus diisi</div>
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kelurahan</label>
                                                                    <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                                        <option value="">Pilih Kelurahan</option>
                                                                        <?php 
                                                                        $current_kec = strtoupper($user_kecamatan);
                                                                        if (isset($kel_list[$current_kec]) && is_array($kel_list[$current_kec])): 
                                                                            foreach ($kel_list[$current_kec] as $kel): ?>
                                                                            <option value="<?php echo htmlspecialchars($kel); ?>"><?php echo htmlspecialchars($kel); ?></option>
                                                                        <?php endforeach; 
                                                                        endif; ?>
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
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-globe me-2"></i>TITIK KOORDINAT
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Latitude</label>
                                                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Latitude harus diisi. Klik tombol Ambil Lokasi</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Longitude</label>
                                                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Longitude harus diisi. Klik tombol Ambil Lokasi</div>
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
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-camera me-2"></i>FOTO
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-start">
                                                                <div class="me-3">
                                                                    <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto').click()">
                                                                        <div class="text-center">
                                                                            <i class="fas fa-camera fa-2x mb-2"></i>
                                                                            <div>Klik untuk upload foto</div>
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

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="form-group mb-0">
                                    <label for="filterKelurahan" class="form-label fw-bold">Filter Kelurahan:</label>
                                    <select class="form-select" id="filterKelurahan">
                                        <option selected value="all">Semua Kelurahan</option>
                                        <?php 
                                        // Gunakan data dari controller
                                        $current_kec = strtoupper($user_kecamatan);
                                        if (isset($kel_list[$current_kec]) && is_array($kel_list[$current_kec])): 
                                            foreach ($kel_list[$current_kec] as $kel): ?>
                                            <option value="<?php echo htmlspecialchars($kel); ?>"><?php echo htmlspecialchars($kel); ?></option>
                                        <?php endforeach; 
                                        endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
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
                            <div class="col-md-2 text-end">
                                <button id="filterBtn" class="btn btn-primary-custom"><i class="fas fa-filter me-2"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-secondary-custom ms-2"><i class="fas fa-redo me-2"></i>Reset</button>
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
                                            <th>Alamat</th>
                                            <th>Kelurahan</th>
                                            <th>Nama Petugas</th>
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
                                                    <td class="alamat-cell"><?php echo htmlspecialchars($data['alamat'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama_petugas'] ?? '-'); ?></td>
                                                    <td>
                                                        <?php if (!empty($data['foto'])): ?>
                                                            <img src="<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto']; ?>" 
                                                                class="foto-thumbnail" 
                                                                onclick="showFoto('<?php echo base_url(); ?>uploads/pelaku_usaha/<?php echo $data['foto']; ?>')"
                                                                title="Klik untuk perbesar"
                                                                style="cursor: pointer;">
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Tidak Ada</span>
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
                                <div class="modal-header" style="border-bottom: 2px solid #832706;">
                                    <h5 class="modal-title" style="color: #832706;">Foto Pelaku Usaha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto Pelaku Usaha" style="max-width: 100%; max-height: 80vh;">
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
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>
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
    
    <!-- Variabel Global -->
    <script>
        var base_url = "<?= base_url() ?>";
        var user_kecamatan = "<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>";
        var csrf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
    </script>
    
    <!-- Custom JS Input Pelaku Usaha -->
    <script src="<?php echo base_url('assets/js/p_input_pelaku_usaha.js'); ?>"></script>
</body>
</html>