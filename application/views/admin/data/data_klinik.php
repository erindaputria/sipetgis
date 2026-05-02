<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Klinik Hewan</title>
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom CSS Data Klinik -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/data_klinik.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
                        <div class="sipetgis-logo">SIPETGIS</div>
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
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li> 
                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                            <h4 class="text-section">Menu Utama</h4>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#masterDataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-database me-2" style="color: #832706 !important;"></i><span>Master Data</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a></li>
                                    <li><a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a></li>
                                    <li><a href="<?= site_url('kepemilikan_jenis_usaha') ?>" class="nav-link">Kepemilikan Jenis Usaha</a></li>
                                    <li><a href="<?php echo base_url(); ?>akses_pengguna" class="nav-link">Akses Pengguna</a></li>
                                    <li><a href="<?php echo base_url(); ?>obat" class="nav-link">Obat</a></li>
                                    <li><a href="<?php echo base_url(); ?>vaksin" class="nav-link">Vaksin</a></li>
                                    <li><a href="<?php echo base_url(); ?>komoditas" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                    <li><a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-users me-2" style="color: #832706 !important;"></i><span>Data</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>data_kepemilikan" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_vaksinasi" class="nav-link">History Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('data_klinik') ?>" class="nav-link active">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a></li>
                                    <li><a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link">Pemotongan Unggas</a></li>
                                    <li><a href="<?= site_url('data_demplot') ?>" class="nav-link">Demplot</a></li>
                                    <li><a href="<?= site_url('data_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-chart-bar me-2" style="color: #832706 !important;"></i><span>Laporan</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="laporanSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_vaksinasi') ?>" class="nav-link">History Data Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>" class="nav-link">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>" class="nav-link">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('laporan_demplot_peternakan') ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>peta_sebaran">
                                <i class="fas fa-map-marked-alt" style="color: #832706 !important;"></i>
                                <p>Peta Sebaran</p>
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
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold">Administrator</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
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
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout">
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Data Klinik Hewan</h3>
                            <h6 class="op-7 mb-0">Manajemen data klinik hewan di Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterIjin" class="form-label fw-bold">Filter Status Ijin:</label>
                                    <select class="form-select form-select-sm" id="filterIjin">
                                        <option selected value="all">Semua Status</option>
                                        <option value="Y">Memiliki Ijin</option>
                                        <option value="N">Belum Memiliki Ijin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterLayanan" class="form-label fw-bold">Filter Jenis Layanan:</label>
                                    <select class="form-select form-select-sm" id="filterLayanan">
                                        <option selected value="all">Semua Layanan</option>
                                        <option value="24 Jam">24 Jam</option>
                                        <option value="Praktek Umum">Praktek Umum</option>
                                        <option value="Spesialis">Spesialis</option>
                                        <option value="Gawat Darurat">Gawat Darurat</option>
                                        <option value="Rawat Inap">Rawat Inap</option>
                                        <option value="Laboratorium">Laboratorium</option>
                                        <option value="Bedah">Bedah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary-custom btn-sm"><i class="fas fa-filter me-1"></i>Filter</button>
                                <button id="resetBtn" class="btn btn-outline-secondary-custom btn-sm"><i class="fas fa-redo me-1"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="klinikTable" class="table table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th width="40">No</th>
                                            <th>Nama Klinik</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Alamat</th>
                                            <th>Kontak</th>
                                            <th>Dokter</th>
                                            <th>Layanan</th>
                                            <th>Status</th>
                                            <th>Peta</th>
                                            <th width="80">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <!-- Data akan diisi oleh JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div id="mapSection" class="map-section" style="display: none;">
                        <div class="detail-header">
                            <div class="map-title" id="mapTitle">Peta Lokasi Klinik Hewan</div>
                            <div id="mapInfo" class="text-muted mt-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="map-controls mb-2">
                                    <button id="btnMapView" class="btn btn-outline-primary-custom btn-sm active"><i class="fas fa-map me-1"></i>Map</button>
                                    <button id="btnSatelliteView" class="btn btn-outline-secondary-custom btn-sm"><i class="fas fa-satellite me-1"></i>Satellite</button>
                                    <button id="btnResetView" class="btn btn-outline-info-custom btn-sm"><i class="fas fa-sync-alt me-1"></i>Reset View</button>
                                </div>
                                <div id="mapContainer" class="map-container"></div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-primary-custom text-white py-2">
                                                <h6 class="mb-0"><i class="fas fa-clinic-medical me-1"></i> Informasi Klinik</h6>
                                            </div>
                                            <div class="card-body p-3" id="clinicInfo"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-primary-custom text-white py-2">
                                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-1"></i> Detail Koordinat</h6>
                                            </div>
                                            <div class="card-body p-3" id="coordInfo"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header bg-primary-custom text-white py-2">
                                        <h6 class="mb-0"><i class="fas fa-stethoscope me-1"></i> Jenis Layanan</h6>
                                    </div>
                                    <div class="card-body p-3" id="layananInfo"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button id="closeMapBtn" class="btn btn-outline-primary-custom btn-sm"><i class="fas fa-times me-1"></i>Tutup Peta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEdit">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-header bg-primary-custom text-white">
                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Klinik Hewan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Klinik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama" name="nama_klinik" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_kecamatan" name="kecamatan" required>
                                    <option value="">Pilih Kecamatan</option>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_kelurahan" name="kelurahan" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">RT</label>
                                <input type="text" class="form-control" id="edit_rt" name="rt">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">RW</label>
                                <input type="text" class="form-control" id="edit_rw" name="rw">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="edit_telepon" name="telepon">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="edit_latitude" name="latitude" placeholder="-7.2574719">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="edit_longitude" name="longitude" placeholder="112.7520883">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Dokter</label>
                                <input type="number" class="form-control" id="edit_dokter" name="jumlah_dokter" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Layanan</label>
                                <input type="text" class="form-control" id="edit_layanan" name="jenis_layanan" placeholder="Contoh: 24 Jam, Praktek Umum, Bedah">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Ijin</label>
                                <select class="form-control" id="edit_status" name="surat_ijin">
                                    <option value="Y">Memiliki Ijin</option>
                                    <option value="N">Belum Memiliki Ijin</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                        <button type="submit" class="btn btn-primary-custom btn-sm"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger-custom text-white">
                    <h5 class="modal-title"><i class="fas fa-trash me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data klinik hewan ini?</p>
                    <p class="fw-bold" id="deleteInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                    <button type="button" class="btn btn-danger-custom btn-sm" id="confirmDelete"><i class="fas fa-trash me-1"></i>Hapus</button>
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Custom JS Data Klinik -->
    <script>
    var base_url = "<?= base_url() ?>";
    </script>
    <script src="<?php echo base_url('assets/js/data_klinik.js'); ?>"></script>
</body>
</html>