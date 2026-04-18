<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard Petugas - SIPETGIS</title>
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
    
    <!-- Custom CSS Dashboard Petugas -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/p_dashboard_petugas.css'); ?>" />
</head>

<body>
    <!-- Overlay untuk mobile sidebar -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
                        <li class="nav-item active">
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
                        <!-- Tombol hamburger menu untuk mobile -->
                        <button class="mobile-menu-btn" id="mobileMenuButton">
                            <i class="fas fa-bars"></i>
                        </button>
                        
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
                                                    <h4>Kecamatan <?php echo $this->session->userdata('kecamatan'); ?></h4>
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
                    <!-- Dashboard Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Dashboard</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan'); ?></h6>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-0">
                        <div class="col-12 col-md-6">
                            <div class="card stat-card me-1" style="background: #832706 !important; border: none !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: white; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-users" style="color: #832706 !important; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-2 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category" style="color: white !important; font-weight: 600;">Jumlah Pelaku Usaha</p>
                                                <h4 class="card-title" style="color: white !important; font-weight: 800;"><?= number_format($total_pemilik_usaha, 0, ',', '.') ?></h4>
                                                <p class="card-subtitle" style="color: white !important;">Peternak</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="card stat-card ms-1" style="background: #832706 !important; border: none !important;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: white; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-paw" style="color: #832706 !important; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-2 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category" style="color: white !important; font-weight: 600;">Jenis Ternak</p>
                                                <h4 class="card-title" style="color: white !important; font-weight: 800;"><?= number_format($jumlah_jenis_usaha, 0, ',', '.') ?></h4>
                                                <p class="card-subtitle" style="color: white !important;">Komoditas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Cards Section -->
                    <div class="row mt-4">
                        <!-- Card Pengobatan -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('P_Input_Pengobatan'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-heartbeat action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">PENGOBATAN</h4>
                                                <p class="card-subtitle-action mb-0">Input data pengobatan ternak</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Vaksinasi -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('P_Input_Vaksinasi'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-syringe action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">VAKSINASI</h4>
                                                <p class="card-subtitle-action mb-0">Input data vaksinasi ternak</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Pelaku Usaha -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('P_Input_Pelaku_Usaha'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-users action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">PELAKU USAHA</h4>
                                                <p class="card-subtitle-action mb-0">Input data pelaku usaha</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Jenis Usaha -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('P_Input_Jenis_Usaha'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-store action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">JENIS USAHA</h4>
                                                <p class="card-subtitle-action mb-0">Input data jenis usaha ternak</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Penjual -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('P_Input_Penjual'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-store-alt action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">PENJUAL</h4>
                                                <p class="card-subtitle-action mb-0">Input data penjual pakan dan obat</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Klinik Hewan -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('p_input_klinik_hewan'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-stethoscope action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">KLINIK HEWAN</h4>
                                                <p class="card-subtitle-action mb-0">Input data klinik hewan</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card RPU -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('p_input_rpu'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-chart-line action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">RPU</h4>
                                                <p class="card-subtitle-action mb-0">Input data RPU</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Pemotongan Unggas -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('p_input_pemotongan_unggas'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-cut action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">PEMOTONGAN UNGGAS</h4>
                                                <p class="card-subtitle-action mb-0">Input data pemotongan unggas</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Demplot -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('p_input_demplot'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-seedling action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">DEMPLOT</h4>
                                                <p class="card-subtitle-action mb-0">Input data demplot peternakan</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Stok Pakan -->
                        <div class="col-12 mb-3">
                            <a href="<?php echo base_url('p_input_stok_pakan'); ?>" class="action-link">
                                <div class="card action-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center">
                                            <div class="col-3 col-sm-2 text-center">
                                                <i class="fas fa-warehouse action-icon"></i>
                                            </div>
                                            <div class="col-7 col-sm-8">
                                                <h4 class="card-title-action mb-1">STOK PAKAN</h4>
                                                <p class="card-subtitle-action mb-0">Input data stok pakan</p>
                                            </div>
                                            <div class="col-2 text-end">
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
    
    <!-- Custom JS Dashboard Petugas -->
    <script src="<?php echo base_url('assets/js/p_dashboard_petugas.js'); ?>"></script>
</body>
</html>