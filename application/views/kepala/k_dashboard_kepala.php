<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Sistem Informasi Peternakan Kota Surabaya</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initSurabayaMap"
      async
      defer
    ></script>

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
    <style>
      .dashboard-header {
        background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
      }
      .stat-card {
        border-radius: 10px;
        transition: all 0.3s;
        height: 100%;
      }
      .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }
      .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
      }
      .livestock-type-card {
        background: #f8f9fa;
        border-left: 4px solid #1a73e8;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
      }
      .dashboard-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
      }
      .dashboard-subtitle {
        color: #666;
        font-size: 14px;
      }
      .nav-tabs-custom .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
      }
      .nav-tabs-custom .nav-link.active {
        color: #1a73e8;
        border-bottom: 2px solid #1a73e8;
      }
      .chart-container {
        height: 400px !important;
        position: relative;
      }
      .compact-card {
        height: 100%;
        display: flex;
        flex-direction: column;
      }
      .compact-card .card-body {
        flex: 1;
        padding: 15px !important;
      }
      .compact-card .card-header {
        padding: 12px 15px;
      }
      .compact-card .card-footer {
        padding: 10px 15px;
      }
      .map-card {
        height: 100%;
      }
      .map-container-wrapper {
        height: 300px;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
      }
      /* Sidebar dropdown styles */
      .nav-secondary .collapse {
        margin-left: 1rem;
      }
      .nav-secondary .collapse .nav-link {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
      }
      .nav-secondary .nav-link[data-bs-toggle="collapse"] {
        cursor: pointer;
      }
      .nav-secondary .nav-link[data-bs-toggle="collapse"] .fa-chevron-down {
        transition: transform 0.3s ease;
      }
      .nav-secondary .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
      }
      /* Additional styles for new content */
      .badge-ternak {
        background: #eef2ff;
        color: #1a73e8;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
      }
      .vaksin-progress {
        margin-bottom: 15px;
      }
      .facility-card {
        text-align: center;
        padding: 10px;
        border-radius: 8px;
        background: #f8f9fa;
      }
    </style>
  </head>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="white">
            <a
              href="<?php echo site_url('k_dashboard_kepala'); ?>"
              class="logo"
              style="text-decoration: none"
            >
              <div
                style="
                  color: #1e3a8a;
                  font-weight: 800;
                  font-size: 24px;
                  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  letter-spacing: 0.5px;
                  line-height: 1;
                "
              >
                SIPETGIS
              </div>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="<?php echo site_url('k_dashboard_kepala'); ?>" style="text-decoration: none">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
              
              <!-- Dropdown Laporan -->
              <li class="nav-item">
                <a
                  class="nav-link d-flex align-items-center justify-content-between collapsed"
                  data-bs-toggle="collapse"
                  href="#laporanSubmenu"
                  role="button"
                  aria-expanded="false"
                >
                  <div class="d-flex align-items-center">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span>Laporan</span>
                  </div>
                  <i class="fas fa-chevron-down ms-2"></i>
                </a>
                <div class="collapse" id="laporanSubmenu">
                  <ul class="list-unstyled ps-4">
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/kepemilikan_ternak'); ?>" class="nav-link">Kepemilikan Ternak</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/history_data_ternak'); ?>" class="nav-link">History Data Ternak</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/vaksinasi'); ?>" class="nav-link">Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/history_vaksinasi'); ?>" class="nav-link">History Data Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/pengobatan_ternak'); ?>" class="nav-link">Pengobatan Ternak</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/penjual_pakan'); ?>" class="nav-link">Penjual Pakan Ternak</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/data_klinik_hewan'); ?>" class="nav-link">Data Klinik Hewan</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/penjual_obat_hewan'); ?>" class="nav-link">Penjual Obat Hewan</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/data_tpu_rpu'); ?>" class="nav-link">Data TPU / RPU</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/demplot_peternakan'); ?>" class="nav-link">Demplot Peternakan</a>
                    </li>
                    <li>
                      <a href="<?php echo site_url('k_laporan_kepala/stok_pakan'); ?>" class="nav-link">Stok Pakan</a>
                    </li>
                    
                  </ul>
                </div>
              </li>

              <!-- Menu Peta Sebaran -->
              <li class="nav-item">
                <a href="<?php echo site_url('k_peta_sebaran_kepala'); ?>" style="text-decoration: none">
                  <i class="fas fa-map-marked-alt"></i>
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
          <div class="main-header-logo">
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="fw-bold">Kepala Dinas DKPP Surabaya</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="u-text">
                            <h4>
                              Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota
                              Surabaya
                            </h4>
                            <p class="text-muted">kepala@dkppsby.go.id</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('login'); ?>" style="text-decoration: none">
                          <i class="fas fa-sign-out-alt me-2"></i>Keluar
                        </a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <!-- Dashboard Header -->
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-1">Dashboard</h3>
                <h6 class="op-7 mb-0">
                  Dashboard Sistem Informasi Peternakan (Sipetgis) Kota Surabaya
                </h6>
              </div>
            </div>

            <!-- Statistics Cards - 3 Card Rapi Style Original -->
<div class="row">
  <!-- Kotak 1: Pelaku Usaha -->
  <div class="col-md-4">
    <div class="card card-stats card-round stat-card">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-primary">
              <i class="fas fa-users stat-icon"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Pelaku Usaha</p>
              <h4 class="card-title">147</h4>
              <p class="card-subtitle">Peternak</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Kotak 2: Jenis Ternak -->
  <div class="col-md-4">
    <div class="card card-stats card-round stat-card">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-success">
              <i class="fas fa-paw stat-icon"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Jenis Ternak</p>
              <h4 class="card-title">13</h4>
              <p class="card-subtitle">Komoditas</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Kotak 3: Vaksinasi -->
  <div class="col-md-4">
    <div class="card card-stats card-round stat-card">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-danger">
              <i class="fas fa-syringe stat-icon"></i>
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

            <!-- Baris Jenis Usaha (13 Jenis Ternak) -->
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="card stat-card">
                  <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-list me-2"></i>Jenis Usaha Peternakan (13 Komoditas)</h6>
                  </div>
                  <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
  <span class="badge-ternak">Sapi Potong</span>
  <span class="badge-ternak">Sapi Perah</span>
  <span class="badge-ternak">Kambing</span>
  <span class="badge-ternak">Domba</span>
  <span class="badge-ternak">Ayam Buras</span>
  <span class="badge-ternak">Ayam Broiler</span>
  <span class="badge-ternak">Ayam Layer</span>
  <span class="badge-ternak">Itik</span>
  <span class="badge-ternak">Angsa</span>
  <span class="badge-ternak">Kalkun</span>
  <span class="badge-ternak">Burung</span>
  <span class="badge-ternak">Kerbau</span>
  <span class="badge-ternak">Kuda</span>
</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Main Content: Grafik Full Width 31 Kecamatan -->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="card compact-card stat-card">
                  <div class="card-header">
                    <h6 class="mb-0">Distribusi Pelaku Usaha per Kecamatan (31 Kecamatan Surabaya)</h6>
                  </div>
                  <div class="card-body">
                    <canvas
                      id="kecamatanChart"
                      class="chart-container"
                    ></canvas>
                  </div>
                  <div class="card-footer bg-transparent border-top-0 pt-0">
                    <div class="text-end">
                      <a href="#" class="btn btn-link text-primary p-0" data-bs-toggle="modal" data-bs-target="#modalDetailPelakuUsaha">
                        Lihat Detail Tabel
                        <i class="fas fa-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Baris Vaksinasi dan Fasilitas -->
            <div class="row mt-4">
              <div class="col-md-6">
               <div class="card stat-card">
  <div class="card-header">
    <h6 class="mb-0"><i class="fas fa-syringe me-2"></i>Cakupan Vaksinasi</h6>
  </div>
  <div class="card-body">
    <div class="vaksin-progress">
      <div class="d-flex justify-content-between mb-1">
        <span>PMK (Penyakit Mulut & Kuku)</span>
        <span class="fw-bold">2.450 Ekor</span>
      </div>
      <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-danger" style="width:84%"></div>
      </div>
    </div>
    <div class="vaksin-progress">
      <div class="d-flex justify-content-between mb-1">
        <span>ND/AI (Newcastle / Avian Influenza)</span>
        <span class="fw-bold">12.400 Ekor</span>
      </div>
      <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-warning" style="width:91%"></div>
      </div>
    </div>
    <div class="vaksin-progress">
      <div class="d-flex justify-content-between mb-1">
        <span>LSD (Lumpy Skin Disease)</span>
        <span class="fw-bold">1.890 Ekor</span>
      </div>
      <div class="progress" style="height: 8px;">
        <div class="progress-bar bg-info" style="width:76%"></div>
      </div>
    </div>
  </div>
</div>
              </div>
              <div class="col-md-6">
                <div class="card stat-card">
                  <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-building me-2"></i>Tempat Usaha</h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-6 mb-3">
                        <div class="facility-card">
                          <i class="fas fa-hospital-user fa-2x text-primary mb-2"></i>
                          <h6 class="mb-0">Klinik Hewan</h6>
                          <p class="fw-bold fs-4 mb-0">8</p>
                          <small class="text-muted">Unit</small>
                        </div>
                      </div>
                      <div class="col-6 mb-3">
                        <div class="facility-card">
                          <i class="fas fa-capsules fa-2x text-success mb-2"></i>
                          <h6 class="mb-0">Penjual Obat Hewan</h6>
                          <p class="fw-bold fs-4 mb-0">11</p>
                          <small class="text-muted">Toko</small>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="facility-card">
                          <i class="fas fa-seedling fa-2x text-warning mb-2"></i>
                          <h6 class="mb-0">Penjual Pakan</h6>
                          <p class="fw-bold fs-4 mb-0">12</p>
                          <small class="text-muted">Outlet</small>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="facility-card">
                          <i class="fas fa-tractor fa-2x text-secondary mb-2"></i>
                          <h6 class="mb-0">RPU / TPU</h6>
                          <p class="fw-bold fs-4 mb-0">5</p>
                          <small class="text-muted">Unit</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           <!-- Tabel Data Kecamatan (diperbarui dengan data lengkap) -->
<div class="row mt-4">
  <div class="col-md-12">
    <div class="card stat-card">
      <div class="card-header">
        <h6 class="mb-0">Data Kecamatan & Sebaran Usaha</h6>
      </div>
      <div class="card-body p-0">
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
              <tr>
                <td>Genteng</span></span></td>
                <td class="text-end">42</span></span></td>
                <td>Sapi Potong, Kambing</span></span></td>
                <td class="text-end">480 Ekor</span></span></td>
                <td class="text-end">520 Ekor</span></span></td>
                <td class="text-end">210 Ekor</span></span></td>
                <td class="text-end">1</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">1</span></span></td>
              </tr>
              <tr>
                <td>Sawahan</span></span></td>
                <td class="text-end">38</span></span></td>
                <td>Ayam Broiler, Itik</span></span></td>
                <td class="text-end">370 Ekor</span></span></td>
                <td class="text-end">11.280 Ekor</span></span></td>
                <td class="text-end">165 Ekor</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">1</span></span></td>
                <td class="text-end">0</span></span></td>
              </tr>
              <tr>
                <td>Tambaksari</span></span></td>
                <td class="text-end">32</span></span></td>
                <td>Domba, Kerbau</span></span></td>
                <td class="text-end">237 Ekor</span></span></td>
                <td class="text-end">0 Ekor</span></span></td>
                <td class="text-end">98 Ekor</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">1</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
              </tr>
              <tr>
                <td>Gubeng</span></span></td>
                <td class="text-end">28</span></span></td>
                <td>Sapi Perah, Kuda</span></span></td>
                <td class="text-end">227 Ekor</span></span></td>
                <td class="text-end">0 Ekor</span></span></td>
                <td class="text-end">185 Ekor</span></span></td>
                <td class="text-end">1</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">1</span></span></td>
              </tr>
              <tr>
                <td>Wonokromo</span></span></td>
                <td class="text-end">25</span></span></td>
                <td>Ayam Layer, Burung</span></span></td>
                <td class="text-end">173 Ekor</span></span></td>
                <td class="text-end">7.800 Ekor</span></span></td>
                <td class="text-end">0 Ekor</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">0</span></span></td>
                <td class="text-end">1</span></span></td>
              </tr>
              <tr class="table-active">
                <td class="fw-bold">Total (5 Kecamatan)</span></span></td>
                <td class="text-end fw-bold">165</span></span></td>
                <td>13 Jenis Ternak</span></span></td>
                <td class="text-end">1.487 Ekor</span></span></td>
                <td class="text-end">19.600 Ekor</span></span></td>
                <td class="text-end">658 Ekor</span></span></td>
                <td class="text-end">2 Unit</span></span></td>
                <td class="text-end">1 Toko</span></span></td>
                <td class="text-end">1 Outlet</span></span></td>
                <td class="text-end">3 Unit</span></span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-transparent border-top-0">
        <div class="text-end">
          <a href="#" class="btn btn-link text-primary" data-bs-toggle="modal" data-bs-target="#modalSemuaKecamatan">
            Lihat Selengkapnya
            <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Pelaku Usaha (Hanya Kecamatan dan Pelaku Usaha) -->
<div class="modal fade" id="modalDetailPelakuUsaha" tabindex="-1" aria-labelledby="modalDetailPelakuUsahaLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="modalDetailPelakuUsahaLabel">
          <i class="fas fa-chart-bar me-2"></i>Data Pelaku Usaha per Kecamatan (31 Kecamatan Surabaya)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kecamatan</th>
                <th class="text-end">Pelaku Usaha</th>
              </tr>
            </thead>
            <tbody>
              <tr><td class="text-end">1</span><td>Karang Pilang</span></td><td class="text-end">15</span></tr>
              <tr><td class="text-end">2</span><td>Jambangan</span></td><td class="text-end">12</span></tr>
              <tr><td class="text-end">3</span><td>Gayungan</span></td><td class="text-end">10</span></tr>
              <tr><td class="text-end">4</span><td>Wonocolo</span></td><td class="text-end">18</span></tr>
              <tr><td class="text-end">5</span><td>Tenggilis Mejoyo</span></td><td class="text-end">14</span></tr>
              <tr><td class="text-end">6</span><td>Gunung Anyar</span></td><td class="text-end">20</span></tr>
              <tr><td class="text-end">7</span><td>Rungkut</span></td><td class="text-end">22</span></tr>
              <tr><td class="text-end">8</span><td>Sukolilo</span></td><td class="text-end">19</span></tr>
              <tr><td class="text-end">9</span><td>Mulyorejo</span></td><td class="text-end">16</span></tr>
              <tr><td class="text-end">10</span><td>Gubeng</span></td><td class="text-end">28</span></tr>
              <tr><td class="text-end">11</span><td>Wonokromo</span></td><td class="text-end">25</span></tr>
              <tr><td class="text-end">12</span><td>Dukuh Pakis</span></td><td class="text-end">13</span></tr>
              <tr><td class="text-end">13</span><td>Wiyung</span></td><td class="text-end">17</span></tr>
              <tr><td class="text-end">14</span><td>Lakarsantri</span></td><td class="text-end">21</span></tr>
              <tr><td class="text-end">15</span><td>Sambikerep</span></td><td class="text-end">11</span></tr>
              <tr><td class="text-end">16</span><td>Tandes</span></td><td class="text-end">23</span></tr>
              <tr><td class="text-end">17</span><td>Sukomanunggal</span></td><td class="text-end">14</span></tr>
              <tr><td class="text-end">18</span><td>Sawahan</span></td><td class="text-end">38</span></tr>
              <tr><td class="text-end">19</span><td>Tegalsari</span></td><td class="text-end">19</span></tr>
              <tr><td class="text-end">20</span><td>Genteng</span></td><td class="text-end">42</span></tr>
              <tr><td class="text-end">21</span><td>Bubutan</span></td><td class="text-end">15</span></tr>
              <tr><td class="text-end">22</span><td>Krembangan</span></td><td class="text-end">12</span></tr>
              <tr><td class="text-end">23</span><td>Semampir</span></td><td class="text-end">24</span></tr>
              <tr><td class="text-end">24</span><td>Kenjeran</span></td><td class="text-end">27</span></tr>
              <tr><td class="text-end">25</span><td>Bulak</span></td><td class="text-end">18</span></tr>
              <tr><td class="text-end">26</span><td>Tambaksari</span></td><td class="text-end">32</span></tr>
              <tr><td class="text-end">27</span><td>Simokerto</span></td><td class="text-end">16</span></tr>
              <tr><td class="text-end">28</span><td>Pabean Cantian</span></td><td class="text-end">10</span></tr>
              <tr><td class="text-end">29</span><td>Kandangan</span></td><td class="text-end">13</span></tr>
              <tr><td class="text-end">30</span><td>Benowo</span></td><td class="text-end">20</span></tr>
              <tr><td class="text-end">31</span><td>Pakal</span></td><td class="text-end">17</span></tr>
            </tbody>
            <tfoot class="table-light">
              <tr class="fw-bold">
                <td colspan="2">Total 31 Kecamatan</span></td>
                <td class="text-end">648</span></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-2"></i>Cetak</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal 31 Kecamatan Surabaya (Lengkap) -->
<div class="modal fade" id="modalSemuaKecamatan" tabindex="-1" aria-labelledby="modalSemuaKecamatanLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="modalSemuaKecamatanLabel">
          <i class="fas fa-city me-2"></i>Data Seluruh Kecamatan di Surabaya (31 Kecamatan)
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
              <tr><td class="text-end">1</span><td>Karang Pilang</span></td><td class="text-end">15</span><td>Sapi Potong, Kambing</span></td><td class="text-end">195 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">112 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">2</span><td>Jambangan</span></td><td class="text-end">12</span><td>Ayam Layer</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">9.840 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">3</span><td>Gayungan</span></td><td class="text-end">10</span><td>Itik, Burung</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">4</span><td>Wonocolo</span></td><td class="text-end">18</span><td>Ayam Broiler</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">15.300 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">5</span><td>Tenggilis Mejoyo</span></td><td class="text-end">14</span><td>Sapi Perah</span></td><td class="text-end">112 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">56 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">6</span><td>Gunung Anyar</span></td><td class="text-end">20</span><td>Kambing, Domba</span></td><td class="text-end">166 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">80 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">7</span><td>Rungkut</span></td><td class="text-end">22</span><td>Ayam Buras, Itik</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">8</span><td>Sukolilo</span></td><td class="text-end">19</span><td>Sapi Potong</span></td><td class="text-end">150 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">76 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">9</span><td>Mulyorejo</span></td><td class="text-end">16</span><td>Ayam Layer</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">13.440 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">10</span><td>Gubeng</span></td><td class="text-end">28</span><td>Sapi Perah, Kuda</span></td><td class="text-end">227 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">185 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">11</span><td>Wonokromo</span></td><td class="text-end">25</span><td>Ayam Layer, Burung</span></td><td class="text-end">173 Ekor</span></td><td class="text-end">7.800 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">12</span><td>Dukuh Pakis</span></td><td class="text-end">13</span><td>Kambing</span></td><td class="text-end">95 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">46 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">13</span><td>Wiyung</span></td><td class="text-end">17</span><td>Ayam Broiler</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">14.790 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">14</span><td>Lakarsantri</span></td><td class="text-end">21</span><td>Sapi Potong, Domba</span></td><td class="text-end">185 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">94 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">15</span><td>Sambikerep</span></td><td class="text-end">11</span><td>Itik</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">16</span><td>Tandes</span></td><td class="text-end">23</span><td>Ayam Buras, Kerbau</span></td><td class="text-end">45 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">23 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">17</span><td>Sukomanunggal</span></td><td class="text-end">14</span><td>Kambing</span></td><td class="text-end">106 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">51 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">18</span><td>Sawahan</span></td><td class="text-end">38</span><td>Ayam Broiler, Itik</span></td><td class="text-end">370 Ekor</span></td><td class="text-end">11.280 Ekor</span></td><td class="text-end">165 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">19</span><td>Tegalsari</span></td><td class="text-end">19</span><td>Sapi Potong</span></td><td class="text-end">152 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">73 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">20</span><td>Genteng</span></td><td class="text-end">42</span><td>Sapi Potong, Kambing</span></td><td class="text-end">480 Ekor</span></td><td class="text-end">520 Ekor</span></td><td class="text-end">210 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">21</span><td>Bubutan</span></td><td class="text-end">15</span><td>Ayam Layer</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">11.550 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">22</span><td>Krembangan</span></td><td class="text-end">12</span><td>Itik</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">23</span><td>Semampir</span></td><td class="text-end">24</span><td>Ayam Buras, Kambing</span></td><td class="text-end">78 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">42 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">24</span><td>Kenjeran</span></td><td class="text-end">27</span><td>Sapi Potong, Itik</span></td><td class="text-end">232 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></tr>
              <tr><td class="text-end">25</span><td>Bulak</span></td><td class="text-end">18</span><td>Ayam Broiler</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">14.580 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">26</span><td>Tambaksari</span></td><td class="text-end">32</span><td>Domba, Kerbau</span></td><td class="text-end">237 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">98 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">27</span><td>Simokerto</span></td><td class="text-end">16</span><td>Kambing</span></td><td class="text-end">120 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">58 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">28</span><td>Pabean Cantian</span></td><td class="text-end">10</span><td>Burung</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">29</span><td>Kandangan</span></td><td class="text-end">13</span><td>Sapi Perah</span></td><td class="text-end">103 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">49 Ekor</span></td><td class="text-end">1</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">30</span><td>Benowo</span></td><td class="text-end">20</span><td>Ayam Broiler, Kuda</span></td><td class="text-end">34 Ekor</span></td><td class="text-end">17.000 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td><td class="text-end">0</span></tr>
              <tr><td class="text-end">31</span><td>Pakal</span></td><td class="text-end">17</span><td>Sapi Potong, Domba</span></td><td class="text-end">141 Ekor</span></td><td class="text-end">0 Ekor</span></td><td class="text-end">68 Ekor</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">0</span></td><td class="text-end">1</span></td>
            </tbody>
            <tfoot class="table-light">
              <tr class="fw-bold">
                <td colspan="2">Total 31 Kecamatan</span></td>
                <td class="text-end">648</span></td>
                <td>13 Jenis Ternak</span></td>
                <td class="text-end">2.487 Ekor</span></td>
                <td class="text-end">74.000 Ekor</span></td>
                <td class="text-end">1.258 Ekor</span></td>
                <td class="text-end">8 Unit</span></td>
                <td class="text-end">4 Toko</span></td>
                <td class="text-end">5 Outlet</span></td>
                <td class="text-end">6 Unit</span></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-2"></i>Cetak</button>
      </div>
    </div>
  </div>
</div>
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
  // Grafik Distribusi Pelaku Usaha per 31 Kecamatan Surabaya (LENGKAP) dengan Angka di Atas Batang
  document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById("kecamatanChart").getContext("2d");
    var kecamatanChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Karang Pilang", "Jambangan", "Gayungan", "Wonocolo", "Tenggilis Mejoyo", "Gunung Anyar", "Rungkut", "Sukolilo", "Mulyorejo", "Gubeng", "Wonokromo", "Dukuh Pakis", "Wiyung", "Lakarsantri", "Sambikerep", "Tandes", "Sukomanunggal", "Sawahan", "Tegalsari", "Genteng", "Bubutan", "Krembangan", "Semampir", "Kenjeran", "Bulak", "Tambaksari", "Simokerto", "Pabean Cantian", "Kandangan", "Benowo", "Pakal"],
        datasets: [
          {
            label: "Jumlah Pelaku Usaha",
            data: [15, 12, 10, 18, 14, 20, 22, 19, 16, 28, 25, 13, 17, 21, 11, 23, 14, 38, 19, 42, 15, 12, 24, 27, 18, 32, 16, 10, 13, 20, 17],
            backgroundColor: "#1a73e8",
            borderColor: "#0d47a1",
            borderWidth: 1,
            borderRadius: 3,
            // Menambahkan datalabels
            datalabels: {
              anchor: 'end',
              align: 'top',
              offset: 4,
              color: '#333',
              font: {
                weight: 'bold',
                size: 11
              },
              formatter: function(value) {
                return value;
              }
            }
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            backgroundColor: "rgba(0, 0, 0, 0.8)",
            titleColor: "#fff",
            bodyColor: "#fff",
            borderColor: "#1a73e8",
            borderWidth: 1,
            callbacks: {
              label: function (context) {
                return `Pelaku Usaha: ${context.raw} peternak`;
              },
            },
          },
          // Plugin datalabels
          datalabels: {
            anchor: 'end',
            align: 'top',
            offset: 4,
            color: '#1a73e8',
            font: {
              weight: 'bold',
              size: 11
            },
            formatter: function(value) {
              return value;
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              drawBorder: false,
              color: "rgba(0, 0, 0, 0.05)",
            },
            ticks: {
              font: {
                size: 10,
              },
              stepSize: 10,
              padding: 5,
              callback: function (value) {
                return value + "";
              },
            },
            title: {
              display: true,
              text: "Jumlah Pelaku Usaha",
              font: { size: 11 }
            }
          },
          x: {
            grid: {
              display: false,
            }, 
            ticks: {
              font: {
                size: 9,
              },
              rotation: 45,
              padding: 5,
            },
            title: {
              display: true,
              text: "Kecamatan",
              font: { size: 11 }
            }
          },
        },
        animation: {
          duration: 1000,
          easing: "easeOutQuart",
        },
        layout: {
          padding: {
            top: 20
          }
        }
      },
    });
  });

  // Script untuk menangani jika gambar tidak ada
  document.addEventListener("DOMContentLoaded", function () {
    const mapImage = document.querySelector(
      'img[src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/peta surabaya.jpeg"]',
    );
    const mapFallback = document.getElementById("map-fallback");

    if (mapImage) {
      mapImage.onerror = function () {
        this.style.display = "none";
        if (mapFallback) {
          mapFallback.classList.remove("d-none");
          mapFallback.classList.add("d-flex");
        }
      };

      mapImage.onload = function () {
        if (mapFallback) {
          mapFallback.classList.add("d-none");
          mapFallback.classList.remove("d-flex");
        }
      };
    }
  });

  function openFullMap() {
    window.location.href = "<?php echo site_url('k_peta_sebaran_kepala'); ?>";
  }
</script>
  </body>
</html>