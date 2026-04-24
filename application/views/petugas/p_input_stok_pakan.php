<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Stok Pakan - SIPETGIS</title>
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
    
    <!-- Custom CSS Input Stok Pakan -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/p_input_stok_pakan.css'); ?>" />
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
                            <a href="<?php echo base_url('P_Input_Demplot'); ?>">
                                <i class="fas fa-seedling" style="color: #832706 !important;"></i>
                                <p style="color: #832706 !important;">Demplot</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a href="<?php echo base_url('P_Input_Stok_Pakan'); ?>">
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Stok Pakan Ternak</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?></h6>
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

                            <!-- Form Container -->
                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header" style="border-bottom: 2px solid #832706;">
                                        <h4 class="card-title" style="color: #832706;">INPUT DATA STOK PAKAN BARU</h4>
                                    </div>
                                    <div class="card-body">
                                        <form id="formStokPakan">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="kecamatan_session" id="kecamatan_session" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>">
                                            
                                            <div class="row">
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

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal</label>
                                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                                                    <div class="invalid-feedback">Tanggal harus diisi</div>
                                                </div>

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

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Merk Pakan</label>
                                                    <input type="text" class="form-control" id="merk_pakan" name="merk_pakan" placeholder="Masukkan merk pakan" required />
                                                    <div class="invalid-feedback">Merk pakan harus diisi</div>
                                                </div>
                                            </div>

                                            <!-- Data Stok Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address" style="border-bottom: 2px solid #832706;">
                                                            <h5 class="card-title mb-0" style="color: #832706;">
                                                                <i class="fas fa-cubes me-2"></i>DATA STOK
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Awal (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_awal" name="stok_awal" placeholder="Stok awal" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok awal harus diisi (minimal 0)</div>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Masuk (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_masuk" name="stok_masuk" placeholder="Stok masuk" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok masuk harus diisi (minimal 0)</div>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label required-field">Stok Keluar (kg)</label>
                                                                    <input type="number" class="form-control" id="stok_keluar" name="stok_keluar" placeholder="Stok keluar" min="0" step="1" required />
                                                                    <div class="invalid-feedback">Stok keluar harus diisi (minimal 0)</div>
                                                                </div>
                                                            </div>
                                                            
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

                    <!-- Filter Section -->
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
                                <button id="filterBtn" class="btn btn-primary-custom"><i class="fas fa-filter me-2"></i>Filter Data</button>
                                <button id="resetBtn" class="btn btn-secondary-custom ms-2"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="stokPakanTable" class="table table-bordered table-hover">
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
                                    <tbody>
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
                                                    <td class="text-end fw-bold"><?php echo number_format($data['stok_akhir'] ?? 0, 0, ',', '.'); ?> kg</td>
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
    
    <!-- Custom JS Input Stok Pakan -->
    <script src="<?php echo base_url('assets/js/p_input_stok_pakan.js'); ?>"></script>
</body>
</html>