<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Klinik Hewan</title>
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
        background: linear-gradient(90deg: #1a73e8 0%, #0d47a1 100%);
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
        background: linear-gradient(90deg: #1a73e8 0%, #0d47a1 100%);
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
      .badge-ijin {
        background-color: #d4edda;
        color: #155724;
      }
      .badge-belum-ijin {
        background-color: #f8d7da;
        color: #721c24;
      }
      
      /* Card untuk layanan */
      .layanan-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 8px 12px;
        margin-right: 5px;
        margin-bottom: 5px;
        background-color: #e7f1ff;
        display: inline-block;
        font-size: 12px;
      }
      
      /* Gallery foto */
      .clinic-photo {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
      }
      .photo-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        cursor: pointer;
        margin-right: 5px;
        margin-bottom: 5px;
      }
      .photo-thumbnail:hover {
        opacity: 0.8;
        border: 2px solid #1a73e8;
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
                    <li>
                      <a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a>
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
                      <a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link"
                        >Penjual Pakan Ternak</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_klinik') ?>" class="nav-link active"
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
                <h3 class="fw-bold mb-1">Data Klinik Hewan</h3>
                <h6 class="op-7 mb-0">
                  Manajemen data klinik hewan di Kota Surabaya
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
                      <option value="genteng">Genteng</option>
                      <option value="tegalsari">Tegalsari</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterIjin" class="form-label fw-bold">
                      Filter Status Ijin:
                    </label>
                    <select class="form-select" id="filterIjin">
                      <option selected value="all">Semua Status</option>
                      <option value="Y">Memiliki Ijin</option>
                      <option value="N">Belum Memiliki Ijin</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterLayanan" class="form-label fw-bold">
                      Filter Jenis Layanan:
                    </label>
                    <select class="form-select" id="filterLayanan">
                      <option selected value="all">Semua Layanan</option>
                      <option value="24 Jam">24 Jam</option>
                      <option value="Praktek Umum">Praktek Umum</option>
                      <option value="Spesialis">Spesialis</option>
                      <option value="Gawat Darurat">Gawat Darurat</option>
                      <option value="Rawat Inap">Rawat Inap</option>
                      <option value="Laboratorium">Laboratorium</option>
                      <option value="Bedah">Bedah</option>
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
                  <table id="klinikTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Klinik</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Alamat / RT/RW</th>
                        <th>Kontak</th>
                        <th>Jumlah Dokter</th>
                        <th>Jenis Layanan</th>
                        <th>Status Ijin</th>
                        <th>Koordinat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data Klinik Hewan sesuai dengan struktur database -->
                      <tr>
                        <td>1</td>
                        <td>
                          <span class="fw-bold">Klinik Hewan Satwa Sehat</span>
                          <br>
                          <small class="text-muted">Praktek Umum & Spesialis</small>
                        </td>
                        <td>Sukolilo</td>
                        <td>Keputih</td>
                        <td>
                          Jl. Raya ITS No. 45<br>
                          <small>RT 005/RW 003</small>
                        </td>
                        <td>
                          <div>031-5945678</div>
                          <small>081234567890</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">4 Dokter</span>
                        </td>
                        <td>24 Jam, Rawat Inap, Bedah</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1 text-muted">-7.2876, 112.7891</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Hewan Satwa Sehat',
                                'Sukolilo',
                                'Keputih',
                                '-7.2876, 112.7891',
                                'Jl. Raya ITS No. 45, RT 005/RW 003',
                                '031-5945678',
                                '4',
                                '24 Jam, Rawat Inap, Bedah',
                                'Y',
                                'klinik1.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Klinik Drh. Soeparno</span>
                          <br>
                          <small class="text-muted">Praktek Umum</small>
                        </td>
                        <td>Rungkut</td>
                        <td>Rungkut Kidul</td>
                        <td>
                          Jl. Raya Rungkut Industri No. 78<br>
                          <small>RT 002/RW 005</small>
                        </td>
                        <td>
                          <div>031-8723456</div>
                          <small>082345678901</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">2 Dokter</span>
                        </td>
                        <td>Praktek Umum, Vaksinasi</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.3265, 112.7683</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Drh. Soeparno',
                                'Rungkut',
                                'Rungkut Kidul',
                                '-7.3265, 112.7683',
                                'Jl. Raya Rungkut Industri No. 78, RT 002/RW 005',
                                '031-8723456',
                                '2',
                                'Praktek Umum, Vaksinasi',
                                'Y',
                                'klinik2.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Surabaya Veterinary Clinic</span>
                          <br>
                          <small class="text-muted">24 Jam & Spesialis</small>
                        </td>
                        <td>Gubeng</td>
                        <td>Gubeng</td>
                        <td>
                          Jl. Gubeng Raya No. 112<br>
                          <small>RT 001/RW 002</small>
                        </td>
                        <td>
                          <div>031-5034567</div>
                          <small>083456789012</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">6 Dokter</span>
                        </td>
                        <td>24 Jam, Spesialis, Bedah, Lab</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2667, 112.7500</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Surabaya Veterinary Clinic',
                                'Gubeng',
                                'Gubeng',
                                '-7.2667, 112.7500',
                                'Jl. Gubeng Raya No. 112, RT 001/RW 002',
                                '031-5034567',
                                '6',
                                '24 Jam, Spesialis, Bedah, Lab',
                                'Y',
                                'klinik3.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Klinik Hewan Kenari</span>
                          <br>
                          <small class="text-muted">Praktek Umum</small>
                        </td>
                        <td>Wonokromo</td>
                        <td>Wonokromo</td>
                        <td>
                          Jl. Kenari No. 34<br>
                          <small>RT 003/RW 004</small>
                        </td>
                        <td>
                          <div>031-7256789</div>
                          <small>084567890123</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">3 Dokter</span>
                        </td>
                        <td>Praktek Umum, Vaksinasi</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2953, 112.7389</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Hewan Kenari',
                                'Wonokromo',
                                'Wonokromo',
                                '-7.2953, 112.7389',
                                'Jl. Kenari No. 34, RT 003/RW 004',
                                '031-7256789',
                                '3',
                                'Praktek Umum, Vaksinasi',
                                'Y',
                                'klinik4.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Puskeswan Mulyorejo</span>
                          <br>
                          <small class="text-muted">Pusat Kesehatan Hewan</small>
                        </td>
                        <td>Mulyorejo</td>
                        <td>Kalisari</td>
                        <td>
                          Jl. Mulyorejo Utara No. 56<br>
                          <small>RT 002/RW 006</small>
                        </td>
                        <td>
                          <div>031-5961234</div>
                          <small>085678901234</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">5 Dokter</span>
                        </td>
                        <td>Praktek Umum, Lab, Vaksinasi</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2621, 112.7915</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Puskeswan Mulyorejo',
                                'Mulyorejo',
                                'Kalisari',
                                '-7.2621, 112.7915',
                                'Jl. Mulyorejo Utara No. 56, RT 002/RW 006',
                                '031-5961234',
                                '5',
                                'Praktek Umum, Lab, Vaksinasi',
                                'Y',
                                'klinik5.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Klinik Hewan Tandes</span>
                          <br>
                          <small class="text-muted">Praktek Umum</small>
                        </td>
                        <td>Tandes</td>
                        <td>Balongsari</td>
                        <td>
                          Jl. Tandes No. 89<br>
                          <small>RT 004/RW 002</small>
                        </td>
                        <td>
                          <div>031-7112345</div>
                          <small>086789012345</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">2 Dokter</span>
                        </td>
                        <td>Praktek Umum</td>
                        <td>
                          <span class="badge badge-status badge-belum-ijin">N</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2439, 112.6816</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Hewan Tandes',
                                'Tandes',
                                'Balongsari',
                                '-7.2439, 112.6816',
                                'Jl. Tandes No. 89, RT 004/RW 002',
                                '031-7112345',
                                '2',
                                'Praktek Umum',
                                'N',
                                'klinik6.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Klinik Hewan Genteng</span>
                          <br>
                          <small class="text-muted">Praktek Umum & Rawat Inap</small>
                        </td>
                        <td>Genteng</td>
                        <td>Genteng</td>
                        <td>
                          Jl. Genteng Besar No. 23<br>
                          <small>RT 001/RW 003</small>
                        </td>
                        <td>
                          <div>031-5345678</div>
                          <small>087890123456</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">3 Dokter</span>
                        </td>
                        <td>Praktek Umum, Rawat Inap</td>
                        <td>
                          <span class="badge badge-status badge-ijin">Y</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2581, 112.7394</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Hewan Genteng',
                                'Genteng',
                                'Genteng',
                                '-7.2581, 112.7394',
                                'Jl. Genteng Besar No. 23, RT 001/RW 003',
                                '031-5345678',
                                '3',
                                'Praktek Umum, Rawat Inap',
                                'Y',
                                'klinik7.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                          <span class="fw-bold">Klinik Hewan Tegalsari</span>
                          <br>
                          <small class="text-muted">Praktek Umum</small>
                        </td>
                        <td>Tegalsari</td>
                        <td>Keputran</td>
                        <td>
                          Jl. Tegalsari No. 67<br>
                          <small>RT 002/RW 005</small>
                        </td>
                        <td>
                          <div>031-5489012</div>
                          <small>088901234567</small>
                        </td>
                        <td>
                          <span class="badge bg-info text-white">2 Dokter</span>
                        </td>
                        <td>Praktek Umum, Vaksinasi</td>
                        <td>
                          <span class="badge badge-status badge-belum-ijin">N</span>
                        </td>
                        <td>
                          <div>
                            <div class="mb-1">-7.2815, 112.7322</div>
                            <button
                              class="btn btn-sm btn-outline-primary"
                              onclick="showMap(
                                'Klinik Hewan Tegalsari',
                                'Tegalsari',
                                'Keputran',
                                '-7.2815, 112.7322',
                                'Jl. Tegalsari No. 67, RT 002/RW 005',
                                '031-5489012',
                                '2',
                                'Praktek Umum, Vaksinasi',
                                'N',
                                'klinik8.jpg'
                              )"
                            >
                              <i class="fas fa-map-marker-alt me-1"></i>Lihat
                              Peta
                            </button>
                          </div>
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
                  Detail Klinik Hewan
                </h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Foto Klinik</h6>
                    </div>
                    <div class="card-body text-center">
                      <img id="detailFoto" src="" alt="Foto Klinik" class="clinic-photo mb-2">
                      <div id="detailThumbnails" class="mt-2">
                        <!-- Thumbnails will be inserted here -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi Klinik</h6>
                    </div>
                    <div class="card-body" id="detailKlinikInfo">
                      <!-- Informasi klinik akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Informasi Lokasi</h6>
                </div>
                <div class="card-body" id="detailLokasiInfo">
                  <!-- Informasi lokasi akan diisi oleh JavaScript -->
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Keterangan & Surat Ijin</h6>
                </div>
                <div class="card-body" id="detailIjinInfo">
                  <!-- Informasi ijin akan diisi oleh JavaScript -->
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
                  Peta Lokasi Klinik Hewan
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
                            <i class="fas fa-clinic-medical me-1"></i> Informasi Klinik
                          </h6>
                        </div>
                        <div class="card-body p-3" id="clinicInfo">
                          <!-- Informasi klinik akan diisi oleh JavaScript -->
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

                  <!-- Informasi Layanan -->
                  <div class="card mt-3">
                    <div class="card-header bg-primary text-white py-2">
                      <h6 class="mb-0">
                        <i class="fas fa-stethoscope me-1"></i> Jenis Layanan
                      </h6>
                    </div>
                    <div class="card-body p-3" id="layananInfo">
                      <!-- Layanan akan diisi oleh JavaScript -->
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
      // Data untuk detail klinik sesuai dengan struktur database
      const klinikDetailData = {
        1: {
          nama_klinik: "Klinik Hewan Satwa Sehat",
          keterangan: "Klinik hewan dengan layanan lengkap 24 jam. Dilengkapi dengan fasilitas rawat inap dan ruang operasi. Melayani berbagai jenis hewan kesayangan dan ternak.",
          kecamatan: "Sukolilo",
          kelurahan: "Keputih",
          rt: "005",
          rw: "003",
          latitude: "-7.2876",
          longitude: "112.7891",
          telp: "031-5945678",
          jumlah_dokter: "4",
          jenis_layanan: "24 Jam, Rawat Inap, Bedah",
          foto_klinik: "klinik1.jpg",
          surat_ijin: "Y",
          created_at: "2020-05-15"
        },
        2: {
          nama_klinik: "Klinik Drh. Soeparno",
          keterangan: "Klinik praktek umum untuk hewan kesayangan. Fokus pada pelayanan vaksinasi dan pengobatan rutin.",
          kecamatan: "Rungkut",
          kelurahan: "Rungkut Kidul",
          rt: "002",
          rw: "005",
          latitude: "-7.3265",
          longitude: "112.7683",
          telp: "031-8723456",
          jumlah_dokter: "2",
          jenis_layanan: "Praktek Umum, Vaksinasi",
          foto_klinik: "klinik2.jpg",
          surat_ijin: "Y",
          created_at: "2019-08-20"
        },
        3: {
          nama_klinik: "Surabaya Veterinary Clinic",
          keterangan: "Klinik hewan spesialis dengan peralatan modern. Menyediakan layanan bedah, laboratorium, dan konsultasi spesialis.",
          kecamatan: "Gubeng",
          kelurahan: "Gubeng",
          rt: "001",
          rw: "002",
          latitude: "-7.2667",
          longitude: "112.7500",
          telp: "031-5034567",
          jumlah_dokter: "6",
          jenis_layanan: "24 Jam, Spesialis, Bedah, Lab",
          foto_klinik: "klinik3.jpg",
          surat_ijin: "Y",
          created_at: "2018-03-10"
        },
        4: {
          nama_klinik: "Klinik Hewan Kenari",
          keterangan: "Klinik hewan yang berlokasi di pusat kota, melayani pengobatan umum dan vaksinasi untuk hewan kesayangan.",
          kecamatan: "Wonokromo",
          kelurahan: "Wonokromo",
          rt: "003",
          rw: "004",
          latitude: "-7.2953",
          longitude: "112.7389",
          telp: "031-7256789",
          jumlah_dokter: "3",
          jenis_layanan: "Praktek Umum, Vaksinasi",
          foto_klinik: "klinik4.jpg",
          surat_ijin: "Y",
          created_at: "2021-01-05"
        },
        5: {
          nama_klinik: "Puskeswan Mulyorejo",
          keterangan: "Pusat Kesehatan Hewan milik pemerintah yang melayani masyarakat dengan tarif terjangkau. Menyediakan layanan kesehatan hewan dan penyuluhan.",
          kecamatan: "Mulyorejo",
          kelurahan: "Kalisari",
          rt: "002",
          rw: "006",
          latitude: "-7.2621",
          longitude: "112.7915",
          telp: "031-5961234",
          jumlah_dokter: "5",
          jenis_layanan: "Praktek Umum, Lab, Vaksinasi",
          foto_klinik: "klinik5.jpg",
          surat_ijin: "Y",
          created_at: "2017-11-12"
        },
        6: {
          nama_klinik: "Klinik Hewan Tandes",
          keterangan: "Klinik hewan sederhana yang melayani pengobatan umum untuk hewan ternak dan kesayangan di wilayah Tandes.",
          kecamatan: "Tandes",
          kelurahan: "Balongsari",
          rt: "004",
          rw: "002",
          latitude: "-7.2439",
          longitude: "112.6816",
          telp: "031-7112345",
          jumlah_dokter: "2",
          jenis_layanan: "Praktek Umum",
          foto_klinik: "klinik6.jpg",
          surat_ijin: "N",
          created_at: "2022-02-18"
        },
        7: {
          nama_klinik: "Klinik Hewan Genteng",
          keterangan: "Klinik hewan dengan fasilitas rawat inap yang nyaman. Melayani konsultasi dan pengobatan untuk hewan kesayangan.",
          kecamatan: "Genteng",
          kelurahan: "Genteng",
          rt: "001",
          rw: "003",
          latitude: "-7.2581",
          longitude: "112.7394",
          telp: "031-5345678",
          jumlah_dokter: "3",
          jenis_layanan: "Praktek Umum, Rawat Inap",
          foto_klinik: "klinik7.jpg",
          surat_ijin: "Y",
          created_at: "2020-09-30"
        },
        8: {
          nama_klinik: "Klinik Hewan Tegalsari",
          keterangan: "Klinik hewan yang sedang dalam proses pengurusan ijin. Saat ini melayani pengobatan umum terbatas.",
          kecamatan: "Tegalsari",
          kelurahan: "Keputran",
          rt: "002",
          rw: "005",
          latitude: "-7.2815",
          longitude: "112.7322",
          telp: "031-5489012",
          jumlah_dokter: "2",
          jenis_layanan: "Praktek Umum, Vaksinasi",
          foto_klinik: "klinik8.jpg",
          surat_ijin: "N",
          created_at: "2023-03-25"
        }
      };

      // Variable untuk peta
      let map = null;
      let mapMarkers = [];
      let currentView = "map";
      let currentClinicMarker = null;

      // Inisialisasi DataTable
      $(document).ready(function () {
        $("#klinikTable").DataTable({
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
            { targets: [9], orderable: false }, // Kolom koordinat tidak bisa diurutkan
            { targets: [10], orderable: false } // Kolom aksi tidak bisa diurutkan
          ]
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const kecamatanValue = $("#filterKecamatan").val();
          const ijinValue = $("#filterIjin").val();
          const layananValue = $("#filterLayanan").val();
          
          let searchTerm = "";

          if (kecamatanValue === "all" && ijinValue === "all" && layananValue === "all") {
            $("#klinikTable").DataTable().search("").draw();
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
              case "genteng": kecamatanTerm = "Genteng"; break;
              case "tegalsari": kecamatanTerm = "Tegalsari"; break;
            }
            searchTerm += kecamatanTerm;
          }

          // Filter berdasarkan status ijin
          if (ijinValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += (ijinValue === "Y") ? "Y" : "N";
          }

          // Filter berdasarkan jenis layanan
          if (layananValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += layananValue;
          }

          $("#klinikTable").DataTable().search(searchTerm).draw();
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterKecamatan").val("all");
          $("#filterIjin").val("all");
          $("#filterLayanan").val("all");
          $("#klinikTable").DataTable().search("").draw();
        });

        // Tambah data button event
        $("#btnTambahData").click(function(e) {
          e.preventDefault();
          alert("Fitur tambah data akan segera tersedia!");
          // window.location.href = "<?php echo base_url(); ?>data_klinik/tambah";
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
          if (map && currentClinicMarker) {
            const latlng = currentClinicMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
          }
        });
      });

      // Function to show map
      function showMap(namaKlinik, kecamatan, kelurahan, coordinates, alamat, telp, jumlahDokter, jenisLayanan, suratIjin, foto) {
        // Parse coordinates
        const [lat, lng] = coordinates
          .split(",")
          .map((coord) => parseFloat(coord.trim()));

        // Update map title and info
        $("#mapTitle").text(`Peta Lokasi ${namaKlinik}`);
        $("#mapInfo").html(`
          <div class="row">
            <div class="col-md-6">
              <span class="fw-bold">Klinik:</span> ${namaKlinik}<br>
              <span class="fw-bold">Kecamatan:</span> ${kecamatan}<br>
              <span class="fw-bold">Kelurahan:</span> ${kelurahan}
            </div>
            <div class="col-md-6">
              <span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br>
              <span class="fw-bold">Telepon:</span> ${telp}<br>
              <span class="fw-bold">Status Ijin:</span> <span class="badge ${suratIjin === 'Y' ? 'badge-ijin' : 'badge-belum-ijin'}">${suratIjin === 'Y' ? 'Memiliki Ijin' : 'Belum Ijin'}</span>
            </div>
          </div>
        `);

        // Update clinic info
        $("#clinicInfo").html(`
          <div class="mb-2">
            <span class="fw-bold">Nama Klinik:</span><br>
            <span class="text-primary fw-bold">${namaKlinik}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kecamatan/Kelurahan:</span><br>
            ${kecamatan} - ${kelurahan}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Alamat:</span><br>
            ${alamat}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kontak:</span><br>
            <i class="fas fa-phone-alt me-1"></i> ${telp}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Jumlah Dokter:</span><br>
            <span class="badge bg-info">${jumlahDokter} Dokter</span>
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
            <span class="fw-bold">RT/RW:</span><br>
            <code>${alamat.split('RT')[1] ? 'RT' + alamat.split('RT')[1].split(',')[0] : '-'}</code>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Format Koordinat:</span><br>
            <small>DD (Decimal Degrees)</small>
          </div>
        `);

        // Update layanan info
        let layananArray = jenisLayanan.split(',');
        let layananHtml = '<div class="row">';
        layananArray.forEach(layanan => {
          layananHtml += `
            <div class="col-md-3">
              <div class="layanan-card">
                <i class="fas fa-check-circle text-success me-1"></i>${layanan.trim()}
              </div>
            </div>
          `;
        });
        layananHtml += '</div>';
        $("#layananInfo").html(layananHtml);

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

            // Custom icon untuk klinik (warna biru dengan simbol +)
            const clinicIcon = L.divIcon({
              html: `<div style="background-color: #0d6efd; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 18px;">+</div>`,
              className: "clinic-marker",
              iconSize: [36, 36],
              iconAnchor: [18, 18],
            });

            // Add marker
            currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
            currentClinicMarker
              .bindPopup(
                `
              <div style="min-width: 250px;">
                <h5 style="margin: 0 0 5px 0; color: #0d6efd; text-align: center;">${namaKlinik}</h5>
                <hr style="margin: 5px 0;">
                <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${alamat}</div>
                <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${kecamatan}</div>
                <div style="margin-bottom: 3px;"><strong>Kelurahan:</strong> ${kelurahan}</div>
                <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${telp}</div>
                <div style="margin-bottom: 3px;"><strong>Dokter:</strong> ${jumlahDokter} orang</div>
                <div style="text-align: center; margin-top: 8px;">
                  <small class="text-muted">Klik di luar popup untuk menutup</small>
                </div>
              </div>
            `,
              )
              .openPopup();
            mapMarkers.push(currentClinicMarker);

            // Add circle area
            const circle = L.circle([lat, lng], {
              color: "#0d6efd",
              fillColor: "#0d6efd",
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

          const clinicIcon = L.divIcon({
            html: `<div style="background-color: #0d6efd; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 18px;">+</div>`,
            className: "clinic-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18],
          });

          currentClinicMarker = L.marker([lat, lng], { icon: clinicIcon }).addTo(map);
          currentClinicMarker
            .bindPopup(
              `
            <div style="min-width: 250px;">
              <h5 style="margin: 0 0 5px 0; color: #0d6efd; text-align: center;">${namaKlinik}</h5>
              <hr style="margin: 5px 0;">
              <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${alamat}</div>
              <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${kecamatan}</div>
              <div style="margin-bottom: 3px;"><strong>Kelurahan:</strong> ${kelurahan}</div>
              <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
              <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${telp}</div>
              <div style="margin-bottom: 3px;"><strong>Dokter:</strong> ${jumlahDokter} orang</div>
              <div style="text-align: center; margin-top: 8px;">
                <small class="text-muted">Klik di luar popup untuk menutup</small>
              </div>
            </div>
          `,
            )
            .openPopup();
          mapMarkers.push(currentClinicMarker);

          const circle = L.circle([lat, lng], {
            color: "#0d6efd",
            fillColor: "#0d6efd",
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
        const data = klinikDetailData[id];
        if (!data) {
          alert("Data tidak ditemukan");
          return;
        }

        $("#detailTitle").text(`Detail Klinik: ${data.nama_klinik}`);
        
        let statusIjin = data.surat_ijin === 'Y' ? 
          '<span class="badge badge-status badge-ijin">Memiliki Ijin</span>' : 
          '<span class="badge badge-status badge-belum-ijin">Belum Memiliki Ijin</span>';
        
        $("#detailInfo").html(`
          ${statusIjin}
          <span class="ms-2">Terdaftar: ${data.created_at}</span>
        `);

        // Foto Klinik
        $("#detailFoto").attr("src", "<?php echo base_url(); ?>assets/images/klinik/" + data.foto_klinik)
          .attr("alt", data.nama_klinik);
        
        $("#detailThumbnails").html(`
          <img src="<?php echo base_url(); ?>assets/images/klinik/${data.foto_klinik}" class="photo-thumbnail" onclick="$('#detailFoto').attr('src', this.src)">
        `);

        // Informasi Klinik
        $("#detailKlinikInfo").html(`
          <table class="table table-sm table-borderless">
            <tr>
              <td width="35%"><strong>Nama Klinik</strong></td>
              <td>: ${data.nama_klinik}</td>
            </tr>
            <tr>
              <td><strong>Kecamatan</strong></td>
              <td>: ${data.kecamatan}</td>
            </tr>
            <tr>
              <td><strong>Kelurahan</strong></td>
              <td>: ${data.kelurahan}</td>
            </tr>
            <tr>
              <td><strong>RT/RW</strong></td>
              <td>: RT ${data.rt} / RW ${data.rw}</td>
            </tr>
            <tr>
              <td><strong>Telepon</strong></td>
              <td>: ${data.telp}</td>
            </tr>
            <tr>
              <td><strong>Jumlah Dokter</strong></td>
              <td>: ${data.jumlah_dokter} orang</td>
            </tr>
            <tr>
              <td><strong>Jenis Layanan</strong></td>
              <td>: ${data.jenis_layanan}</td>
            </tr>
          </table>
        `);

        // Informasi Lokasi
        $("#detailLokasiInfo").html(`
          <div class="row">
            <div class="col-md-6">
              <table class="table table-sm table-borderless">
                <tr>
                  <td width="40%"><strong>Latitude</strong></td>
                  <td>: <code>${data.latitude}</code></td>
                </tr>
                <tr>
                  <td><strong>Longitude</strong></td>
                  <td>: <code>${data.longitude}</code></td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <button class="btn btn-sm btn-primary" onclick="showMap(
                '${data.nama_klinik}',
                '${data.kecamatan}',
                '${data.kelurahan}',
                '${data.latitude}, ${data.longitude}',
                '${data.kelurahan}, RT ${data.rt}/RW ${data.rw}',
                '${data.telp}',
                '${data.jumlah_dokter}',
                '${data.jenis_layanan}',
                '${data.surat_ijin}',
                '${data.foto_klinik}'
              )">
                <i class="fas fa-map-marker-alt me-1"></i>Lihat di Peta
              </button>
            </div>
          </div>
        `);

        // Informasi Ijin
        let ijinStatus = data.surat_ijin === 'Y' ? 
          '<span class="text-success fw-bold">✓ Memiliki Surat Ijin Praktek</span>' : 
          '<span class="text-danger fw-bold">✗ Belum Memiliki Surat Ijin Praktek</span>';
        
        $("#detailIjinInfo").html(`
          <div class="mb-3">
            <strong>Status Ijin:</strong><br>
            ${ijinStatus}
          </div>
          <div class="mb-3">
            <strong>Keterangan:</strong><br>
            <p class="text-muted">${data.keterangan}</p>
          </div>
        `);

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