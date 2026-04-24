<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Sistem Informasi Peternakan Kota Surabaya</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initSurabayaMap" async defer></script>

    <!-- Fonts and icons -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js"></script>
    <script> 
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
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
    
    <!-- Custom CSS Dashboard Kepala -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard_kepala.css" />
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
        <!-- ========== END SIDEBAR ========== -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
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
                    <!-- ========== DASHBOARD HEADER ========== -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Dashboard</h3>
                            <h6 class="op-7 mb-0">Dashboard Sistem Informasi Peternakan Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- ========== STATISTICS CARDS ========== -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-stats card-round stat-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: #ffffff !important; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-users" style="color: #832706 !important; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Pelaku Usaha</p>
                                                <h4 class="card-title"><?php echo number_format($total_pelaku_usaha, 0, ',', '.'); ?></h4>
                                                <p class="card-subtitle">Peternak</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-stats card-round stat-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: #ffffff !important; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-paw" style="color: #832706 !important; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Jenis Ternak</p>
                                                <h4 class="card-title"><?php echo number_format($total_jenis_usaha, 0, ',', '.'); ?></h4>
                                                <p class="card-subtitle">Komoditas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-stats card-round stat-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center" style="background: #ffffff !important; border-radius: 16px; width: 65px; height: 65px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-syringe" style="color: #832706 !important; font-size: 28px;"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <p class="card-category">Vaksinasi</p>
                                                <h4 class="card-title">3</h4>
                                                <p class="card-subtitle">PMK | ND/AI | LSD</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== JENIS USAHA PETERNAKAN (CARD PUTIH) ========== -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card" style="background: #ffffff !important; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                <div class="card-header" style="background: #ffffff !important; border-bottom: 1px solid #eef2ff;">
                                    <h6 class="mb-0" style="color: #832706 !important; font-weight: 600;">
                                        <i class="fas fa-list me-2" style="color: #832706 !important;"></i>Jenis Usaha Peternakan 
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Sapi Potong</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Sapi Perah</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Kambing</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Domba</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Ayam Buras</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Ayam Broiler</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Ayam Layer</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Itik</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Angsa</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Kalkun</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Burung</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Kerbau</span>
                                        <span class="badge-ternak" style="background: #eef2ff; color: #832706;">Kuda</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== GRAFIK DISTRIBUSI PELAKU USAHA ========== -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="chart-container-wrapper" style="background: #ffffff; border-radius: 10px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                                <div style="margin-bottom: 15px;">
                                    <h6 class="mb-0" style="color: #832706; font-weight: 600;">Distribusi Pelaku Usaha per Kecamatan (31 Kecamatan Surabaya)</h6>
                                </div>
                                <canvas id="kecamatanChart" class="chart-container" style="height: 400px; width: 100%;"></canvas>
                                <div class="text-end mt-3">
                                    <a href="#" class="btn btn-link p-0" style="color: #832706 !important; text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDetailPelakuUsaha">
                                        Lihat Detail Tabel
                                        <i class="fas fa-arrow-right ms-1" style="color: #832706 !important;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    // Data grafik dari database
                    var chartLabels = <?php echo json_encode($grafik_kecamatan->labels); ?>;
                    var chartData = <?php echo json_encode($grafik_kecamatan->data); ?>;

                    // Debug di console browser
                    console.log('Labels:', chartLabels);
                    console.log('Data:', chartData);

                    // Inisialisasi Chart
                    document.addEventListener("DOMContentLoaded", function () {
                        var ctx = document.getElementById("kecamatanChart").getContext("2d");
                        ctx.canvas.style.backgroundColor = "#ffffff";
                        
                        new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: chartLabels,
                                datasets: [{
                                    label: "Jumlah Pelaku Usaha",
                                    data: chartData,
                                    backgroundColor: "#832706",
                                    borderColor: "#6b2005",
                                    borderWidth: 1,
                                    borderRadius: 3,
                                    barPercentage: 0.7,
                                    categoryPercentage: 0.9
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { 
                                        display: true,
                                        position: 'top',
                                        labels: {
                                            color: '#832706',
                                            font: { size: 11, weight: 'bold' },
                                            usePointStyle: true,
                                            boxWidth: 10
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: "#832706",
                                        titleColor: "#ffffff",
                                        bodyColor: "#ffffff",
                                        callbacks: {
                                            label: function (context) {
                                                return `Pelaku Usaha: ${context.raw} peternak`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { display: false },
                                        ticks: { 
                                            font: { size: 10 }, 
                                            stepSize: 10,
                                            color: "#333333"
                                        },
                                        title: { 
                                            display: true, 
                                            text: "Jumlah Pelaku Usaha", 
                                            font: { size: 11, weight: 'bold' },
                                            color: "#832706"
                                        }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { 
                                            font: { size: 8 }, 
                                            rotation: 45,
                                            color: "#333333"
                                        },
                                        title: { 
                                            display: true, 
                                            text: "Kecamatan", 
                                            font: { size: 11, weight: 'bold' },
                                            color: "#832706"
                                        }
                                    }
                                },
                                animation: { duration: 1000, easing: "easeOutQuart" },
                                layout: { 
                                    padding: { 
                                        top: 20,
                                        bottom: 10,
                                        left: 10,
                                        right: 10
                                    } 
                                }
                            }
                        });
                    });
                    </script>

                    <!-- ========== BARIS VAKSINASI DAN TEMPAT USAHA ========== -->
                    <div class="row mt-4">
                        <!-- Cakupan Vaksinasi -->
                        <div class="col-md-6">
                            <div class="vaksin-wrapper" style="background: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; height: 100%;">
                                <div class="vaksin-header" style="padding: 15px 20px; border-bottom: 1px solid #eef2ff;">
                                    <h6 class="mb-0" style="color: #832706; font-weight: 600;">
                                        <i class="fas fa-syringe me-2" style="color: #832706 !important;"></i>Cakupan Vaksinasi
                                    </h6>
                                </div>
                                <div class="vaksin-body" style="padding: 20px;">
                                    <div class="vaksin-progress" style="margin-bottom: 20px;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="color: #832706; font-weight: 500;">PMK (Penyakit Mulut & Kuku)</span>
                                            <span class="fw-bold" style="color: #832706;"><?php echo number_format($total_vaksinasi_pmk, 0, ',', '.'); ?> Ekor</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" style="width: <?php echo $persen_vaksinasi_pmk; ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="vaksin-progress" style="margin-bottom: 20px;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="color: #832706; font-weight: 500;">ND/AI (Newcastle / Avian Influenza)</span>
                                            <span class="fw-bold" style="color: #832706;"><?php echo number_format($total_vaksinasi_ndai, 0, ',', '.'); ?> Ekor</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: <?php echo $persen_vaksinasi_ndai; ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="vaksin-progress" style="margin-bottom: 0;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span style="color: #832706; font-weight: 500;">LSD (Lumpy Skin Disease)</span>
                                            <span class="fw-bold" style="color: #832706;"><?php echo number_format($total_vaksinasi_lsd, 0, ',', '.'); ?> Ekor</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-info" style="width: <?php echo $persen_vaksinasi_lsd; ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tempat Usaha -->
                        <div class="col-md-6">
                            <div class="facility-wrapper" style="background: #ffffff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; height: 100%;">
                                <div class="facility-header" style="padding: 15px 20px; border-bottom: 1px solid #eef2ff;">
                                    <h6 class="mb-0" style="color: #832706; font-weight: 600;">
                                        <i class="fas fa-building me-2" style="color: #832706 !important;"></i>Tempat Usaha
                                    </h6>
                                </div>
                                <div class="facility-body" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <div class="facility-card" style="text-align: center; padding: 10px; border-radius: 8px; background: #f8f9fa;">
                                                <i class="fas fa-hospital-user fa-2x mb-2" style="color: #832706 !important;"></i>
                                                <h6 class="mb-0" style="color: #832706;">Klinik Hewan</h6>
                                                <p class="fw-bold fs-4 mb-0" style="color: #832706;"><?php echo number_format($total_klinik_hewan, 0, ',', '.'); ?></p>
                                                <small class="text-muted" style="color: #832706;">Unit</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="facility-card" style="text-align: center; padding: 10px; border-radius: 8px; background: #f8f9fa;">
                                                <i class="fas fa-capsules fa-2x mb-2" style="color: #832706 !important;"></i>
                                                <h6 class="mb-0" style="color: #832706;">Penjual Obat Hewan</h6>
                                                <p class="fw-bold fs-4 mb-0" style="color: #832706;"><?php echo number_format($total_penjual_obat, 0, ',', '.'); ?></p>
                                                <small class="text-muted" style="color: #832706;">Toko</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="facility-card" style="text-align: center; padding: 10px; border-radius: 8px; background: #f8f9fa;">
                                                <i class="fas fa-seedling fa-2x mb-2" style="color: #832706 !important;"></i>
                                                <h6 class="mb-0" style="color: #832706;">Penjual Pakan</h6>
                                                <p class="fw-bold fs-4 mb-0" style="color: #832706;"><?php echo number_format($total_penjual_pakan, 0, ',', '.'); ?></p>
                                                <small class="text-muted" style="color: #832706;">Outlet</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="facility-card" style="text-align: center; padding: 10px; border-radius: 8px; background: #f8f9fa;">
                                                <i class="fas fa-tractor fa-2x mb-2" style="color: #832706 !important;"></i>
                                                <h6 class="mb-0" style="color: #832706;">RPU / TPU</h6>
                                                <p class="fw-bold fs-4 mb-0" style="color: #832706;">5</p>
                                                <small class="text-muted" style="color: #832706;">Unit</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   <!-- ========== TABEL DATA KECAMATAN ========== -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-wrapper" style="background: #ffffff; border-radius: 10px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Kecamatan</th>
                                                <th class="text-end">Pelaku Usaha</th>
                                                <th>Jenis Ternak</th>
                                                <th class="text-end">Vaksinasi PMK</th>
                                                <th class="text-end">Vaksinasi ND-AI</th>
                                                <th class="text-end">Vaksinasi LSD</th>
                                                <th class="text-end">Klinik Hewan</th>
                                                <th class="text-end">Penjual Obat</th>
                                                <th class="text-end">Penjual Pakan</th>
                                                <th class="text-end">RPU/TPU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($statistik_kecamatan)): ?>
                                                <?php 
                                                $total_peternak = 0;
                                                $total_vaksin_pmk = 0;
                                                $total_vaksin_ndai = 0;
                                                $total_vaksin_lsd = 0;
                                                ?>
                                                <?php foreach ($statistik_kecamatan as $row): 
                                                    $total_peternak += $row->jumlah_peternak;
                                                    $total_vaksin_pmk += $row->{'Sapi Potong'} + $row->{'Sapi Perah'} + $row->Kambing + $row->Domba;
                                                    $total_vaksin_ndai += $row->{'Ayam Buras'} + $row->{'Ayam Broiler'} + $row->{'Ayam Layer'} + $row->Itik;
                                                    $total_vaksin_lsd += $row->Kerbau + $row->Kuda;
                                                ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row->kecamatan); ?></td>
                                                        <td class="text-end"><?php echo number_format($row->jumlah_peternak, 0, ',', '.'); ?></td>
                                                        <td><?php echo htmlspecialchars($row->jenis_ternak); ?></td>
                                                        <td class="text-end"><?php echo number_format($row->{'Sapi Potong'} + $row->{'Sapi Perah'} + $row->Kambing + $row->Domba, 0, ',', '.'); ?> Ekor</td>
                                                        <td class="text-end"><?php echo number_format($row->{'Ayam Buras'} + $row->{'Ayam Broiler'} + $row->{'Ayam Layer'} + $row->Itik, 0, ',', '.'); ?> Ekor</td>
                                                        <td class="text-end"><?php echo number_format($row->Kerbau + $row->Kuda, 0, ',', '.'); ?> Ekor</td>
                                                        <td class="text-end"><?php echo number_format($total_klinik_hewan, 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?php echo number_format($total_penjual_obat, 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?php echo number_format($total_penjual_pakan, 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?php echo number_format($total_rpu_tpu, 0, ',', '.'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr class="table-active">
                                                    <td class="fw-bold">Total (<?php echo count($statistik_kecamatan); ?> Kecamatan)</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_peternak, 0, ',', '.'); ?></td>
                                                    <td class="fw-bold">13 Jenis Ternak</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_vaksin_pmk, 0, ',', '.'); ?> Ekor</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_vaksin_ndai, 0, ',', '.'); ?> Ekor</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_vaksin_lsd, 0, ',', '.'); ?> Ekor</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_klinik_hewan, 0, ',', '.'); ?> Unit</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_penjual_obat, 0, ',', '.'); ?> Toko</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_penjual_pakan, 0, ',', '.'); ?> Outlet</td>
                                                    <td class="text-end fw-bold"><?php echo number_format($total_rpu_tpu, 0, ',', '.'); ?> Unit</td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">Belum ada data</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-footer" style="padding: 12px 20px; border-top: 1px solid #eef2ff; text-align: right;">
                                    <a href="#" class="btn btn-link" style="color: #832706 !important; text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalSemuaKecamatan">
                                        Lihat Selengkapnya
                                        <i class="fas fa-arrow-right ms-1" style="color: #832706 !important;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== MODAL DETAIL PELAKU USAHA ========== -->
                    <div class="modal fade" id="modalDetailPelakuUsaha" tabindex="-1" aria-labelledby="modalDetailPelakuUsahaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header" style="background: #832706 !important;">
                                    <h5 class="modal-title fw-bold" style="color: #ffffff !important;">
                                        <i class="fas fa-chart-bar me-2" style="color: #ffffff !important;"></i>Data Pelaku Usaha per Kecamatan
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0">
                                            <thead class="table-light"><tr><th>No</th><th>Kecamatan</th><th class="text-end">Pelaku Usaha</th></tr></thead>
                                            <tbody>
                                                <?php foreach ($pelaku_usaha_per_kecamatan as $row): ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $row->no; ?></td>
                                                    <td><?php echo htmlspecialchars($row->kecamatan); ?></td>
                                                    <td class="text-end"><?php echo number_format($row->pelaku_usaha, 0, ',', '.'); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr class="fw-bold"><td colspan="2">Total 31 Kecamatan</td><td class="text-end"><?php echo number_format($total_pelaku_usaha_all, 0, ',', '.'); ?></td></tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="background: #6b2005 !important; color: #ffffff !important;" data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" style="background: #832706 !important;" onclick="window.print()"><i class="fas fa-print me-2" style="color: #ffffff !important;"></i>Cetak</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========== MODAL 31 KECAMATAN LENGKAP ========== -->
<div class="modal fade" id="modalSemuaKecamatan" tabindex="-1" aria-labelledby="modalSemuaKecamatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: #832706 !important;">
                <h5 class="modal-title fw-bold" style="color: #ffffff !important;">
                    <i class="fas fa-city me-2" style="color: #ffffff !important;"></i>Data Seluruh Kecamatan di Surabaya (31 Kecamatan)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th class="text-end">Pelaku Usaha</th>
                                <th>Jenis Ternak</th>
                                <th class="text-end">Vaksinasi PMK</th>
                                <th class="text-end">Vaksinasi ND-AI</th>
                                <th class="text-end">Vaksinasi LSD</th>
                                <th class="text-end">Klinik Hewan</th>
                                <th class="text-end">Penjual Obat</th>
                                <th class="text-end">Penjual Pakan</th>
                                <th class="text-end">RPU/TPU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detail_pelaku_usaha_per_kecamatan)): ?>
                                <?php 
                                $total_seluruh_pelaku = 0;
                                $total_seluruh_pmk = 0;
                                $total_seluruh_ndai = 0;
                                $total_seluruh_lsd = 0;
                                $total_seluruh_klinik = 0;
                                $total_seluruh_obat = 0;
                                $total_seluruh_pakan = 0;
                                ?>
                                <?php foreach ($detail_pelaku_usaha_per_kecamatan as $row): 
                                    $total_seluruh_pelaku += $row->pelaku_usaha;
                                    
                                    // Ambil data vaksinasi per kecamatan
                                    $vaksin_pmk = isset($vaksinasi_per_kecamatan[$row->kecamatan]['PMK']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['PMK'] : 0;
                                    $vaksin_ndai = isset($vaksinasi_per_kecamatan[$row->kecamatan]['ND-AI']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['ND-AI'] : 0;
                                    $vaksin_lsd = isset($vaksinasi_per_kecamatan[$row->kecamatan]['LSD']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['LSD'] : 0;
                                    
                                    // Ambil data klinik per kecamatan
                                    $klinik = isset($klinik_per_kecamatan[$row->kecamatan]) ? $klinik_per_kecamatan[$row->kecamatan] : 0;
                                    
                                    // Ambil data penjual obat per kecamatan
                                    $penjual_obat = isset($penjual_obat_per_kecamatan[$row->kecamatan]) ? $penjual_obat_per_kecamatan[$row->kecamatan] : 0;
                                    
                                    // Ambil data penjual pakan per kecamatan
                                    $penjual_pakan = isset($penjual_pakan_per_kecamatan[$row->kecamatan]) ? $penjual_pakan_per_kecamatan[$row->kecamatan] : 0;
                                    
                                    $total_seluruh_pmk += $vaksin_pmk;
                                    $total_seluruh_ndai += $vaksin_ndai;
                                    $total_seluruh_lsd += $vaksin_lsd;
                                    $total_seluruh_klinik += $klinik;
                                    $total_seluruh_obat += $penjual_obat;
                                    $total_seluruh_pakan += $penjual_pakan;
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $row->no; ?></td>
                                        <td><?php echo htmlspecialchars($row->kecamatan); ?></td>
                                        <td class="text-end"><?php echo number_format($row->pelaku_usaha, 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($row->jenis_ternak); ?></td>
                                        <td class="text-end"><?php echo number_format($vaksin_pmk, 0, ',', '.'); ?> Ekor</td>
                                        <td class="text-end"><?php echo number_format($vaksin_ndai, 0, ',', '.'); ?> Ekor</td>
                                        <td class="text-end"><?php echo number_format($vaksin_lsd, 0, ',', '.'); ?> Ekor</td>
                                        <td class="text-end"><?php echo number_format($klinik, 0, ',', '.'); ?> Unit</td>
                                        <td class="text-end"><?php echo number_format($penjual_obat, 0, ',', '.'); ?> Toko</td>
                                        <td class="text-end"><?php echo number_format($penjual_pakan, 0, ',', '.'); ?> Outlet</td>
                                        <td class="text-end">0 Unit</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-active">
                                    <td class="fw-bold" colspan="2">Total 31 Kecamatan</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_pelaku, 0, ',', '.'); ?></td>
                                    <td class="fw-bold">13 Jenis Ternak</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_pmk, 0, ',', '.'); ?> Ekor</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_ndai, 0, ',', '.'); ?> Ekor</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_lsd, 0, ',', '.'); ?> Ekor</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_klinik, 0, ',', '.'); ?> Unit</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_obat, 0, ',', '.'); ?> Toko</td>
                                    <td class="text-end fw-bold"><?php echo number_format($total_seluruh_pakan, 0, ',', '.'); ?> Outlet</td>
                                    <td class="text-end fw-bold">0 Unit</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="background: #6b2005 !important; color: #ffffff !important;" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" style="background: #832706 !important;" onclick="window.print()"><i class="fas fa-print me-2" style="color: #ffffff !important;"></i>Cetak</button>
            </div>
        </div>
    </div>
</div>

       
    <!-- ========== CORE JS FILES ========== -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
</body>
</html>