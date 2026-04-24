<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input RPU - SIPETGIS</title>
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
    
    <!-- Custom CSS Input RPU -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/p_input_rpu.css'); ?>" />
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
                            <a href="<?php echo base_url('P_Input_Pengobatan'); ?>">
                                <i class="fas fa-heartbeat" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Pengobatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_Input_Vaksinasi'); ?>">
                                <i class="fas fa-syringe" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Vaksinasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_Input_Pelaku_Usaha'); ?>">
                                <i class="fas fa-users" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Pelaku Usaha</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_Input_Jenis_Usaha'); ?>">
                                <i class="fas fa-store" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Jenis Usaha</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_Input_Penjual'); ?>">
                                <i class="fas fa-store-alt" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Penjual</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('P_Input_Klinik_Hewan'); ?>">
                                <i class="fas fa-stethoscope" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Klinik Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item active">
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Rumah Potong Unggas (RPU)</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?></h6>
                        </div>
                    </div>

                    <!-- Alert Section -->
                    <div id="alert-container"></div>

                    <!-- Action Card + Input RPU -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <!-- Card untuk Tombol Input -->
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT RPU
                                    </button>
                                </div>
                            </div>

                            <!-- Form Container -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header" style="border-bottom: 2px solid #832706;">
                                        <h4 class="card-title" style="color: #832706;">INPUT DATA RPU BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formRpu" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="kecamatan_session" id="kecamatan_session" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>">
                                            
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label required-field">Tanggal RPU</label>
                                                    <input type="date" class="form-control" id="tanggal_rpu" name="tanggal_rpu" required />
                                                    <div class="invalid-feedback">Tanggal RPU harus diisi</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label required-field">Nama RPU/Pejagal</label>
                                                    <select class="form-control" id="pejagal" name="pejagal" required>
                                                        <option value="">Pilih RPU/Pejagal</option>
                                                        <?php if (!empty($pejagal_list)): ?>
                                                            <?php foreach ($pejagal_list as $p): ?>
                                                                <option value="<?php echo htmlspecialchars($p['pejagal']); ?>"><?php echo htmlspecialchars($p['pejagal']); ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        <option value="RPU Baru">[Input RPU Baru]</option>
                                                    </select>
                                                    <div class="invalid-feedback">Nama RPU/Pejagal harus dipilih</div>
                                                </div>
                                                
                                                <div class="col-md-12 mb-3" id="rpuBaruContainer" style="display: none;">
                                                    <input type="text" class="form-control" id="pejagal_baru" name="pejagal_baru" placeholder="Masukkan nama RPU/Pejagal baru">
                                                    <small class="text-muted">Nama RPU/Pejagal baru akan ditambahkan ke database</small>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Perizinan/NIB</label>
                                                    <input type="text" class="form-control" id="perizinan" name="perizinan" placeholder="Masukkan Nomor Perizinan/NIB" />
                                                    <small class="text-muted">Masukkan nomor izin atau NIB jika ada</small>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Tersedia Juleha</label>
                                                    <select class="form-control" id="tersedia_juleha" name="tersedia_juleha">
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                    <small class="text-muted">Apakah tersedia Juru Sembelih Halal?</small>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label required-field">Nama Penanggung Jawab</label>
                                                    <input type="text" class="form-control" id="nama_pj" name="nama_pj" placeholder="Masukkan nama penanggung jawab" required />
                                                    <div class="invalid-feedback">Nama penanggung jawab harus diisi</div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">NIK Penanggung Jawab</label>
                                                    <input type="text" class="form-control" id="nik_pj" name="nik_pj" placeholder="Masukkan NIK" maxlength="16" />
                                                    <small id="nik_info" class="text-muted"></small>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" id="telp_pj" name="telp_pj" placeholder="Masukkan nomor telepon" />
                                                </div>

                                                <div class="col-md-4 mb-3">
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

                                            <!-- Multiple Komoditas Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-list me-2"></i>DATA KOMODITAS POTONG
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered komoditas-table" id="komoditasTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="20%">Komoditas <span class="text-danger">*</span></th>
                                                                            <th width="15%">Jumlah (Ekor) <span class="text-danger">*</span></th>
                                                                            <th width="15%">Berat (Kg) <span class="text-danger">*</span></th>
                                                                            <th width="25%">Asal Unggas <span class="text-danger">*</span></th>
                                                                            <th width="15%">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="komoditasBody">
                                                                        <tr class="komoditas-row">
                                                                            <td>
                                                                                <select class="form-control komoditas" name="komoditas[]" required>
                                                                                    <option value="">Pilih Komoditas</option>
                                                                                    <option value="Ayam Kampung">Ayam Kampung</option>
                                                                                    <option value="Ayam Broiler">Ayam Broiler</option>
                                                                                    <option value="Layer Afkir">Layer Afkir</option>
                                                                                    <option value="Layer Jantan">Layer Jantan</option>
                                                                                    <option value="Itik">Itik</option>
                                                                                    <option value="Entok">Entok</option>
                                                                                </select>
                                                                             </th>
                                                                            <td>
                                                                                <input type="number" class="form-control jumlah_ekor" name="jumlah_ekor[]" min="1" placeholder="Ekor" required />
                                                                             </th>
                                                                            <td>
                                                                                <input type="number" step="0.1" class="form-control berat_kg" name="berat_kg[]" min="0.1" placeholder="Kg" required />
                                                                             </th>
                                                                            <td>
                                                                                <select class="form-control asal_unggas" name="asal_unggas[]" required>
                                                                                    <option value="">Pilih Asal</option>
                                                                                    <option value="Surabaya">Surabaya</option>
                                                                                    <option value="Luar Surabaya">Luar Surabaya</option>
                                                                                </select>
                                                                             </th>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-sm btn-add-row" title="Tambah baris">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                                <button type="button" class="btn btn-sm btn-remove-row" title="Hapus baris" style="display: none;">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                             </th>
                                                                        </tr>
                                                                    </tbody>
                                                                 </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Alamat Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-map-marker-alt me-2"></i>LOKASI RPU
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label required-field">Alamat / Lokasi</label>
                                                                    <textarea class="form-control" id="lokasi" name="lokasi" rows="2" placeholder="Masukkan alamat lengkap lokasi RPU" required></textarea>
                                                                    <div class="invalid-feedback">Alamat/lokasi harus diisi</div>
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
                                                                        if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): 
                                                                            foreach ($kel_list[$user_kec] as $kel): ?>
                                                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                                                        <?php endforeach; 
                                                                        endif; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback">Kelurahan harus dipilih</div>
                                                                </div>

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

                                            <!-- Foto Kegiatan -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
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
                                                                            <small class="text-muted d-block mb-2">Upload foto kegiatan RPU (maks. 5MB, format: JPG, PNG)</small>
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

                                            <!-- Keterangan -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Keterangan</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
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
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterPejagal" class="form-label fw-bold">Filter RPU/Pejagal:</label>
                                    <select class="form-select" id="filterPejagal">
                                        <option selected value="all">Semua RPU</option>
                                        <?php 
                                        if (!empty($pejagal_list)) {
                                            foreach ($pejagal_list as $p): ?>
                                                <option value="<?php echo htmlspecialchars($p['pejagal']); ?>"><?php echo htmlspecialchars($p['pejagal']); ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Komoditas:</label>
                                    <select class="form-select" id="filterKomoditas">
                                        <option selected value="all">Semua Komoditas</option>
                                        <?php 
                                        if (!empty($komoditas_list)) {
                                            foreach ($komoditas_list as $kom): ?>
                                                <option value="<?php echo $kom['komoditas']; ?>"><?php echo $kom['komoditas']; ?></option>
                                            <?php endforeach;
                                        } ?>
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
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary-custom"><i class="fas fa-filter me-2"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-secondary-custom ms-2"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="rpuTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal RPU</th>
                                            <th>Pejagal</th>
                                            <th>Perizinan/NIB</th>
                                            <th>Komoditas</th>
                                            <th>Total Ekor</th>
                                            <th>Juleha</th>
                                            <th>Kelurahan</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($rpu_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($rpu_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo isset($data['tanggal_rpu']) ? date('d-m-Y', strtotime($data['tanggal_rpu'])) : '-'; ?></td>
                                                    <td><?php echo htmlspecialchars($data['pejagal'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['perizinan'] ?? '-'); ?></td>
                                                    <td>
                                                        <?php if (!empty($data['komoditas_badges'])): ?>
                                                            <?php foreach ($data['komoditas_badges'] as $kom): ?>
                                                                <span class="badge bg-info text-white d-inline-block me-1"><?php echo htmlspecialchars($kom); ?></span>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge-ekor"><?php echo number_format($data['total_ekor'] ?? 0); ?> ekor</span>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $juleha = $data['tersedia_juleha'] ?? '-';
                                                        $badge_class = ($juleha == 'Ya') ? 'bg-success' : (($juleha == 'Tidak') ? 'bg-danger' : 'bg-secondary');
                                                        ?>
                                                        <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($juleha); ?></span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td class="text-center">
                                                        <?php if (!empty($data['foto_kegiatan'])): ?>
                                                            <img src="<?php echo base_url(); ?>uploads/rpu/<?php echo $data['foto_kegiatan']; ?>" 
                                                                 class="foto-thumbnail" 
                                                                 onclick="showFoto('<?php echo base_url(); ?>uploads/rpu/<?php echo $data['foto_kegiatan']; ?>')"
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
                                    <h5 class="modal-title" style="color: #832706;">Foto Kegiatan RPU</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="fotoModalImg" src="" alt="Foto Kegiatan RPU" style="max-width: 100%; max-height: 80vh;">
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
    
    <!-- Custom JS Input RPU -->
    <script src="<?php echo base_url('assets/js/p_input_rpu.js'); ?>"></script>
</body>
</html>