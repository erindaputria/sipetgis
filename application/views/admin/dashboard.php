<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initSurabayaMap" async defer></script>

    <!-- Fonts and icons -->
    <script src="assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["assets/SIPETGIS/assets/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/SIPETGIS/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/SIPETGIS/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/SIPETGIS/assets/css/kaiadmin.min.css" />
    
    <!-- Custom CSS Dashboard -->
    <link rel="stylesheet" href="assets/css/dashboard.css" />
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
                        <li class="nav-item active">
                            <a href="index.html"> 
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
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="fw-bold" style="color: #000000 !important;">Administrator</span>
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
                                            <a href="<?= site_url('login/logout') ?>" class="nav-link">
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
                            <h6 class="op-7 mb-0">Dashboard Sistem Informasi Peternakan Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-0">
                        <div class="col-md-6">
                            <div class="card card-stats card-round stat-card me-1">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: #ffffff; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                                                <i class="fas fa-users" style="color: #832706; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category" style="color: #832706; font-weight: 600;">Pelaku Usaha</p>
                                                <h4 class="card-title" style="color: #1e293b; font-weight: 800;"><?= number_format($total_pelaku_usaha, 0, ',', '.') ?></h4>
                                                <p class="card-subtitle" style="color: #64748b;">Peternak</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-stats card-round stat-card ms-1">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: #ffffff; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                                                <i class="fas fa-paw" style="color: #832706; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category" style="color: #832706; font-weight: 600;">Jenis Ternak</p>
                                                <h4 class="card-title" style="color: #1e293b; font-weight: 800;"><?= number_format($total_jenis_usaha, 0, ',', '.') ?></h4>
                                                <p class="card-subtitle" style="color: #64748b;">Komoditas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card stat-card">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="kecamatanTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th>Kecamatan</th>
                                                    <th class="text-end">Jumlah Peternak</th>
                                                    <th class="text-end">Sapi Potong</th>
                                                    <th class="text-end">Sapi Perah</th>
                                                    <th class="text-end">Kambing</th>
                                                    <th class="text-end">Domba</th>
                                                    <th class="text-end">Ayam Buras</th>
                                                    <th class="text-end">Ayam Broiler</th>
                                                    <th class="text-end">Ayam Layer</th>
                                                    <th class="text-end">Itik</th>
                                                    <th class="text-end">Angsa</th>
                                                    <th class="text-end">Kalkun</th>
                                                    <th class="text-end">Burung</th>
                                                    <th class="text-end">Kerbau</th>
                                                    <th class="text-end">Kuda</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($statistik_kecamatan)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($statistik_kecamatan as $row): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++ ?></td>
                                                            <td><?= htmlspecialchars($row->kecamatan) ?></td>
                                                            <td class="text-end"><?= number_format($row->jumlah_peternak, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->{'Sapi Potong'}, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->{'Sapi Perah'}, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Kambing, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Domba, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->{'Ayam Buras'}, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->{'Ayam Broiler'}, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->{'Ayam Layer'}, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Itik, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Angsa, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Kalkun, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Burung, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Kerbau, 0, ',', '.') ?></td>
                                                            <td class="text-end"><?= number_format($row->Kuda, 0, ',', '.') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="16" class="text-center">Belum ada data</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                            <?php 
                                            // Hitung total untuk footer
                                            $totals = $this->Dashboard_model->get_total_per_komoditas();
                                            $total_peternak = $this->Dashboard_model->get_total_peternak();
                                            ?>
                                            <tfoot class="table-light">
                                                <tr class="fw-bold">
                                                    <td colspan="2" class="text-end">TOTAL:</td>
                                                    <td class="text-end"><?= number_format($total_peternak, 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Sapi Potong'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Sapi Perah'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Kambing'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Domba'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Ayam Buras'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Ayam Broiler'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Ayam Layer'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Itik'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Angsa'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Kalkun'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Burung'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Kerbau'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($totals['Kuda'], 0, ',', '.') ?></td>
                                                </tr>
                                            </tfoot>
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
    <script src="assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
    
    <!-- Custom JS Dashboard -->
    <script src="assets/js/dashboard.js"></script>
</body>
</html>