<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Pemotongan Unggas</title>
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
      .badge-petugas {
        background-color: #f3e5f5;
        color: #7b1fa2;
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
      .pemotongan-photo {
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
      
      /* Info RPU */
      .rpu-info {
        background-color: #e8eaf6;
        color: #3f51b5;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
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
                      <a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link active"
                        >Pemotongan Unggas</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_demplot') ?>" class="nav-link"
                        >Demplot</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_stok_pakan') ?>" class="nav-link"
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
                <h3 class="fw-bold mb-1">Data Pemotongan Unggas</h3>
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
                    <label for="filterRPU" class="form-label fw-bold">
                      Filter RPU:
                    </label>
                    <select class="form-select" id="filterRPU">
                      <option selected value="all">Semua RPU</option>
                      <?php if (!empty($rpu_list)): ?>
                        <?php foreach ($rpu_list as $r): ?>
                          <option value="<?php echo htmlspecialchars($r['id_rpu']); ?>">
                            <?php echo htmlspecialchars($r['nama_rpu'] ?? 'RPU ' . $r['id_rpu']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterPetugas" class="form-label fw-bold">
                      Filter Petugas:
                    </label>
                    <select class="form-select" id="filterPetugas">
                      <option selected value="all">Semua Petugas</option>
                      <?php if (!empty($petugas_list)): ?>
                        <?php foreach ($petugas_list as $p): ?>
                          <option value="<?php echo htmlspecialchars($p['nama_petugas']); ?>">
                            <?php echo htmlspecialchars($p['nama_petugas']); ?>
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
                      <option value="ayam">Ayam</option>
                      <option value="itik">Itik</option>
                      <option value="dst">DST</option>
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
                  <table id="pemotonganTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>RPU</th>
                        <th>Komoditas (Ekor)</th>
                        <th>Total Ekor</th>
                        <th>Total Berat (kg)</th>
                        <th>Daerah Asal</th>
                        <th>Petugas</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($pemotongan_data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($pemotongan_data as $data): ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo isset($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                            <td>
                              <span class="rpu-info">RPU <?php echo htmlspecialchars($data['id_rpu'] ?? '-'); ?></span>
                            </td>
                            <td>
                              <?php if (!empty($data['komoditas_list'])): ?>
                                <small><?php echo htmlspecialchars($data['komoditas_list']); ?></small>
                              <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <span class="badge-ekor"><?php echo $data['total_ekor'] ?? '0'; ?> ekor</span>
                            </td>
                            <td>
                              <span class="badge-berat"><?php echo number_format($data['total_berat'] ?? 0, 2); ?> kg</span>
                            </td>
                            <td>
                              <span class="badge-asal"><?php echo isset($data['daerah_asal']) ? htmlspecialchars($data['daerah_asal']) : '-'; ?></span>
                            </td>
                            <td>
                              <span class="badge-petugas"><?php echo isset($data['nama_petugas']) ? htmlspecialchars($data['nama_petugas']) : '-'; ?></span>
                            </td>
                            <td>
                              <?php if (!empty($data['foto_kegiatan'])): ?>
                                <img src="<?php echo base_url('uploads/pemotongan_unggas/' . $data['foto_kegiatan']); ?>" 
                                     alt="Foto" 
                                     class="photo-thumbnail"
                                     onclick="showFotoPreview(this.src)">
                              <?php else: ?>
                                <span class="empty-coord">Tidak ada</span>
                              <?php endif; ?>
                            </td>
                            <td>
                              <div class="d-flex gap-1">
                                <button
                                  class="btn btn-sm btn-info"
                                  title="Detail Data"
                                  onclick="showDetail(<?php echo $data['id_pemotongan']; ?>)"
                                >
                                  <i class="fas fa-eye"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-warning"
                                  title="Edit Data"
                                  onclick="window.location.href='<?php echo base_url(); ?>p_input_pemotongan_unggas/edit/<?php echo $data['id_pemotongan']; ?>'"
                                >
                                  <i class="fas fa-edit"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-danger"
                                  title="Hapus Data"
                                  onclick="if(confirm('Apakah Anda yakin ingin menghapus data pemotongan unggas ini?')) window.location.href='<?php echo base_url(); ?>data_pemotongan_unggas/hapus/<?php echo $data['id_pemotongan']; ?>'"
                                >
                                  <i class="fas fa-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="10" class="text-center">Tidak ada data pemotongan unggas</td>
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
                <h5 class="fw-bold mb-0" id="detailTitle">Detail Pemotongan Unggas</h5>
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
                      <img id="detailFoto" src="" alt="Foto Kegiatan" class="pemotongan-photo mb-2">
                      <div id="detailThumbnails" class="mt-2">
                        <!-- Thumbnails will be inserted here -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi Pemotongan</h6>
                    </div>
                    <div class="card-body" id="detailPemotonganInfo">
                      <!-- Informasi pemotongan akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Data Komoditas</h6>
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

            <!-- Modal untuk Preview Foto -->
            <div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img id="modalFoto" src="" alt="Preview" style="max-width: 100%; max-height: 80vh;">
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

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
      // Data pemotongan dari PHP (untuk detail)
      const pemotonganDetailData = {};

      // Inisialisasi DataTable
      $(document).ready(function () {
        // Load statistik
        loadStatistik();
        
        // Initialize DataTable
        $("#pemotonganTable").DataTable({
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
            { targets: [8], orderable: false }, // Kolom foto tidak bisa diurutkan
            { targets: [9], orderable: false } // Kolom aksi tidak bisa diurutkan
          ]
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const rpuValue = $("#filterRPU").val();
          const petugasValue = $("#filterPetugas").val();
          const komoditasValue = $("#filterKomoditas").val();
          const startDate = $("#startDate").val();
          const endDate = $("#endDate").val();
          
          let searchTerm = "";

          if (rpuValue !== "all") {
            searchTerm += "RPU " + rpuValue;
          }

          if (petugasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += petugasValue;
          }

          if (komoditasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += komoditasValue;
          }

          // Filter berdasarkan tanggal menggunakan AJAX
          if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
          } else {
            $("#pemotonganTable").DataTable().search(searchTerm).draw();
          }
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterRPU").val("all");
          $("#filterPetugas").val("all");
          $("#filterKomoditas").val("all");
          $("#startDate").val("<?php echo date('Y-m-01'); ?>");
          $("#endDate").val("<?php echo date('Y-m-t'); ?>");
          $("#pemotonganTable").DataTable().search("").draw();
          loadStatistik();
        });

        // Close detail button event
        $("#closeDetailBtn").click(function () {
          $("#detailSection").hide();
        });
      });

      // Fungsi untuk load statistik
      function loadStatistik() {
        $.ajax({
          url: '<?php echo base_url("data_pemotongan_unggas/get_statistik"); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#totalKegiatan').text(data.total_kegiatan);
            $('#totalEkor').text(data.total_ekor);
            $('#totalBerat').text(data.total_berat.toFixed(2));
            $('#totalRPU').text(data.total_rpu);
          }
        });
      }

      // Fungsi untuk filter berdasarkan periode
      function filterByPeriode(startDate, endDate, searchTerm) {
        $.ajax({
          url: '<?php echo base_url("data_pemotongan_unggas/filter_by_periode"); ?>',
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
        const table = $("#pemotonganTable").DataTable();
        table.clear();
        
        if (data && data.length > 0) {
          let no = 1;
          data.forEach(item => {
            table.row.add([
              no++,
              formatDate(item.tanggal),
              `<span class="rpu-info">RPU ${escapeHtml(item.id_rpu || '-')}</span>`,
              `<small>${escapeHtml(item.komoditas_list || '-')}</small>`,
              `<span class="badge-ekor">${item.total_ekor || '0'} ekor</span>`,
              `<span class="badge-berat">${parseFloat(item.total_berat || 0).toFixed(2)} kg</span>`,
              `<span class="badge-asal">${escapeHtml(item.daerah_asal || '-')}</span>`,
              `<span class="badge-petugas">${escapeHtml(item.nama_petugas || '-')}</span>`,
              formatFotoCell(item.foto_kegiatan),
              formatActionButtons(item.id_pemotongan)
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

      // Helper function to format foto cell
      function formatFotoCell(foto) {
        if (!foto) {
          return '<span class="empty-coord">Tidak ada</span>';
        }
        
        return `<img src="<?php echo base_url('uploads/pemotongan_unggas/'); ?>${escapeHtml(foto)}" 
                     alt="Foto" 
                     class="photo-thumbnail"
                     onclick="showFotoPreview(this.src)">`;
      }

      // Helper function to format action buttons
      function formatActionButtons(id) {
        return `
          <div class="d-flex gap-1">
            <button class="btn btn-sm btn-info" title="Detail Data" onclick="showDetail(${id})">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning" title="Edit Data" onclick="window.location.href='<?php echo base_url(); ?>p_input_pemotongan_unggas/edit/${id}'">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" title="Hapus Data" onclick="if(confirm('Apakah Anda yakin ingin menghapus data pemotongan unggas ini?')) window.location.href='<?php echo base_url(); ?>data_pemotongan_unggas/hapus/${id}'">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;
      }

      // Function to show detail
      function showDetail(id) {
        $.ajax({
          url: '<?php echo base_url("data_pemotongan_unggas/detail/"); ?>' + id,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const data = response.data;
              
              $("#detailTitle").text(`Detail Pemotongan Unggas: RPU ${data.id_rpu}`);
              $("#detailInfo").html(`Tanggal: ${formatDate(data.tanggal)}`);

              // Foto Kegiatan
              if (data.foto_kegiatan) {
                $("#detailFoto").attr("src", "<?php echo base_url(); ?>uploads/pemotongan_unggas/" + data.foto_kegiatan)
                  .attr("alt", "Foto Kegiatan");
                $("#detailThumbnails").html(`
                  <img src="<?php echo base_url(); ?>uploads/pemotongan_unggas/${data.foto_kegiatan}" class="photo-thumbnail" onclick="$('#detailFoto').attr('src', this.src)">
                `);
              } else {
                $("#detailFoto").attr("src", "<?php echo base_url(); ?>assets/images/no-image.jpg")
                  .attr("alt", "No Image");
                $("#detailThumbnails").html('<p class="text-muted small">Tidak ada foto</p>');
              }

              // Informasi Pemotongan
              $("#detailPemotonganInfo").html(`
                <table class="table table-sm table-borderless">
                  <tr>
                    <td width="35%"><strong>ID RPU</strong></td>
                    <td>: RPU ${escapeHtml(data.id_rpu || '-')}</td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Pemotongan</strong></td>
                    <td>: ${formatDate(data.tanggal)}</td>
                  </tr>
                  <tr>
                    <td><strong>Daerah Asal</strong></td>
                    <td>: ${escapeHtml(data.daerah_asal || '-')}</td>
                  </tr>
                  <tr>
                    <td><strong>Petugas</strong></td>
                    <td>: ${escapeHtml(data.nama_petugas || '-')}</td>
                  </tr>
                  <tr>
                    <td><strong>Total Ekor</strong></td>
                    <td>: <span class="badge-ekor">${data.total_ekor || '0'} ekor</span></td>
                  </tr>
                  <tr>
                    <td><strong>Total Berat</strong></td>
                    <td>: <span class="badge-berat">${parseFloat(data.total_berat || 0).toFixed(2)} kg</span></td>
                  </tr>
                </table>
              `);

              // Data Komoditas
              let komoditasHtml = '<table class="table table-sm table-bordered"><thead><tr><th>Komoditas</th><th>Jumlah (Ekor)</th><th>Estimasi Berat (kg)</th></tr></thead><tbody>';
              
              if (data.ayam && data.ayam > 0) {
                komoditasHtml += `<tr><td>Ayam</td><td>${data.ayam}</td><td>${(data.ayam * 1.5).toFixed(2)}</td></tr>`;
              }
              if (data.itik && data.itik > 0) {
                komoditasHtml += `<tr><td>Itik</td><td>${data.itik}</td><td>${(data.itik * 1.2).toFixed(2)}</td></tr>`;
              }
              if (data.dst && data.dst > 0) {
                komoditasHtml += `<tr><td>DST</td><td>${data.dst}</td><td>${(data.dst * 1.0).toFixed(2)}</td></tr>`;
              }
              
              if ((!data.ayam || data.ayam == 0) && (!data.itik || data.itik == 0) && (!data.dst || data.dst == 0)) {
                komoditasHtml += '<tr><td colspan="3" class="text-center">Tidak ada data komoditas</td></tr>';
              }
              
              komoditasHtml += '</tbody></table>';
              $("#detailKomoditasInfo").html(komoditasHtml);

              // Keterangan
              $("#detailKeteranganInfo").html(`
                <p class="mb-0">${escapeHtml(data.keterangan || '-')}</p>
              `);

              $("#detailSection").show();

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

      // Function to show foto preview
      function showFotoPreview(src) {
        $('#modalFoto').attr('src', src);
        $('#fotoModal').modal('show');
      }
    </script>
  </body>
</html>