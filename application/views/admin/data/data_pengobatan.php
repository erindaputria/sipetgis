<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - History Data Pengobatan</title>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" />

    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        .dashboard-header { background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%); color: white; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .stat-card { border-radius: 10px; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .stat-icon { font-size: 2.5rem; opacity: 0.8; }
        .filter-section { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px; border: 1px solid #dee2e6; }
        .table-responsive { border-radius: 8px; overflow-x: auto; overflow-y: visible; }
        .table th { background-color: #f8f9fa; font-weight: 600; white-space: nowrap; }
        .table td { white-space: nowrap; vertical-align: middle; }
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { padding: 10px; }
        
        /* Style untuk tombol DataTables */
        .dt-buttons {
            float: left !important;
            margin-right: 10px;
            margin-bottom: 10px;
        }
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
        
        /* Map Styles */
        .map-container { height: 500px; border-radius: 8px; overflow: hidden; border: 1px solid #dee2e6; background-color: #f8f9fa; }
        .map-section { background: #f8f9fa; border-radius: 8px; padding: 20px; margin-top: 30px; position: relative; z-index: 10; border: 1px solid #dee2e6; }
        .map-controls { margin-bottom: 15px; }
        .map-controls .btn { margin-right: 5px; margin-bottom: 5px; }
        .coord-badge { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 3px 8px; border-radius: 4px; font-family: monospace; font-size: 12px; }
        .empty-coord { color: #6c757d; font-style: italic; }
        .map-title { background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%); color: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 1.2rem; }
        .leaflet-container { font-family: "Public Sans", sans-serif !important; }
        .leaflet-popup-content { min-width: 200px; }
        #mapContainer.leaflet-container { width: 100% !important; height: 500px !important; }
        
        /* Style untuk action buttons - DIPERKECIL */
        .btn-action-group {
            display: flex;
            gap: 3px;
            justify-content: center;
        }
        .btn-action {
            padding: 3px 6px;
            font-size: 11px;
            border-radius: 3px;
            min-width: 28px;
        }
        .btn-action i {
            font-size: 11px;
        }
        .btn-action.btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-action.btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        /* Style untuk link foto */
        .foto-link { 
            color: #1a73e8; 
            text-decoration: none; 
            cursor: pointer; 
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 6px;
            background-color: #f8f9fa;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }
        .foto-link:hover { 
            background-color: #1a73e8;
            color: white;
            text-decoration: none;
        }
        .badge-foto {
            background-color: #6c757d;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: normal;
            display: inline-block;
        }
        
        /* Style untuk tombol peta */
        .btn-map {
            padding: 3px 6px;
            font-size: 11px;
            border-radius: 3px;
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        .btn-map:hover {
            background-color: #218838;
            border-color: #218838;
            color: white;
        }
        .btn-map i {
            font-size: 11px;
        }
        
        /* Style untuk badge bantuan provinsi */
        .badge-bantuan-ya {
            background-color: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge-bantuan-tidak {
            background-color: #dc3545;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        
        /* Style untuk badge jenis kelamin */
        .badge-jk-jantan {
            background-color: #0d6efd;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge-jk-betina {
            background-color: #d63384;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }
        
        /* Style untuk nomor telepon */
        .telp-link {
            color: #1a73e8;
            text-decoration: none;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }
        .telp-link:hover {
            color: #0d47a1;
            text-decoration: underline;
        }
        .telp-link i {
            font-size: 10px;
        }
        
        /* Style untuk NIK */
        .nik-text {
            font-family: monospace;
            font-size: 11px;
        }
        
        .modal-foto .modal-body { text-align: center; }
        .modal-foto img { max-width: 100%; max-height: 80vh; }
        
        /* Layout DataTables */
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        
        /* Card styling */
        .form-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        /* Badge untuk jumlah */
        .badge-jumlah {
            background-color: #e9f0fa;
            color: #1a73e8;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        
        /* Styling tabel */
        #historyDataTable {
            width: 100% !important;
            font-size: 12px;
        }
        #historyDataTable thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            padding: 10px 8px;
        }
        #historyDataTable tbody td {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
        }
        #historyDataTable tbody tr:hover {
            background-color: #f5f8ff;
        }
        
        /* Toolbar atas */
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 15px;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 15px;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
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
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; letter-spacing: 0.5px; line-height: 1;">
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
                        <li class="nav-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Menu Utama</h4></li>
                        
                        <!-- Master Data -->
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#masterDataSubmenu">
                                <div class="d-flex align-items-center"><i class="fas fa-database me-2"></i><span>Master Data</span></div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>pelaku_usaha" class="nav-link">Pelaku Usaha</a></li>
                                    <li><a href="<?php echo base_url(); ?>akses_pengguna" class="nav-link">Akses Pengguna</a></li>
                                    <li><a href="<?php echo base_url(); ?>pengobatan" class="nav-link">Pengobatan</a></li>
                                    <li><a href="<?php echo base_url(); ?>vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>komoditas" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?php echo base_url(); ?>layanan_klinik" class="nav-link">Layanan Klinik</a></li>
                                </ul>
                            </div>
                        </li>
                        
                        <!-- Data -->
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#dataSubmenu">
                                <div class="d-flex align-items-center"><i class="fas fa-users me-2"></i><span>Data</span></div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse show" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>data_kepemilikan_ternak" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_vaksinasi" class="nav-link">History Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link active">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('data_klinik') ?>" class="nav-link">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="nav-item"><a href="<?php echo base_url(); ?>laporan"><i class="fas fa-chart-bar"></i><p>Laporan</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>peta_sebaran"><i class="fas fa-map-marked-alt"></i><p>Peta Sebaran</p></a></li>
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
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"><i class="fa fa-search"></i></a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group"><input type="text" placeholder="Search ..." class="form-control" /></div>
                                    </form>
                                </ul>
                            </li>
                            
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                    <div class="avatar-sm"><img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" /></div>
                                    <span class="profile-username"><span class="fw-bold">Administrator</span></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li><div class="user-box"><div class="u-text"><h4>Administrator</h4><p class="text-muted">admin@dkppsby.go.id</p></div></div></li>
                                        <li><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url(); ?>login"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            
            <div class="container">
                <div class="page-inner">
                    <!-- Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1">History Data Pengobatan</h3>
                            <h6 class="op-7 mb-0">Manajemen history data pengobatan di Kota Surabaya</h6>
                        </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Komoditas:</label>
                                    <select class="form-select form-select-sm" id="filterKomoditas">
                                        <option selected value="all">Semua Komoditas</option>
                                        <option value="Sapi Potong">Sapi Potong</option>
                                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                                        <option value="Ayam Kampung">Ayam Kampung</option>
                                        <option value="Kambing">Kambing</option>
                                        <option value="Itik">Itik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterKecamatan" class="form-label fw-bold">Filter Kecamatan:</label>
                                    <select class="form-select form-select-sm" id="filterKecamatan">
                                        <option selected value="all">Semua Kecamatan</option>
                                        <option value="Asemrowo">Asemrowo</option>
                                        <option value="Benowo">Benowo</option>
                                        <option value="Bubutan">Bubutan</option>
                                        <option value="Bulak">Bulak</option>
                                        <option value="Dukuh Pakis">Dukuh Pakis</option>
                                        <option value="Gayungan">Gayungan</option>
                                        <option value="Genteng">Genteng</option>
                                        <option value="Gubeng">Gubeng</option>
                                        <option value="Gunung Anyar">Gunung Anyar</option>
                                        <option value="Jambangan">Jambangan</option>
                                        <option value="Karang Pilang">Karang Pilang</option>
                                        <option value="Kenjeran">Kenjeran</option>
                                        <option value="Krembangan">Krembangan</option>
                                        <option value="Lakarsantri">Lakarsantri</option>
                                        <option value="Mulyorejo">Mulyorejo</option>
                                        <option value="Pabean Cantian">Pabean Cantian</option>
                                        <option value="Pakal">Pakal</option>
                                        <option value="Rungkut">Rungkut</option>
                                        <option value="Sambikerep">Sambikerep</option>
                                        <option value="Sawahan">Sawahan</option>
                                        <option value="Semampir">Semampir</option>
                                        <option value="Simokerto">Simokerto</option>
                                        <option value="Sukolilo">Sukolilo</option>
                                        <option value="Sukomanunggal">Sukomanunggal</option>
                                        <option value="Tambaksari">Tambaksari</option>
                                        <option value="Tandes">Tandes</option>
                                        <option value="Tegalsari">Tegalsari</option>
                                        <option value="Tenggilis Mejoyo">Tenggilis Mejoyo</option>
                                        <option value="Wiyung">Wiyung</option>
                                        <option value="Wonocolo">Wonocolo</option>
                                        <option value="Wonokromo">Wonokromo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterKelurahan" class="form-label fw-bold">Filter Kelurahan:</label>
                                    <select class="form-select form-select-sm" id="filterKelurahan">
                                        <option selected value="all">Semua Kelurahan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterPeriode" class="form-label fw-bold">Filter Periode:</label>
                                    <select class="form-select form-select-sm" id="filterPeriode">
                                        <option selected value="all">Semua Periode</option>
                                        <option value="2026">Tahun 2026</option>
                                        <option value="2025">Tahun 2025</option>
                                        <option value="2024">Tahun 2024</option>
                                        <option value="2023">Tahun 2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button id="filterBtn" class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-outline-secondary btn-sm"><i class="fas fa-redo me-1"></i>Reset</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="card form-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="historyDataTable" class="table table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Petugas</th>
                                            <th>Nama Peternak</th>
                                            <th>NIK</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Peta</th>
                                            <th>Jumlah</th>
                                            <th>Komoditas</th>
                                            <th>Gejala Klinis/Diagnosa</th>
                                            <th>Pemberian Obat/Tindakan</th>
                                            <th>Bantuan Prov</th>
                                            <th>Telepon</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <!-- Data dari AJAX -->
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                    
                    <!-- MAP SECTION -->
                    <div id="mapSection" class="map-section" style="display: none;">
                        <div class="detail-header">
                            <div class="map-title" id="mapTitle">Peta Lokasi Ternak</div>
                            <div id="mapInfo" class="text-muted mt-2"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="map-controls mb-2">
                                    <button id="btnMapView" class="btn btn-outline-primary btn-sm active"><i class="fas fa-map me-1"></i>Map</button>
                                    <button id="btnSatelliteView" class="btn btn-outline-secondary btn-sm"><i class="fas fa-satellite me-1"></i>Satellite</button>
                                    <button id="btnResetView" class="btn btn-outline-info btn-sm"><i class="fas fa-sync-alt me-1"></i>Reset View</button>
                                </div>
                                
                                <div id="mapContainer" class="map-container"></div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white py-2">
                                                <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Informasi Peternak</h6>
                                            </div>
                                            <div class="card-body p-3" id="farmInfo"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white py-2">
                                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-1"></i> Detail Koordinat</h6>
                                            </div>
                                            <div class="card-body p-3" id="coordInfo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-3">
                            <button id="closeMapBtn" class="btn btn-outline-primary btn-sm"><i class="fas fa-times me-1"></i>Tutup Peta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detail Pengobatan Ternak</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center mb-3" id="detailFotoContainer">
                            <img id="detailFoto" src="" alt="Foto Pengobatan" style="max-width: 100%; max-height: 300px; display: none;">
                            <div id="noFotoMessage" class="text-muted">Tidak ada foto</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th width="40%">Tanggal</th><td>:</td><td id="detailTanggal"></td></tr>
                                <tr><th>Nama Petugas</th><td>:</td><td id="detailPetugas"></td></tr>
                                <tr><th>Nama Peternak</th><td>:</td><td id="detailNamaPeternak"></td></tr>
                                <tr><th>NIK</th><td>:</td><td id="detailNik"></td></tr>
                                <tr><th>Kecamatan</th><td>:</td><td id="detailKecamatan"></td></tr>
                                <tr><th>Kelurahan</th><td>:</td><td id="detailKelurahan"></td></tr>
                                <tr><th>RT/RW</th><td>:</td><td id="detailRtrw"></td></tr>
                                <tr><th>Koordinat</th><td>:</td><td id="detailKoordinat"></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr><th>Jumlah</th><td>:</td><td id="detailJumlah"></td></tr>
                                <tr><th>Komoditas</th><td>:</td><td id="detailKomoditas"></td></tr>
                                <tr><th>Gejala Klinis/Diagnosa</th><td>:</td><td id="detailGejalaKlinis"></td></tr>
                                <tr><th>Pemberian Obat/Tindakan</th><td>:</td><td id="detailJenisPengobatan"></td></tr>
                                <tr><th>Bantuan Provinsi</th><td>:</td><td id="detailBantuanProv"></td></tr>
                                <tr><th>Telepon</th><td>:</td><td id="detailTelp"></td></tr>
                                <tr><th>Jenis Kelamin</th><td>:</td><td id="detailJenisKelamin"></td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>Keterangan:</h6>
                            <p id="detailKeterangan" class="p-3 bg-light rounded"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="btnDetailMap"><i class="fas fa-map-marker-alt me-1"></i>Lihat Peta</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Foto -->
    <div class="modal fade modal-foto" id="fotoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Foto Pengobatan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><img id="fotoModalImg" src="" alt="Foto Pengobatan"></div>
            </div>
        </div>
    </div>
    
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white"><h5 class="modal-title">Konfirmasi Hapus</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><p>Apakah Anda yakin ingin menghapus data pengobatan ini?</p><p class="fw-bold" id="deleteInfo"></p></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDelete"><i class="fas fa-trash me-1"></i>Hapus</button>
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
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
    
    <script>
        // ================ VARIABLES ================
        let map = null;
        let mapMarkers = [];
        let currentView = "map";
        let currentFarmMarker = null;
        let dataTable = null;
        let deleteId = null;
        let allData = [];
        
        // Data kelurahan per kecamatan
        const kelurahanData = {
            'Asemrowo': ['Asemrowo', 'Genting Kalianak', 'Tambak Sarioso'],
            'Benowo': ['Benowo', 'Kandangan', 'Rompokalisari', 'Sememi', 'Tambak Osowilangon'],
            'Bubutan': ['Alun-alun Contong', 'Bubutan', 'Gundih', 'Jepara', 'Tembok Dukuh'],
            'Bulak': ['Bulak', 'Kedung Cowek', 'Kenjeran', 'Sukolilo Baru'],
            'Dukuh Pakis': ['Dukuh Kupang', 'Dukuh Pakis', 'Gunung Sari', 'Pradah Kalikendal'],
            'Gayungan': ['Dukuh Menanggal', 'Gayungan', 'Ketintang', 'Menanggal'],
            'Genteng': ['Embong Kaliasin', 'Genteng', 'Kapasari', 'Ketabang', 'Peneleh'],
            'Gubeng': ['Airlangga', 'Baratajaya', 'Gubeng', 'Kertajaya', 'Mojo', 'Pucang Sewu'],
            'Gunung Anyar': ['Gunung Anyar', 'Gunung Anyar Tambak', 'Rungkut Menanggal', 'Rungkut Tengah'],
            'Jambangan': ['Jambangan', 'Karah', 'Kebonsari', 'Pagesangan'],
            'Karang Pilang': ['Karang Pilang', 'Kebraon', 'Kedurus', 'Waru Gunung'],
            'Kenjeran': ['Bulak Banteng', 'Tambak Wedi', 'Tanah Kali Kedinding', 'Sidotopo Wetan'],
            'Krembangan': ['Dupak', 'Krembangan Selatan', 'Krembangan Utara', 'Morokrembangan', 'Perak Barat', 'Perak Timur'],
            'Lakarsantri': ['Bangkingan', 'Jeruk', 'Lakarsantri', 'Lidah Kulon', 'Lidah Wetan', 'Sumur Welut'],
            'Mulyorejo': ['Dukuh Sutorejo', 'Kalijudan', 'Kalisari', 'Kejawan Putih Tambak', 'Manyar Sabrangan', 'Mulyorejo'],
            'Pabean Cantian': ['Bongkaran', 'Krembangan Utara', 'Nyamplungan', 'Perak Timur', 'Perak Utara'],
            'Pakal': ['Babat Jerawat', 'Benowo', 'Pakal', 'Sumber Rejo', 'Tambak Dono'],
            'Rungkut': ['Kedung Baruk', 'Medokan Ayu', 'Penjaringansari', 'Rungkut Kidul', 'Rungkut Tengah', 'Wonorejo'],
            'Sambikerep': ['Bringin', 'Lontar', 'Made', 'Sambikerep', 'Sememi'],
            'Sawahan': ['Banyu Urip', 'Kupang Krajan', 'Pakis', 'Patemon', 'Putat Jaya', 'Sawahan'],
            'Semampir': ['Ampel', 'Pegirian', 'Sidotopo', 'Ujung', 'Wonokusumo'],
            'Simokerto': ['Kapasan', 'Simokerto', 'Tambakrejo', 'Sidodadi'],
            'Sukolilo': ['Gebang Putih', 'Keputih', 'Klampis Ngasem', 'Menur Pumpungan', 'Nginden Jangkungan', 'Semolowaru'],
            'Sukomanunggal': ['Putat Gede', 'Simomulyo', 'Sukomanunggal', 'Tanah Kali Kedinding', 'Tandes Kidul'],
            'Tambaksari': ['Dukuh Setro', 'Gading', 'Kapas Madya', 'Pacar Keling', 'Pacar Kembang', 'Ploso', 'Rangkah', 'Tambaksari'],
            'Tandes': ['Balongsari', 'Banjar Sugihan', 'Karang Poh', 'Manukan Kulon', 'Manukan Wetan', 'Tandes'],
            'Tegalsari': ['Dr. Soetomo', 'Kedungdoro', 'Keputran', 'Tegalsari', 'Wonorejo'],
            'Tenggilis Mejoyo': ['Kendangsari', 'Kutisari', 'Panjang Jiwo', 'Tenggilis Mejoyo'],
            'Wiyung': ['Babat Jerawat', 'Balas Klumprik', 'Jajar Tunggal', 'Wiyung'],
            'Wonocolo': ['Bendul Merisi', 'Jemur Wonosari', 'Margorejo', 'Sidosermo', 'Siwalankerto'],
            'Wonokromo': ['Darmo', 'Jagir', 'Ngagel', 'Ngagel Rejo', 'Sawunggaling', 'Wonokromo']
        };
        
        // ================ DOCUMENT READY ================
        $(document).ready(function() {
            // Load data
            loadData();
            
            // Initialize DataTable
            dataTable = $("#historyDataTable").DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'B>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary'
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-info'
                    }
                ],
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
                responsive: false,
                scrollX: true,
                columnDefs: [
                    { orderable: false, targets: [7, 15, 16] } // Kolom Peta, Aksi, Foto tidak bisa diurutkan
                ]
            });
            
            // Event listeners
            $("#filterBtn").click(filterData);
            $("#resetBtn").click(resetFilter);
            $("#closeMapBtn").click(closeMap);
            $("#btnMapView").click(function() { currentView = "map"; updateMapView(); $(this).addClass("active"); $("#btnSatelliteView").removeClass("active"); });
            $("#btnSatelliteView").click(function() { currentView = "satellite"; updateMapView(); $(this).addClass("active"); $("#btnMapView").removeClass("active"); });
            $("#btnResetView").click(function() { if (map && currentFarmMarker) { const latlng = currentFarmMarker.getLatLng(); map.setView([latlng.lat, latlng.lng], 15); } });
            $("#confirmDelete").click(function() { if (deleteId) deleteData(deleteId); });
            $("#btnDetailMap").click(function() {
                const lat = $("#detailKoordinat").data("lat");
                const lng = $("#detailKoordinat").data("lng");
                const nama = $("#detailNamaPeternak").text();
                const komoditas = $("#detailKomoditas").text();
                if (lat && lng) { $("#detailModal").modal("hide"); showMap(komoditas, nama, `${lat}, ${lng}`); }
                else alert("Koordinat tidak tersedia");
            });
            
            // Filter kecamatan change -> update kelurahan
            $("#filterKecamatan").change(function() {
                const selectedKec = $(this).val();
                updateKelurahanOptions(selectedKec);
            });
        });
        
        // ================ LOAD DATA ================
        function loadData() {
            $.ajax({
                url: "<?php echo base_url('Data_Pengobatan/get_all_data'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    allData = data;
                    renderTable(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading data:", error);
                    $("#dataTableBody").html('<tr><td colspan="17" class="text-center text-danger">Gagal memuat data</td></tr>');
                }
            });
        }
        
        function updateKelurahanOptions(kecamatan) {
            let options = '<option selected value="all">Semua Kelurahan</option>';
            
            if (kecamatan !== 'all' && kelurahanData[kecamatan]) {
                kelurahanData[kecamatan].sort().forEach(kel => {
                    options += `<option value="${kel}">${kel}</option>`;
                });
            } else if (kecamatan === 'all') {
                // Tampilkan semua kelurahan dari data
                const allKel = [...new Set(allData.map(item => item.kelurahan).filter(Boolean))].sort();
                allKel.forEach(kel => {
                    options += `<option value="${kel}">${kel}</option>`;
                });
            }
            
            $("#filterKelurahan").html(options);
        }
        
        // ================ RENDER TABLE ================
        function renderTable(data) {
            let html = "";
            if (data && data.length > 0) {
                $.each(data, function(index, item) {
                    const no = index + 1;
                    const tanggal = formatDate(item.tanggal_pengobatan);
                    
                    // Format nomor telepon
                    const telp = item.telp ? 
                        `<a href="tel:${item.telp}" class="telp-link" title="Telepon">
                            <i class="fas fa-phone-alt"></i> ${item.telp}
                        </a>` : 
                        '<span class="text-muted">-</span>';
                    
                    // Badge bantuan provinsi
                    const bantuanProv = item.bantuan_prov === 'Ya' ? 
                        '<span class="badge-bantuan-ya">Ya</span>' : 
                        '<span class="badge-bantuan-tidak">Tidak</span>';
                    
                    // Badge jenis kelamin
                    const jenisKelamin = item.jenis_kelamin === 'Jantan' ? 
                        '<span class="badge-jk-jantan">Jantan</span>' : 
                        item.jenis_kelamin === 'Betina' ? 
                        '<span class="badge-jk-betina">Betina</span>' : 
                        '-';
                    
                    // Tombol peta
                    const btnMap = (item.latitude && item.longitude) ? 
                        `<button class="btn-map" onclick="showMap('${item.komoditas_ternak}', '${item.nama_peternak}', '${item.latitude}, ${item.longitude}')" title="Lihat Peta">
                            <i class="fas fa-map-marker-alt"></i>
                        </button>` : 
                        `<span class="badge bg-secondary" style="font-size:10px; padding:3px 6px;">-</span>`;
                    
                    // Link foto
                    const fotoLink = item.foto_pengobatan ? 
                        `<a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/pengobatan/${item.foto_pengobatan}')" title="Lihat Foto">
                            <i class="fas fa-image"></i>
                        </a>` : 
                        '<span class="badge-foto">No Foto</span>';
                    
                    // NIK
                    const nik = item.nik ? 
                        `<span class="nik-text">${item.nik}</span>` : 
                        '-';
                    
                    html += `<tr>
                        <td>${no}</td>
                        <td>${tanggal}</td>
                        <td>${item.nama_petugas || '-'}</td>
                        <td>${item.nama_peternak || '-'}</td>
                        <td>${nik}</td>
                        <td>${item.kecamatan || '-'}</td>
                        <td>${item.kelurahan || '-'}</td>
                        <td>${btnMap}</td>
                        <td><span class="badge-jumlah">${item.jumlah || 0}</span></td>
                        <td>${item.komoditas_ternak || '-'}</td>
                        <td>${item.gejala_klinis || '-'}</td>
                        <td>${item.jenis_pengobatan || '-'}</td>
                        <td>${bantuanProv}</td>
                        <td>${telp}</td>
                        <td>${jenisKelamin}</td>
                        <td>
                            <div class="btn-action-group">
<button class="btn btn-info btn-action" onclick="showDetail(${item.id})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-danger btn-action" onclick="confirmDelete(${item.id}, '${item.nama_peternak}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <td>${fotoLink}</td>
                    </tr>`;
                });
            } else {
                html = `<tr><td colspan="17" class="text-center">Tidak ada data pengobatan</td></tr>`;
            }
            
            $("#dataTableBody").html(html);
            if (dataTable) { 
                dataTable.clear(); 
                dataTable.rows.add($(html)); 
                dataTable.draw(); 
            }
        }
        
        // ================ FILTER ================
        function filterData() {
            const komoditas = $("#filterKomoditas").val();
            const kecamatan = $("#filterKecamatan").val();
            const kelurahan = $("#filterKelurahan").val();
            const periode = $("#filterPeriode").val();
            
            let filteredData = allData;
            
            if (komoditas !== "all") {
                filteredData = filteredData.filter(item => item.komoditas_ternak === komoditas);
            }
            
            if (kecamatan !== "all") {
                filteredData = filteredData.filter(item => item.kecamatan === kecamatan);
            }
            
            if (kelurahan !== "all") {
                filteredData = filteredData.filter(item => item.kelurahan === kelurahan);
            }
            
            if (periode !== "all") {
                filteredData = filteredData.filter(item => {
                    if (!item.tanggal_pengobatan) return false;
                    const year = new Date(item.tanggal_pengobatan).getFullYear();
                    return year.toString() === periode;
                });
            }
            
            renderTable(filteredData);
        }
        
        function resetFilter() {
            $("#filterKomoditas").val("all");
            $("#filterKecamatan").val("all");
            $("#filterKelurahan").html('<option selected value="all">Semua Kelurahan</option>');
            $("#filterPeriode").val("all");
            
            renderTable(allData);
        }
        
        // ================ UTILITIES ================
        function formatDate(dateString) {
            if (!dateString) return "-";
            const d = new Date(dateString);
            return `${String(d.getDate()).padStart(2,'0')}-${String(d.getMonth()+1).padStart(2,'0')}-${d.getFullYear()}`;
        }
        
        // ================ CRUD ================
        function showDetail(id) {
            $.ajax({
                url: `<?php echo base_url('Data_Pengobatan/get_detail/'); ?>${id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $("#detailTanggal").text(formatDate(data.tanggal_pengobatan));
                        $("#detailPetugas").text(data.nama_petugas || "-");
                        $("#detailNamaPeternak").text(data.nama_peternak || "-");
                        $("#detailNik").text(data.nik || "-");
                        $("#detailKecamatan").text(data.kecamatan || "-");
                        $("#detailKelurahan").text(data.kelurahan || "-");
                        $("#detailRtrw").text(`RT ${data.rt || "-"} / RW ${data.rw || "-"}`);
                        const coord = (data.latitude && data.longitude) ? `${data.latitude}, ${data.longitude}` : "Tidak tersedia";
                        $("#detailKoordinat").text(coord);
                        $("#detailKoordinat").data("lat", data.latitude);
                        $("#detailKoordinat").data("lng", data.longitude);
                        
                        $("#detailJumlah").text(`${data.jumlah || 0} Ekor`);
                        $("#detailKomoditas").text(data.komoditas_ternak || "-");
                        $("#detailGejalaKlinis").text(data.gejala_klinis || "-");
                        $("#detailJenisPengobatan").text(data.jenis_pengobatan || "-");
                        $("#detailBantuanProv").text(data.bantuan_prov || "-");
                        $("#detailTelp").text(data.telp || "-");
                        $("#detailJenisKelamin").text(data.jenis_kelamin || "-");
                        $("#detailKeterangan").text(data.keterangan || "-");
                        
                        if (data.foto_pengobatan) {
                            const url = `<?php echo base_url(); ?>uploads/pengobatan/${data.foto_pengobatan}`;
                            $("#detailFoto").attr("src", url).show();
                            $("#noFotoMessage").hide();
                        } else { $("#detailFoto").hide(); $("#noFotoMessage").show(); }
                        $("#detailModal").modal("show");
                    }
                },
                error: function() { alert("Gagal mengambil detail data"); }
            });
        }
        
        function showFoto(url) { 
            $("#fotoModalImg").attr("src", url); 
            $("#fotoModal").modal("show"); 
        }
        
        function confirmDelete(id, nama) { 
            deleteId = id; 
            $("#deleteInfo").text(`Data pengobatan: ${nama}`); 
            $("#deleteModal").modal("show"); 
        }
        
        function deleteData(id) {
            $.ajax({
                url: `<?php echo base_url('Data_Pengobatan/delete/'); ?>${id}`,
                type: "POST",
                dataType: "json",
                success: function(res) {
                    $("#deleteModal").modal("hide");
                    if (res.status === "success") { 
                        alert(res.message); 
                        loadData(); 
                    }
                    else alert(res.message);
                },
                error: function() { 
                    $("#deleteModal").modal("hide"); 
                    alert("Gagal menghapus data"); 
                }
            });
        }
        
        // ================ MAP FUNCTION ================
        function showMap(komoditas, peternak, coordinates) {
            const [lat, lng] = coordinates.split(",").map(c => parseFloat(c.trim()));
            if (!lat || !lng || isNaN(lat) || isNaN(lng)) { alert("Koordinat tidak valid"); return; }
            
            $("#mapTitle").text(`Peta Lokasi Ternak ${komoditas}, Peternak: ${peternak}`);
            $("#mapInfo").html(`
                <div class="row">
                    <div class="col-md-6"><span class="fw-bold">Peternak:</span> ${peternak}<br><span class="fw-bold">Komoditas:</span> ${komoditas}</div>
                    <div class="col-md-6"><span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br><span class="fw-bold">Tanggal Update:</span> Terbaru</div>
                </div>
            `);
            
            $("#farmInfo").html(`
                <div class="mb-2"><span class="fw-bold">Nama Peternak:</span><br><span class="text-primary fw-bold">${peternak}</span></div>
                <div class="mb-2"><span class="fw-bold">Komoditas:</span><br><span class="badge bg-primary">${komoditas}</span></div>
                <div class="mb-2"><span class="fw-bold">Jumlah Ternak:</span><br><span class="fw-bold">- Ekor</span></div>
                <div class="mb-2"><span class="fw-bold">Status:</span><br><span class="badge bg-success">Aktif</span></div>
            `);
            
            $("#coordInfo").html(`
                <div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>${lat.toFixed(6)}</code></div>
                <div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>${lng.toFixed(6)}</code></div>
                <div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>
                <div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>
            `);
            
            if (!map) {
                $("#mapContainer").css("height", "500px");
                setTimeout(() => {
                    map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
                    L.control.zoom({ position: "topright" }).addTo(map);
                    L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
                    updateMapView();
                    
                    const farmIcon = L.divIcon({
                        html: `<div style="background-color: #1a73e8; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
                        className: "farm-marker", iconSize: [30, 30], iconAnchor: [15, 15]
                    });
                    
                    currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
                    currentFarmMarker.bindPopup(`
                        <div style="min-width: 200px;">
                            <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${peternak}</h5>
                            <hr style="margin: 5px 0;">
                            <div><strong>Komoditas:</strong> ${komoditas}</div>
                            <div><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                            <div><strong>Jenis Pengobatan:</strong> Pengobatan</div>
                            <div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>
                        </div>
                    `).openPopup();
                    mapMarkers.push(currentFarmMarker);
                    
                    const circle = L.circle([lat, lng], { color: "#1a73e8", fillColor: "#1a73e8", fillOpacity: 0.1, radius: 500 }).addTo(map);
                    mapMarkers.push(circle);
                    setTimeout(() => { map.invalidateSize(); }, 100);
                }, 100);
            } else {
                mapMarkers.forEach(m => { if (map.hasLayer(m)) map.removeLayer(m); });
                mapMarkers = [];
                map.setView([lat, lng], 15);
                
                const farmIcon = L.divIcon({
                    html: `<div style="background-color: #1a73e8; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
                    className: "farm-marker", iconSize: [30, 30], iconAnchor: [15, 15]
                });
                
                currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(map);
                currentFarmMarker.bindPopup(`
                    <div style="min-width: 200px;">
                        <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${peternak}</h5>
                        <hr style="margin: 5px 0;">
                        <div><strong>Komoditas:</strong> ${komoditas}</div>
                        <div><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                        <div><strong>Jenis Pengobatan:</strong> Pengobatan</div>
                        <div style="text-align: center; margin-top: 8px;"><small class="text-muted">Klik di luar popup untuk menutup</small></div>
                    </div>
                `).openPopup();
                mapMarkers.push(currentFarmMarker);
                
                const circle = L.circle([lat, lng], { color: "#1a73e8", fillColor: "#1a73e8", fillOpacity: 0.1, radius: 500 }).addTo(map);
                mapMarkers.push(circle);
                setTimeout(() => { map.invalidateSize(); }, 50);
            }
            
            $("#mapSection").show();
            $("html, body").animate({ scrollTop: $("#mapSection").offset().top - 20 }, 500);
            setTimeout(() => { if (map) map.invalidateSize(); }, 300);
        }
        
        function updateMapView() {
            if (!map) return;
            map.eachLayer(layer => { if (layer instanceof L.TileLayer) map.removeLayer(layer); });
            if (currentView === "map") {
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { attribution: '&copy; OpenStreetMap', maxZoom: 19 }).addTo(map);
            } else {
                L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", { attribution: "Tiles &copy; Esri", maxZoom: 19 }).addTo(map);
            }
            mapMarkers.forEach(m => { if (!map.hasLayer(m)) map.addLayer(m); });
            setTimeout(() => { map.invalidateSize(); }, 50);
        }
        
        function closeMap() { 
            $("#mapSection").hide();  
            if (map) { 
                map.remove(); 
                map = null; 
            } 
        }
    </script>
</body>
</html>