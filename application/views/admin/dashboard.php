<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Sistem Informasi Peternakan Kabupaten Balangan</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initSurabayaMap"
      async
      defer
    ></script>

    <!-- Fonts and icons -->
    <script src="assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js"></script>
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
      .district-bar {
        background: #1a73e8;
        height: 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        color: white;
        padding-left: 10px;
        line-height: 20px;
        font-size: 12px;
      }
      .map-container {
        height: 400px;
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
      }
      .commodity-chart {
        height: 250px;
        position: relative;
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
    </style>
  </head>

  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="white">
            
            <a href="<?= base_url('dashboard') ?>" class="logo" style="text-decoration: none">
              <div
                style="
                  color: #1e3a8a; /* Biru navy yang elegan */
                  font-weight: 800;
                  font-size: 24px;
                  font-family:
                    &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
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
                <a href="index.html">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Menu Utama</h4>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link d-flex align-items-center justify-content-between collapsed"
                  data-bs-toggle="collapse"
                  href="#masterDataSubmenu"
                  role="button"
                  aria-expanded="false"
                >
                  <div class="d-flex align-items-center">
                    <i class="fas fa-database me-2"></i>
                    <span>Master Data</span>
                  </div>
                  <i class="fas fa-chevron-down ms-2"></i>
                </a>
                <div class="collapse" id="masterDataSubmenu">
                  <ul class="list-unstyled ps-4">
                    <li>
                       <a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a>
                    </li>
                     <li>
                       <a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a>
                    </li>
                    <li>
                      <a href="<?= site_url('akses_pengguna') ?>" class="nav-link"
                        >Akses Pengguna</a
                      >
                    </li>
                   <li>
                      <a href="<?= site_url('obat') ?>" class="nav-link">Obat</a>
                    </li>
                    <li>
                      <a href="<?= site_url('vaksin') ?>" class="nav-link"
                        >Vaksin</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('komoditas') ?>" class="nav-link"
                      >Komoditas</a>
                    </li>
                     <li>
                      <a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a>
                    </li>
                    <li>
                      <a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link d-flex align-items-center justify-content-between collapsed"
                  data-bs-toggle="collapse"
                  href="#dataSubmenu"
                  role="button"
                  aria-expanded="false"
                >
                  <div class="d-flex align-items-center">
                    <i class="fas fa-users me-2"></i>
                    <span>Data</span>
                  </div>
                  <i class="fas fa-chevron-down ms-2"></i>
                </a>
                <div class="collapse" id="dataSubmenu">
                  <ul class="list-unstyled ps-4">
                    <li>
                      <a href="<?= site_url('data_kepemilikan') ?>" class="nav-link"
                      >Kepemilikan Ternak</a>
                    </li>
                      <li>
                        <a href="<?= site_url('data_history_ternak') ?>" class="nav-link"
                          >History Data Ternak</a
                        >
                      </li>
                    <li>
                      <a href="<?= site_url('data_vaksinasi') ?>" class="nav-link"
                        >Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_history_vaksinasi') ?>" class="nav-link"
                        >History Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_pengobatan') ?>" class="nav-link"
                        >Pengobatan Ternak</a
                      >
                    </li>
                     <li>
                      <a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link"
                        >Penjual Pakan Ternak</a
                      >
                    </li>
                     <li>
                      <a href="<?= site_url('data_klinik') ?>" class="nav-link"
                        >Klinik Hewan</a
                      >
                    </li>
                     <li>
                      <a href="<?= site_url('data_penjual_obat') ?>" class="nav-link"
                        >Penjual Obat Hewan</a
                      >
                    </li>
                      <li>
                      <a href="<?= site_url('data_rpu') ?>" class="nav-link active"
                        >TPU/RPU</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link active"
                        >Pemotongan Unggas</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_demplot') ?>" class="nav-link active"
                        >Demplot</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_stok_pakan') ?>" class="nav-link active"
                        >Stok Pakan</a
                      >
                    </li>
                  </ul>
                </div>
              </li>
             <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <span>Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i> 
                            </a>
                            <div class="collapse show" id="laporanSubmenu"> 
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_vaksinasi') ?>" class="nav-link">History Data Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>" class="nav-link active">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>" class="nav-link">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('laporan_demplot_peternakan') ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
              <li class="nav-item">
                <a href="<?= site_url('peta_sebaran') ?>" class="nav-link">
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
                        src="assets/SIPETGIS/assets/img/logo dkpp.png"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
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
                         <a href="<?= site_url('login') ?>" class="nav-link">
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

           <!-- Statistics Cards - 2 Card Tanpa Renggang (Gutter 0) -->
<div class="row g-0">
  <!-- Kotak 1: Pelaku Usaha -->
  <div class="col-md-6">
    <div class="card card-stats card-round stat-card me-1">
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
  <div class="col-md-6">
    <div class="card card-stats card-round stat-card ms-1">
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
</div>

            <!-- Main Content -->
            <div class="row">
              <!-- Left Column -->
              <div class="col-md-8"></div>
            </div>

            <!-- Geolocation Section -->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <!-- Card untuk tabel kecamatan -->
                      <div class="card stat-card">
                        <div class="card-header">
                          <h6 class="mb-0">Data Kecamatan</h6>
                        </div>
                        <div class="card-body p-0">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
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
        <tr><td class="text-center">1</td><td>Karang Pilang</td><td class="text-end">15</td><td class="text-end">45</td><td class="text-end">12</td><td class="text-end">38</td><td class="text-end">25</td><td class="text-end">120</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">50</td><td class="text-end">5</td><td class="text-end">2</td><td class="text-end">15</td><td class="text-end">8</td><td class="text-end">3</td></tr>
        <tr><td class="text-center">2</td><td>Jambangan</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">18</td><td class="text-end">200</td><td class="text-end">0</td><td class="text-end">8500</td><td class="text-end">30</td><td class="text-end">3</td><td class="text-end">0</td><td class="text-end">20</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">3</td><td>Gayungan</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">30</td><td class="text-end">22</td><td class="text-end">350</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">180</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">45</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">4</td><td>Wonocolo</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">20</td><td class="text-end">15</td><td class="text-end">0</td><td class="text-end">12500</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">2</td><td class="text-end">0</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">5</td><td>Tenggilis Mejoyo</td><td class="text-end">14</td><td class="text-end">28</td><td class="text-end">35</td><td class="text-end">15</td><td class="text-end">10</td><td class="text-end">80</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">20</td><td class="text-end">4</td><td class="text-end">1</td><td class="text-end">8</td><td class="text-end">5</td><td class="text-end">2</td></tr>
        <tr><td class="text-center">6</td><td>Gunung Anyar</td><td class="text-end">20</td><td class="text-end">52</td><td class="text-end">18</td><td class="text-end">45</td><td class="text-end">30</td><td class="text-end">150</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">35</td><td class="text-end">6</td><td class="text-end">2</td><td class="text-end">12</td><td class="text-end">10</td><td class="text-end">4</td></tr>
        <tr><td class="text-center">7</td><td>Rungkut</td><td class="text-end">22</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">35</td><td class="text-end">28</td><td class="text-end">420</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">95</td><td class="text-end">10</td><td class="text-end">3</td><td class="text-end">25</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">8</td><td>Sukolilo</td><td class="text-end">19</td><td class="text-end">38</td><td class="text-end">0</td><td class="text-end">22</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">3</td><td class="text-end">0</td><td class="text-end">8</td><td class="text-end">6</td><td class="text-end">1</td></tr>
        <tr><td class="text-center">9</td><td>Mulyorejo</td><td class="text-end">16</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">18</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">11200</td><td class="text-end">22</td><td class="text-end">2</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">10</td><td>Gubeng</td><td class="text-end">28</td><td class="text-end">65</td><td class="text-end">42</td><td class="text-end">38</td><td class="text-end">25</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">8</td><td class="text-end">4</td><td class="text-end">30</td><td class="text-end">12</td><td class="text-end">8</td></tr>
        <tr><td class="text-center">11</td><td>Wonokromo</td><td class="text-end">25</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">20</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">6500</td><td class="text-end">18</td><td class="text-end">5</td><td class="text-end">2</td><td class="text-end">22</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">12</td><td>Dukuh Pakis</td><td class="text-end">13</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">32</td><td class="text-end">20</td><td class="text-end">95</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">12</td><td class="text-end">2</td><td class="text-end">0</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">13</td><td>Wiyung</td><td class="text-end">17</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">14800</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">4</td><td class="text-end">1</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">14</td><td>Lakarsantri</td><td class="text-end">21</td><td class="text-end">48</td><td class="text-end">15</td><td class="text-end">35</td><td class="text-end">28</td><td class="text-end">180</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">6</td><td class="text-end">2</td><td class="text-end">18</td><td class="text-end">8</td><td class="text-end">3</td></tr>
        <tr><td class="text-center">15</td><td>Sambikerep</td><td class="text-end">11</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">22</td><td class="text-end">15</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">85</td><td class="text-end">12</td><td class="text-end">3</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">16</td><td>Tandes</td><td class="text-end">23</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">20</td><td class="text-end">320</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">22</td><td class="text-end">5</td><td class="text-end">1</td><td class="text-end">15</td><td class="text-end">5</td><td class="text-end">2</td></tr>
        <tr><td class="text-center">17</td><td>Sukomanunggal</td><td class="text-end">14</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">18</td><td class="text-end">75</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">10</td><td class="text-end">2</td><td class="text-end">0</td><td class="text-end">6</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">18</td><td>Sawahan</td><td class="text-end">38</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">45</td><td class="text-end">32</td><td class="text-end">0</td><td class="text-end">11280</td><td class="text-end">0</td><td class="text-end">42</td><td class="text-end">8</td><td class="text-end">2</td><td class="text-end">20</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">19</td><td>Tegalsari</td><td class="text-end">19</td><td class="text-end">42</td><td class="text-end">8</td><td class="text-end">22</td><td class="text-end">15</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">4</td><td class="text-end">1</td><td class="text-end">12</td><td class="text-end">5</td><td class="text-end">2</td></tr>
        <tr><td class="text-center">20</td><td>Genteng</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td><td class="text-end">42</td><td class="text-end">520</td></tr>
        <tr><td class="text-center">21</td><td>Bubutan</td><td class="text-end">15</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">18</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">11500</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">3</td><td class="text-end">0</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">22</td><td>Krembangan</td><td class="text-end">12</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">20</td><td class="text-end">14</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">65</td><td class="text-end">5</td><td class="text-end">1</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">23</td><td>Semampir</td><td class="text-end">24</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">35</td><td class="text-end">22</td><td class="text-end">280</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">6</td><td class="text-end">2</td><td class="text-end">15</td><td class="text-end">4</td><td class="text-end">1</td></tr>
        <tr><td class="text-center">24</td><td>Kenjeran</td><td class="text-end">27</td><td class="text-end">58</td><td class="text-end">12</td><td class="text-end">32</td><td class="text-end">25</td><td class="text-end">150</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">45</td><td class="text-end">8</td><td class="text-end">3</td><td class="text-end">18</td><td class="text-end">6</td><td class="text-end">2</td></tr>
        <tr><td class="text-center">25</td><td>Bulak</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">14500</td><td class="text-end">0</td><td class="text-end">20</td><td class="text-end">4</td><td class="text-end">0</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">26</td><td>Tambaksari</td><td class="text-end">32</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">48</td><td class="text-end">35</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">10</td><td class="text-end">4</td><td class="text-end">25</td><td class="text-end">8</td><td class="text-end">3</td></tr>
        <tr><td class="text-center">27</td><td>Simokerto</td><td class="text-end">16</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">28</td><td class="text-end">18</td><td class="text-end">85</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">12</td><td class="text-end">3</td><td class="text-end">0</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">28</td><td>Pabean Cantian</td><td class="text-end">10</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">12</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">15</td><td class="text-end">5</td><td class="text-end">20</td><td class="text-end">0</td><td class="text-end">0</td></tr>
        <tr><td class="text-center">29</td><td>Kandangan</td><td class="text-end">13</td><td class="text-end">25</td><td class="text-end">18</td><td class="text-end">20</td><td class="text-end">14</td><td class="text-end">60</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">3</td><td class="text-end">1</td><td class="text-end">10</td><td class="text-end">5</td><td class="text-end">2</td></tr>
        <tr><td class="text-center">30</td><td>Benowo</td><td class="text-end">20</td><td class="text-end">8</td><td class="text-end">0</td><td class="text-end">25</td><td class="text-end">18</td><td class="text-end">0</td><td class="text-end">17000</td><td class="text-end">0</td><td class="text-end">15</td><td class="text-end">4</td><td class="text-end">0</td><td class="text-end">12</td><td class="text-end">3</td><td class="text-end">6</td></tr>
        <tr><td class="text-center">31</td><td>Pakal</td><td class="text-end">17</td><td class="text-end">35</td><td class="text-end">10</td><td class="text-end">28</td><td class="text-end">20</td><td class="text-end">95</td><td class="text-end">0</td><td class="text-end">0</td><td class="text-end">18</td><td class="text-end">5</td><td class="text-end">2</td><td class="text-end">14</td><td class="text-end">7</td><td class="text-end">3</td></tr>
      </tbody>
      <tfoot class="table-light">
        <tr class="fw-bold">
          <td class="text-center" colspan="2">Total 31 Kecamatan</td>
          <td class="text-end">648</td>
          <td class="text-end">929</td>
          <td class="text-end">212</td>
          <td class="text-end">849</td>
          <td class="text-end">598</td>
          <td class="text-end">2.905</td>
          <td class="text-end">74.000</td>
          <td class="text-end">26.720</td>
          <td class="text-end">1.032</td>
          <td class="text-end">135</td>
          <td class="text-end">39</td>
          <td class="text-end">402</td>
          <td class="text-end">77</td>
          <td class="text-end">62</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
                        
                      </div>
                    </div>

                    <!-- <div class="col-md-12">
                      Peta Surabaya - Lebih lebar
                      <div class="mapcontainer">
                        <div
                          style="
                            height: 300px;
                            border-radius: 8px;
                            overflow: hidden;
                            background: #f8f9fa;
                          "
                        >
                          Gambar peta Surabaya
                          <div class="position-relative w-100 h-100">
                            Jika punya gambar peta Surabaya
                            <img
                              src="assets/SIPETGIS/assets/img/peta surabaya.jpeg"
                              alt="Peta Surabaya"
                              class="w-100 h-100 object-fit-cover"
                            />

                            Fallback jika gambar tidak ada
                            <div
                              id="map-fallback"
                              class="d-none flex-column align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 bg-white"
                            >
                              <i
                                class="fas fa-map-marked-alt fa-4x text-muted mb-3"
                              ></i>
                              <h5 class="text-center">
                                Peta Administrasi Surabaya
                              </h5>
                              <p class="text-muted text-center mb-3">
                                31 Kecamatan
                              </p>

                              Mini peta dengan dots
                              <div
                                class="d-flex flex-wrap justify-content-center gap-2 mb-3"
                              >
                                <span class="badge bg-primary">Genteng</span>
                                <span class="badge bg-success">Sawahan</span>
                                <span class="badge bg-info">Tambaksari</span>
                                <span class="badge bg-warning">Simokerto</span>
                                <span class="badge bg-danger">Gubeng</span>
                                <span class="badge bg-secondary"
                                  >+26 lainnya</span
                                >
                              </div>
                            </div>

                            Overlay info
                            <div
                              class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white"
                            >
                              <div
                                class="d-flex justify-content-between align-items-center"
                              >
                                <div>
                                  <h6 class="mb-0">Peta Sebaran Peternak</h6>
                                  <small
                                    >Klik untuk melihat peta interaktif</small
                                  >
                                </div>
                                <button
                                  class="btn btn-light btn-sm"
                                  onclick="openFullMap()"
                                >
                                  <i class="fas fa-external-link-alt me-1"></i>
                                  Eksplorasi
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>

                  <script>
                    // Script untuk menangani jika gambar tidak ada
                    document.addEventListener("DOMContentLoaded", function () {
                      const mapImage = document.querySelector(
                        'img[src="assets/SIPETGIS/assets/img/peta surabaya.jpeg"]',
                      );
                      const mapFallback =
                        document.getElementById("map-fallback");

                      if (mapImage) {
                        // Cek jika gambar gagal dimuat
                        mapImage.onerror = function () {
                          this.style.display = "none";
                          if (mapFallback) {
                            mapFallback.classList.remove("d-none");
                            mapFallback.classList.add("d-flex");
                          }
                        };

                        // Cek jika gambar berhasil dimuat
                        mapImage.onload = function () {
                          if (mapFallback) {
                            mapFallback.classList.add("d-none");
                            mapFallback.classList.remove("d-flex");
                          }
                        };
                      }
                    });

                    function openFullMap() {
                      alert(
                        "Fitur peta interaktif akan tersedia setelah API Google Maps diatur.",
                      );
                      // window.open('/peta-interaktif.html', '_blank');
                    }
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Chart JS -->
    <script src="assets/SIPETGIS/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
      // Commodity Chart
      document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("commodityChart").getContext("2d");
        var commodityChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: [
              "Ayam Ras Petelur",
              "Sapi Potong",
              "Kambing",
              "Ayam Kampung",
              "Itik",
            ],
            datasets: [
              {
                data: [1225, 850, 620, 450, 320],
                backgroundColor: [
                  "#1a73e8",
                  "#34a853",
                  "#fbbc05",
                  "#ea4335",
                  "#9334e6",
                ],
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,

            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: "bottom",
              },
            },
          },
        });
      });
    </script>
  </body>
</html>
