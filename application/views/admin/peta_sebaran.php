<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Peta Sebaran Peternakan - SIPETGIS</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />
    <link
        rel="icon"
        href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
        type="image/x-icon"
    />

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

    <style>
        #map {
            height: calc(100vh - 150px);
            width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            z-index: 1;
        }

        .map-controls {
            position: absolute;
            top: 120px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .map-control-btn {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            width: 40px;
            height: 40px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #4361ee;
            cursor: pointer;
            transition: all 0.3s;
        }

        .map-control-btn:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }

        /* LEGENDA - Bisa disembunyikan dan digeser */
        .map-legend {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            width: 250px;
            cursor: move;
            user-select: none;
        }

        .legend-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            padding: 10px 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }

        .legend-header h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .legend-toggle-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .legend-toggle-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .legend-content {
            padding: 15px;
            transition: all 0.3s;
        }

        .legend-content.collapsed {
            display: none;
        }

        .legend-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #1e3a8a;
            font-size: 14px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .legend-color {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid white;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .legend-text {
            font-size: 13px;
            color: #495057;
            flex: 1;
        }

        .legend-count {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
            color: #495057;
        }

        /* FILTER PANEL - Bisa digeser dan disembunyikan */
        .filter-panel {
            position: absolute;
            top: 120px;
            left: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            width: 320px;
            display: flex;
            flex-direction: column;
            cursor: move;
            user-select: none;
            resize: both;
            overflow: hidden;
            min-width: 280px;
            max-width: 500px;
            max-height: 80vh;
        }

        .filter-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }

        .filter-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-header i {
            font-size: 14px;
        }

        .filter-toggle-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .filter-toggle-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .filter-content {
            padding: 15px;
            overflow-y: auto;
            flex: 1;
            cursor: default;
            transition: all 0.3s;
        }

        .filter-content.collapsed {
            display: none;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .filter-section-title i {
            margin-right: 8px;
            color: #4361ee;
        }

        .data-type-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .data-type-btn {
            border: 1px solid #dee2e6;
            border-radius: 20px;
            padding: 6px 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .data-type-btn:hover {
            background: #f8f9fa;
        }

        .data-type-btn.active {
            background: #4361ee;
            color: white;
            border-color: #4361ee;
        }

        .kecamatan-list {
            max-height: 150px;
            overflow-y: auto;
            margin-top: 10px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 10px;
        }

        .kecamatan-item {
            display: flex;
            align-items: center;
            padding: 5px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }

        .kecamatan-item:hover {
            background-color: #f8f9fa;
        }

        .kecamatan-item:last-child {
            border-bottom: none;
        }

        .kecamatan-checkbox {
            margin-right: 8px;
        }

        .kecamatan-name {
            flex-grow: 1;
            font-size: 13px;
        }

        .kecamatan-count {
            background-color: #e9ecef;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
            color: #495057;
        }

        .date-range {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }

        .date-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 13px;
        }

        .btn-apply-filter {
            width: 100%;
            padding: 10px;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            margin-bottom: 8px;
        }

        .btn-apply-filter:hover {
            background: #3a56d4;
        }

        .btn-reset-filter {
            width: 100%;
            padding: 10px;
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-reset-filter:hover {
            background: #e9ecef;
        }

        .total-info {
            position: absolute;
            top: 120px;
            right: 70px;
            background: white;
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            font-size: 13px;
            font-weight: 600;
            color: #4361ee;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-box {
            position: relative;
            margin-bottom: 15px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 35px 10px 10px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 13px;
        }

        .search-box i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .statistik-card {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .statistik-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .statistik-label {
            color: #666;
        }

        .statistik-value {
            font-weight: 600;
            color: #4361ee;
        }

        .btn-filter-toggle-mobile {
            position: absolute;
            top: 120px;
            left: 20px;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            width: 45px;
            height: 45px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #4361ee;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
        }

        .btn-filter-toggle-mobile:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .btn-filter-toggle-mobile {
                display: flex;
            }
            
            .filter-panel {
                display: none;
                width: calc(100% - 40px);
                left: 10px;
                top: 100px;
            }
            
            .filter-panel.active {
                display: flex;
            }
            
            .map-controls {
                top: 100px;
            }

            .total-info {
                top: 100px;
                right: 60px;
            }

            .map-legend {
                bottom: 10px;
                right: 10px;
                width: 200px;
            }
        }

        .detail-panel {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.2);
            z-index: 1000;
            width: 350px;
            max-height: 450px;
            overflow-y: auto;
            display: none;
        }

        .detail-panel.active {
            display: block;
        }

        .detail-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: move;
        }

        .detail-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .detail-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 20px;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .detail-close:hover {
            opacity: 1;
        }

        .detail-body {
            padding: 15px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            width: 120px;
            color: #666;
            font-size: 13px;
        }

        .detail-value {
            flex: 1;
            color: #333;
            font-size: 13px;
        }

        .leaflet-popup-content {
            min-width: 250px;
        }

        .popup-title {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 10px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .popup-item {
            display: flex;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .popup-label {
            font-weight: 600;
            width: 100px;
            color: #666;
        }

        .popup-value {
            flex: 1;
            color: #333;
        }

        .popup-btn {
            width: 100%;
            margin-top: 10px;
            padding: 8px;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }

        .popup-btn:hover {
            background: #3a56d4;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            z-index: 2000;
            display: none;
            justify-content: center;
            align-items: center;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4361ee;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .resize-handle {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 15px;
            height: 15px;
            cursor: se-resize;
            background: linear-gradient(135deg, transparent 50%, #999 50%);
            border-radius: 0 0 8px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing: 0.5px;">
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
                            <a href="<?php echo base_url(); ?>">
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
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#masterDataSubmenu">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-database me-2"></i>
                                    <span>Master Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>pelaku_usaha" class="nav-link">Pelaku Usaha</a></li>
                                    <li><a href="<?php echo base_url(); ?>akses_pengguna" class="nav-link">Akses Pengguna</a></li>
                                    <li><a href="<?php echo base_url(); ?>pengobatan" class="nav-link">Pengobatan</a></li>
                                    <li><a href="<?php echo base_url(); ?>vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>komoditas" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2"></i>
                                    <span>Data</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>data_kepemilikan" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_vaksinasi" class="nav-link">History Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('data_klinik') ?>" class="nav-link">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>laporan">
                                <i class="fas fa-chart-bar"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a href="<?= site_url('peta_sebaran') ?>">
                                <i class="fas fa-map-marked-alt"></i>
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
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" class="avatar-img rounded-circle">
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold">Administrator</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <li>
                                        <div class="user-box">
                                            <div class="u-text">
                                                <h4>Administrator</h4>
                                                <p class="text-muted">admin@dkppsby.go.id</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">
                                            <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                        </a>
                                    </li>
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
                            <h3 class="fw-bold mb-1">Peta Sebaran Peternakan</h3>
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

                                    <!-- FILTER PANEL - Bisa digeser dan disembunyikan -->
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
                                                    <span class="statistik-value" id="activeDataCount">6/6</span>
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
                                                <small class="text-muted">*Berlaku untuk data pengobatan & vaksinasi</small>
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

                                    <!-- LEGENDA - Bisa digeser dan disembunyikan -->
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

    <script>
    // DATA DUMMY LENGKAP
    const dataDummy = {
        pengobatan: Array(50).fill().map((_, i) => ({
            id: i + 1,
            nama_peternak: `Peternak ${i + 1}`,
            alamat: `Jl. Contoh No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            tanggal_pengobatan: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
            diagnosa: ['Demam', 'Diare', 'Mastitis', 'Cacingan', 'Luka'][Math.floor(Math.random() * 5)],
            id_obat: Math.floor(Math.random() * 10) + 1,
            keterangan: 'Pengobatan rutin'
        })),

        vaksinasi: Array(40).fill().map((_, i) => ({
            id: i + 1,
            nama_peternak: `Peternak Vaksin ${i + 1}`,
            alamat: `Jl. Vaksin No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            tanggal_vaksinasi: `2024-${String(Math.floor(Math.random() * 12) + 1).padStart(2, '0')}-${String(Math.floor(Math.random() * 28) + 1).padStart(2, '0')}`,
            id_vaksin: Math.floor(Math.random() * 5) + 1,
            jumlah_ternak: Math.floor(Math.random() * 100) + 10,
            keterangan: 'Vaksinasi rutin'
        })),

        pelaku_usaha: Array(30).fill().map((_, i) => ({
            id: i + 1,
            nama_pelaku: `Pengusaha ${i + 1}`,
            alamat: `Jl. Usaha No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            jenis_usaha: ['Peternakan', 'Pembibitan', 'Penggemukan'][Math.floor(Math.random() * 3)],
            skala_usaha: ['Kecil', 'Menengah', 'Besar'][Math.floor(Math.random() * 3)],
            no_hp: '08123456789'
        })),

        penjual_pakan: Array(25).fill().map((_, i) => ({
            id: i + 1,
            nama_toko: `Toko Pakan ${i + 1}`,
            pemilik: `Pemilik ${i + 1}`,
            alamat: `Jl. Pakan No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            jenis_pakan: ['Konsentrat', 'Hijauan', 'Pelet', 'Jagung'][Math.floor(Math.random() * 4)],
            no_hp: '08123456789'
        })),

        klinik_hewan: Array(15).fill().map((_, i) => ({
            id: i + 1,
            nama_klinik: `Klinik Hewan ${i + 1}`,
            dokter_hewan: `Dokter ${i + 1}`,
            alamat: `Jl. Klinik No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            layanan: ['Umum', 'Spesialis', '24 Jam'][Math.floor(Math.random() * 3)],
            no_hp: '08123456789',
            jam_operasional: '08:00 - 20:00'
        })),

        penjual_obat: Array(20).fill().map((_, i) => ({
            id: i + 1,
            nama_toko: `Apotek Hewan ${i + 1}`,
            pemilik: `Pemilik ${i + 1}`,
            alamat: `Jl. Obat No. ${i + 1}, Surabaya`,
            latitude: -7.2575 + (Math.random() - 0.5) * 0.1,
            longitude: 112.7521 + (Math.random() - 0.5) * 0.1,
            id_kecamatan: Math.floor(Math.random() * 31) + 1,
            no_sipa: 'SIPA/' + String(Math.floor(Math.random() * 1000)).padStart(3, '0'),
            no_hp: '08123456789'
        }))
    };

    // Data Kecamatan Surabaya
    const kecamatanData = [
        { id: 1, nama_kecamatan: 'Asemrowo', latitude: -7.2050, longitude: 112.7079 },
        { id: 2, nama_kecamatan: 'Benowo', latitude: -7.2296, longitude: 112.6523 },
        { id: 3, nama_kecamatan: 'Bubutan', latitude: -7.2455, longitude: 112.7293 },
        { id: 4, nama_kecamatan: 'Bulak', latitude: -7.2299, longitude: 112.7871 },
        { id: 5, nama_kecamatan: 'Dukuh Pakis', latitude: -7.2759, longitude: 112.6907 },
        { id: 6, nama_kecamatan: 'Gayungan', latitude: -7.3246, longitude: 112.7349 },
        { id: 7, nama_kecamatan: 'Genteng', latitude: -7.2569, longitude: 112.7482 },
        { id: 8, nama_kecamatan: 'Gubeng', latitude: -7.2841, longitude: 112.7536 },
        { id: 9, nama_kecamatan: 'Gununganyar', latitude: -7.3331, longitude: 112.7866 },
        { id: 10, nama_kecamatan: 'Jambangan', latitude: -7.3249, longitude: 112.7135 },
        { id: 11, nama_kecamatan: 'Karangpilang', latitude: -7.3193, longitude: 112.6768 },
        { id: 12, nama_kecamatan: 'Kenjeran', latitude: -7.2478, longitude: 112.7799 },
        { id: 13, nama_kecamatan: 'Krembangan', latitude: -7.2372, longitude: 112.7377 },
        { id: 14, nama_kecamatan: 'Lakarsantri', latitude: -7.2914, longitude: 112.6495 },
        { id: 15, nama_kecamatan: 'Mulyorejo', latitude: -7.2760, longitude: 112.7856 },
        { id: 16, nama_kecamatan: 'Pabean Cantian', latitude: -7.2337, longitude: 112.7311 },
        { id: 17, nama_kecamatan: 'Pakal', latitude: -7.2876, longitude: 112.6298 },
        { id: 18, nama_kecamatan: 'Rungkut', latitude: -7.3177, longitude: 112.7785 },
        { id: 19, nama_kecamatan: 'Sambikerep', latitude: -7.2971, longitude: 112.6668 },
        { id: 20, nama_kecamatan: 'Sawahan', latitude: -7.2771, longitude: 112.7291 },
        { id: 21, nama_kecamatan: 'Semampir', latitude: -7.2347, longitude: 112.7453 },
        { id: 22, nama_kecamatan: 'Simokerto', latitude: -7.2448, longitude: 112.7434 },
        { id: 23, nama_kecamatan: 'Sukolilo', latitude: -7.2875, longitude: 112.7772 },
        { id: 24, nama_kecamatan: 'Sukomanunggal', latitude: -7.2963, longitude: 112.6982 },
        { id: 25, nama_kecamatan: 'Tambaksari', latitude: -7.2593, longitude: 112.7604 },
        { id: 26, nama_kecamatan: 'Tandes', latitude: -7.2591, longitude: 112.6728 },
        { id: 27, nama_kecamatan: 'Tegalsari', latitude: -7.2645, longitude: 112.7428 },
        { id: 28, nama_kecamatan: 'Tenggilis Mejoyo', latitude: -7.3158, longitude: 112.7635 },
        { id: 29, nama_kecamatan: 'Wiyung', latitude: -7.3202, longitude: 112.6983 },
        { id: 30, nama_kecamatan: 'Wonocolo', latitude: -7.3101, longitude: 112.7246 },
        { id: 31, nama_kecamatan: 'Wonokromo', latitude: -7.2995, longitude: 112.7377 }
    ];

    // Gabungkan data
    const dataDariServer = {
        pengobatan: dataDummy.pengobatan,
        vaksinasi: dataDummy.vaksinasi,
        pelaku_usaha: dataDummy.pelaku_usaha,
        penjual_pakan: dataDummy.penjual_pakan,
        klinik_hewan: dataDummy.klinik_hewan,
        penjual_obat: dataDummy.penjual_obat,
        kecamatan: kecamatanData
    };

    // Variabel global
    let map;
    let markerCluster;
    let allMarkers = [];
    let activeDataTypes = new Set(['pengobatan', 'vaksinasi', 'pelaku_usaha', 'penjual_pakan', 'klinik_hewan', 'penjual_obat']);
    let selectedKecamatan = new Set(kecamatanData.map(k => k.id));
    let tanggalMulai = null;
    let tanggalSelesai = null;

    // Warna marker
    const warnaMarker = {
        pengobatan: '#ff5252',
        vaksinasi: '#4caf50',
        pelaku_usaha: '#2196f3',
        penjual_pakan: '#ff9800',
        klinik_hewan: '#9c27b0',
        penjual_obat: '#00bcd4'
    };

    const ikonMarker = {
        pengobatan: 'fa-notes-medical',
        vaksinasi: 'fa-syringe',
        pelaku_usaha: 'fa-users',
        penjual_pakan: 'fa-seedling',
        klinik_hewan: 'fa-clinic-medical',
        penjual_obat: 'fa-pills'
    };

    // Inisialisasi
    $(document).ready(function() {
        initMap();
        makeDraggable();
        initToggles();
        initResizable();
    });

    // Inisialisasi peta
    function initMap() {
        map = L.map('map').setView([-7.2575, 112.7521], 12);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        map.removeControl(map.zoomControl);

        markerCluster = L.markerClusterGroup({
            maxClusterRadius: 50,
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true
        });

        map.addLayer(markerCluster);

        loadKecamatanToFilter();
        loadDataKePeta();
        setupEventListeners();
    }

    // Buat elemen bisa digeser
    function makeDraggable() {
        $("#filterPanel").draggable({
            handle: "#filterHeader",
            containment: "window"
        });

        $("#mapLegend").draggable({
            handle: "#legendHeader",
            containment: "window"
        });

        $("#detailPanel").draggable({
            handle: "#detailHeader",
            containment: "window"
        });
    }

    // Inisialisasi toggle untuk filter dan legenda
    function initToggles() {
        // Toggle filter panel
        $("#toggleFilter").click(function() {
            $("#filterContent").slideToggle();
            $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
        });

        // Toggle legend
        $("#toggleLegend").click(function() {
            $("#legendContent").slideToggle();
            $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
        });

        // Toggle filter panel mobile
        $("#filterToggleMobile").click(function() {
            $("#filterPanel").toggleClass('active');
        });
    }

    // Resize filter panel
    function initResizable() {
        const panel = document.getElementById('filterPanel');
        const handle = document.getElementById('resizeHandle');
        
        handle.addEventListener('mousedown', function(e) {
            e.preventDefault();
            const startX = e.clientX;
            const startY = e.clientY;
            const startWidth = parseInt(document.defaultView.getComputedStyle(panel).width, 10);
            const startHeight = parseInt(document.defaultView.getComputedStyle(panel).height, 10);

            function doDrag(e) {
                const newWidth = startWidth + (e.clientX - startX);
                const newHeight = startHeight + (e.clientY - startY);
                panel.style.width = newWidth + 'px';
                panel.style.height = newHeight + 'px';
            }

            function stopDrag() {
                document.documentElement.removeEventListener('mousemove', doDrag, false);
                document.documentElement.removeEventListener('mouseup', stopDrag, false);
            }

            document.documentElement.addEventListener('mousemove', doDrag, false);
            document.documentElement.addEventListener('mouseup', stopDrag, false);
        });
    }

    // Load kecamatan ke filter
    function loadKecamatanToFilter() {
        const list = document.getElementById('kecamatanList');
        list.innerHTML = '';
        
        kecamatanData.forEach(k => {
            const item = document.createElement('div');
            item.className = 'kecamatan-item';
            item.innerHTML = `
                <input type="checkbox" class="kecamatan-checkbox form-check-input" 
                       id="kec_${k.id}" value="${k.id}" checked>
                <label class="kecamatan-name" for="kec_${k.id}">${k.nama_kecamatan}</label>
                <span class="kecamatan-count" id="count_${k.id}">0</span>
            `;
            list.appendChild(item);
        });

        document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const id = parseInt(this.value);
                if (this.checked) {
                    selectedKecamatan.add(id);
                } else {
                    selectedKecamatan.delete(id);
                }
                updateSelectAllCheckbox();
                loadDataKePeta();
            });
        });

        document.getElementById('selectAllKecamatan').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
                cb.checked = checked;
                const id = parseInt(cb.value);
                if (checked) {
                    selectedKecamatan.add(id);
                } else {
                    selectedKecamatan.delete(id);
                }
            });
            loadDataKePeta();
        });
    }

    function updateSelectAllCheckbox() {
        const allChecked = document.querySelectorAll('.kecamatan-checkbox:checked').length === kecamatanData.length;
        document.getElementById('selectAllKecamatan').checked = allChecked;
    }

    // Load data ke peta
    function loadDataKePeta() {
        showLoading();
        
        markerCluster.clearLayers();
        allMarkers = [];

        let totalMarkers = 0;
        const counts = {
            pengobatan: 0,
            vaksinasi: 0,
            pelaku_usaha: 0,
            penjual_pakan: 0,
            klinik_hewan: 0,
            penjual_obat: 0
        };

        activeDataTypes.forEach(jenis => {
            const data = dataDariServer[jenis] || [];
            
            data.forEach(item => {
                if (!selectedKecamatan.has(item.id_kecamatan)) {
                    return;
                }

                if (jenis === 'pengobatan' || jenis === 'vaksinasi') {
                    if (tanggalMulai && tanggalSelesai) {
                        const tglItem = jenis === 'pengobatan' ? item.tanggal_pengobatan : item.tanggal_vaksinasi;
                        if (tglItem < tanggalMulai || tglItem > tanggalSelesai) {
                            return;
                        }
                    }
                }

                const marker = createMarker(item, jenis);
                markerCluster.addLayer(marker);
                
                allMarkers.push({ marker, data: item, jenis });
                totalMarkers++;
                counts[jenis]++;
            });
        });

        document.getElementById('totalMarkers').innerText = totalMarkers;
        document.getElementById('totalFiltered').innerText = totalMarkers;
        
        // Update legend counts
        document.getElementById('countPengobatan').innerText = counts.pengobatan;
        document.getElementById('countVaksinasi').innerText = counts.vaksinasi;
        document.getElementById('countPelakuUsaha').innerText = counts.pelaku_usaha;
        document.getElementById('countPenjualPakan').innerText = counts.penjual_pakan;
        document.getElementById('countKlinik').innerText = counts.klinik_hewan;
        document.getElementById('countPenjualObat').innerText = counts.penjual_obat;
        
        updateKecamatanCounts();
        hideLoading();
    }

    // Buat marker
    function createMarker(item, jenis) {
        const icon = L.divIcon({
            html: `<div style="background-color: ${warnaMarker[jenis]}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                    <i class="fas ${ikonMarker[jenis]}"></i>
                   </div>`,
            className: 'custom-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12]
        });

        const marker = L.marker([item.latitude, item.longitude], { icon });
        
        const popupContent = createPopupContent(item, jenis);
        marker.bindPopup(popupContent);

        marker.on('click', () => {
            showDetailPanel(item, jenis);
        });

        return marker;
    }

    // Buat konten popup
    function createPopupContent(item, jenis) {
        let content = `<div class="popup-title">`;
        let namaKecamatan = kecamatanData.find(k => k.id === item.id_kecamatan)?.nama_kecamatan || '-';
        
        switch(jenis) {
            case 'pengobatan':
                content += `<i class="fas fa-notes-medical me-2" style="color: ${warnaMarker[jenis]}"></i>Data Pengobatan`;
                break;
            case 'vaksinasi':
                content += `<i class="fas fa-syringe me-2" style="color: ${warnaMarker[jenis]}"></i>Data Vaksinasi`;
                break;
            case 'pelaku_usaha':
                content += `<i class="fas fa-users me-2" style="color: ${warnaMarker[jenis]}"></i>Pelaku Usaha`;
                break;
            case 'penjual_pakan':
                content += `<i class="fas fa-seedling me-2" style="color: ${warnaMarker[jenis]}"></i>Penjual Pakan`;
                break;
            case 'klinik_hewan':
                content += `<i class="fas fa-clinic-medical me-2" style="color: ${warnaMarker[jenis]}"></i>Klinik Hewan`;
                break;
            case 'penjual_obat':
                content += `<i class="fas fa-pills me-2" style="color: ${warnaMarker[jenis]}"></i>Penjual Obat`;
                break;
        }
        
        content += `</div>`;

        switch(jenis) {
            case 'pengobatan':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Peternak:</span>
                        <span class="popup-value">${item.nama_peternak || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Tanggal:</span>
                        <span class="popup-value">${item.tanggal_pengobatan || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Diagnosa:</span>
                        <span class="popup-value">${item.diagnosa || '-'}</span>
                    </div>
                `;
                break;
                
            case 'vaksinasi':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Peternak:</span>
                        <span class="popup-value">${item.nama_peternak || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Tanggal:</span>
                        <span class="popup-value">${item.tanggal_vaksinasi || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Jumlah:</span>
                        <span class="popup-value">${item.jumlah_ternak || '0'} ekor</span>
                    </div>
                `;
                break;
                
            case 'pelaku_usaha':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Nama:</span>
                        <span class="popup-value">${item.nama_pelaku || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Jenis Usaha:</span>
                        <span class="popup-value">${item.jenis_usaha || '-'}</span>
                    </div>
                `;
                break;
                
            case 'penjual_pakan':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Toko:</span>
                        <span class="popup-value">${item.nama_toko || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Pemilik:</span>
                        <span class="popup-value">${item.pemilik || '-'}</span>
                    </div>
                `;
                break;
                
            case 'klinik_hewan':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Klinik:</span>
                        <span class="popup-value">${item.nama_klinik || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Dokter:</span>
                        <span class="popup-value">${item.dokter_hewan || '-'}</span>
                    </div>
                `;
                break;
                
            case 'penjual_obat':
                content += `
                    <div class="popup-item">
                        <span class="popup-label">Toko:</span>
                        <span class="popup-value">${item.nama_toko || '-'}</span>
                    </div>
                    <div class="popup-item">
                        <span class="popup-label">Pemilik:</span>
                        <span class="popup-value">${item.pemilik || '-'}</span>
                    </div>
                `;
                break;
        }

        content += `
            <div class="popup-item">
                <span class="popup-label">Kecamatan:</span>
                <span class="popup-value">${namaKecamatan}</span>
            </div>
            <div class="popup-item">
                <span class="popup-label">Alamat:</span>
                <span class="popup-value">${item.alamat || '-'}</span>
            </div>
            <button class="popup-btn" onclick="showDetailFromPopup('${jenis}', ${item.id})">
                <i class="fas fa-info-circle me-1"></i>Lihat Detail
            </button>
        `;

        return content;
    }

    window.showDetailFromPopup = function(jenis, id) {
        const data = dataDariServer[jenis];
        const item = data.find(d => d.id == id);
        if (item) {
            showDetailPanel(item, jenis);
        }
    };

    function showDetailPanel(item, jenis) {
        const panel = document.getElementById('detailPanel');
        const body = document.getElementById('detailBody');
        let namaKecamatan = kecamatanData.find(k => k.id === item.id_kecamatan)?.nama_kecamatan || '-';
        
        let html = '';
        
        switch(jenis) {
            case 'pengobatan':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Pengobatan</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Peternak:</span>
                        <span class="detail-value">${item.nama_peternak || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">${item.tanggal_pengobatan || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Diagnosa:</span>
                        <span class="detail-value">${item.diagnosa || '-'}</span>
                    </div>
                `;
                break;
                
            case 'vaksinasi':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Vaksinasi</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Peternak:</span>
                        <span class="detail-value">${item.nama_peternak || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal:</span>
                        <span class="detail-value">${item.tanggal_vaksinasi || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jumlah:</span>
                        <span class="detail-value">${item.jumlah_ternak || '0'} ekor</span>
                    </div>
                `;
                break;
                
            case 'pelaku_usaha':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Pelaku Usaha</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama:</span>
                        <span class="detail-value">${item.nama_pelaku || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Usaha:</span>
                        <span class="detail-value">${item.jenis_usaha || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Skala:</span>
                        <span class="detail-value">${item.skala_usaha || '-'}</span>
                    </div>
                `;
                break;
                
            case 'penjual_pakan':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Penjual Pakan</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Toko:</span>
                        <span class="detail-value">${item.nama_toko || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Pemilik:</span>
                        <span class="detail-value">${item.pemilik || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Pakan:</span>
                        <span class="detail-value">${item.jenis_pakan || '-'}</span>
                    </div>
                `;
                break;
                
            case 'klinik_hewan':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Klinik Hewan</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Klinik:</span>
                        <span class="detail-value">${item.nama_klinik || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Dokter:</span>
                        <span class="detail-value">${item.dokter_hewan || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Layanan:</span>
                        <span class="detail-value">${item.layanan || '-'}</span>
                    </div>
                `;
                break;
                
            case 'penjual_obat':
                html = `
                    <div class="detail-row">
                        <span class="detail-label">Jenis Data:</span>
                        <span class="detail-value">Penjual Obat</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Toko:</span>
                        <span class="detail-value">${item.nama_toko || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Pemilik:</span>
                        <span class="detail-value">${item.pemilik || '-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">No. SIPA:</span>
                        <span class="detail-value">${item.no_sipa || '-'}</span>
                    </div>
                `;
                break;
        }
        
        html += `
            <div class="detail-row">
                <span class="detail-label">Kecamatan:</span>
                <span class="detail-value">${namaKecamatan}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Alamat:</span>
                <span class="detail-value">${item.alamat || '-'}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">No. HP:</span>
                <span class="detail-value">${item.no_hp || '-'}</span>
            </div>
        `;
        
        body.innerHTML = html;
        panel.classList.add('active');
    }

    function updateKecamatanCounts() {
        const counts = {};
        kecamatanData.forEach(k => counts[k.id] = 0);

        allMarkers.forEach(({ data }) => {
            const idKec = data.id_kecamatan;
            if (counts[idKec] !== undefined) {
                counts[idKec]++;
            }
        });

        Object.keys(counts).forEach(idKec => {
            const el = document.getElementById(`count_${idKec}`);
            if (el) {
                el.innerText = counts[idKec];
            }
        });
    }

    function setupEventListeners() {
        // Data type selector
        document.querySelectorAll('.data-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.toggle('active');
                const dataType = this.dataset.type;
                
                if (this.classList.contains('active')) {
                    activeDataTypes.add(dataType);
                } else {
                    activeDataTypes.delete(dataType);
                }
                
                document.getElementById('activeDataCount').innerText = `${activeDataTypes.size}/6`;
                loadDataKePeta();
            });
        });

        // Apply filter
        document.getElementById('applyFilter').addEventListener('click', function() {
            tanggalMulai = document.getElementById('tanggalMulai').value;
            tanggalSelesai = document.getElementById('tanggalSelesai').value;
            loadDataKePeta();
        });

        // Reset filter
        document.getElementById('resetFilter').addEventListener('click', function() {
            document.querySelectorAll('.data-type-btn').forEach(btn => {
                btn.classList.add('active');
            });
            activeDataTypes = new Set(['pengobatan', 'vaksinasi', 'pelaku_usaha', 'penjual_pakan', 'klinik_hewan', 'penjual_obat']);
            document.getElementById('activeDataCount').innerText = '6/6';

            document.querySelectorAll('.kecamatan-checkbox').forEach(cb => {
                cb.checked = true;
                selectedKecamatan.add(parseInt(cb.value));
            });
            document.getElementById('selectAllKecamatan').checked = true;

            document.getElementById('tanggalMulai').value = '';
            document.getElementById('tanggalSelesai').value = '';
            tanggalMulai = null;
            tanggalSelesai = null;

            document.getElementById('searchInput').value = '';

            loadDataKePeta();
        });

        // Search
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            
            if (keyword.length < 3) return;

            for (let { marker, data, jenis } of allMarkers) {
                let match = false;
                
                switch(jenis) {
                    case 'pengobatan':
                    case 'vaksinasi':
                        match = data.nama_peternak && data.nama_peternak.toLowerCase().includes(keyword);
                        break;
                    case 'pelaku_usaha':
                        match = data.nama_pelaku && data.nama_pelaku.toLowerCase().includes(keyword);
                        break;
                    case 'penjual_pakan':
                    case 'penjual_obat':
                        match = (data.nama_toko && data.nama_toko.toLowerCase().includes(keyword)) ||
                               (data.pemilik && data.pemilik.toLowerCase().includes(keyword));
                        break;
                    case 'klinik_hewan':
                        match = (data.nama_klinik && data.nama_klinik.toLowerCase().includes(keyword)) ||
                               (data.dokter_hewan && data.dokter_hewan.toLowerCase().includes(keyword));
                        break;
                }

                if (match) {
                    marker.openPopup();
                    map.setView(marker.getLatLng(), 15);
                    break;
                }
            }
        });

        // Map controls
        document.getElementById('zoomInBtn').addEventListener('click', () => map.zoomIn());
        document.getElementById('zoomOutBtn').addEventListener('click', () => map.zoomOut());
        document.getElementById('resetViewBtn').addEventListener('click', () => map.setView([-7.2575, 112.7521], 12));
        
        document.getElementById('locateMeBtn').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => map.setView([position.coords.latitude, position.coords.longitude], 15),
                    () => alert('Tidak dapat mengakses lokasi Anda')
                );
            } else {
                alert('Browser tidak mendukung geolokasi');
            }
        });

        // Close detail panel
        document.getElementById('closeDetailBtn').addEventListener('click', function() {
            document.getElementById('detailPanel').classList.remove('active');
        });

        // Click outside to close detail panel
        document.addEventListener('click', function(e) {
            const panel = document.getElementById('detailPanel');
            if (panel.classList.contains('active') && 
                !panel.contains(e.target) && 
                !e.target.closest('.leaflet-popup-content')) {
                panel.classList.remove('active');
            }
        });
    }

    function showLoading() {
        document.getElementById('loadingOverlay').classList.add('active');
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('active');
    }
    </script>
</body>
</html>