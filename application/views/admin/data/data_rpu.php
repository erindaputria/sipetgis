<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Rumah Potong Unggas (RPU)</title>
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
      .badge-ekor {
        background-color: #e8f5e9;
        color: #2e7d32;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-berat {
        background-color: #fff3e0;
        color: #f57c00;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-asal {
        background-color: #e1f5fe;
        color: #0288d1;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
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
      
      /* Card untuk komoditas */
      .komoditas-card {
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
      .rpu-photo {
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
      
      /* Statistik cards */
      .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a73e8;
      }
      .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
      }
      
      /* Filter periode */
      .periode-input {
        max-width: 150px;
        display: inline-block;
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
                      <a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a>
                    </li>
                    <li>
                       <a href="<?= site_url('obat') ?>" class="nav-link">Obat</a>
                    </li>
                    <li>
                      <a href="<?= site_url('vaksin') ?>" class="nav-link">Vaksin</a>
                    </li>
                    <li>
                      <a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a>
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
                <h3 class="fw-bold mb-1">Data Rumah Potong Unggas (RPU)</h3>
                <h6 class="op-7 mb-0">
                  Manajemen data kegiatan pemotongan unggas di Kota Surabaya
                </h6>
              </div>
            </div>

        

            <!-- Filter Section -->
            <div class="filter-section">
              <div class="row align-items-center">
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterPejagal" class="form-label fw-bold">
                      Filter RPU:
                    </label>
                    <select class="form-select" id="filterPejagal">
                      <option selected value="all">Semua RPU</option>
                      <?php if (!empty($pejagal_list)): ?>
                        <?php foreach ($pejagal_list as $p): ?>
                          <option value="<?php echo htmlspecialchars($p['pejagal']); ?>">
                            <?php echo htmlspecialchars($p['pejagal']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterKomoditas" class="form-label fw-bold">
                      Filter Komoditas:
                    </label>
                    <select class="form-select" id="filterKomoditas">
                      <option selected value="all">Semua Komoditas</option>
                      <?php if (!empty($komoditas_list)): ?>
                        <?php foreach ($komoditas_list as $k): ?>
                          <option value="<?php echo htmlspecialchars($k['komoditas']); ?>">
                            <?php echo htmlspecialchars($k['komoditas']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterKecamatan" class="form-label fw-bold">
                      Filter Kecamatan:
                    </label>
                    <select class="form-select" id="filterKecamatan">
                      <option selected value="all">Semua Kecamatan</option>
                      <?php if (!empty($kecamatan_list)): ?>
                        <?php foreach ($kecamatan_list as $k): ?>
                          <option value="<?php echo htmlspecialchars($k['kecamatan']); ?>">
                            <?php echo htmlspecialchars($k['kecamatan']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group mb-0">
                    <label for="filterPeriode" class="form-label fw-bold">
                      Filter Periode:
                    </label>
                    <div class="d-flex">
                      <input type="date" id="startDate" class="form-control form-control-sm periode-input me-1" value="<?php echo date('Y-m-01'); ?>">
                      <span class="mx-1 align-self-center">-</span>
                      <input type="date" id="endDate" class="form-control form-control-sm periode-input ms-1" value="<?php echo date('Y-m-t'); ?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 text-end">
                  <button id="filterBtn" class="btn btn-primary mt-4">
                    <i class="fas fa-filter me-2"></i>Filter
                  </button>
                  <button id="resetBtn" class="btn btn-outline-secondary mt-4">
                    <i class="fas fa-redo me-2"></i>Reset
                  </button>
                </div>
              </div>
            </div>

            <!-- Data Table -->
            <div class="card stat-card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="rpuTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>RPU/Pejagal</th>
                        <th>Penanggung Jawab</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Komoditas (Ekor/Berat)</th>
                        <th>Total</th>
                        <th>Koordinat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($rpu_data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($rpu_data as $data): ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo isset($data['tanggal_rpu']) ? date('d-m-Y', strtotime($data['tanggal_rpu'])) : '-'; ?></td>
                            <td>
                              <span class="fw-bold"><?php echo htmlspecialchars($data['pejagal'] ?? '-'); ?></span>
                              <br>
                              <small class="text-muted">Petugas: <?php echo htmlspecialchars($data['nama_petugas'] ?? '-'); ?></small>
                            </td>
                            <td>
                              <?php echo htmlspecialchars($data['nama_pj'] ?? '-'); ?>
                              <br>
                              <small class="text-muted"><?php echo htmlspecialchars($data['nik_pj'] ?? '-'); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($data['kecamatan'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                            <td>
                              <?php if (!empty($data['komoditas_list'])): ?>
                                <small><?php echo htmlspecialchars($data['komoditas_list']); ?></small>
                              <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <span class="badge-ekor"><?php echo $data['total_ekor'] ?? '0'; ?> ekor</span>
                              <span class="badge-berat"><?php echo number_format($data['total_berat'] ?? 0, 2); ?> kg</span>
                              <br>
                              <span class="badge-asal"><?php echo isset($data['asal_unggas']) ? htmlspecialchars($data['asal_unggas']) : '-'; ?></span>
                            </td>
                            <td>
                              <div>
                                <div class="mb-1 small">
                                  <?php if (!empty($data['latitude']) && !empty($data['longitude'])): ?>
                                    <span class="coord-badge"><?php echo substr($data['latitude'], 0, 8); ?>... , <?php echo substr($data['longitude'], 0, 8); ?>...</span>
                                  <?php else: ?>
                                    <span class="empty-coord">Tidak ada</span>
                                  <?php endif; ?>
                                </div>
                                <?php if (!empty($data['latitude']) && !empty($data['longitude'])): ?>
                                  <button
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="showMap(
                                      '<?php echo addslashes($data['pejagal']); ?>',
                                      '<?php echo addslashes($data['kecamatan']); ?>',
                                      '<?php echo addslashes($data['kelurahan']); ?>',
                                      '<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>',
                                      '<?php echo addslashes($data['lokasi']); ?>',
                                      '<?php echo addslashes($data['telp_pj']); ?>',
                                      '<?php echo $data['total_ekor'] ?? '0'; ?>',
                                      '<?php echo number_format($data['total_berat'] ?? 0, 2); ?>',
                                      '<?php echo addslashes($data['foto_kegiatan']); ?>',
                                      <?php echo $data['id']; ?>
                                    )"
                                  >
                                    <i class="fas fa-map-marker-alt me-1"></i>Lihat Peta
                                  </button>
                                <?php else: ?>
                                  <span class="text-muted small">-</span>
                                <?php endif; ?>
                              </div>
                            </td>
                            <td>
                              <div class="d-flex gap-1">
                                <button
                                  class="btn btn-sm btn-info"
                                  title="Detail Data"
                                  onclick="showDetail(<?php echo $data['id']; ?>)"
                                >
                                  <i class="fas fa-eye"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-warning"
                                  title="Edit Data"
                                  onclick="window.location.href='<?php echo base_url(); ?>p_input_rpu/edit/<?php echo $data['id']; ?>'"
                                >
                                  <i class="fas fa-edit"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-danger"
                                  title="Hapus Data"
                                  onclick="if(confirm('Apakah Anda yakin ingin menghapus data RPU ini?')) window.location.href='<?php echo base_url(); ?>data_rpu/hapus/<?php echo $data['id']; ?>'"
                                >
                                  <i class="fas fa-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="10" class="text-center">Tidak ada data RPU</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Detail Section (Initially Hidden) -->
            <div id="detailSection" class="detail-section" style="display: none">
              <div class="detail-header">
                <h5 class="fw-bold mb-0" id="detailTitle">Detail RPU</h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Foto Kegiatan</h6>
                    </div>
                    <div class="card-body text-center">
                      <img id="detailFoto" src="" alt="Foto Kegiatan" class="rpu-photo mb-2">
                      <div id="detailThumbnails" class="mt-2">
                        <!-- Thumbnails will be inserted here -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi RPU & Penanggung Jawab</h6>
                    </div>
                    <div class="card-body" id="detailRpuInfo">
                      <!-- Informasi RPU akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Informasi Lokasi & Koordinat</h6>
                </div>
                <div class="card-body" id="detailLokasiInfo">
                  <!-- Informasi lokasi akan diisi oleh JavaScript -->
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Data Komoditas Potong</h6>
                </div>
                <div class="card-body" id="detailKomoditasInfo">
                  <!-- Data komoditas akan diisi oleh JavaScript -->
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Keterangan</h6>
                </div>
                <div class="card-body" id="detailKeteranganInfo">
                  <!-- Keterangan akan diisi oleh JavaScript -->
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
                  Peta Lokasi RPU
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
                            <i class="fas fa-store me-1"></i> Informasi RPU
                          </h6>
                        </div>
                        <div class="card-body p-3" id="clinicInfo">
                          <!-- Informasi RPU akan diisi oleh JavaScript -->
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header bg-primary text-white py-2">
                          <h6 class="mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i> Detail Koordinat
                          </h6>
                        </div>
                        <div class="card-body p-3" id="coordInfo">
                          <!-- Informasi koordinat akan diisi oleh JavaScript -->
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Informasi Komoditas -->
                  <div class="card mt-3">
                    <div class="card-header bg-primary text-white py-2">
                      <h6 class="mb-0">
                        <i class="fas fa-drumstick-bite me-1"></i> Komoditas Potong
                      </h6>
                    </div>
                    <div class="card-body p-3" id="komoditasMapInfo">
                      <!-- Komoditas akan diisi oleh JavaScript -->
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
      // Data RPU dari PHP (untuk detail)
      const rpuDetailData = {};
      
      // Variable untuk peta
      let map = null;
      let mapMarkers = [];
      let currentView = "map";
      let currentRpuMarker = null;

      // Inisialisasi DataTable
      $(document).ready(function () {
        // Load statistik
        loadStatistik();
        
        // Initialize DataTable
        $("#rpuTable").DataTable({
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
          order: [[1, 'desc']], // Urut berdasarkan tanggal descending
          columnDefs: [
            { targets: [8], orderable: false }, // Kolom koordinat tidak bisa diurutkan
            { targets: [9], orderable: false } // Kolom aksi tidak bisa diurutkan
          ]
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const pejagalValue = $("#filterPejagal").val();
          const komoditasValue = $("#filterKomoditas").val();
          const kecamatanValue = $("#filterKecamatan").val();
          const startDate = $("#startDate").val();
          const endDate = $("#endDate").val();
          
          let searchTerm = "";

          if (pejagalValue !== "all") {
            searchTerm += pejagalValue;
          }

          if (komoditasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += komoditasValue;
          }

          if (kecamatanValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += kecamatanValue;
          }

          // Filter berdasarkan tanggal menggunakan AJAX
          if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
          } else {
            $("#rpuTable").DataTable().search(searchTerm).draw();
          }
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterPejagal").val("all");
          $("#filterKomoditas").val("all");
          $("#filterKecamatan").val("all");
          $("#startDate").val("<?php echo date('Y-m-01'); ?>");
          $("#endDate").val("<?php echo date('Y-m-t'); ?>");
          $("#rpuTable").DataTable().search("").draw();
          loadStatistik();
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
          if (map && currentRpuMarker) {
            const latlng = currentRpuMarker.getLatLng();
            map.setView([latlng.lat, latlng.lng], 15);
          }
        });
      });

      // Fungsi untuk load statistik
      function loadStatistik() {
        $.ajax({
          url: '<?php echo base_url("data_rpu/get_statistik"); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#totalKegiatan').text(data.total_kegiatan);
            $('#totalEkor').text(data.total_ekor);
            $('#totalBerat').text(data.total_berat.toFixed(2));
            $('#totalPejagal').text(data.total_pejagal);
          }
        });
      }

      // Fungsi untuk filter berdasarkan periode
      function filterByPeriode(startDate, endDate, searchTerm) {
        $.ajax({
          url: '<?php echo base_url("data_rpu/filter_by_periode"); ?>',
          type: 'POST',
          data: {
            start_date: startDate,
            end_date: endDate
          },
          dataType: 'json',
          success: function(response) {
            // Update tabel dengan data baru
            updateTableWithData(response.data, searchTerm);
          }
        });
      }

      // Fungsi untuk update tabel dengan data baru
      function updateTableWithData(data, searchTerm) {
        const table = $("#rpuTable").DataTable();
        table.clear();
        
        if (data && data.length > 0) {
          let no = 1;
          data.forEach(item => {
            table.row.add([
              no++,
              formatDate(item.tanggal_rpu),
              `<span class="fw-bold">${escapeHtml(item.pejagal || '-')}</span><br><small class="text-muted">Petugas: ${escapeHtml(item.nama_petugas || '-')}</small>`,
              `${escapeHtml(item.nama_pj || '-')}<br><small class="text-muted">${escapeHtml(item.nik_pj || '-')}</small>`,
              escapeHtml(item.kecamatan || '-'),
              escapeHtml(item.kelurahan || '-'),
              `<small>${escapeHtml(item.komoditas_list || '-')}</small>`,
              `<span class="badge-ekor">${item.total_ekor || '0'} ekor</span><span class="badge-berat">${parseFloat(item.total_berat || 0).toFixed(2)} kg</span>`,
              formatCoordinateCell(item.latitude, item.longitude, item.pejagal, item.kecamatan, item.kelurahan, item.lokasi, item.telp_pj, item.total_ekor, item.total_berat, item.foto_kegiatan, item.id),
              formatActionButtons(item.id)
            ]);
          });
        } else {
          table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
        }
        
        table.draw();
        
        if (searchTerm) {
          table.search(searchTerm).draw();
        }
      }

      // Helper function to format date
      function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
      }

      // Helper function to escape HTML
      function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Helper function to format coordinate cell
      function formatCoordinateCell(lat, lng, pejagal, kecamatan, kelurahan, lokasi, telp, totalEkor, totalBerat, foto, id) {
        if (!lat || !lng) {
          return '<span class="empty-coord">Tidak ada</span>';
        }
        
        return `
          <div>
            <div class="mb-1 small">
              <span class="coord-badge">${lat.substring(0, 8)}... , ${lng.substring(0, 8)}...</span>
            </div>
            <button
              class="btn btn-sm btn-outline-primary"
              onclick="showMap(
                '${escapeHtml(pejagal)}',
                '${escapeHtml(kecamatan)}',
                '${escapeHtml(kelurahan)}',
                '${lat}, ${lng}',
                '${escapeHtml(lokasi || '')}',
                '${escapeHtml(telp || '')}',
                '${totalEkor || '0'}',
                '${parseFloat(totalBerat || 0).toFixed(2)}',
                '${escapeHtml(foto || '')}',
                ${id}
              )"
            >
              <i class="fas fa-map-marker-alt me-1"></i>Lihat Peta
            </button>
          </div>
        `;
      }

      // Helper function to format action buttons
      function formatActionButtons(id) {
        return `
          <div class="d-flex gap-1">
            <button class="btn btn-sm btn-info" title="Detail Data" onclick="showDetail(${id})">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning" title="Edit Data" onclick="window.location.href='<?php echo base_url(); ?>p_input_rpu/edit/${id}'">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" title="Hapus Data" onclick="if(confirm('Apakah Anda yakin ingin menghapus data RPU ini?')) window.location.href='<?php echo base_url(); ?>data_rpu/hapus/${id}'">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;
      }

      // Function to show detail
      function showDetail(id) {
        $.ajax({
          url: '<?php echo base_url("data_rpu/detail/"); ?>' + id,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const data = response.data;
              
              $("#detailTitle").text(`Detail RPU: ${data.pejagal}`);
              $("#detailInfo").html(`Tanggal: ${formatDate(data.tanggal_rpu)}`);

              // Foto Kegiatan
              if (data.foto_kegiatan) {
                $("#detailFoto").attr("src", "<?php echo base_url(); ?>uploads/rpu/" + data.foto_kegiatan)
                  .attr("alt", data.pejagal);
                $("#detailThumbnails").html(`
                  <img src="<?php echo base_url(); ?>uploads/rpu/${data.foto_kegiatan}" class="photo-thumbnail" onclick="$('#detailFoto').attr('src', this.src)">
                `);
              } else {
                $("#detailFoto").attr("src", "<?php echo base_url(); ?>assets/images/no-image.jpg")
                  .attr("alt", "No Image");
                $("#detailThumbnails").html('<p class="text-muted small">Tidak ada foto</p>');
              }

              // Informasi RPU
              $("#detailRpuInfo").html(`
                <table class="table table-sm table-borderless">
                  <tr>
                    <td width="35%"><strong>RPU/Pejagal</strong></td>
                    <td>: ${escapeHtml(data.pejagal)}</td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal RPU</strong></td>
                    <td>: ${formatDate(data.tanggal_rpu)}</td>
                  </tr>
                  <tr>
                    <td><strong>Penanggung Jawab</strong></td>
                    <td>: ${escapeHtml(data.nama_pj)}</td>
                  </tr>
                  <tr>
                    <td><strong>NIK</strong></td>
                    <td>: ${escapeHtml(data.nik_pj || '-')}</td>
                  </tr>
                  <tr>
                    <td><strong>No. Telepon</strong></td>
                    <td>: ${escapeHtml(data.telp_pj || '-')}</td>
                  </tr>
                  <tr>
                    <td><strong>Petugas</strong></td>
                    <td>: ${escapeHtml(data.nama_petugas)}</td>
                  </tr>
                </table>
              `);

              // Informasi Lokasi
              let lokasiText = data.lokasi ? data.lokasi : '-';
              $("#detailLokasiInfo").html(`
                <div class="row">
                  <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                      <tr>
                        <td width="35%"><strong>Lokasi</strong></td>
                        <td>: ${escapeHtml(lokasiText)}</td>
                      </tr>
                      <tr>
                        <td><strong>Kecamatan</strong></td>
                        <td>: ${escapeHtml(data.kecamatan)}</td>
                      </tr>
                      <tr>
                        <td><strong>Kelurahan</strong></td>
                        <td>: ${escapeHtml(data.kelurahan)}</td>
                      </tr>
                      <tr>
                        <td><strong>RT/RW</strong></td>
                        <td>: ${escapeHtml(data.rt || '-')} / ${escapeHtml(data.rw || '-')}</td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                      <tr>
                        <td width="35%"><strong>Latitude</strong></td>
                        <td>: <code>${escapeHtml(data.latitude || '-')}</code></td>
                      </tr>
                      <tr>
                        <td><strong>Longitude</strong></td>
                        <td>: <code>${escapeHtml(data.longitude || '-')}</code></td>
                      </tr>
                      ${data.latitude && data.longitude ? `
                      <tr>
                        <td colspan="2">
                          <button class="btn btn-sm btn-primary mt-2" onclick="showMap(
                            '${escapeHtml(data.pejagal)}',
                            '${escapeHtml(data.kecamatan)}',
                            '${escapeHtml(data.kelurahan)}',
                            '${data.latitude}, ${data.longitude}',
                            '${escapeHtml(data.lokasi || '')}',
                            '${escapeHtml(data.telp_pj || '')}',
                            '${data.total_ekor || '0'}',
                            '${parseFloat(data.total_berat || 0).toFixed(2)}',
                            '${escapeHtml(data.foto_kegiatan || '')}',
                            ${data.id}
                          )">
                            <i class="fas fa-map-marker-alt me-1"></i>Lihat di Peta
                          </button>
                        </td>
                      </tr>
                      ` : ''}
                    </table>
                  </div>
                </div>
              `);

              // Data Komoditas
              let komoditasHtml = '';
              if (data.komoditas && data.komoditas.length > 0) {
                komoditasHtml = '<table class="table table-sm table-bordered"><thead><tr><th>No</th><th>Komoditas</th><th>Jumlah (Ekor)</th><th>Berat (Kg)</th><th>Asal Unggas</th></tr></thead><tbody>';
                $.each(data.komoditas, function(i, k) {
                  komoditasHtml += `<tr>
                    <td>${i+1}</td>
                    <td>${escapeHtml(k.komoditas)}</td>
                    <td>${escapeHtml(k.jumlah_ekor)}</td>
                    <td>${parseFloat(k.berat_kg).toFixed(2)}</td>
                    <td>${escapeHtml(k.asal_unggas || '-')}</td>
                  </tr>`;
                });
                komoditasHtml += '</tbody></table>';
              } else {
                komoditasHtml = '<p class="text-muted">Tidak ada data komoditas</p>';
              }
              $("#detailKomoditasInfo").html(komoditasHtml);

              // Keterangan
              $("#detailKeteranganInfo").html(`
                <p class="mb-0">${escapeHtml(data.keterangan || '-')}</p>
              `);

              $("#detailSection").show();
              $("#mapSection").hide();

              $("html, body").animate(
                {
                  scrollTop: $("#detailSection").offset().top - 20,
                },
                500
              );
            } else {
              alert('Data tidak ditemukan');
            }
          },
          error: function() {
            alert('Gagal memuat detail data');
          }
        });
      }

      // Function to show map
      function showMap(namaRpu, kecamatan, kelurahan, coordinates, alamat, telp, totalEkor, totalBerat, foto, id) {
        // Parse coordinates
        const [lat, lng] = coordinates
          .split(",")
          .map((coord) => parseFloat(coord.trim()));

        // Update map title and info
        $("#mapTitle").text(`Peta Lokasi ${namaRpu}`);
        $("#mapInfo").html(`
          <div class="row">
            <div class="col-md-6">
              <span class="fw-bold">RPU:</span> ${escapeHtml(namaRpu)}<br>
              <span class="fw-bold">Kecamatan:</span> ${escapeHtml(kecamatan)}<br>
              <span class="fw-bold">Kelurahan:</span> ${escapeHtml(kelurahan)}
            </div>
            <div class="col-md-6">
              <span class="fw-bold">Koordinat:</span> <span class="coord-badge">${coordinates}</span><br>
              <span class="fw-bold">Telepon:</span> ${escapeHtml(telp || '-')}<br>
              <span class="fw-bold">Total Potong:</span> ${totalEkor} ekor (${totalBerat} kg)
            </div>
          </div>
        `);

        // Update RPU info
        $("#clinicInfo").html(`
          <div class="mb-2">
            <span class="fw-bold">Nama RPU:</span><br>
            <span class="text-primary fw-bold">${escapeHtml(namaRpu)}</span>
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kecamatan/Kelurahan:</span><br>
            ${escapeHtml(kecamatan)} - ${escapeHtml(kelurahan)}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Alamat:</span><br>
            ${escapeHtml(alamat || '-')}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Kontak:</span><br>
            <i class="fas fa-phone-alt me-1"></i> ${escapeHtml(telp || '-')}
          </div>
          <div class="mb-2">
            <span class="fw-bold">Total Potong:</span><br>
            <span class="badge-ekor">${totalEkor} ekor</span>
            <span class="badge-berat">${totalBerat} kg</span>
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
        `);

        // Load komoditas data
        $.ajax({
          url: '<?php echo base_url("data_rpu/detail/"); ?>' + id,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success' && response.data.komoditas) {
              let komoditasHtml = '<div class="row">';
              response.data.komoditas.forEach(k => {
                komoditasHtml += `
                  <div class="col-md-4">
                    <div class="komoditas-card">
                      <strong>${escapeHtml(k.komoditas)}</strong><br>
                      <small>${k.jumlah_ekor} ekor (${parseFloat(k.berat_kg).toFixed(2)} kg)</small><br>
                      <span class="badge-asal">${escapeHtml(k.asal_unggas || '-')}</span>
                    </div>
                  </div>
                `;
              });
              komoditasHtml += '</div>';
              $("#komoditasMapInfo").html(komoditasHtml);
            } else {
              $("#komoditasMapInfo").html('<p class="text-muted">Tidak ada data komoditas</p>');
            }
          }
        });

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

            // Custom icon untuk RPU
            const rpuIcon = L.divIcon({
              html: `<div style="background-color: #1a73e8; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;">RPU</div>`,
              className: "rpu-marker",
              iconSize: [36, 36],
              iconAnchor: [18, 18],
            });

            // Add marker
            currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
            currentRpuMarker
              .bindPopup(
                `
              <div style="min-width: 250px;">
                <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${escapeHtml(namaRpu)}</h5>
                <hr style="margin: 5px 0;">
                <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${escapeHtml(alamat || '-')}</div>
                <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${escapeHtml(kecamatan)}</div>
                <div style="margin-bottom: 3px;"><strong>Kelurahan:</strong> ${escapeHtml(kelurahan)}</div>
                <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
                <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${escapeHtml(telp || '-')}</div>
                <div style="margin-bottom: 3px;"><strong>Potongan:</strong> ${totalEkor} ekor (${totalBerat} kg)</div>
                <div style="text-align: center; margin-top: 8px;">
                  <small class="text-muted">Klik di luar popup untuk menutup</small>
                </div>
              </div>
            `,
              )
              .openPopup();
            mapMarkers.push(currentRpuMarker);

            // Add circle area
            const circle = L.circle([lat, lng], {
              color: "#1a73e8",
              fillColor: "#1a73e8",
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

          const rpuIcon = L.divIcon({
            html: `<div style="background-color: #1a73e8; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white; font-size: 16px;">RPU</div>`,
            className: "rpu-marker",
            iconSize: [36, 36],
            iconAnchor: [18, 18],
          });

          currentRpuMarker = L.marker([lat, lng], { icon: rpuIcon }).addTo(map);
          currentRpuMarker
            .bindPopup(
              `
            <div style="min-width: 250px;">
              <h5 style="margin: 0 0 5px 0; color: #1a73e8; text-align: center;">${escapeHtml(namaRpu)}</h5>
              <hr style="margin: 5px 0;">
              <div style="margin-bottom: 3px;"><strong>Alamat:</strong> ${escapeHtml(alamat || '-')}</div>
              <div style="margin-bottom: 3px;"><strong>Kecamatan:</strong> ${escapeHtml(kecamatan)}</div>
              <div style="margin-bottom: 3px;"><strong>Kelurahan:</strong> ${escapeHtml(kelurahan)}</div>
              <div style="margin-bottom: 3px;"><strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</div>
              <div style="margin-bottom: 3px;"><strong>Telepon:</strong> ${escapeHtml(telp || '-')}</div>
              <div style="margin-bottom: 3px;"><strong>Potongan:</strong> ${totalEkor} ekor (${totalBerat} kg)</div>
              <div style="text-align: center; margin-top: 8px;">
                <small class="text-muted">Klik di luar popup untuk menutup</small>
              </div>
            </div>
          `,
            )
            .openPopup();
          mapMarkers.push(currentRpuMarker);

          const circle = L.circle([lat, lng], {
            color: "#1a73e8",
            fillColor: "#1a73e8",
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