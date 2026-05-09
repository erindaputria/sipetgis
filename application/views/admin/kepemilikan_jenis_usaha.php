<!doctype html>
<html lang="id">

<style>
    /* FORCE SELECT2 TEKS PUTIH SAAT HOVER */
    .select2-results__option--selectable:hover,
    .select2-results__option--selectable:hover *,
    .select2-results__option--highlighted,
    .select2-results__option--highlighted *,
    .select2-results__option[aria-selected="true"],
    .select2-results__option[aria-selected="true"] * {
        background-color: #832706 !important;
        color: #ffffff !important;
    }
</style>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Kepemilikan Jenis Usaha - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url('assets/SIPETGIS/assets/img/kaiadmin/favicon.ico'); ?>" type="image/x-icon" />
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash(); ?>">

    <script>
    var BASE_URL = '<?= base_url(); ?>';
    var CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
    var CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';
    </script>

    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js'); ?>"></script>
    <script> 
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["<?php echo base_url('assets/SIPETGIS/assets/css/fonts.min.css'); ?>"]
            },
            active: function() { sessionStorage.fonts = true; }
        });
    </script>

    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/plugins.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/kaiadmin.min.css'); ?>" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/kepemilikan_jenis_usaha.css'); ?>" />
    
    <style>
        .select2-container--bootstrap-5 .select2-selection { min-height: 38px; border-radius: 6px; }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { line-height: 36px; }
        .select2-container--bootstrap-5 .select2-dropdown { border-radius: 8px; }
        .select2-results__option { padding: 8px 12px; }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="white">
                <a href="<?php echo site_url('dashboard'); ?>" class="logo" style="text-decoration: none">
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
                    <li class="nav-item"><a href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                    <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Menu Utama</h4></li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#masterDataSubmenu">
                            <div class="d-flex align-items-center"><i class="fas fa-database me-2" style="color: #832706 !important;"></i><span>Master</span></div>
                            <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                        </a>
                        <div class="collapse" id="masterDataSubmenu">
                            <ul class="list-unstyled ps-4">
                                <li><a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a></li>
                                <li><a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a></li>
                                <li><a href="<?= site_url('kepemilikan_jenis_usaha') ?>" class="nav-link active">Kepemilikan Jenis Usaha</a></li>
                                <li><a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a></li>
                                <li><a href="<?= site_url('obat') ?>" class="nav-link">Obat</a></li>
                                <li><a href="<?= site_url('vaksin') ?>" class="nav-link">Vaksin</a></li>
                                <li><a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a></li>
                                <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                <li><a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu">
                            <div class="d-flex align-items-center"><i class="fas fa-users me-2" style="color: #832706 !important;"></i><span>Data</span></div>
                            <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                        </a>
                        <div class="collapse" id="dataSubmenu">
                            <ul class="list-unstyled ps-4">
                                <li><a href="<?= site_url('data_kepemilikan') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                <li><a href="<?= site_url('data_history_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                <li><a href="<?= site_url('data_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                <li><a href="<?= site_url('data_history_vaksinasi') ?>" class="nav-link">History Vaksinasi</a></li>
                                <li><a href="<?= site_url('data_pengobatan') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                <li><a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                <li><a href="<?= site_url('data_klinik') ?>" class="nav-link">Klinik Hewan</a></li>
                                <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                <li><a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a></li>
                                <li><a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link">Pemotongan Unggas</a></li>
                                <li><a href="<?= site_url('data_demplot') ?>" class="nav-link">Demplot</a></li>
                                <li><a href="<?= site_url('data_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu">
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
                    <li class="nav-item"><a href="<?= site_url('peta_sebaran') ?>" class="nav-link"><i class="fas fa-map-marked-alt" style="color: #832706 !important;"></i><p>Peta Sebaran</p></a></li>
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
                        <li class="nav-item topbar-user dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                <div class="avatar-sm"><img src="<?php echo base_url('assets/SIPETGIS/assets/img/logo dkpp.png'); ?>" alt="..." class="avatar-img rounded-circle" /></div>
                                <span class="profile-username"><span class="fw-bold">Administrator</span></span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li><div class="user-box"><div class="u-text"><h4>Administrator</h4><p class="text-muted">admin@dkppsby.go.id</p></div></div></li>
                                    <li><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url(); ?>login/logout"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <div class="page-inner">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Master Kepemilikan Jenis Usaha</h3>
                        <h6 class="op-7 mb-0">Kelola Data Kepemilikan Jenis Usaha</h6>
                    </div>
                    <div class="ms-md-auto py-2 py-md-0">
                        <button class="btn btn-primary-custom text-white" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                            <i class="fas fa-plus me-2"></i>Tambah Data
                        </button>
                    </div>
                </div>

                <!-- Modal Tambah Data -->
                <div class="modal fade" id="tambahDataModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content modal-form">
                            <form action="<?= base_url('kepemilikan_jenis_usaha/simpan'); ?>" method="post" id="formTambah">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Data Kepemilikan Jenis Usaha</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Informasi:</strong> Pilih NIK atau Nama Pelaku Usaha terlebih dahulu.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- Modal Tambah Data - Bagian Select2 -->
<div class="col-md-12">
    <div class="form-group">
        <label class="fw-bold" style="color: #832706;">Cari NIK / Nama Pelaku Usaha <span class="text-danger">*</span></label>
        <select name="nik" id="nik_select" class="form-control select2-nik" style="width: 100%;" required>
            <option value="">-- Ketik NIK atau Nama Pelaku Usaha (minimal 2 karakter) --</option>
        </select>
        <small class="text-muted">Hanya pelaku usaha yang sudah terdaftar di database yang dapat dipilih</small>
    </div>
</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Pelaku Usaha <span class="text-danger">*</span></label>
                                                <input type="text" name="nama_peternak" id="nama_peternak" class="form-control" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Usaha <span class="text-danger">*</span></label>
                                                <select name="jenis_usaha" class="form-control" required>
                                                    <option value="">Pilih Jenis Usaha</option>
                                                    <option value="Peternak Sapi Perah">Peternak Sapi Perah</option>
                                                    <option value="Peternak Sapi Potong">Peternak Sapi Potong</option>
                                                    <option value="Peternak Kambing">Peternak Kambing</option>
                                                    <option value="Peternak Domba">Peternak Domba</option>
                                                    <option value="Peternak Ayam Broiler">Peternak Ayam Broiler</option>
                                                    <option value="Peternak Ayam Petelur">Peternak Ayam Petelur</option>
                                                    <option value="Peternak Itik">Peternak Itik</option>
                                                    <option value="Peternak Kelinci">Peternak Kelinci</option>
                                                    <option value="Peternak Babi">Peternak Babi</option>
                                                    <option value="Peternak Kuda">Peternak Kuda</option>
                                                    <option value="Penjual Pakan Ternak">Penjual Pakan Ternak</option>
                                                    <option value="Penjual Obat Hewan">Penjual Obat Hewan</option>
                                                    <option value="Klinik Hewan">Klinik Hewan</option>
                                                    <option value="TPU/RPU">TPU/RPU</option>
                                                    <option value="Pemotongan Unggas">Pemotongan Unggas</option>
                                                    <option value="Demplot">Demplot</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jumlah Ternak / Unit Usaha <span class="text-danger">*</span></label>
                                                <input type="number" name="jumlah" class="form-control" required min="0" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kecamatan <span class="text-danger">*</span></label>
                                                <select name="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    <?php $kecamatan = ['ASEMROWO','BENOWO','BUBUTAN','BULAK','DUKUH PAKIS','GAYUNGAN','GENTENG','GUBENG','GUNUNG ANYAR','JAMBANGAN','KARANG PILANG','KENJERAN','KREMBANGAN','LAKARSANTRI','MULYOREJO','PABEAN CANTIAN','PAKAL','RUNGKUT','SAMBIKEREP','SAWAHAN','SEMAMPIR','SIMOKERTO','SUKOLILO','SUKOMANUNGGAL','TAMBAKSARI','TANDES','TEGALSARI','TENGGILIS MEJOYO','WIYUNG','WONOCOLO','WONOKROMO']; ?>
                                                    <?php foreach($kecamatan as $kec): ?>
                                                        <option value="<?= $kec ?>"><?= $kec ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <input type="text" name="kelurahan" class="form-control" placeholder="Masukkan Kelurahan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>RW</label>
                                                <input type="text" name="rw" class="form-control" placeholder="Contoh: 01">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>RT</label>
                                                <input type="text" name="rt" class="form-control" placeholder="Contoh: 02">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alamat Lengkap <span class="text-danger">*</span></label>
                                                <textarea name="alamat" class="form-control" rows="3" required placeholder="Masukkan Alamat Lengkap"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>GIS Latitude (Optional)</label>
                                                <input type="text" name="gis_lat" class="form-control" placeholder="-7.258665">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>GIS Longitude (Optional)</label>
                                                <input type="text" name="gis_long" class="form-control" placeholder="112.713936">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Batal</button>
                                    <button type="submit" class="btn btn-primary" id="btnSimpan" disabled>Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Data -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-form">
            <form action="<?= base_url('kepemilikan_jenis_usaha/update'); ?>" method="post" id="formEdit">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" id="edit_id" name="id">
                <input type="hidden" id="edit_nik" name="nik">
                
                <div class="modal-header" style="border-bottom: 2px solid #832706;">
                    <h5 class="modal-title" style="color: #832706;">
                        <i class="fas fa-edit me-2"></i>Edit Data Kepemilikan Jenis Usaha
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <!-- Informasi Pelaku Usaha -->
                    <div class="card mb-3" style="background-color: #fef3ef; border: 1px solid #ffe0d5;">
                        <div class="card-body py-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #832706;">NIK</label>
                                        <input type="text" id="edit_nik_display" class="form-control" readonly style="background-color: #e9ecef;">
                                        <small class="text-muted">NIK tidak dapat diubah</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fw-bold" style="color: #832706;">Nama Pelaku Usaha <span class="text-danger">*</span></label>
                                        <input type="text" id="edit_nama_peternak" name="nama_peternak" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Usaha dan Jumlah -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">Jenis Usaha <span class="text-danger">*</span></label>
                                <select id="edit_jenis_usaha" name="jenis_usaha" class="form-control" required>
                                    <option value="">Pilih Jenis Usaha</option>
                                    <option value="Peternak Sapi Perah">Peternak Sapi Perah</option>
                                    <option value="Peternak Sapi Potong">Peternak Sapi Potong</option>
                                    <option value="Peternak Kambing">Peternak Kambing</option>
                                    <option value="Peternak Domba">Peternak Domba</option>
                                    <option value="Peternak Ayam Broiler">Peternak Ayam Broiler</option>
                                    <option value="Peternak Ayam Petelur">Peternak Ayam Petelur</option>
                                    <option value="Peternak Itik">Peternak Itik</option>
                                    <option value="Peternak Kelinci">Peternak Kelinci</option>
                                    <option value="Peternak Babi">Peternak Babi</option>
                                    <option value="Peternak Kuda">Peternak Kuda</option>
                                    <option value="Penjual Pakan Ternak">Penjual Pakan Ternak</option>
                                    <option value="Penjual Obat Hewan">Penjual Obat Hewan</option>
                                    <option value="Klinik Hewan">Klinik Hewan</option>
                                    <option value="TPU/RPU">TPU/RPU</option>
                                    <option value="Pemotongan Unggas">Pemotongan Unggas</option>
                                    <option value="Demplot">Demplot</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">Jumlah Ternak / Unit Usaha <span class="text-danger">*</span></label>
                                <input type="number" id="edit_jumlah" name="jumlah" class="form-control" required min="0" step="1">
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">Kecamatan <span class="text-danger">*</span></label>
                                <select id="edit_kecamatan" name="kecamatan" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <?php $kecamatan = ['ASEMROWO','BENOWO','BUBUTAN','BULAK','DUKUH PAKIS','GAYUNGAN','GENTENG','GUBENG','GUNUNG ANYAR','JAMBANGAN','KARANG PILANG','KENJERAN','KREMBANGAN','LAKARSANTRI','MULYOREJO','PABEAN CANTIAN','PAKAL','RUNGKUT','SAMBIKEREP','SAWAHAN','SEMAMPIR','SIMOKERTO','SUKOLILO','SUKOMANUNGGAL','TAMBAKSARI','TANDES','TEGALSARI','TENGGILIS MEJOYO','WIYUNG','WONOCOLO','WONOKROMO']; ?>
                                    <?php foreach($kecamatan as $kec): ?>
                                        <option value="<?= $kec ?>"><?= $kec ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">Kelurahan</label>
                                <input type="text" id="edit_kelurahan" name="kelurahan" class="form-control" placeholder="Masukkan Kelurahan">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">RW</label>
                                <input type="text" id="edit_rw" name="rw" class="form-control" placeholder="Contoh: 01">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">RT</label>
                                <input type="text" id="edit_rt" name="rt" class="form-control" placeholder="Contoh: 02">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea id="edit_alamat" name="alamat" class="form-control" rows="3" required placeholder="Masukkan Alamat Lengkap"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- GIS Koordinat -->
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">GIS Latitude (Optional)</label>
                                <input type="text" id="edit_gis_lat" name="gis_lat" class="form-control" placeholder="-7.258665">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold" style="color: #832706;">GIS Longitude (Optional)</label>
                                <input type="text" id="edit_gis_long" name="gis_long" class="form-control" placeholder="112.713936">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #832706 !important; border-color: #832706 !important; border-radius: 6px; padding: 8px 20px; font-weight: 500;">
                        <i class="fas fa-save me-1"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Content Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="kepemilikanJenisUsahaTable" class="table table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th width="50">No</th>
                                                <th>NIK</th>
                                                <th>Nama Pelaku Usaha</th>
                                                                                                <th>Jenis Usaha</th>
                                                <th>Jumlah</th>
                                                <th>Alamat</th>
                                                <th>Kecamatan</th>
                                                <th width="100">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($kepemilikan_jenis_usaha)): ?>
                                                <?php $no = 1; ?>
                                                <?php foreach($kepemilikan_jenis_usaha as $row): ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= htmlspecialchars($row->nik ?? '-'); ?></td>
                                                        <td><?= htmlspecialchars($row->nama_peternak ?? ''); ?></td>
                                                        <td><?= htmlspecialchars($row->jenis_usaha ?? ''); ?></td>
                                                        <td><?= number_format($row->jumlah ?? 0, 0, ',', '.'); ?></td>
                                                        <td class="alamat-cell"><?= htmlspecialchars($row->alamat ?? ''); ?></td>
                                                        <td><?= htmlspecialchars($row->kecamatan ?? ''); ?></td>
                                                        <td>
                                                            <button class="btn btn-action btn-edit" title="Edit"
                                                                    data-id="<?= $row->id ?? ''; ?>"
                                                                    data-nik="<?= htmlspecialchars($row->nik ?? ''); ?>"
                                                                    data-nama_peternak="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>"
                                                                    data-jenis_usaha="<?= htmlspecialchars($row->jenis_usaha ?? ''); ?>"
                                                                    data-jumlah="<?= $row->jumlah ?? ''; ?>"
                                                                    data-alamat="<?= htmlspecialchars($row->alamat ?? ''); ?>"
                                                                    data-kecamatan="<?= htmlspecialchars($row->kecamatan ?? ''); ?>"
                                                                    data-kelurahan="<?= htmlspecialchars($row->kelurahan ?? ''); ?>"
                                                                    data-rw="<?= htmlspecialchars($row->rw ?? ''); ?>"
                                                                    data-rt="<?= htmlspecialchars($row->rt ?? ''); ?>"
                                                                    data-gis_lat="<?= htmlspecialchars($row->gis_lat ?? ''); ?>"
                                                                    data-gis_long="<?= htmlspecialchars($row->gis_long ?? ''); ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-action btn-delete" title="Hapus"
                                                                    data-id="<?= $row->id ?? ''; ?>"
                                                                    data-nama="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data</td>
                                                </tr>
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
    </div>
</div>

<script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/SIPETGIS/assets/js/kaiadmin.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?php echo base_url('assets/js/kepemilikan_jenis_usaha.js'); ?>"></script>
</body>
</html>