<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - History Data Ternak</title>
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
        height: 500px; /* Diperbesar dari 400px */
        border-radius: 8px;
        overflow: hidden;
        margin-top: 10px; /* Dikurangi dari 20px */
        border: 1px solid #dee2e6;
        background-color: #f8f9fa; /* Background default */
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
        padding: 15px 20px; /* Diperbesar padding */
        border-radius: 8px;
        margin-bottom: 20px; /* Diperbesar */
        font-weight: 600;
        font-size: 1.2rem; /* Diperbesar font */
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
                       <a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a>
                    </li>
                     <li>
                       <a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a>
                    </li>
                    <li>
                      <a
                        href="<?php echo base_url(); ?>akses_pengguna"
                        class="nav-link"
                        >Akses Pengguna</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>pengobatan" class="nav-link">Pengobatan</a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>vaksinasi" class="nav-link">Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>komoditas" class="nav-link">Komoditas</a>
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
              <li class="nav-item active">
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
                      <a href="<?php echo base_url(); ?>data_kepemilikan" class="nav-link"
                        >Kepemilikan Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link active"
                        >History Data Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link"
                        >Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_history_vaksinasi" class="nav-link"
                        >History Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link"
                        >Pengobatan Ternak</a
                      >
                    </li>
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
                <h3 class="fw-bold mb-1">History Data Ternak</h3>
                <h6 class="op-7 mb-0">
                  Manajemen history data ternak di Kota Surabaya
                </h6>
              </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="form-group mb-0">
                    <label for="filterKomoditas" class="form-label fw-bold">
                      Filter Komoditas:
                    </label>
                    <select class="form-select" id="filterKomoditas">
                      <option selected value="all">Semua Komoditas</option>
                      <option value="sapi_potong">Sapi Potong</option>
                      <option value="ayam_petelur">Ayam Ras Petelur</option>
                      <option value="ayam_kampung">Ayam Kampung</option>
                      <option value="kambing">Kambing</option>
                      <option value="itik">Itik</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-0">
                    <label for="filterPeriode" class="form-label fw-bold">
                      Filter Periode:
                    </label>
                    <select class="form-select" id="filterPeriode">
                      <option selected value="all">Semua Periode</option>
                      <option value="2023">Tahun 2023</option>
                      <option value="2022">Tahun 2022</option>
                      <option value="2021">Tahun 2021</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 text-end">
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
                  <table id="historyDataTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Peternak</th>
                        <th>Komoditas</th>
                        <th>Jumlah Tambah</th>
                        <th>Jumlah Kurang</th>
                        <th>Koordinat Lokasi</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data dari gambar yang diberikan -->
                      <tr>
                        <td>1</td>
                        <td>BERSATU</td>
                        <td>Sapi Potong</td>
                        <td>
                          <span class="">5</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">0</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2575, 112.7521</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="
                                showMap(
                                  'Sapi Potong',
                                  'BERSATU',
                                  '-7.2575, 112.7521',
                                )
                              "
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>22-03-2023</td>
                        <td>
                          <div class="d-flex gap-1">
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
                        <td>LUKAH BANUA BARU</td>
                        <td>Ayam Ras Petelur</td>
                        <td>
                          <span class="">725</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">0</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1 text-muted">-</div>
                            <button
                              class="btn btn-sm btn-outline-secondary"
                              disabled
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>28-10-2022</td>
                        <td>
                          <div class="d-flex gap-1">
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
                        <td>Berdikari (Kandang Jaya)</td>
                        <td>Ayam Ras Petelur</td>
                        <td>
                          <span class="">500</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">0</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1 text-muted">-</div>
                            <button
                              class="btn btn-sm btn-outline-secondary"
                              disabled
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>27-10-2022</td>
                        <td>
                          <div class="d-flex gap-1">
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
                      <!-- Data tambahan untuk demo -->
                      <tr>
                        <td>4</td>
                        <td>Mekar Sari Farm</td>
                        <td>Sapi Potong</td>
                        <td>
                          <span class="">3</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">1</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2650, 112.7475</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="
                                showMap(
                                  'Sapi Potong',
                                  'Mekar Sari Farm',
                                  '-7.2650, 112.7475',
                                )
                              "
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>15-02-2023</td>
                        <td>
                          <div class="d-flex gap-1">
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
                        <td>Peternak Mandiri</td>
                        <td>Ayam Kampung</td>
                        <td>
                          <span class="">150</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">20</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2500, 112.7600</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="
                                showMap(
                                  'Ayam Kampung',
                                  'Peternak Mandiri',
                                  '-7.2500, 112.7600',
                                )
                              "
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>10-01-2023</td>
                        <td>
                          <div class="d-flex gap-1">
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
                        <td>Ternak Sejahtera</td>
                        <td>Kambing</td>
                        <td>
                          <span class="">12</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">2</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2550, 112.7550</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="
                                showMap(
                                  'Kambing',
                                  'Ternak Sejahtera',
                                  '-7.2550, 112.7550',
                                )
                              "
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>05-03-2023</td>
                        <td>
                          <div class="d-flex gap-1">
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
                        <td>Bebek Unggul Farm</td>
                        <td>Itik</td>
                        <td>
                          <span class="">80</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <span class="">10</span> <span class="">Ekor</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2600, 112.7500</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="
                                showMap(
                                  'Itik',
                                  'Bebek Unggul Farm',
                                  '-7.2600, 112.7500',
                                )
                              "
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
                        </td>
                        <td>18-02-2023</td>
                        <td>
                          <div class="d-flex gap-1">
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
                  Detail History Data Ternak
                </h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="table-responsive">
                <table id="detailTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jenis Perubahan</th>
                      <th>Jumlah</th>
                      <th>Alasan</th>
                      <th>Petugas</th>
                      <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody id="detailTableBody">
                    <!-- Detail data will be inserted here -->
                  </tbody>
                </table>
              </div>

              <div class="text-end mt-3">
                <button id="closeDetailBtn" class="btn btn-outline-primary">
                  <i class="fas fa-times me-2"></i>Tutup Detail
                </button>
              </div>
            </div>

            <!-- Map Section (Initially Hidden) - REVISI STRUKTUR -->
            <div id="mapSection" class="map-section" style="display: none">
              <div class="detail-header">
                <div class="map-title" id="mapTitle">Peta Lokasi Ternak</div>
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

                  <!-- Map Container dengan tinggi yang fixed -->
                  <div id="mapContainer" class="map-container"></div>

                  <!-- Informasi tambahan di bawah peta -->
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-primary text-white py-2">
                          <h6 class="mb-0">
                            <i class="fas fa-info-circle me-1"></i> Informasi
                            Peternak
                          </h6>
                        </div>
                        <div class="card-body p-3" id="farmInfo">
                          <!-- Informasi peternak akan diisi oleh JavaScript -->
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
      // Data untuk detail history
      const historyDetailData = {
        1: [
          {
            no: 1,
            jenis: "Penambahan",
            jumlah: 5,
            alasan: "Kelahiran",
            petugas: "Dr. Andi",
            tanggal: "22-03-2023",
          },
        ],
        2: [
          {
            no: 1,
            jenis: "Penambahan",
            jumlah: 725,
            alasan: "Pembelian bibit",
            petugas: "Dr. Sari",
            tanggal: "28-10-2022",
          },
        ],
        3: [
          {
            no: 1,
            jenis: "Penambahan",
            jumlah: 500,
            alasan: "Pembelian bibit",
            petugas: "Dr. Budi",
            tanggal: "27-10-2022",
          },
        ],
        4: [
          {
            no: 1,
            jenis: "Penambahan",
            jumlah: 3,
            alasan: "Kelahiran",
            petugas: "Dr. Andi",
            tanggal: "15-02-2023",
          },
          {
            no: 2,
            jenis: "Pengurangan",
            jumlah: 1,
            alasan: "Penjualan",
            petugas: "Dr. Andi",
            tanggal: "15-02-2023",
          },
        ],
        5: [
          {
            no: 1,
            jenis: "Penambahan",
            jumlah: 150,
            alasan: "Pembelian bibit",
            petugas: "Dr. Rina",
            tanggal: "10-01-2023",
          },
          {
            no: 2,
            jenis: "Pengurangan",
            jumlah: 20,
            alasan: "Kematian",
            petugas: "Dr. Rina",
            tanggal: "10-01-2023",
          },
        ],
      };

      // Data untuk informasi lokasi terdekat (dari gambar)
      const locationInfoData = [
        "Nirmala",
        "Komplek Grya Indah 1",
        "Jl. Arjuna",
        "Jl. Aisyah",
        "Berkel Risi",
        "Dewi Afifah Fatah",
        "Dapur Mardabak & Terang Bulan Syifa",
        "Umum Kera Tempatnya Closet",
        "Jl. Bekantan II",
        "Jl. Bekantan III",
        "Jl. Anthurium 1",
        "Jl. Anthurium 2",
        "Jl. Anthurium 3",
        "Jl. Anthurium 4",
        "Jl. Anthurium 5",
        "Jl. Anthurium 6",
        "Jl. Anthurium 7",
        "Jl. Anthurium 8",
        "Jl. Anthurium 9",
        "Jl. Anthurium 10",
      ];

      // Variable untuk peta
      let map = null;
      let mapMarkers = [];
      let currentView = "map";
      let currentFarmMarker = null;

      // Inisialisasi DataTable
      $(document).ready(function () {
        $("#historyDataTable").DataTable({
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
          responsive: true
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const komoditasValue = $("#filterKomoditas").val();
          const periodeValue = $("#filterPeriode").val();
          let searchTerm = "";

          if (komoditasValue === "all" && periodeValue === "all") {
            $("#historyDataTable").DataTable().search("").draw();
            return;
          }

          // Filter berdasarkan komoditas
          if (komoditasValue !== "all") {
            let komoditasTerm = "";
            switch (komoditasValue) {
              case "sapi_potong":
                komoditasTerm = "Sapi Potong";
                break;
              case "ayam_petelur":
                komoditasTerm = "Ayam Ras Petelur";
                break;
              case "ayam_kampung":
                komoditasTerm = "Ayam Kampung";
                break;
              case "kambing":
                komoditasTerm = "Kambing";
                break;
              case "itik":
                komoditasTerm = "Itik";
                break;
            }
            searchTerm += komoditasTerm;
          }

          // Filter berdasarkan periode (tahun)
          if (periodeValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += periodeValue;
          }

          $("#historyDataTable").DataTable().search(searchTerm).draw();
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterKomoditas").val("all");
          $("#filterPeriode").val("all");
          $("#historyDataTable").DataTable().search("").draw();
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

      // Function to show map directly when "Lihat Peta" is clicked
      function showMap(komoditas, peternak, coordinates) {
        // Parse coordinates
        const [lat, lng] = coordinates
          .split(",")
          .map((coord) => parseFloat(coord.trim()));

        // Update map title and info
        $("#mapTitle").text(
          `Peta Lokasi Ternak ${komoditas}, Peternak: ${peternak}`,
        );
        $("#mapInfo").html(`
          <div class="row">
            <div class="col-md-6">
              <span class="fw-bold">Peternak:</span> ${peternak}<br>
              <span class="fw-bold">Komoditas:</span> ${komoditas}
            </div>
            <div class="col-md-6">
              <span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br>
              <span class="fw-bold">Tanggal Update:</span> Terbaru
            </div>
          </div>
        `);

        // Update farm info
        $("#farmInfo").html(`
          <div class="mb-2">
            <span class="fw-bold">Nama Peternak:</span><br>
            <span class="text-primary fw-bold">${peternak}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Komoditas:</span><br>
            <span class="badge bg-primary">${komoditas}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Jumlah Ternak:</span><br>
            <span class="fw-bold">5 Ekor</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Status:</span><br>
            <span class="badge bg-success">Aktif</span>
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

        // Initialize or update map
        if (!map) {
          // Pastikan map container sudah siap
          $("#mapContainer").css("height", "500px");

          // Inisialisasi peta dengan delay kecil untuk memastikan DOM siap
          setTimeout(() => {
            map = L.map("mapContainer", {
              zoomControl: false, // Nonaktifkan kontrol zoom default
              attributionControl: false, // Nonaktifkan atribusi default
            }).setView([lat, lng], 15);

            // Tambahkan kontrol zoom custom
            L.control
              .zoom({
                position: "topright",
              })
              .addTo(map);

            // Tambahkan atribusi di pojok kanan bawah
            L.control
              .attribution({
                position: "bottomright",
              })
              .addTo(map)
              .addAttribution("© OpenStreetMap contributors");

            updateMapView();

            // Buat custom icon untuk peternakan
            const farmIcon = L.divIcon({
              html: `<div style="background-color: #1a73e8; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
              className: "farm-marker",
              iconSize: [30, 30],
              iconAnchor: [15, 15],
            });

            // Add marker untuk lokasi peternak
            currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(
              map,
            );
            currentFarmMarker
              .bindPopup(
                `
              <div style="min-width: 200px;">
                <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${peternak}</h5>
                <hr style="margin: 5px 0;">
                <div style="margin-bottom: 3px;"><strong>Komoditas:</strong> ${komoditas}</div>
                <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                <div style="margin-bottom: 3px;"><strong>Jumlah Ternak:</strong> 5 Ekor</div>
                <div style="text-align: center; margin-top: 8px;">
                  <small class="text-muted">Klik di luar popup untuk menutup</small>
                </div>
              </div>
            `,
              )
              .openPopup();
            mapMarkers.push(currentFarmMarker);

            // Add circle untuk menunjukkan area
            const circle = L.circle([lat, lng], {
              color: "#1a73e8",
              fillColor: "#1a73e8",
              fillOpacity: 0.1,
              radius: 500,
            }).addTo(map);
            mapMarkers.push(circle);

            // Trigger resize untuk memastikan peta dirender dengan benar
            setTimeout(() => {
              map.invalidateSize();
            }, 100);
          }, 100);
        } else {
          // Hapus marker lama jika ada
          mapMarkers.forEach((marker) => map.removeLayer(marker));
          mapMarkers = [];

          // Pindahkan view ke lokasi baru
          map.setView([lat, lng], 15);

          // Buat custom icon untuk peternakan
          const farmIcon = L.divIcon({
            html: `<div style="background-color: #1a73e8; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 14px;">P</div>`,
            className: "farm-marker",
            iconSize: [30, 30],
            iconAnchor: [15, 15],
          });

          // Add marker untuk lokasi peternak
          currentFarmMarker = L.marker([lat, lng], { icon: farmIcon }).addTo(
            map,
          );
          currentFarmMarker
            .bindPopup(
              `
            <div style="min-width: 200px;">
              <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${peternak}</h5>
              <hr style="margin: 5px 0;">
              <div style="margin-bottom: 3px;"><strong>Komoditas:</strong> ${komoditas}</div>
              <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
              <div style="margin-bottom: 3px;"><strong>Jumlah Ternak:</strong> 5 Ekor</div>
              <div style="text-align: center; margin-top: 8px;">
                <small class="text-muted">Klik di luar popup untuk menutup</small>
              </div>
            </div>
          `,
            )
            .openPopup();
          mapMarkers.push(currentFarmMarker);

          // Add circle untuk menunjukkan area
          const circle = L.circle([lat, lng], {
            color: "#1a73e8",
            fillColor: "#1a73e8",
            fillOpacity: 0.1,
            radius: 500,
          }).addTo(map);
          mapMarkers.push(circle);

          // Trigger resize
          setTimeout(() => {
            map.invalidateSize();
          }, 50);
        }

        // Show map section
        $("#mapSection").show();
        $("#detailSection").hide();

        // Scroll to map section
        $("html, body").animate(
          {
            scrollTop: $("#mapSection").offset().top - 20,
          },
          500,
        );

        // Trigger resize peta setelah ditampilkan
        setTimeout(() => {
          if (map) {
            map.invalidateSize();
          }
        }, 300);
      }

      // Function to update map view (map/satellite)
      function updateMapView() {
        if (!map) return;

        // Clear existing tiles
        map.eachLayer((layer) => {
          if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
          }
        });

        // Add new tile layer based on current view
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

        // Re-add markers
        mapMarkers.forEach((marker) => {
          if (marker instanceof L.Circle) {
            map.addLayer(marker);
          } else if (marker instanceof L.Marker) {
            map.addLayer(marker);
          }
        });

        // Trigger resize
        setTimeout(() => {
          map.invalidateSize();
        }, 50);
      }
    </script>
  </body>
</html>