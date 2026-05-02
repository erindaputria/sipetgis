<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan Kepemilikan Ternak - SIPETGIS</title>
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
    
    <!-- Custom CSS Laporan Kepemilikan Ternak -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan_kepemilikan_ternak.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?= base_url('k_dashboard_kepala') ?>" class="logo" style="text-decoration: none">
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
                            <a href="<?php echo site_url('k_dashboard_kepala'); ?>">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2" style="color: #832706 !important;"></i>
                                    <span>Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="laporanSubmenu"> 
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('k_laporan_kepala/kepemilikan_ternak') ?>" class="nav-link active">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/history_data_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/history_vaksinasi') ?>" class="nav-link">History Data Vaksinasi</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/pengobatan_ternak') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/data_klinik_hewan') ?>" class="nav-link">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/penjual_obat_hewan') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/data_tpu_rpu') ?>" class="nav-link">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/demplot_peternakan') ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('k_laporan_kepala/stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('k_peta_sebaran_kepala') ?>" class="nav-link">
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Laporan Kepemilikan Ternak</h3>
                            <h6 class="op-7 mb-0">Data Peternak dan Populasi Ternak Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section --> 
                    <div class="filter-section no-print">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                                <select class="form-select" id="filterTahun">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php foreach($tahun as $t): ?>
                                        <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Bulan</label>
                                <select class="form-select" id="filterBulan">
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php foreach($bulan as $key => $value): ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select class="form-select" id="filterKecamatan">
                                    <option value="semua">Semua Kecamatan</option>
                                    <?php 
                                    $kecamatan_list = [
                                        'Asemrowo', 'Krembangan', 'Pabean Cantian', 'Semampir', 'Bulak',
                                        'Kenjeran', 'Simokerto', 'Tambaksari', 'Mulyorejo', 'Sukolilo',
                                        'Gubeng', 'Rungkut', 'Gunung Anyar', 'Tenggilis Mejoyo', 'Wonocolo',
                                        'Benowo', 'Pakal', 'Sambikerep', 'Tandes', 'Sukomanunggal',
                                        'Lakarsantri', 'Wiyung', 'Sawahan', 'Dukuh Pakis', 'Karangpilang',
                                        'Gayungan', 'Jambangan', 'Wonokromo', 'Tegalsari', 'Genteng', 'Bubutan'
                                    ];
                                    foreach($kecamatan_list as $kec): 
                                    ?>
                                        <option value="<?= $kec ?>"><?= $kec ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Jenis Data</label>
                                <select class="form-select" id="filterJenisData">
                                    <option value="peternak">Jumlah Peternak</option>
                                    <option value="populasi">Jumlah Populasi Ternak</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary-custom" id="btnFilter">
                                    <i class="fas fa-search me-2"></i>Tampilkan Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Report Title -->
                    <div class="report-title" id="reportTitle">
                        REKAP DATA JUMLAH PETERNAK
                    </div>
                    <div class="report-subtitle" id="reportSubtitle">
                        Kota Surabaya
                    </div>

                    <!-- Main Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="kepemilikanTable">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Kecamatan</th>
                                            <th>Sapi Potong</th>
                                            <th>Sapi Perah</th>
                                            <th>Kambing</th>
                                            <th>Domba</th>
                                            <th>Ayam</th>
                                            <th>Itik</th>
                                            <th>Angsa</th>
                                            <th>Kalkun</th>
                                            <th>Burung</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        $kecamatan_list_display = [
                                            1 => 'Asemrowo', 2 => 'Krembangan', 3 => 'Pabean Cantian', 4 => 'Semampir', 5 => 'Bulak',
                                            6 => 'Kenjeran', 7 => 'Simokerto', 8 => 'Tambaksari', 9 => 'Mulyorejo', 10 => 'Sukolilo',
                                            11 => 'Gubeng', 12 => 'Rungkut', 13 => 'Gunung Anyar', 14 => 'Tenggilis Mejoyo', 15 => 'Wonocolo',
                                            16 => 'Benowo', 17 => 'Pakal', 18 => 'Sambikerep', 19 => 'Tandes', 20 => 'Sukomanunggal',
                                            21 => 'Lakarsantri', 22 => 'Wiyung', 23 => 'Sawahan', 24 => 'Dukuh Pakis', 25 => 'Karangpilang',
                                            26 => 'Gayungan', 27 => 'Jambangan', 28 => 'Wonokromo', 29 => 'Tegalsari', 30 => 'Genteng', 31 => 'Bubutan'
                                        ];
                                        
                                        foreach($kecamatan_list_display as $no => $kecamatan):
                                            $baseUrlDetail = base_url('laporan_kepemilikan_ternak/detail_kecamatan/' . urlencode($kecamatan));
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no ?></td>
                                            <td class="kecamatan-cell"><?= $kecamatan ?></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Sapi Potong" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/SapiPerah" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Kambing" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Domba" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Ayam" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Itik" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Angsa" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Kalkun" class="data-link" target="_blank">0</a></td>
                                            <td class="text-center"><a href="<?= $baseUrlDetail ?>/Burung" class="data-link" target="_blank">0</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot id="tableFooter" style="display: table-footer-group;">
                                        <!-- Total row akan ditambahkan oleh JavaScript -->
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!-- Definisi variabel global -->
    <script>
        var base_url = "<?= base_url() ?>";
        var bulanNama = {
            '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April', '05': 'Mei', '06': 'Juni',
            '07': 'Juli', '08': 'Agustus', '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
        };
    </script>

    <!-- Custom JS Laporan Kepemilikan Ternak -->
    <script src="<?php echo base_url('assets/js/laporan_kepemilikan_ternak.js'); ?>"></script>
</body>
</html>