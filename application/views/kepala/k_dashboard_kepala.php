<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Sistem Informasi Peternakan Kota Surabaya</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Google Maps API - dengan callback yang sudah didefinisikan -->
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

                    console.log('Labels:', chartLabels);
                    console.log('Data:', chartData);

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
                                                <p class="fw-bold fs-4 mb-0" style="color: #832706;"><?php echo number_format(isset($total_rpu_tpu) ? $total_rpu_tpu : 5, 0, ',', '.'); ?></p>
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
                                                        <td class="text-end"><?php echo number_format(isset($total_rpu_tpu) ? $total_rpu_tpu : 5, 0, ',', '.'); ?> Unit</td>
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
                                                    <td class="text-end fw-bold"><?php echo number_format(isset($total_rpu_tpu) ? $total_rpu_tpu : 5, 0, ',', '.'); ?> Unit</td>
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
                                            <thead class="table-light">
                                                <tr><th>No</th><th>Kecamatan</th><th class="text-end">Pelaku Usaha</th></tr>
                                            </thead>
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
                                    <button type="button" class="btn btn-primary" id="btnPrintPelakuUsaha" style="background: #832706 !important;"><i class="fas fa-print me-2" style="color: #ffffff !important;"></i>Cetak</button>
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
                                                    <th style="width: 5%;">No</th>
                                                    <th style="width: 15%;">Kecamatan</th>
                                                    <th style="width: 10%;" class="text-end">Pelaku Usaha</th>
                                                    <th style="width: 15%;">Jenis Ternak</th>
                                                    <th style="width: 10%;" class="text-end">Vaksinasi PMK</th>
                                                    <th style="width: 10%;" class="text-end">Vaksinasi ND-AI</th>
                                                    <th style="width: 10%;" class="text-end">Vaksinasi LSD</th>
                                                    <th style="width: 8%;" class="text-end">Klinik Hewan</th>
                                                    <th style="width: 8%;" class="text-end">Penjual Obat</th>
                                                    <th style="width: 8%;" class="text-end">Penjual Pakan</th>
                                                    <th style="width: 8%;" class="text-end">RPU/TPU</th>
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
                                                    $total_seluruh_rpu = 0;
                                                    ?>
                                                    <?php foreach ($detail_pelaku_usaha_per_kecamatan as $row): 
                                                        $vaksin_pmk = isset($vaksinasi_per_kecamatan[$row->kecamatan]['PMK']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['PMK'] : 0;
                                                        $vaksin_ndai = isset($vaksinasi_per_kecamatan[$row->kecamatan]['ND-AI']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['ND-AI'] : 0;
                                                        $vaksin_lsd = isset($vaksinasi_per_kecamatan[$row->kecamatan]['LSD']) ? $vaksinasi_per_kecamatan[$row->kecamatan]['LSD'] : 0;
                                                        $klinik = isset($klinik_per_kecamatan[$row->kecamatan]) ? $klinik_per_kecamatan[$row->kecamatan] : 0;
                                                        $penjual_obat = isset($penjual_obat_per_kecamatan[$row->kecamatan]) ? $penjual_obat_per_kecamatan[$row->kecamatan] : 0;
                                                        $penjual_pakan = isset($penjual_pakan_per_kecamatan[$row->kecamatan]) ? $penjual_pakan_per_kecamatan[$row->kecamatan] : 0;
                                                        $rpu_tpu = isset($rpu_tpu_per_kecamatan[$row->kecamatan]) ? $rpu_tpu_per_kecamatan[$row->kecamatan] : 0;
                                                        
                                                        $total_seluruh_pelaku += $row->pelaku_usaha;
                                                        $total_seluruh_pmk += $vaksin_pmk;
                                                        $total_seluruh_ndai += $vaksin_ndai;
                                                        $total_seluruh_lsd += $vaksin_lsd;
                                                        $total_seluruh_klinik += $klinik;
                                                        $total_seluruh_obat += $penjual_obat;
                                                        $total_seluruh_pakan += $penjual_pakan;
                                                        $total_seluruh_rpu += $rpu_tpu;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $row->no; ?></td>
                                                            <td><strong><?php echo htmlspecialchars($row->kecamatan); ?></strong></td>
                                                            <td class="text-end"><?php echo number_format($row->pelaku_usaha, 0, ',', '.'); ?></td>
                                                            <td><?php echo htmlspecialchars($row->jenis_ternak); ?></td>
                                                            <td class="text-end"><?php echo number_format($vaksin_pmk, 0, ',', '.'); ?> <small class="text-muted">ekor</small></td>
                                                            <td class="text-end"><?php echo number_format($vaksin_ndai, 0, ',', '.'); ?> <small class="text-muted">ekor</small></td>
                                                            <td class="text-end"><?php echo number_format($vaksin_lsd, 0, ',', '.'); ?> <small class="text-muted">ekor</small></td>
                                                            <td class="text-end"><?php echo number_format($klinik, 0, ',', '.'); ?> <small class="text-muted">unit</small></td>
                                                            <td class="text-end"><?php echo number_format($penjual_obat, 0, ',', '.'); ?> <small class="text-muted">toko</small></td>
                                                            <td class="text-end"><?php echo number_format($penjual_pakan, 0, ',', '.'); ?> <small class="text-muted">outlet</small></td>
                                                            <td class="text-end"><?php echo number_format($rpu_tpu, 0, ',', '.'); ?> <small class="text-muted">unit</small></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <tr class="table-active" style="background-color: #f8f9fa; font-weight: bold;">
                                                        <td class="fw-bold" colspan="2">TOTAL (31 Kecamatan)</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_pelaku, 0, ',', '.'); ?></td>
                                                        <td class="fw-bold" style="background-color: #e9ecef;">13 Jenis Ternak</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_pmk, 0, ',', '.'); ?> ekor</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_ndai, 0, ',', '.'); ?> ekor</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_lsd, 0, ',', '.'); ?> ekor</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_klinik, 0, ',', '.'); ?> unit</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_obat, 0, ',', '.'); ?> toko</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_pakan, 0, ',', '.'); ?> outlet</td>
                                                        <td class="text-end fw-bold" style="background-color: #e9ecef;"><?php echo number_format($total_seluruh_rpu, 0, ',', '.'); ?> unit</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="11" class="text-center py-4">Belum ada data tersedia</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="background: #6b2005 !important; color: #ffffff !important; border: none;" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Tutup
                                    </button>
                                    <button type="button" class="btn btn-primary" id="btnPrintSemuaKecamatan" style="background: #832706 !important; border: none;">
                                        <i class="fas fa-print me-2"></i>Cetak
                                    </button>
                                </div>
                            </div> 
                        </div>
                    </div>

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

    <!-- ========== FUNGSI PRINT UNTUK DASHBOARD ========== -->
    <script>
    // Fix Google Maps error - define empty callback
    window.initSurabayaMap = function() {
        console.log('Google Maps API loaded');
    };

    // Fungsi print untuk modal Pelaku Usaha
    function printPelakuUsahaTable() {
        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert("Mohon izinkan pop-up window untuk mencetak!");
            return;
        }
        
        var tableRows = [];
        $('#modalDetailPelakuUsaha tbody tr').each(function() {
            var row = $(this);
            var no = row.find('td:eq(0)').text().trim();
            var kecamatan = row.find('td:eq(1)').text().trim();
            var pelakuUsaha = row.find('td:eq(2)').text().trim();
            tableRows.push({ no: no, kecamatan: kecamatan, pelakuUsaha: pelakuUsaha });
        });
         
        var totalPelaku = $('#modalDetailPelakuUsaha tfoot td:eq(1)').text().trim();
        
        var currentDate = new Date();
        var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }) + ' ' + currentDate.toLocaleTimeString('id-ID');
        
        printWindow.document.write('<!DOCTYPE html>');
        printWindow.document.write('<html><head><title>Data Pelaku Usaha per Kecamatan</title>');
        printWindow.document.write('<meta charset="UTF-8">');
        printWindow.document.write('<style>');
        printWindow.document.write('* { margin: 0; padding: 0; box-sizing: border-box; }');
        printWindow.document.write('body { font-family: "Times New Roman", Arial, sans-serif; margin: 20px; background: white; }');
        printWindow.document.write('.print-container { max-width: 100%; margin: 0 auto; }');
        printWindow.document.write('.header { text-align: center; margin-bottom: 25px; }');
        printWindow.document.write('.header h1 { margin: 0; color: #832706; font-size: 22px; letter-spacing: 1px; }');
        printWindow.document.write('.header h2 { margin: 8px 0 5px 0; color: #333; font-size: 16px; }');
        printWindow.document.write('.header h3 { margin: 5px 0; color: #555; font-size: 14px; font-weight: normal; }');
        printWindow.document.write('.header hr { margin: 10px 0; border: 0.5px solid #832706; }');
        printWindow.document.write('.header p { margin: 8px 0 0 0; color: #666; font-size: 12px; }');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }');
        printWindow.document.write('th, td { border: 1px solid #000; padding: 8px 10px; }');
        printWindow.document.write('th { background-color: #832706; color: white; text-align: center; font-weight: bold; }');
        printWindow.document.write('td { color: #000; }');
        printWindow.document.write('tbody tr:nth-child(even) { background-color: #f9f9f9; }');
        printWindow.document.write('.total-row { background-color: #e8f5e9 !important; font-weight: bold; }');
        printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 15px; }');
        printWindow.document.write('.text-center { text-align: center; }');
        printWindow.document.write('.text-left { text-align: left; }');
        printWindow.document.write('.text-right { text-align: right; }');
        printWindow.document.write('.fw-bold { font-weight: bold; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        
        printWindow.document.write('<div class="print-container">');
        printWindow.document.write('<div class="header">');
        printWindow.document.write('<h1>PEMERINTAH KOTA SURABAYA</h1>');
        printWindow.document.write('<h2>DINAS KETAHANAN PANGAN DAN PERTANIAN</h2>');
        printWindow.document.write('<h3>SISTEM INFORMASI PETERNAKAN (SIPETGIS)</h3>');
        printWindow.document.write('<hr>');
        printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
        printWindow.document.write('</div>');
        
        printWindow.document.write('<h3 style="margin: 20px 0 10px 0; color: #832706;">DATA PELAKU USAHA PER KECAMATAN</h3>');
        
        printWindow.document.write('<table>');
        printWindow.document.write('<thead>');
        printWindow.document.write('<tr>');
        printWindow.document.write('<th width="10%" style="text-align: center;">No</th>');
        printWindow.document.write('<th width="60%" style="text-align: center;">Kecamatan</th>');
        printWindow.document.write('<th width="30%" style="text-align: center;">Pelaku Usaha (Peternak)</th>');
        printWindow.document.write('</tr>');
        printWindow.document.write('</thead>');
        printWindow.document.write('<tbody>');
        
        for (var i = 0; i < tableRows.length; i++) {
            printWindow.document.write('<tr>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].no + '</td>');
            printWindow.document.write('<td class="text-left">' + tableRows[i].kecamatan + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].pelakuUsaha + '</td>');
            printWindow.document.write('</tr>');
        }
        
        printWindow.document.write('<tr class="total-row">');
        printWindow.document.write('<td colspan="2" class="text-center fw-bold">TOTAL (31 Kecamatan)</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalPelaku + '</td>');
        printWindow.document.write('</tr>');
        
        printWindow.document.write('</tbody>');
        printWindow.document.write('</table>');
        
        printWindow.document.write('<div class="footer-note">');
        printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
        printWindow.document.write('Surabaya, ' + formattedDateTime);
        printWindow.document.write('</div>');
        
        printWindow.document.write('</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    }

    // Fungsi print untuk modal Semua Kecamatan
    function printSemuaKecamatanTable() {
        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert("Mohon izinkan pop-up window untuk mencetak!");
            return;
        }
        
        var tableRows = [];
        $('#modalSemuaKecamatan tbody tr').each(function() {
            var row = $(this);
            if (!row.hasClass('table-active')) {
                var no = row.find('td:eq(0)').text().trim();
                var kecamatan = row.find('td:eq(1)').text().trim();
                var pelakuUsaha = row.find('td:eq(2)').text().trim();
                var jenisTernak = row.find('td:eq(3)').text().trim();
                var vaksinPmk = row.find('td:eq(4)').text().trim();
                var vaksinNdai = row.find('td:eq(5)').text().trim();
                var vaksinLsd = row.find('td:eq(6)').text().trim();
                var klinik = row.find('td:eq(7)').text().trim();
                var penjualObat = row.find('td:eq(8)').text().trim();
                var penjualPakan = row.find('td:eq(9)').text().trim();
                var rpuTpu = row.find('td:eq(10)').text().trim();
                
                tableRows.push({
                    no: no, kecamatan: kecamatan, pelakuUsaha: pelakuUsaha,
                    jenisTernak: jenisTernak, vaksinPmk: vaksinPmk,
                    vaksinNdai: vaksinNdai, vaksinLsd: vaksinLsd,
                    klinik: klinik, penjualObat: penjualObat,
                    penjualPakan: penjualPakan, rpuTpu: rpuTpu
                });
            }
        });
        
        var totalRow = $('#modalSemuaKecamatan tbody tr.table-active');
        var totalPelaku = totalRow.find('td:eq(2)').text().trim();
        var totalPmk = totalRow.find('td:eq(4)').text().trim();
        var totalNdai = totalRow.find('td:eq(5)').text().trim();
        var totalLsd = totalRow.find('td:eq(6)').text().trim();
        var totalKlinik = totalRow.find('td:eq(7)').text().trim();
        var totalObat = totalRow.find('td:eq(8)').text().trim();
        var totalPakan = totalRow.find('td:eq(9)').text().trim();
        var totalRpu = totalRow.find('td:eq(10)').text().trim();
        
        var currentDate = new Date();
        var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }) + ' ' + currentDate.toLocaleTimeString('id-ID');
        
        printWindow.document.write('<!DOCTYPE html>');
        printWindow.document.write('<html><head><title>Data Seluruh Kecamatan Surabaya (31 Kecamatan)</title>');
        printWindow.document.write('<meta charset="UTF-8">');
        printWindow.document.write('<style>');
        printWindow.document.write('* { margin: 0; padding: 0; box-sizing: border-box; }');
        printWindow.document.write('body { font-family: "Times New Roman", Arial, sans-serif; margin: 15px; background: white; font-size: 11px; }');
        printWindow.document.write('.print-container { max-width: 100%; margin: 0 auto; }');
        printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
        printWindow.document.write('.header h1 { margin: 0; color: #832706; font-size: 18px; letter-spacing: 1px; }');
        printWindow.document.write('.header h2 { margin: 5px 0; color: #333; font-size: 14px; }');
        printWindow.document.write('.header h3 { margin: 3px 0; color: #555; font-size: 12px; font-weight: normal; }');
        printWindow.document.write('.header hr { margin: 8px 0; border: 0.5px solid #832706; }');
        printWindow.document.write('.header p { margin: 5px 0 0 0; color: #666; font-size: 10px; }');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 9px; }');
        printWindow.document.write('th, td { border: 1px solid #000; padding: 5px 4px; }');
        printWindow.document.write('th { background-color: #832706; color: white; text-align: center; font-weight: bold; }');
        printWindow.document.write('td { color: #000; }');
        printWindow.document.write('tbody tr:nth-child(even) { background-color: #f9f9f9; }');
        printWindow.document.write('.total-row { background-color: #e8f5e9 !important; font-weight: bold; }');
        printWindow.document.write('.footer-note { margin-top: 20px; font-size: 9px; color: #666; text-align: center; border-top: 1px solid #ddd; padding-top: 10px; }');
        printWindow.document.write('.text-center { text-align: center; }');
        printWindow.document.write('.text-left { text-align: left; }');
        printWindow.document.write('.text-right { text-align: right; }');
        printWindow.document.write('.fw-bold { font-weight: bold; }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        
        printWindow.document.write('<div class="print-container">');
        printWindow.document.write('<div class="header">');
        printWindow.document.write('<h1>PEMERINTAH KOTA SURABAYA</h1>');
        printWindow.document.write('<h2>DINAS KETAHANAN PANGAN DAN PERTANIAN</h2>');
        printWindow.document.write('<h3>SISTEM INFORMASI PETERNAKAN (SIPETGIS)</h3>');
        printWindow.document.write('<hr>');
        printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
        printWindow.document.write('</div>');
        
        printWindow.document.write('<h3 style="margin: 15px 0 8px 0; color: #832706; font-size: 13px;">DATA SELURUH KECAMATAN DI SURABAYA (31 KECAMATAN)</h3>');
        
        printWindow.document.write('<table>');
        printWindow.document.write('<thead>');
        printWindow.document.write('<tr>');
        printWindow.document.write('<th width="4%">No</th>');
        printWindow.document.write('<th width="12%">Kecamatan</th>');
        printWindow.document.write('<th width="8%">Pelaku Usaha</th>');
        printWindow.document.write('<th width="12%">Jenis Ternak</th>');
        printWindow.document.write('<th width="7%">Vaksinasi PMK</th>');
        printWindow.document.write('<th width="7%">Vaksinasi ND-AI</th>');
        printWindow.document.write('<th width="7%">Vaksinasi LSD</th>');
        printWindow.document.write('<th width="7%">Klinik Hewan</th>');
        printWindow.document.write('<th width="7%">Penjual Obat</th>');
        printWindow.document.write('<th width="7%">Penjual Pakan</th>');
        printWindow.document.write('<th width="7%">RPU/TPU</th>');
        printWindow.document.write('</tr>');
        printWindow.document.write('</thead>');
        printWindow.document.write('<tbody>');
        
        for (var i = 0; i < tableRows.length; i++) {
            printWindow.document.write('<tr>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].no + '</td>');
            printWindow.document.write('<td class="text-left">' + tableRows[i].kecamatan + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].pelakuUsaha + '</td>');
            printWindow.document.write('<td class="text-left">' + (tableRows[i].jenisTernak || '-') + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinPmk + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinNdai + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].vaksinLsd + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].klinik + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].penjualObat + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].penjualPakan + '</td>');
            printWindow.document.write('<td class="text-center">' + tableRows[i].rpuTpu + '</td>');
            printWindow.document.write('</tr>');
        }
        
        printWindow.document.write('<tr class="total-row">');
        printWindow.document.write('<td colspan="2" class="text-center fw-bold">TOTAL (31 Kecamatan)</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalPelaku + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">13 Jenis</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalPmk + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalNdai + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalLsd + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalKlinik + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalObat + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalPakan + '</td>');
        printWindow.document.write('<td class="text-center fw-bold">' + totalRpu + '</td>');
        printWindow.document.write('</tr>');
        
        printWindow.document.write('</tbody>');
        printWindow.document.write('</table>');
        
        printWindow.document.write('<div class="footer-note">');
        printWindow.document.write('Dokumen ini dicetak secara elektronik dari sistem SIPETGIS<br>');
        printWindow.document.write('Surabaya, ' + formattedDateTime);
        printWindow.document.write('</div>');
        
        printWindow.document.write('</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    }

    // Event listener menggunakan jQuery (tanpa onclick inline)
    $(document).ready(function() {
        $('#btnPrintPelakuUsaha').on('click', function(e) {
            e.preventDefault();
            printPelakuUsahaTable();
        });
        
        $('#btnPrintSemuaKecamatan').on('click', function(e) {
            e.preventDefault();
            printSemuaKecamatanTable();
        });
    });
    </script>
</body>
</html>