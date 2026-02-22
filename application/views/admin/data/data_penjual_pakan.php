<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Penjual Pakan Ternak</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

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
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css"
    />

    <!-- Leaflet CSS for Maps -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""
    />

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
      .filter-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
      }
      .table-responsive {
        border-radius: 8px;
        overflow: hidden;
      }
      .table th {
        background-color: #f8f9fa;
        font-weight: 600;
      }
      .detail-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
      }
      .detail-header {
        border-bottom: 2px solid #1a73e8;
        padding-bottom: 10px;
        margin-bottom: 15px;
      }
      .btn-detail {
        background-color: #1a73e8;
        color: white;
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 14px;
      }
      .btn-detail:hover {
        background-color: #0d47a1;
        color: white;
      }
      .badge-ternak {
        background-color: #e3f2fd;
        color: #1a73e8;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
      }
      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter,
      .dataTables_wrapper .dataTables_info,
      .dataTables_wrapper .dataTables_paginate {
        padding: 10px;
      }
      
      /* Style untuk tombol DataTables */
      .dt-buttons .btn {
        border-radius: 5px;
        margin-right: 5px;
        transition: all 0.3s;
      }

      .dt-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }

      .dt-buttons .btn-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
      }

      .dt-buttons .btn-success {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: white !important;
      }

      .dt-buttons .btn-danger {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
      }

      .dt-buttons .btn-info {
        background-color: #0dcaf0 !important;
        border-color: #0dcaf0 !important;
        color: white !important;
      }

      /* Pagination styling */
      .pagination .page-link {
        border: none;
        color: #495057;
        margin: 0 3px;
        border-radius: 6px !important;
      }

      .pagination .page-item.active .page-link {
        background-color: #4361ee;
        color: white;
      }

      .pagination .page-link:hover {
        background-color: #f8f9fa;
      }

      .map-container {
        height: 500px;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 10px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
      }
      .map-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 30px;
        position: relative;
        z-index: 10;
      }
      .map-info-table {
        margin-top: 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
      }
      .map-info-table th {
        background-color: #e9ecef;
        font-weight: 600;
      }
      .map-controls {
        margin-bottom: 15px;
      }
      .map-controls .btn {
        margin-right: 5px;
        margin-bottom: 5px;
      }
      .coord-badge {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 3px 8px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
      }
      .empty-coord {
        color: #6c757d;
        font-style: italic;
      }
      .map-title {
        background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 1.2rem;
      }
      /* Perbaikan untuk tampilan leaflet */
      .leaflet-container {
        font-family: "Public Sans", sans-serif !important;
      }
      .leaflet-popup-content {
        min-width: 200px;
      }
      /* Pastikan map container benar-benar terlihat */
      #mapContainer.leaflet-container {
        width: 100% !important;
        height: 500px !important;
      }
      
      /* Badge untuk status */
      .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 11px;
      }
      .badge-active {
        background-color: #d4edda;
        color: #155724;
      }
      .badge-inactive {
        background-color: #f8d7da;
        color: #721c24;
      }
      
      /* Card untuk produk pakan */
      .product-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: white;
      }
      .product-card:hover {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
            <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
              <div
                style="
                  color: #1e3a8a;
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
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>">
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
                      <a href="pelaku-usaha.html" class="nav-link"
                        >Pelaku Usaha</a
                      >
                    </li>
                    <li>
                      <a
                        href="views/masterdata/akses-pengguna.html"
                        class="nav-link"
                        >Akses Pengguna</a
                      >
                    </li>
                    <li>
                      <a href="pengobatan.html" class="nav-link">Pengobatan</a>
                    </li>
                    <li>
                      <a href="vaksinasi.html" class="nav-link">Vaksinasi</a>
                    </li>
                    <li>
                      <a href="komoditas.html" class="nav-link">Komoditas</a>
                    </li>
                     <li>
                      <a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item active">
                <a
                  class="nav-link d-flex align-items-center justify-content-between"
                  data-bs-toggle="collapse"
                  href="#dataSubmenu"
                  role="button"
                  aria-expanded="true"
                >
                  <div class="d-flex align-items-center">
                    <i class="fas fa-users me-2"></i>
                    <span>Data</span>
                  </div>
                  <i class="fas fa-chevron-down ms-2"></i>
                </a>
                <div class="collapse show" id="dataSubmenu">
                  <ul class="list-unstyled ps-4">
                    <li>
                      <a href="<?php echo base_url(); ?>data_kepemilikan" class="nav-link"
                        >Kepemilikan Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link"
                        >History Data Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link"
                        >Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a
                        href="<?php echo base_url(); ?>data_history_vaksinasi"
                        class="nav-link"
                        >History Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link"
                        >Pengobatan Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link active"
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
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                 <a href="<?php echo base_url(); ?>laporan">
                  <i class="fas fa-chart-bar"></i>
                  <p>Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>peta_sebaran">
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
                        <a class="dropdown-item" href="<?php echo base_url(); ?>login">
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
                <h3 class="fw-bold mb-1">Data Penjual Pakan Ternak</h3>
                <h6 class="op-7 mb-0">
                  Manajemen data penjual pakan ternak di Kota Surabaya
                </h6>
              </div>
              
            </div>

         

            <!-- Filter Section -->
            <div class="filter-section">
              <div class="row align-items-center">
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterKecamatan" class="form-label fw-bold">
                      Filter Kecamatan:
                    </label>
                    <select class="form-select" id="filterKecamatan">
                      <option selected value="all">Semua Kecamatan</option>
                      <option value="sukolilo">Sukolilo</option>
                      <option value="rungkut">Rungkut</option>
                      <option value="gunung_anyar">Gunung Anyar</option>
                      <option value="mulyorejo">Mulyorejo</option>
                      <option value="sawahan">Sawahan</option>
                      <option value="gubeng">Gubeng</option>
                      <option value="wonokromo">Wonokromo</option>
                      <option value="tandes">Tandes</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterStatus" class="form-label fw-bold">
                      Filter Status:
                    </label>
                    <select class="form-select" id="filterStatus">
                      <option selected value="all">Semua Status</option>
                      <option value="aktif">Aktif</option>
                      <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterJenisPakan" class="form-label fw-bold">
                      Filter Jenis Pakan:
                    </label>
                    <select class="form-select" id="filterJenisPakan">
                      <option selected value="all">Semua Jenis</option>
                      <option value="konsentrat">Konsentrat</option>
                      <option value="hijauan">Hijauan</option>
                      <option value="fermentasi">Fermentasi</option>
                      <option value="pakan_ayam">Pakan Ayam</option>
                      <option value="pakan_sapi">Pakan Sapi</option>
                      <option value="pakan_kambing">Pakan Kambing</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 text-end">
                  <button id="filterBtn" class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Filter Data
                  </button>
                  <button id="resetBtn" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                  </button>
                </div>
              </div>
            </div>

            <!-- Data Table -->
            <div class="card stat-card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="penjualPakanTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Pemilik</th>
                        <th>Kecamatan</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Koordinat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data Penjual Pakan -->
                      <tr>
                        <td>1</td>
                        <td>
                          <span class="fw-bold">Toko Pakan Ternak Sumber Rejeki</span>
                          <br>
                          <small class="text-muted">5 jenis pakan</small>
                        </td>
                        <td>H. Ahmad S.</td>
                        <td>Sukolilo</td>
                        <td>Jl. Raya Sukolilo No. 45</td>
                        <td>
                          <div>081234567890</div>
                          <small>ahmad@email.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1 text-muted">-7.2876, 112.7891</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Toko Pakan Ternak Sumber Rejeki',
                                'H. Ahmad S.',
                                'Sukolilo',
                                '-7.2876, 112.7891',
                                'Jl. Raya Sukolilo No. 45',
                                '081234567890',
                                ['Konsentrat', 'Pakan Sapi', 'Pakan Ayam']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(1)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>
                          <span class="fw-bold">UD. Pakan Ternak Sejahtera</span>
                          <br>
                          <small class="text-muted">8 jenis pakan</small>
                        </td>
                        <td>Budi Santoso</td>
                        <td>Rungkut</td>
                        <td>Jl. Raya Rungkut Industri No. 12</td>
                        <td>
                          <div>082345678901</div>
                          <small>budi@udsejahtera.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.3265, 112.7683</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'UD. Pakan Ternak Sejahtera',
                                'Budi Santoso',
                                'Rungkut',
                                '-7.3265, 112.7683',
                                'Jl. Raya Rungkut Industri No. 12',
                                '082345678901',
                                ['Konsentrat', 'Fermentasi', 'Pakan Sapi', 'Pakan Kambing', 'Vitamin']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(2)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>
                          <span class="fw-bold">CV. Agro Pakan Surabaya</span>
                          <br>
                          <small class="text-muted">12 jenis pakan</small>
                        </td>
                        <td>Siti Aminah</td>
                        <td>Gunung Anyar</td>
                        <td>Jl. Gunung Anyar Timur No. 78</td>
                        <td>
                          <div>083456789012</div>
                          <small>siti@agropakan.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.3381, 112.7944</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'CV. Agro Pakan Surabaya',
                                'Siti Aminah',
                                'Gunung Anyar',
                                '-7.3381, 112.7944',
                                'Jl. Gunung Anyar Timur No. 78',
                                '083456789012',
                                ['Konsentrat', 'Hijauan', 'Fermentasi', 'Pakan Ayam', 'Pakan Sapi', 'Pakan Kambing', 'Pakan Itik']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(3)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>
                          <span class="fw-bold">Toko Pakan Mulyorejo</span>
                          <br>
                          <small class="text-muted">4 jenis pakan</small>
                        </td>
                        <td>Supriyadi</td>
                        <td>Mulyorejo</td>
                        <td>Jl. Mulyorejo Utara No. 23</td>
                        <td>
                          <div>084567890123</div>
                          <small>supriyadi@yahoo.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2621, 112.7915</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Toko Pakan Mulyorejo',
                                'Supriyadi',
                                'Mulyorejo',
                                '-7.2621, 112.7915',
                                'Jl. Mulyorejo Utara No. 23',
                                '084567890123',
                                ['Pakan Ayam', 'Pakan Itik', 'Vitamin']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(4)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>
                          <span class="fw-bold">PD. Pakan Ternak Jaya</span>
                          <br>
                          <small class="text-muted">6 jenis pakan</small>
                        </td>
                        <td>Dwi Handayani</td>
                        <td>Sawahan</td>
                        <td>Jl. Sawahan Baru No. 56</td>
                        <td>
                          <div>085678901234</div>
                          <small>dwi.handayani@gmail.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2511, 112.7304</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'PD. Pakan Ternak Jaya',
                                'Dwi Handayani',
                                'Sawahan',
                                '-7.2511, 112.7304',
                                'Jl. Sawahan Baru No. 56',
                                '085678901234',
                                ['Konsentrat', 'Pakan Ayam', 'Pakan Sapi', 'Pakan Kambing']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(5)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>6</td>
                        <td>
                          <span class="fw-bold">Toko Pakan Gubeng</span>
                          <br>
                          <small class="text-muted">3 jenis pakan</small>
                        </td>
                        <td>Rudi Hartono</td>
                        <td>Gubeng</td>
                        <td>Jl. Gubeng Pojok No. 34</td>
                        <td>
                          <div>086789012345</div>
                          <small>rudi.hartono@yahoo.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2667, 112.7500</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Toko Pakan Gubeng',
                                'Rudi Hartono',
                                'Gubeng',
                                '-7.2667, 112.7500',
                                'Jl. Gubeng Pojok No. 34',
                                '086789012345',
                                ['Pakan Ayam', 'Vitamin']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-inactive">Tidak Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(6)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>
                          <span class="fw-bold">CV. Pakan Ternak Berkah</span>
                          <br>
                          <small class="text-muted">10 jenis pakan</small>
                        </td>
                        <td>Hasan Basri</td>
                        <td>Wonokromo</td>
                        <td>Jl. Wonokromo No. 89</td>
                        <td>
                          <div>087890123456</div>
                          <small>hasan@berkahpakan.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2953, 112.7389</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'CV. Pakan Ternak Berkah',
                                'Hasan Basri',
                                'Wonokromo',
                                '-7.2953, 112.7389',
                                'Jl. Wonokromo No. 89',
                                '087890123456',
                                ['Konsentrat', 'Hijauan', 'Fermentasi', 'Pakan Ayam', 'Pakan Sapi', 'Pakan Kambing', 'Pakan Itik', 'Vitamin', 'Mineral']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(7)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>8</td>
                        <td>
                          <span class="fw-bold">UD. Sumber Pakan Ternak</span>
                          <br>
                          <small class="text-muted">7 jenis pakan</small>
                        </td>
                        <td>Joko Susilo</td>
                        <td>Tandes</td>
                        <td>Jl. Tandes Barat No. 67</td>
                        <td>
                          <div>088901234567</div>
                          <small>joko.susilo@yahoo.com</small>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2439, 112.6816</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'UD. Sumber Pakan Ternak',
                                'Joko Susilo',
                                'Tandes',
                                '-7.2439, 112.6816',
                                'Jl. Tandes Barat No. 67',
                                '088901234567',
                                ['Konsentrat', 'Fermentasi', 'Pakan Sapi', 'Pakan Ayam', 'Vitamin']
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-status badge-active">Aktif</span>
                        </td>
                        <td>
                          <div class="d-flex gap-1">
                            <button
                              class="btn btn-sm btn-info"
                              title="Detail Data"
                              onclick="showDetail(8)"
                            >
                              <i class="fas fa-eye"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-warning"
                              title="Edit Data"
                            >
                              <i class="fas fa-edit"></i>
                            </button>
                            <button
                              class="btn btn-sm btn-danger"
                              title="Hapus Data"
                            >
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Detail Section (Initially Hidden) -->
            <div
              id="detailSection"
              class="detail-section"
              style="display: none"
            >
              <div class="detail-header">
                <h5 class="fw-bold mb-0" id="detailTitle">
                  Detail Penjual Pakan Ternak
                </h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi Toko</h6>
                    </div>
                    <div class="card-body" id="detailTokoInfo">
                      <!-- Informasi toko akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi Pemilik</h6>
                    </div>
                    <div class="card-body" id="detailPemilikInfo">
                      <!-- Informasi pemilik akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Daftar Produk Pakan</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Produk</th>
                          <th>Jenis</th>
                          <th>Harga (Rp)</th>
                          <th>Stok</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody id="detailProdukBody">
                        <!-- Detail produk akan diisi oleh JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button id="closeDetailBtn" class="btn btn-outline-primary">
                  <i class="fas fa-times me-2"></i>Tutup Detail
                </button>
              </div>
            </div>

            <!-- Map Section (Initially Hidden) -->
            <div id="mapSection" class="map-section" style="display: none">
              <div class="detail-header">
                <div class="map-title" id="mapTitle">
                  Peta Lokasi Penjual Pakan Ternak
                </div>
                <div id="mapInfo" class="text-muted mt-2">
                  <!-- Map info akan diisi oleh JavaScript -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="map-controls mb-2">
                    <button
                      id="btnMapView"
                      class="btn btn-outline-primary btn-sm active"
                    >
                      <i class="fas fa-map me-1"></i>Map
                    </button>
                    <button
                      id="btnSatelliteView"
                      class="btn btn-outline-secondary btn-sm"
                    >
                      <i class="fas fa-satellite me-1"></i>Satellite
                    </button>
                    <button
                      id="btnResetView"
                      class="btn btn-outline-info btn-sm"
                    >
                      <i class="fas fa-sync-alt me-1"></i>Reset View
                    </button>
                  </div>

                  <!-- Map Container -->
                  <div id="mapContainer" class="map-container"></div>

                  <!-- Informasi tambahan di bawah peta -->
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-primary text-white py-2">
                          <h6 class="mb-0">
                            <i class="fas fa-store me-1"></i> Informasi Toko
                          </h6>
                        </div>
                        <div class="card-body p-3" id="farmInfo">
                          <!-- Informasi toko akan diisi oleh JavaScript -->
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-primary text-white py-2">
                          <h6 class="mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i> Detail
                            Koordinat
                          </h6>
                        </div>
                        <div class="card-body p-3" id="coordInfo">
                          <!-- Informasi koordinat akan diisi oleh JavaScript -->
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Daftar produk pakan -->
                  <div class="card mt-3">
                    <div class="card-header bg-primary text-white py-2">
                      <h6 class="mb-0">
                        <i class="fas fa-tag me-1"></i> Produk Pakan Tersedia
                      </h6>
                    </div>
                    <div class="card-body p-3" id="productInfo">
                      <!-- Produk pakan akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button id="closeMapBtn" class="btn btn-outline-primary">
                  <i class="fas fa-times me-2"></i>Tutup Peta
                </button>
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

    <!-- DataTables JS -->
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"
    ></script>
    <script
      type="text/javascript"
      charset="utf8"
      src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"
    ></script>

    <!-- Leaflet JS for Maps -->
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""
    ></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
      // Data untuk detail penjual pakan
      const penjualDetailData = {
        1: {
          toko: {
            nama: "Toko Pakan Ternak Sumber Rejeki",
            kecamatan: "Sukolilo",
            alamat: "Jl. Raya Sukolilo No. 45, Surabaya",
            telepon: "081234567890",
            email: "ahmad@email.com",
            status: "Aktif",
            tanggal_terdaftar: "15 Januari 2020",
            jam_operasional: "08:00 - 20:00 WIB"
          },
          pemilik: {
            nama: "H. Ahmad S.",
            nik: "3578011501750001",
            telepon: "081234567890",
            email: "ahmad@email.com",
            alamat: "Jl. Sukolilo Raya No. 45, Surabaya"
          },
          produk: [
            {no: 1, nama: "Konsentrat Sapi 511", jenis: "Konsentrat", harga: 450000, stok: "50 sak", keterangan: "Untuk sapi potong"},
            {no: 2, nama: "Pakan Ayam BR1", jenis: "Pakan Ayam", harga: 375000, stok: "75 sak", keterangan: "Ayam broiler"},
            {no: 3, nama: "Pakan Sapi Fermentasi", jenis: "Fermentasi", harga: 350000, stok: "40 karung", keterangan: "Hijauan fermentasi"},
            {no: 4, nama: "Vitamin Ternak", jenis: "Vitamin", harga: 85000, stok: "120 botol", keterangan: "Multivitamin"},
            {no: 5, nama: "Mineral Blok", jenis: "Mineral", harga: 125000, stok: "30 balok", keterangan: "Mineral blok 5kg"}
          ]
        },
        2: {
          toko: {
            nama: "UD. Pakan Ternak Sejahtera",
            kecamatan: "Rungkut",
            alamat: "Jl. Raya Rungkut Industri No. 12, Surabaya",
            telepon: "082345678901",
            email: "budi@udsejahtera.com",
            status: "Aktif",
            tanggal_terdaftar: "10 Maret 2019",
            jam_operasional: "07:30 - 19:00 WIB"
          },
          pemilik: {
            nama: "Budi Santoso",
            nik: "3578022003800002",
            telepon: "082345678901",
            email: "budi@udsejahtera.com",
            alamat: "Jl. Rungkut Industri No. 12, Surabaya"
          },
          produk: [
            {no: 1, nama: "Konsentrat Sapi", jenis: "Konsentrat", harga: 475000, stok: "60 sak", keterangan: "Untuk sapi"},
            {no: 2, nama: "Pakan Ayam Pedaging", jenis: "Pakan Ayam", harga: 380000, stok: "80 sak", keterangan: "BR1"},
            {no: 3, nama: "Pakan Itik", jenis: "Pakan Itik", harga: 365000, stok: "45 sak", keterangan: "Untuk itik petelur"},
            {no: 4, nama: "Pakan Fermentasi", jenis: "Fermentasi", harga: 340000, stok: "35 karung", keterangan: "Silase jagung"},
            {no: 5, nama: "Pakan Kambing", jenis: "Pakan Kambing", harga: 320000, stok: "40 karung", keterangan: "Konsentrat kambing"},
            {no: 6, nama: "Vitamin", jenis: "Vitamin", harga: 90000, stok: "100 botol", keterangan: "Multivitamin"},
            {no: 7, nama: "Probiotik", jenis: "Suplemen", harga: 150000, stok: "50 botol", keterangan: "Untuk pencernaan"},
            {no: 8, nama: "Mineral Blok", jenis: "Mineral", harga: 135000, stok: "25 balok", keterangan: "Mineral blok 5kg"}
          ]
        },
        3: {
          toko: {
            nama: "CV. Agro Pakan Surabaya",
            kecamatan: "Gunung Anyar",
            alamat: "Jl. Gunung Anyar Timur No. 78, Surabaya",
            telepon: "083456789012",
            email: "siti@agropakan.com",
            status: "Aktif",
            tanggal_terdaftar: "5 Mei 2018",
            jam_operasional: "08:00 - 21:00 WIB"
          },
          pemilik: {
            nama: "Siti Aminah",
            nik: "3578034504850003",
            telepon: "083456789012",
            email: "siti@agropakan.com",
            alamat: "Jl. Gunung Anyar Timur No. 78, Surabaya"
          },
          produk: [
            {no: 1, nama: "Konsentrat Premium", jenis: "Konsentrat", harga: 500000, stok: "100 sak", keterangan: "Untuk sapi potong & perah"},
            {no: 2, nama: "Hijauan Segar", jenis: "Hijauan", harga: 25000, stok: "200 ikat", keterangan: "Rumput gajah"},
            {no: 3, nama: "Silase Jagung", jenis: "Fermentasi", harga: 375000, stok: "60 karung", keterangan: "Fermentasi jagung"},
            {no: 4, nama: "Pakan Ayam BR1", jenis: "Pakan Ayam", harga: 385000, stok: "120 sak", keterangan: "Ayam broiler"},
            {no: 5, nama: "Pakan Ayam Layer", jenis: "Pakan Ayam", harga: 360000, stok: "90 sak", keterangan: "Ayam petelur"},
            {no: 6, nama: "Pakan Sapi", jenis: "Pakan Sapi", harga: 420000, stok: "70 sak", keterangan: "Konsentrat sapi"},
            {no: 7, nama: "Pakan Kambing", jenis: "Pakan Kambing", harga: 390000, stok: "50 sak", keterangan: "Konsentrat kambing"},
            {no: 8, nama: "Pakan Itik", jenis: "Pakan Itik", harga: 350000, stok: "40 sak", keterangan: "Untuk itik"},
            {no: 9, nama: "Vitamin Komplit", jenis: "Vitamin", harga: 95000, stok: "150 botol", keterangan: "Vitamin + mineral"},
            {no: 10, nama: "Mineral Blok", jenis: "Mineral", harga: 145000, stok: "40 balok", keterangan: "Mineral blok 5kg"},
            {no: 11, nama: "Probiotik", jenis: "Suplemen", harga: 165000, stok: "60 botol", keterangan: "Untuk kesehatan pencernaan"},
            {no: 12, nama: "Premix", jenis: "Premix", harga: 185000, stok: "35 sak", keterangan: "Campuran pakan"}
          ]
        }
      };

      // Variable untuk peta
      let map = null;
      let mapMarkers = [];
      let currentView = "map";
      let currentFarmMarker = null;

      // Inisialisasi DataTable
      $(document).ready(function () {
        $("#penjualPakanTable").DataTable({
          dom: "Bfrtip",
          buttons: [
            {
              extend: "copy",
              text: '<i class="fas fa-copy"></i> Copy',
              className: 'btn btn-sm btn-primary'
            },
            {
              extend: "csv",
              text: '<i class="fas fa-file-csv"></i> CSV',
              className: 'btn btn-sm btn-success'
            },
            {
              extend: "excel",
              text: '<i class="fas fa-file-excel"></i> Excel',
              className: 'btn btn-sm btn-success'
            },
            {
              extend: "pdf",
              text: '<i class="fas fa-file-pdf"></i> PDF',
              className: 'btn btn-sm btn-danger'
            },
            {
              extend: "print",
              text: '<i class="fas fa-print"></i> Print',
              className: 'btn btn-sm btn-info'
            }
          ],
          language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Berikutnya",
              previous: "Sebelumnya"
            }
          },
          pageLength: 10,
          lengthChange: true,
          lengthMenu: [5, 10, 25, 50, 100],
          responsive: true,
          order: [[0, 'asc']],
          columnDefs: [
            { targets: [6], orderable: false }, // Kolom koordinat tidak bisa diurutkan
            { targets: [8], orderable: false } // Kolom aksi tidak bisa diurutkan
          ]
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const kecamatanValue = $("#filterKecamatan").val();
          const statusValue = $("#filterStatus").val();
          const jenisPakanValue = $("#filterJenisPakan").val();
          
          let searchTerm = "";

          if (kecamatanValue === "all" && statusValue === "all" && jenisPakanValue === "all") {
            $("#penjualPakanTable").DataTable().search("").draw();
            return;
          }

          // Filter berdasarkan kecamatan
          if (kecamatanValue !== "all") {
            let kecamatanTerm = "";
            switch (kecamatanValue) {
              case "sukolilo": kecamatanTerm = "Sukolilo"; break;
              case "rungkut": kecamatanTerm = "Rungkut"; break;
              case "gunung_anyar": kecamatanTerm = "Gunung Anyar"; break;
              case "mulyorejo": kecamatanTerm = "Mulyorejo"; break;
              case "sawahan": kecamatanTerm = "Sawahan"; break;
              case "gubeng": kecamatanTerm = "Gubeng"; break;
              case "wonokromo": kecamatanTerm = "Wonokromo"; break;
              case "tandes": kecamatanTerm = "Tandes"; break;
            }
            searchTerm += kecamatanTerm;
          }

          // Filter berdasarkan status
          if (statusValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += (statusValue === "aktif") ? "Aktif" : "Tidak Aktif";
          }

          // Filter berdasarkan jenis pakan
          if (jenisPakanValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            let jenisTerm = "";
            switch (jenisPakanValue) {
              case "konsentrat": jenisTerm = "Konsentrat"; break;
              case "hijauan": jenisTerm = "Hijauan"; break;
              case "fermentasi": jenisTerm = "Fermentasi"; break;
              case "pakan_ayam": jenisTerm = "Pakan Ayam"; break;
              case "pakan_sapi": jenisTerm = "Pakan Sapi"; break;
              case "pakan_kambing": jenisTerm = "Pakan Kambing"; break;
            }
            searchTerm += jenisTerm;
          }

          $("#penjualPakanTable").DataTable().search(searchTerm).draw();
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterKecamatan").val("all");
          $("#filterStatus").val("all");
          $("#filterJenisPakan").val("all");
          $("#penjualPakanTable").DataTable().search("").draw();
        });

        // Tambah data button event
        $("#btnTambahData").click(function(e) {
          e.preventDefault();
          alert("Fitur tambah data akan segera tersedia!");
          // Redirect ke halaman tambah data
          // window.location.href = "<?php echo base_url(); ?>data_penjual_pakan/tambah";
        });

        // Close detail button event
        $("#closeDetailBtn").click(function () {
          $("#detailSection").hide();
        });

        // Close map button event
        $("#closeMapBtn").click(function () {
          $("#mapSection").hide();
          if (map) {
            map.remove();
            map = null;
          }
        });

        // Map view controls
        $("#btnMapView").click(function () {
          currentView = "map";
          updateMapView();
          $(this).addClass("active");
          $("#btnSatelliteView").removeClass("active");
        });

        $("#btnSatelliteView").click(function () {
          currentView = "satellite";
          updateMapView();
          $(this).addClass("active");
          $("#btnMapView").removeClass("active");
        });

        $("#btnResetView").click(function () {
          if (map && currentFarmMarker) {
            const latlng = currentFarmMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
          }
        });
      });

      // Function to show map
      function showMap(namaToko, pemilik, kecamatan, coordinates, alamat, telepon, produkList) {
        // Parse coordinates
        const [lat, lng] = coordinates
          .split(",")
          .map((coord) => parseFloat(coord.trim()));

        // Update map title and info
        $("#mapTitle").text(`Peta Lokasi ${namaToko}`);
        $("#mapInfo").html(`
          <div class="row">
            <div class="col-md-6">
              <span class="fw-bold">Toko:</span> ${namaToko}<br>
              <span class="fw-bold">Pemilik:</span> ${pemilik}<br>
              <span class="fw-bold">Kecamatan:</span> ${kecamatan}
            </div>
            <div class="col-md-6">
              <span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br>
              <span class="fw-bold">Telepon:</span> ${telepon}
            </div>
          </div>
        `);

        // Update farm info
        $("#farmInfo").html(`
          <div class="mb-2">
            <span class="fw-bold">Nama Toko:</span><br>
            <span class="text-primary fw-bold">${namaToko}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Pemilik:</span><br>
            ${pemilik}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kecamatan:</span><br>
            <span class="badge bg-primary">${kecamatan}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Alamat:</span><br>
            ${alamat}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kontak:</span><br>
            <i class="fas fa-phone-alt me-1"></i> ${telepon}
          </div>
        `);

        // Update coordinate info
        $("#coordInfo").html(`
          <div class="mb-2">
            <span class="fw-bold">Latitude:</span><br>
            <code>${lat.toFixed(6)}</code>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Longitude:</span><br>
            <code>${lng.toFixed(6)}</code>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Format Koordinat:</span><br>
            <small>DD (Decimal Degrees)</small>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Akurasi:</span><br>
            <small>GPS ± 5 meter</small>
          </div>
        `);

        // Update product info
        let productHtml = '<div class="row">';
        produkList.forEach((produk, index) => {
          productHtml += `
            <div class="col-md-4">
              <div class="product-card">
                <span class="fw-bold">${produk}</span>
              </div>
            </div>
          `;
        });
        productHtml += '</div>';
        $("#productInfo").html(productHtml);

        // Initialize or update map
        if (!map) {
          $("#mapContainer").css("height", "500px");

          setTimeout(() => {
            map = L.map("mapContainer", {
              zoomControl: false,
              attributionControl: false,
            }).setView([lat, lng], 15);

            L.control
              .zoom({
                position: "topright",
              })
              .addTo(map);

            L.control
              .attribution({
                position: "bottomright",
              })
              .addTo(map)
              .addAttribution("© OpenStreetMap contributors");

            updateMapView();

            // Custom icon untuk toko pakan (warna orange)
            const shopIcon = L.divIcon({
              html: `<div style="background-color: #fd7e14; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
              className: "shop-marker",
              iconSize: [30, 30],
              iconAnchor: [15, 15],
            });

            // Add marker
            currentFarmMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
            currentFarmMarker
              .bindPopup(
                `
              <div style="min-width: 250px;">
                <h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">${namaToko}</h5>
                <hr style="margin: 5px 0;">
                <div style="margin-bottom: 3px;"><strong>Pemilik:</strong> ${pemilik}</div>
                <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${kecamatan}</div>
                <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${alamat}</div>
                <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${telepon}</div>
                <div style="text-align: center; margin-top: 8px;">
                  <small class="text-muted">Klik di luar popup untuk menutup</small>
                </div>
              </div>
            `,
              )
              .openPopup();
            mapMarkers.push(currentFarmMarker);

            // Add circle area
            const circle = L.circle([lat, lng], {
              color: "#fd7e14",
              fillColor: "#fd7e14",
              fillOpacity: 0.1,
              radius: 300,
            }).addTo(map);
            mapMarkers.push(circle);

            setTimeout(() => {
              map.invalidateSize();
            }, 100);
          }, 100);
        } else {
          mapMarkers.forEach((marker) => map.removeLayer(marker));
          mapMarkers = [];

          map.setView([lat, lng], 15);

          const shopIcon = L.divIcon({
            html: `<div style="background-color: #fd7e14; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
            className: "shop-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15],
          });

          currentFarmMarker = L.marker([lat, lng], { icon: shopIcon }).addTo(map);
          currentFarmMarker
            .bindPopup(
              `
            <div style="min-width: 250px;">
              <h5 style="margin: 0 0 5px 0; color: #fd7e14; text-align: center;">${namaToko}</h5>
              <hr style="margin: 5px 0;">
              <div style="margin-bottom: 3px;"><strong>Pemilik:</strong> ${pemilik}</div>
              <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${kecamatan}</div>
              <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${alamat}</div>
              <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
              <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${telepon}</div>
              <div style="text-align: center; margin-top: 8px;">
                <small class="text-muted">Klik di luar popup untuk menutup</small>
              </div>
            </div>
          `,
            )
            .openPopup();
          mapMarkers.push(currentFarmMarker);

          const circle = L.circle([lat, lng], {
            color: "#fd7e14",
            fillColor: "#fd7e14",
            fillOpacity: 0.1,
            radius: 300,
          }).addTo(map);
          mapMarkers.push(circle);

          setTimeout(() => {
            map.invalidateSize();
          }, 50);
        }

        $("#mapSection").show();
        $("#detailSection").hide();

        $("html, body").animate(
          {
            scrollTop: $("#mapSection").offset().top - 20,
          },
          500
        );

        setTimeout(() => {
          if (map) {
            map.invalidateSize();
          }
        }, 300);
      }

      // Function to show detail
      function showDetail(id) {
        const data = penjualDetailData[id];
        if (!data) {
          alert("Data tidak ditemukan");
          return;
        }

        $("#detailTitle").text(`Detail Penjual Pakan: ${data.toko.nama}`);
        $("#detailInfo").html(`
          <span class="badge bg-${data.toko.status === 'Aktif' ? 'success' : 'danger'}">${data.toko.status}</span>
          <span class="ms-2">Terdaftar: ${data.toko.tanggal_terdaftar}</span>
        `);

        // Informasi Toko
        $("#detailTokoInfo").html(`
          <table class="table table-sm table-borderless">
            <tr>
              <td width="40%"><strong>Nama Toko</strong></td>
              <td>: ${data.toko.nama}</td>
            </tr>
            <tr>
              <td><strong>Kecamatan</strong></td>
              <td>: ${data.toko.kecamatan}</td>
            </tr>
            <tr>
              <td><strong>Alamat</strong></td>
              <td>: ${data.toko.alamat}</td>
            </tr>
            <tr>
              <td><strong>Telepon</strong></td>
              <td>: ${data.toko.telepon}</td>
            </tr>
            <tr>
              <td><strong>Email</strong></td>
              <td>: ${data.toko.email}</td>
            </tr>
            <tr>
              <td><strong>Jam Operasional</strong></td>
              <td>: ${data.toko.jam_operasional}</td>
            </tr>
          </table>
        `);

        // Informasi Pemilik
        $("#detailPemilikInfo").html(`
          <table class="table table-sm table-borderless">
            <tr>
              <td width="40%"><strong>Nama Pemilik</strong></td>
              <td>: ${data.pemilik.nama}</td>
            </tr>
            <tr>
              <td><strong>NIK</strong></td>
              <td>: ${data.pemilik.nik}</td>
            </tr>
            <tr>
              <td><strong>Telepon</strong></td>
              <td>: ${data.pemilik.telepon}</td>
            </tr>
            <tr>
              <td><strong>Email</strong></td>
              <td>: ${data.pemilik.email}</td>
            </tr>
            <tr>
              <td><strong>Alamat</strong></td>
              <td>: ${data.pemilik.alamat}</td>
            </tr>
          </table>
        `);

        // Daftar Produk
        let produkHtml = "";
        data.produk.forEach(item => {
          produkHtml += `
            <tr>
              <td>${item.no}</td>
              <td>${item.nama}</td>
              <td>${item.jenis}</td>
              <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
              <td>${item.stok}</td>
              <td>${item.keterangan}</td>
            </tr>
          `;
        });
        $("#detailProdukBody").html(produkHtml);

        $("#detailSection").show();
        $("#mapSection").hide();

        $("html, body").animate(
          {
            scrollTop: $("#detailSection").offset().top - 20,
          },
          500
        );
      }

      // Function to update map view
      function updateMapView() {
        if (!map) return;

        map.eachLayer((layer) => {
          if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
          }
        });

        if (currentView === "map") {
          L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
              '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
          }).addTo(map);
        } else if (currentView === "satellite") {
          L.tileLayer(
            "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
            {
              attribution:
                "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
              maxZoom: 19,
            },
          ).addTo(map);
        }

        mapMarkers.forEach((marker) => {
          if (marker instanceof L.Circle) {
            map.addLayer(marker);
          } else if (marker instanceof L.Marker) {
            map.addLayer(marker);
          }
        });

        setTimeout(() => {
          map.invalidateSize();
        }, 50);
      }
    </script>
  </body>
</html>