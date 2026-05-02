<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Stok Pakan</title>
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

    <!-- Custom CSS Data Stok Pakan -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/data_stok_pakan.css'); ?>" />
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
                                    <li><a href="<?= site_url('data_klinik') ?>" class="nav-link">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a></li>
                                    <li><a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link">Pemotongan Unggas</a></li>
                                    <li><a href="<?= site_url('data_demplot') ?>" class="nav-link">Demplot</a></li>
                                    <li><a href="<?= site_url('data_stok_pakan') ?>" class="nav-link active">Stok Pakan</a></li>
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Data Stok Pakan</h3>
                            <h6 class="op-7 mb-0">Manajemen data stok pakan ternak di Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterJenisPakan" class="form-label fw-bold">Filter Jenis Pakan:</label>
                                    <select class="form-select form-select-sm" id="filterJenisPakan">
                                        <option selected value="all">Semua Jenis</option>
                                        <?php if (!empty($jenis_pakan_list)): ?>
                                            <?php foreach ($jenis_pakan_list as $j): ?>
                                                <option value="<?php echo htmlspecialchars($j['jenis_pakan']); ?>">
                                                    <?php echo htmlspecialchars($j['jenis_pakan']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterMerkPakan" class="form-label fw-bold">Filter Merk:</label>
                                    <select class="form-select form-select-sm" id="filterMerkPakan">
                                        <option selected value="all">Semua Merk</option>
                                        <?php if (!empty($merk_pakan_list)): ?>
                                            <?php foreach ($merk_pakan_list as $m): ?>
                                                <option value="<?php echo htmlspecialchars($m['merk_pakan']); ?>">
                                                    <?php echo htmlspecialchars($m['merk_pakan']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label for="filterDemplot" class="form-label fw-bold">Filter Demplot:</label>
                                    <select class="form-select form-select-sm" id="filterDemplot">
                                        <option selected value="all">Semua Demplot</option>
                                        <?php if (!empty($demplot_list)): ?>
                                            <?php foreach ($demplot_list as $d): ?>
                                                <option value="<?php echo htmlspecialchars($d['id_demplot']); ?>">
                                                    Demplot <?php echo htmlspecialchars($d['id_demplot']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterPeriode" class="form-label fw-bold">Filter Periode:</label>
                                    <div class="d-flex">
                                        <input type="date" id="startDate" class="form-control form-control-sm periode-input me-1" value="<?php echo date('Y-m-01'); ?>">
                                        <span class="mx-1 align-self-center">-</span>
                                        <input type="date" id="endDate" class="form-control form-control-sm periode-input ms-1" value="<?php echo date('Y-m-t'); ?>">
                                    </div>
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
                                <table id="stokTable" class="table table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th width="40">No</th>
                                            <th>Tanggal</th>
                                            <th>Demplot</th>
                                            <th>Jenis Pakan</th>
                                            <th>Merk</th>
                                            <th>Stok Awal</th>
                                            <th>Stok Masuk</th>
                                            <th>Stok Keluar</th>
                                            <th>Stok Akhir</th>
                                            <th>Keterangan</th>
                                            <th width="80">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($stok_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($stok_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo isset($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                                                    <td>
                                                        <span class="demplot-info">Demplot <?php echo htmlspecialchars($data['id_demplot'] ?? '-'); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-jenis"><?php echo htmlspecialchars($data['jenis_pakan'] ?? '-'); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-merk"><?php echo htmlspecialchars($data['merk_pakan'] ?? '-'); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-stok"><?php echo number_format($data['stok_awal'] ?? 0, 0); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-masuk">+<?php echo number_format($data['stok_masuk'] ?? 0, 0); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-keluar">-<?php echo number_format($data['stok_keluar'] ?? 0, 0); ?></span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="badge-akhir"><?php echo number_format($data['stok_akhir'] ?? 0, 0); ?></span>
                                                            <?php if (isset($data['stok_awal']) && $data['stok_awal'] > 0): ?>
                                                                <?php $persen = ($data['stok_akhir'] / $data['stok_awal']) * 100; ?>
                                                                <div class="stok-progress">
                                                                    <div class="stok-progress-bar" style="width: <?php echo min($persen, 100); ?>%"></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small><?php echo htmlspecialchars(substr($data['keterangan'] ?? '-', 0, 30)); ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-action-group">
                                                            <button class="btn btn-action btn-edit" title="Edit" 
                                                                    data-id="<?php echo $data['id_stok']; ?>"
                                                                    data-tanggal="<?php echo isset($data['tanggal']) ? $data['tanggal'] : ''; ?>"
                                                                    data-demplot="<?php echo $data['id_demplot']; ?>"
                                                                    data-jenis="<?php echo htmlspecialchars($data['jenis_pakan'] ?? ''); ?>"
                                                                    data-merk="<?php echo htmlspecialchars($data['merk_pakan'] ?? ''); ?>"
                                                                    data-stok_awal="<?php echo $data['stok_awal'] ?? 0; ?>"
                                                                    data-stok_masuk="<?php echo $data['stok_masuk'] ?? 0; ?>"
                                                                    data-stok_keluar="<?php echo $data['stok_keluar'] ?? 0; ?>"
                                                                    data-keterangan="<?php echo htmlspecialchars($data['keterangan'] ?? ''); ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-action btn-delete" title="Hapus" 
                                                                    data-id="<?php echo $data['id_stok']; ?>"
                                                                    data-nama="<?php echo htmlspecialchars($data['jenis_pakan'] ?? 'Stok Pakan'); ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data stok pakan<td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"><tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="editModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form id="formEdit">
                                    <input type="hidden" id="edit_id" name="id_stok">
                                    <div class="modal-header bg-primary-custom text-white">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Stok Pakan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Demplot <span class="text-danger">*</span></label>
                                                <select class="form-control" id="edit_demplot" name="id_demplot" required>
                                                    <option value="">Pilih Demplot</option>
                                                    <?php if (!empty($demplot_list)): ?>
                                                        <?php foreach ($demplot_list as $d): ?>
                                                            <option value="<?php echo $d['id_demplot']; ?>">
                                                                Demplot <?php echo $d['id_demplot']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jenis Pakan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="edit_jenis" name="jenis_pakan" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Merk Pakan</label>
                                                <input type="text" class="form-control" id="edit_merk" name="merk_pakan">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Stok Awal (kg) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="edit_stok_awal" name="stok_awal" required min="0">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Stok Masuk (kg)</label>
                                                <input type="number" class="form-control" id="edit_stok_masuk" name="stok_masuk" min="0">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Stok Keluar (kg)</label>
                                                <input type="number" class="form-control" id="edit_stok_keluar" name="stok_keluar" min="0">
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
                                    <p>Apakah Anda yakin ingin menghapus data stok pakan ini?</p>
                                    <p class="fw-bold" id="deleteInfo"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary-custom btn-sm" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Batal</button>
                                    <button type="button" class="btn btn-danger-custom btn-sm" id="confirmDelete"><i class="fas fa-trash me-1"></i>Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Section -->
                    <div id="detailSection" class="detail-section" style="display: none;">
                        <div class="detail-header">
                            <h5 class="fw-bold mb-0" id="detailTitle">Detail Stok Pakan</h5>
                            <div id="detailInfo" class="text-muted mt-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header bg-primary-custom text-white">
                                        <h6 class="mb-0">Informasi Stok Pakan</h6>
                                    </div>
                                    <div class="card-body" id="detailStokInfo"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-primary-custom text-white">
                                <h6 class="mb-0">Detail Perubahan Stok</h6>
                            </div>
                            <div class="card-body" id="detailPerubahanInfo"></div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header bg-primary-custom text-white">
                                <h6 class="mb-0">Keterangan</h6>
                            </div>
                            <div class="card-body" id="detailKeteranganInfo"></div>
                        </div>
                        <div class="text-end mt-3">
                            <button id="closeDetailBtn" class="btn btn-outline-primary-custom btn-sm"><i class="fas fa-times me-1"></i>Tutup Detail</button>
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

    <!-- Custom JS Data Stok Pakan -->
    <script src="<?php echo base_url('assets/js/data_stok_pakan.js'); ?>"></script>
</body>
</html>