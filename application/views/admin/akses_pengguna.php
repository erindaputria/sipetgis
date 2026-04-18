<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Akses Pengguna - SIPETGIS</title>
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
    
    <!-- Custom CSS Akses Pengguna -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/akses_pengguna.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?= base_url('dashboard') ?>" class="logo" style="text-decoration: none">
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
                            <a href="<?php echo site_url('dashboard'); ?>">
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
                                <div class="d-flex align-items-center"><i class="fas fa-database me-2" style="color: #832706 !important;"></i><span>Master</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a></li>
                                    <li><a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a></li>
                                    <li><a href="<?= site_url('akses_pengguna') ?>" class="nav-link active">Akses Pengguna</a></li>
                                    <li><a href="<?= site_url('obat') ?>" class="nav-link">Obat</a></li>
                                    <li><a href="<?= site_url('vaksin') ?>" class="nav-link">Vaksin</a></li>
                                    <li><a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                    <li><a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
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
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2" style="color: #832706 !important;"></i>
                                    <span>Laporan</span>
                                </div>
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
                            <a href="<?= site_url('peta_sebaran') ?>" class="nav-link">
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
                                        <img src="<?php echo base_url('assets/SIPETGIS/assets/img/logo dkpp.png'); ?>" alt="..." class="avatar-img rounded-circle" />
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
                    <!-- Flash Messages -->
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Master Akses Pengguna</h3>
                            <h6 class="op-7 mb-0">Kelola Data Akses Pengguna</h6>
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
                                <form action="<?= base_url('akses_pengguna/simpan'); ?>" method="post" id="formTambah">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Data Akses Pengguna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Password <span class="text-danger">*</span></label>
                                                <div class="password-field">
                                                    <input type="password" id="password" name="password" class="form-control" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                                <div class="password-field">
                                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                                                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Level <span class="text-danger">*</span></label>
                                                <select name="level" class="form-control" required>
                                                    <option value="">Pilih Level</option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Petugas Lapangan">Petugas Lapangan</option>
                                                    <option value="Kepala Dinas">Kepala Dinas</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Telepon <span class="text-danger">*</span></label>
                                                <input type="text" name="telepon" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Non-Aktif">Non-Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="editDataModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-form">
                                <form action="<?= base_url('akses_pengguna/update'); ?>" method="post" id="formEdit">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Akses Pengguna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" id="edit_username" name="username" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Password <span class="text-muted">(Kosongkan jika tidak diubah)</span></label>
                                                <div class="password-field">
                                                    <input type="password" id="edit_password" name="password" class="form-control">
                                                    <button type="button" class="password-toggle" onclick="togglePassword('edit_password')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Level <span class="text-danger">*</span></label>
                                                <select id="edit_level" name="level" class="form-control" required>
                                                    <option value="">Pilih Level</option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Petugas Lapangan">Petugas Lapangan</option>
                                                    <option value="Kepala Dinas">Kepala Dinas</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Telepon <span class="text-danger">*</span></label>
                                                <input type="text" id="edit_telepon" name="telepon" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Kecamatan <span class="text-danger">*</span></label>
                                                <select id="edit_kecamatan" name="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    <?php foreach($kecamatan as $kec): ?>
                                                        <option value="<?= $kec ?>"><?= $kec ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select id="edit_status" name="status" class="form-control" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Non-Aktif">Non-Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal View Password -->
                    <div class="modal fade" id="viewPasswordModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-key me-2"></i>Password Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" id="view_username" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" id="view_password" class="form-control" readonly>
                                            <button class="btn btn-outline-primary" type="button" onclick="togglePassword('view_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="aksesPenggunaTable" class="table table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Username</th>
                                                    <th>Level</th>
                                                    <th>Telepon</th>
                                                    <th>Kecamatan</th>
                                                    <th>Status</th>
                                                    <th width="130">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($akses)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach($akses as $row): ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= htmlspecialchars($row->username ?? ''); ?></td>
                                                            <td>
                                                                <span class="badge-peran 
                                                                    <?php 
                                                                        if(isset($row->level)) {
                                                                            if($row->level == 'Administrator') echo 'badge-admin';
                                                                            elseif($row->level == 'Kepala Dinas') echo 'badge-kepala';
                                                                            else echo 'badge-petugas';
                                                                        }
                                                                    ?>">
                                                                    <?= htmlspecialchars($row->level ?? ''); ?>
                                                                </span>
                                                            </td>
                                                            <td><?= htmlspecialchars($row->telepon ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->kecamatan ?? ''); ?></td>
                                                            <td>
                                                                <span class="badge-peran 
                                                                    <?php 
                                                                        if(isset($row->status)) {
                                                                            if($row->status == 'Aktif') echo 'badge-aktif';
                                                                            else echo 'badge-nonaktif';
                                                                        }
                                                                    ?>">
                                                                    <?= htmlspecialchars($row->status ?? ''); ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-action btn-view" title="Lihat Password"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-username="<?= htmlspecialchars($row->username ?? ''); ?>"
                                                                        data-password="<?= htmlspecialchars($row->password ?? ''); ?>">
                                                                    <i class="fas fa-key"></i>
                                                                </button>
                                                                <button class="btn btn-action btn-edit" title="Edit"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-username="<?= htmlspecialchars($row->username ?? ''); ?>"
                                                                        data-level="<?= htmlspecialchars($row->level ?? ''); ?>"
                                                                        data-telepon="<?= htmlspecialchars($row->telepon ?? ''); ?>"
                                                                        data-kecamatan="<?= htmlspecialchars($row->kecamatan ?? ''); ?>"
                                                                        data-status="<?= htmlspecialchars($row->status ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-action btn-delete" title="Hapus"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-username="<?= htmlspecialchars($row->username ?? ''); ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr><td colspan="7" class="text-center">Tidak ada数据</td></tr>
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
    
    <!-- Custom JS Akses Pengguna -->
    <script src="<?php echo base_url('assets/js/akses_pengguna.js'); ?>"></script>
</body>
</html>