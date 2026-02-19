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

    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        .dashboard-header { background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%); color: white; padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .stat-card { border-radius: 10px; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .stat-icon { font-size: 2.5rem; opacity: 0.8; }
        .filter-section { background: #f8f9fa; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .table-responsive { border-radius: 8px; overflow: hidden; }
        .table th { background-color: #f8f9fa; font-weight: 600; }
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { padding: 10px; }
        
        /* Style untuk tombol DataTables */
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
        .map-section { background: #f8f9fa; border-radius: 8px; padding: 20px; margin-top: 30px; position: relative; z-index: 10; }
        .map-controls { margin-bottom: 15px; }
        .map-controls .btn { margin-right: 5px; margin-bottom: 5px; }
        .coord-badge { background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 3px 8px; border-radius: 4px; font-family: monospace; font-size: 12px; }
        .empty-coord { color: #6c757d; font-style: italic; }
        .map-title { background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%); color: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 1.2rem; }
        .leaflet-container { font-family: "Public Sans", sans-serif !important; }
        .leaflet-popup-content { min-width: 200px; }
        #mapContainer.leaflet-container { width: 100% !important; height: 500px !important; }
        
        .btn-action { margin: 0 2px; }
        .foto-link { color: #1a73e8; text-decoration: none; cursor: pointer; }
        .foto-link:hover { text-decoration: underline; color: #0d47a1; }
        .modal-foto .modal-body { text-align: center; }
        .modal-foto img { max-width: 100%; max-height: 80vh; }
        
        /* Layout */
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        .dt-buttons { float: left !important; margin-right: 10px; }
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
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Komoditas:</label>
                                    <select class="form-select" id="filterKomoditas">
                                        <option selected value="all">Semua Komoditas</option>
                                        <option value="Sapi Potong">Sapi Potong</option>
                                        <option value="Ayam Ras Petelur">Ayam Ras Petelur</option>
                                        <option value="Ayam Kampung">Ayam Kampung</option>
                                        <option value="Kambing">Kambing</option>
                                        <option value="Itik">Itik</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKelurahan" class="form-label fw-bold">Filter Kelurahan:</label>
                                    <select class="form-select" id="filterKelurahan">
                                        <option selected value="all">Semua Kelurahan</option>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Filter Data</button>
                                <button id="resetBtn" class="btn btn-outline-secondary"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="historyDataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peternak</th>
                                            <th>Komoditas</th>
                                            <th>Jenis Pengobatan</th>
                                            <th>Jumlah</th>
                                            <th>Lokasi</th>
                                            <th>Peta</th>
                                            <th>Tanggal</th>
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
                            <button id="closeMapBtn" class="btn btn-outline-primary"><i class="fas fa-times me-2"></i>Tutup Peta</button>
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
                            <table class="table table-borderless">
                                <tr><th width="40%">Nama Peternak</th><td>:</td><td id="detailNamaPeternak"></td></tr>
                                <tr><th>NIK</th><td>:</td><td id="detailNik"></td></tr>
                                <tr><th>Komoditas</th><td>:</td><td id="detailKomoditas"></td></tr>
                                <tr><th>Jenis Pengobatan</th><td>:</td><td id="detailJenisPengobatan"></td></tr>
                                <tr><th>Jumlah</th><td>:</td><td id="detailJumlah"></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><th>Tanggal</th><td>:</td><td id="detailTanggal"></td></tr>
                                <tr><th>Petugas</th><td>:</td><td id="detailPetugas"></td></tr>
                                <tr><th>Kelurahan</th><td>:</td><td id="detailKelurahan"></td></tr>
                                <tr><th>RT/RW</th><td>:</td><td id="detailRtrw"></td></tr>
                                <tr><th>Koordinat</th><td>:</td><td id="detailKoordinat"></td></tr>
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
                    <button type="button" class="btn btn-primary" id="btnDetailMap"><i class="fas fa-map-marker-alt me-2"></i>Lihat Peta</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Tutup</button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete"><i class="fas fa-trash me-2"></i>Hapus</button>
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
        
        // ================ DOCUMENT READY ================
        $(document).ready(function() {
            // Load data
            loadData();
            loadKelurahanFilter();
            
            // Initialize DataTable dengan tombol berwarna
            dataTable = $("#historyDataTable").DataTable({
                dom: 'Bfrtip',
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
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [6, 8, 9] } // Non-aktifkan sorting untuk kolom Peta, Aksi, Foto
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
        });
        
        // ================ LOAD DATA ================
        function loadData() {
            $.ajax({
                url: "<?php echo base_url('P_Input_Pengobatan/get_all_data'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) { renderTable(data); updateStatistics(data); renderKelurahanFilter(data); },
                error: function() { loadDummyData(); }
            });
        }
        
        function loadDummyData() {
            const dummyData = [
                { id_obat: 1, nama_peternak: "Arya Dimas", komoditas_ternak: "Ayam Ras Petelur", jenis_pengobatan: "Pengobatan Herbal", jumlah: 2, kelurahan: "Sawahan", rt: "07", rw: "15", latitude: "-7.288136", longitude: "112.734604", tanggal_pengobatan: "2026-02-10", foto_pengobatan: "" },
                { id_obat: 2, nama_peternak: "BULUH MERINDU", komoditas_ternak: "Kambing", jenis_pengobatan: "Pengobatan Herbal", jumlah: 21, kelurahan: "Sawahan", rt: "01", rw: "02", latitude: "-7.2575", longitude: "112.7521", tanggal_pengobatan: "2022-12-14", foto_pengobatan: "" },
                { id_obat: 3, nama_peternak: "Lajar", komoditas_ternak: "Sapi Potong", jenis_pengobatan: "Pengobatan Herbal", jumlah: 20, kelurahan: "Kupang Krajan", rt: "03", rw: "04", latitude: "-7.2650", longitude: "112.7475", tanggal_pengobatan: "2022-11-02", foto_pengobatan: "" },
                { id_obat: 4, nama_peternak: "GARDA PEMUDA", komoditas_ternak: "Sapi Potong", jenis_pengobatan: "Pengobatan Herbal", jumlah: 32, kelurahan: "Kupang Krajan", rt: "05", rw: "06", latitude: "-7.2500", longitude: "112.7600", tanggal_pengobatan: "2022-12-09", foto_pengobatan: "" },
                { id_obat: 5, nama_peternak: "Ternak Sejahtera", komoditas_ternak: "Ayam Kampung", jenis_pengobatan: "Pengobatan Antibiotik", jumlah: 50, kelurahan: "Banyu Urip", rt: "02", rw: "03", latitude: "-7.2550", longitude: "112.7550", tanggal_pengobatan: "2022-11-15", foto_pengobatan: "" }
            ];
            renderTable(dummyData);
            updateStatistics(dummyData);
            renderKelurahanFilter(dummyData);
        }
        
        // ================ RENDER TABLE ================
        function renderTable(data) {
            let html = "";
            if (data && data.length > 0) {
                $.each(data, function(index, item) {
                    const no = index + 1;
                    const tanggal = formatDate(item.tanggal_pengobatan);
                    const lokasi = `${item.kelurahan || ''} ${item.rt ? 'RT ' + item.rt : ''} ${item.rw ? 'RW ' + item.rw : ''}`.trim() || '-';
                    
                    // BUTTON PETA - langsung dari koordinat
                    const btnMap = (item.latitude && item.longitude) ? 
                        `<button class="btn btn-sm btn-outline-primary btn-action" onclick="showMap('${item.komoditas_ternak}', '${item.nama_peternak}', '${item.latitude}, ${item.longitude}')">
                            <i class="fas fa-map-marker-alt me-1"></i>Lihat Peta
                        </button>` : 
                        `<span class="empty-coord">-</span>`;
                    
                    // FOTO - berbentuk LINK di kolom paling kanan
                    const fotoLink = item.foto_pengobatan ? 
                        `<a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/pengobatan/${item.foto_pengobatan}')">
                            <i class="fas fa-image me-1"></i>Lihat Foto
                        </a>` : 
                        '<span class="badge bg-secondary">No Foto</span>';
                    
                    html += `<tr>
                        <td>${no}</td>
                        <td>${item.nama_peternak || '-'}</td>
                        <td>${item.komoditas_ternak || '-'}</td>
                        <td>${item.jenis_pengobatan || '-'}</td>
                        <td>${item.jumlah || 0} Ekor</td>
                        <td>${lokasi}</td>
                        <td>${btnMap}</td>
                        <td>${tanggal}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-info btn-action" onclick="showDetail(${item.id_obat})"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="confirmDelete(${item.id_obat}, '${item.nama_peternak}')"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                        <td>${fotoLink}</td>
                    </tr>`;
                });
            } else {
                html = `<tr><td colspan="10" class="text-center">Tidak ada data pengobatan</td></tr>`;
            }
            
            $("#dataTableBody").html(html);
            if (dataTable) { 
                dataTable.clear(); 
                dataTable.rows.add($(html)); 
                dataTable.draw(); 
            }
        }
        
        // ================ FILTER ================
        function loadKelurahanFilter() {
            $.ajax({
                url: "<?php echo base_url('P_Input_Pengobatan/get_all_data'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) { renderKelurahanFilter(data); },
                error: function() { 
                    renderKelurahanFilter([
                        { kelurahan: "Sawahan" }, { kelurahan: "Kupang Krajan" }, 
                        { kelurahan: "Banyu Urip" }, { kelurahan: "Putat Jaya" }
                    ]); 
                }
            });
        }
        
        function renderKelurahanFilter(data) {
            const list = [];
            $.each(data, function(i, item) { if (item.kelurahan && !list.includes(item.kelurahan)) list.push(item.kelurahan); });
            list.sort();
            let options = '<option selected value="all">Semua Kelurahan</option>';
            $.each(list, function(i, k) { options += `<option value="${k}">${k}</option>`; });
            $("#filterKelurahan").html(options);
        }
        
        function filterData() {
            const komoditas = $("#filterKomoditas").val();
            const kelurahan = $("#filterKelurahan").val();
            const periode = $("#filterPeriode").val();
            let searchTerm = "";
            if (komoditas !== "all") searchTerm += komoditas;
            if (kelurahan !== "all") { if (searchTerm) searchTerm += " "; searchTerm += kelurahan; }
            if (periode !== "all") { if (searchTerm) searchTerm += " "; searchTerm += periode; }
            dataTable.search(searchTerm).draw();
        }
        
        function resetFilter() {
            $("#filterKomoditas").val("all");
            $("#filterKelurahan").val("all");
            $("#filterPeriode").val("all");
            dataTable.search("").draw();
        }
        
        // ================ STATISTICS ================
        function updateStatistics(data) {
            let totalTernak = 0;
            const peternakSet = new Set(), lokasiSet = new Set();
            $.each(data, function(i, item) { 
                totalTernak += parseInt(item.jumlah) || 0; 
                if (item.nama_peternak) peternakSet.add(item.nama_peternak);
                if (item.kelurahan) lokasiSet.add(item.kelurahan);
            });
            $("#totalPengobatan").text(data.length);
            $("#totalPeternak").text(peternakSet.size);
            $("#totalTernak").text(totalTernak);
            $("#totalLokasi").text(lokasiSet.size);
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
                url: `<?php echo base_url('P_Input_Pengobatan/get_detail/'); ?>${id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        $("#detailNamaPeternak").text(data.nama_peternak || "-");
                        $("#detailNik").text(data.nik || "-");
                        $("#detailKomoditas").text(data.komoditas_ternak || "-");
                        $("#detailJenisPengobatan").text(data.jenis_pengobatan || "-");
                        $("#detailJumlah").text(`${data.jumlah || 0} Ekor`);
                        $("#detailTanggal").text(formatDate(data.tanggal_pengobatan));
                        $("#detailPetugas").text(data.nama_petugas || "-");
                        $("#detailKelurahan").text(data.kelurahan || "-");
                        $("#detailRtrw").text(`RT ${data.rt || "-"} / RW ${data.rw || "-"}`);
                        const coord = (data.latitude && data.longitude) ? `${data.latitude}, ${data.longitude}` : "Tidak tersedia";
                        $("#detailKoordinat").text(coord);
                        $("#detailKoordinat").data("lat", data.latitude);
                        $("#detailKoordinat").data("lng", data.longitude);
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
                url: `<?php echo base_url('P_Input_Pengobatan/delete/'); ?>${id}`,
                type: "POST",
                dataType: "json",
                success: function(res) {
                    $("#deleteModal").modal("hide");
                    if (res.status === "success") { alert(res.message); loadData(); loadKelurahanFilter(); }
                    else alert(res.message);
                },
                error: function() { $("#deleteModal").modal("hide"); alert("Gagal menghapus data"); }
            });
        }
        
        // ================ MAP FUNCTION ================
        function showMap(komoditas, peternak, coordinates) {
            const [lat, lng] = coordinates.split(",").map(c => parseFloat(c.trim()));
            if (!lat || !lng || isNaN(lat) || isNaN(lng)) { alert("Koordinat tidak valid"); return; }
            
            // Title dan Info
            $("#mapTitle").text(`Peta Lokasi Ternak ${komoditas}, Peternak: ${peternak}`);
            $("#mapInfo").html(`
                <div class="row">
                    <div class="col-md-6"><span class="fw-bold">Peternak:</span> ${peternak}<br><span class="fw-bold">Komoditas:</span> ${komoditas}</div>
                    <div class="col-md-6"><span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br><span class="fw-bold">Tanggal Update:</span> Terbaru</div>
                </div>
            `);
            
            // Informasi Peternak
            $("#farmInfo").html(`
                <div class="mb-2"><span class="fw-bold">Nama Peternak:</span><br><span class="text-primary fw-bold">${peternak}</span></div>
                <div class="mb-2"><span class="fw-bold">Komoditas:</span><br><span class="badge bg-primary">${komoditas}</span></div>
                <div class="mb-2"><span class="fw-bold">Jumlah Ternak:</span><br><span class="fw-bold">- Ekor</span></div>
                <div class="mb-2"><span class="fw-bold">Status:</span><br><span class="badge bg-success">Aktif</span></div>
            `);
            
            // Detail Koordinat
            $("#coordInfo").html(`
                <div class="mb-2"><span class="fw-bold">Latitude:</span><br><code>${lat.toFixed(6)}</code></div>
                <div class="mb-2"><span class="fw-bold">Longitude:</span><br><code>${lng.toFixed(6)}</code></div>
                <div class="mb-2"><span class="fw-bold">Format Koordinat:</span><br><small>DD (Decimal Degrees)</small></div>
                <div class="mb-2"><span class="fw-bold">Akurasi:</span><br><small>GPS ± 5 meter</small></div>
            `);
            
            // Inisialisasi Map
            if (!map) {
                $("#mapContainer").css("height", "500px");
                setTimeout(() => {
                    map = L.map("mapContainer", { zoomControl: false, attributionControl: false }).setView([lat, lng], 15);
                    L.control.zoom({ position: "topright" }).addTo(map);
                    L.control.attribution({ position: "bottomright" }).addTo(map).addAttribution("© OpenStreetMap contributors");
                    updateMapView();
                    
                    // Icon BIRU dengan huruf P
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