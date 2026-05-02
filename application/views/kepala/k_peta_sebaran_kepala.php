<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Peta Sebaran Peternakan - SIPETGIS</title>
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

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS Peta Sebaran -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/peta_sebaran.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- ========== SIDEBAR ========== -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo site_url('k_dashboard_kepala'); ?>" class="logo" style="text-decoration: none">
                        <div style="color: #832706; font-weight: 800; font-size: 24px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing: 0.5px; line-height: 1;">
                            SIPETGIS
                        </div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a href="<?php echo site_url('k_dashboard_kepala'); ?>" style="text-decoration: none">
                                <i class="fas fa-home me-2" style="color: #832706 !important;"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2" style="color: #832706 !important;"></i>
                                    <span>Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="laporanSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo site_url('k_laporan_kepala/kepemilikan_ternak'); ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/history_data_ternak'); ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/vaksinasi'); ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/history_vaksinasi'); ?>" class="nav-link">History Data Vaksinasi</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/pengobatan_ternak'); ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/penjual_pakan'); ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/data_klinik_hewan'); ?>" class="nav-link">Data Klinik Hewan</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/penjual_obat_hewan'); ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/data_tpu_rpu'); ?>" class="nav-link">Data TPU / RPU</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/demplot_peternakan'); ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?php echo site_url('k_laporan_kepala/stok_pakan'); ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url('k_peta_sebaran_kepala'); ?>" style="text-decoration: none">
                                <i class="fas fa-map-marked-alt" style="color: #832706 !important;"></i>
                                <p>Peta Sebaran</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> 

        <div class="main-panel">
            <div class="main-header">
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                           <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold" style="color: #000000 !important;">Kepala Dinas DKPP Surabaya</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li> 
                                            <div class="user-box">
                                                <div class="u-text">
                                                    <h4>Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota Surabaya</h4>
                                                    <p class="text-muted">kepala@dkppsby.go.id</p>
                                                </div> 
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>" style="text-decoration: none">
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
                        <div>
                            <h3 class="fw-bold mb-1" style="color: var(--primary);">Peta Sebaran Peternakan</h3>
                            <h6 class="op-7 mb-0">
                                Visualisasi spasial data peternakan dan fasilitas pendukung Kota Surabaya
                            </h6>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-0 position-relative">
                                    <!-- Loading Overlay -->
                                    <div class="loading-overlay" id="loadingOverlay">
                                        <div class="spinner"></div>
                                    </div>

                                    <!-- Filter Toggle Button (Mobile) -->
                                    <button class="btn-filter-toggle-mobile" id="filterToggleMobile">
                                        <i class="fas fa-filter"></i>
                                    </button>

                                    <!-- FILTER PANEL -->
                                    <div class="filter-panel" id="filterPanel">
                                        <div class="filter-header" id="filterHeader">
                                            <h5>
                                                <i class="fas fa-sliders-h"></i>
                                                Filter Data
                                            </h5>
                                            <button class="filter-toggle-btn" id="toggleFilter" title="Sembunyikan/Tampilkan">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                        </div>
                                        <div class="filter-content" id="filterContent">
                                            <!-- Search Box -->
                                            <div class="search-box">
                                                <input type="text" id="searchInput" placeholder="Cari lokasi atau peternak...">
                                                <i class="fas fa-search"></i>
                                            </div>

                                            <!-- Statistik -->
                                            <div class="statistik-card">
                                                <div class="statistik-item">
                                                    <span class="statistik-label">Total Terfilter:</span>
                                                    <span class="statistik-value" id="totalFiltered">0</span>
                                                </div>
                                                <div class="statistik-item">
                                                    <span class="statistik-label">Jenis Data Aktif:</span>
                                                    <span class="statistik-value" id="activeDataCount">9/9</span>
                                                </div>
                                            </div>

                                            <!-- Filter Section: Jenis Data -->
                                            <div class="filter-section">
                                                <div class="filter-section-title">
                                                    <i class="fas fa-database"></i> Jenis Data
                                                </div>
                                                <div class="data-type-selector" id="dataTypeSelector">
                                                    <button class="data-type-btn active" data-type="pengobatan">
                                                        <i class="fas fa-notes-medical"></i> Pengobatan
                                                    </button>
                                                    <button class="data-type-btn active" data-type="vaksinasi">
                                                        <i class="fas fa-syringe"></i> Vaksinasi
                                                    </button>
                                                    <button class="data-type-btn active" data-type="pelaku_usaha">
                                                        <i class="fas fa-users"></i> Pelaku Usaha
                                                    </button>
                                                    <button class="data-type-btn active" data-type="penjual_pakan">
                                                        <i class="fas fa-seedling"></i> Penjual Pakan
                                                    </button>
                                                    <button class="data-type-btn active" data-type="klinik_hewan">
                                                        <i class="fas fa-clinic-medical"></i> Klinik Hewan
                                                    </button>
                                                    <button class="data-type-btn active" data-type="penjual_obat">
                                                        <i class="fas fa-pills"></i> Penjual Obat
                                                    </button>
                                                    <button class="data-type-btn active" data-type="rpu">
                                                        <i class="fas fa-cut"></i> RPU
                                                    </button>
                                                    <button class="data-type-btn active" data-type="pemotongan_unggas">
                                                        <i class="fas fa-drumstick-bite"></i> Pemotongan Unggas
                                                    </button>
                                                    <button class="data-type-btn active" data-type="demplot">
                                                        <i class="fas fa-seedling"></i> Demplot
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Filter Section: Kecamatan -->
                                            <div class="filter-section">
                                                <div class="filter-section-title">
                                                    <i class="fas fa-map-marker-alt"></i> Kecamatan
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" id="selectAllKecamatan" checked>
                                                    <label class="form-check-label" for="selectAllKecamatan">
                                                        <strong>Pilih Semua Kecamatan</strong>
                                                    </label>
                                                </div>
                                                <div class="kecamatan-list" id="kecamatanList">
                                                    <!-- Kecamatan akan diisi via JavaScript -->
                                                </div>
                                            </div>

                                            <!-- Filter Section: Tanggal -->
                                            <div class="filter-section">
                                                <div class="filter-section-title">
                                                    <i class="fas fa-calendar-alt"></i> Rentang Tanggal
                                                </div>
                                                <div class="date-range">
                                                    <input type="date" class="date-input" id="tanggalMulai" placeholder="Tanggal Mulai">
                                                    <input type="date" class="date-input" id="tanggalSelesai" placeholder="Tanggal Selesai">
                                                </div>
                                                <small class="text-muted">*Berlaku untuk data pengobatan, vaksinasi, RPU, dan pemotongan unggas</small>
                                            </div>

                                            <!-- Filter Actions -->
                                            <button class="btn-apply-filter" id="applyFilter">
                                                <i class="fas fa-check me-2"></i>Terapkan Filter
                                            </button>
                                            <button class="btn-reset-filter" id="resetFilter">
                                                <i class="fas fa-undo me-2"></i>Reset Filter
                                            </button>
                                        </div>
                                        <div class="resize-handle" id="resizeHandle"></div>
                                    </div>

                                    <!-- Map Controls -->
                                    <div class="map-controls">
                                        <button class="map-control-btn" id="zoomInBtn" title="Perbesar">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="map-control-btn" id="zoomOutBtn" title="Perkecil">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button class="map-control-btn" id="resetViewBtn" title="Reset Peta">
                                            <i class="fas fa-home"></i>
                                        </button>
                                        <button class="map-control-btn" id="locateMeBtn" title="Lokasi Saya">
                                            <i class="fas fa-location-arrow"></i>
                                        </button>
                                    </div>

                                    <!-- Total Info -->
                                    <div class="total-info" id="totalInfo">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span id="totalMarkers">0</span> titik ditampilkan
                                    </div>

                                    <!-- LEGENDA -->
                                    <div class="map-legend" id="mapLegend">
                                        <div class="legend-header" id="legendHeader">
                                            <h6><i class="fas fa-info-circle me-2"></i>Legenda</h6>
                                            <button class="legend-toggle-btn" id="toggleLegend">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                        </div>
                                        <div class="legend-content" id="legendContent">
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #ff5252;"></div>
                                                <span class="legend-text">Pengobatan</span>
                                                <span class="legend-count" id="countPengobatan">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #4caf50;"></div>
                                                <span class="legend-text">Vaksinasi</span>
                                                <span class="legend-count" id="countVaksinasi">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #2196f3;"></div>
                                                <span class="legend-text">Pelaku Usaha</span>
                                                <span class="legend-count" id="countPelakuUsaha">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #ff9800;"></div>
                                                <span class="legend-text">Penjual Pakan</span>
                                                <span class="legend-count" id="countPenjualPakan">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #9c27b0;"></div>
                                                <span class="legend-text">Klinik Hewan</span>
                                                <span class="legend-count" id="countKlinik">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #00bcd4;"></div>
                                                <span class="legend-text">Penjual Obat</span>
                                                <span class="legend-count" id="countPenjualObat">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #795548;"></div>
                                                <span class="legend-text">RPU</span>
                                                <span class="legend-count" id="countRPU">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #e91e63;"></div>
                                                <span class="legend-text">Pemotongan Unggas</span>
                                                <span class="legend-count" id="countPemotonganUnggas">0</span>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #8bc34a;"></div>
                                                <span class="legend-text">Demplot</span>
                                                <span class="legend-count" id="countDemplot">0</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Panel -->
                                    <div class="detail-panel" id="detailPanel">
                                        <div class="detail-header" id="detailHeader">
                                            <h5><i class="fas fa-info-circle me-2"></i>Detail Informasi</h5>
                                            <button class="detail-close" id="closeDetailBtn">&times;</button>
                                        </div>
                                        <div class="detail-body" id="detailBody">
                                            <!-- Detail akan diisi via JavaScript -->
                                        </div>
                                    </div>

                                    <!-- Map Container -->
                                    <div id="map"></div>
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
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <!-- jQuery UI untuk draggable -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- Variabel Global -->
    <script>
        var base_url = "<?= base_url() ?>";
        var site_url = "<?= site_url() ?>";
    </script>

    <!-- Custom JS Peta Sebaran -->
    <script src="<?php echo base_url('assets/js/peta_sebaran.js'); ?>"></script>
</body>
</html>