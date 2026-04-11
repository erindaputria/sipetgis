<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Data Stok Pakan</title>
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
      .badge-stok {
        background-color: #e3f2fd;
        color: #1a73e8;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 12px;
      }
      .badge-masuk {
        background-color: #e8f5e9;
        color: #2e7d32;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-keluar {
        background-color: #ffebee;
        color: #c62828;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-akhir {
        background-color: #fff3e0;
        color: #f57c00;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-jenis {
        background-color: #e1f5fe;
        color: #0288d1;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-merk {
        background-color: #f3e5f5;
        color: #7b1fa2;
        font-size: 11px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-block;
        margin: 2px 0;
      }
      .badge-demplot {
        background-color: #e0f2f1;
        color: #00695c;
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

      /* Filter periode */
      .periode-input {
        max-width: 150px;
        display: inline-block;
      }
      
      /* Stok progress */
      .stok-progress {
        height: 5px;
        background-color: #e9ecef;
        border-radius: 3px;
        margin-top: 5px;
      }
      .stok-progress-bar {
        height: 100%;
        background-color: #1a73e8;
        border-radius: 3px;
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
      
      /* Info demplot */
      .demplot-info {
        background-color: #e0f2f1;
        color: #00695c;
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
                      <a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a>
                    </li>
                    <li>
                      <a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link"
                        >Pemotongan Unggas</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('data_demplot') ?>" class="nav-link"
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
                <h3 class="fw-bold mb-1">Data Stok Pakan</h3>
                <h6 class="op-7 mb-0">
                  Manajemen data stok pakan ternak di Kota Surabaya
                </h6>
              </div>            
            </div>

          
            <!-- Filter Section -->
            <div class="filter-section">
              <div class="row align-items-center">
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterJenisPakan" class="form-label fw-bold">
                      Filter Jenis Pakan:
                    </label>
                    <select class="form-select" id="filterJenisPakan">
                      <option selected value="all">Semua Jenis</option>
                      <?php if (!empty($jenis_pakan_list)): ?>
                        <?php foreach ($jenis_pakan_list as $j): ?>
                          <option value="<?php echo htmlspecialchars($j['jenis_pakan']); ?>">
                            <?php echo htmlspecialchars($j['jenis_pakan']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterMerkPakan" class="form-label fw-bold">
                      Filter Merk:
                    </label>
                    <select class="form-select" id="filterMerkPakan">
                      <option selected value="all">Semua Merk</option>
                      <?php if (!empty($merk_pakan_list)): ?>
                        <?php foreach ($merk_pakan_list as $m): ?>
                          <option value="<?php echo htmlspecialchars($m['merk_pakan']); ?>">
                            <?php echo htmlspecialchars($m['merk_pakan']); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group mb-0">
                    <label for="filterDemplot" class="form-label fw-bold">
                      Filter Demplot:
                    </label>
                    <select class="form-select" id="filterDemplot">
                      <option selected value="all">Semua Demplot</option>
                      <?php if (!empty($demplot_list)): ?>
                        <?php foreach ($demplot_list as $d): ?>
                          <option value="<?php echo htmlspecialchars($d['id_demplot']); ?>">
                            Demplot <?php echo htmlspecialchars($d['id_demplot']); ?>
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
                  <table id="stokTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Demplot</th>
                        <th>Jenis Pakan</th>
                        <th>Merk</th>
                        <th>Stok Awal (kg)</th>
                        <th>Stok Masuk (kg)</th>
                        <th>Stok Keluar (kg)</th>
                        <th>Stok Akhir (kg)</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($stok_data)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($stok_data as $data): ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo isset($data['tanggal']) ? date('d-m-Y', strtotime($data['tanggal'])) : '-'; ?></td>
                            <td>
                              <span class="demplot-info">Demplot <?php echo htmlspecialchars($data['id_demplot'] ?? '-'); ?></span>
                            </td>
                            <td>
                              <span class="badge-jenis"><?php echo htmlspecialchars($data['jenis_pakan'] ?? '-'); ?></span>
                            </td>
                            <td>
                              <span class="badge-merk"><?php echo htmlspecialchars($data['merk_pakan'] ?? '-'); ?></span>
                            </td>
                            <td class="text-end">
                              <span class="badge-stok"><?php echo number_format($data['stok_awal'] ?? 0, 0); ?></span>
                            </td>
                            <td class="text-end">
                              <span class="badge-masuk">+<?php echo number_format($data['stok_masuk'] ?? 0, 0); ?></span>
                            </td>
                            <td class="text-end">
                              <span class="badge-keluar">-<?php echo number_format($data['stok_keluar'] ?? 0, 0); ?></span>
                            </td>
                            <td class="text-end">
                              <span class="badge-akhir"><?php echo number_format($data['stok_akhir'] ?? 0, 0); ?></span>
                              <?php if (isset($data['stok_awal']) && isset($data['stok_akhir']) && $data['stok_awal'] > 0): ?>
                                <?php $persen = ($data['stok_akhir'] / $data['stok_awal']) * 100; ?>
                                <div class="stok-progress">
                                  <div class="stok-progress-bar" style="width: <?php echo min($persen, 100); ?>%"></div>
                                </div>
                              <?php endif; ?>
                            </td>
                            <td>
                              <small><?php echo htmlspecialchars(substr($data['keterangan'] ?? '-', 0, 30)) . (strlen($data['keterangan'] ?? '') > 30 ? '...' : ''); ?></small>
                            </td>
                            <td>
                              <div class="d-flex gap-1">
                                <button
                                  class="btn btn-sm btn-info"
                                  title="Detail Data"
                                  onclick="showDetail(<?php echo $data['id_stok']; ?>)"
                                >
                                  <i class="fas fa-eye"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-warning"
                                  title="Edit Data"
                                  onclick="window.location.href='<?php echo base_url(); ?>p_input_stok_pakan/edit/<?php echo $data['id_stok']; ?>'"
                                >
                                  <i class="fas fa-edit"></i>
                                </button>
                                <button
                                  class="btn btn-sm btn-danger"
                                  title="Hapus Data"
                                  onclick="if(confirm('Apakah Anda yakin ingin menghapus data stok pakan ini?')) window.location.href='<?php echo base_url(); ?>data_stok_pakan/hapus/<?php echo $data['id_stok']; ?>'"
                                >
                                  <i class="fas fa-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="11" class="text-center">Tidak ada data stok pakan</td>
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
                <h5 class="fw-bold mb-0" id="detailTitle">Detail Stok Pakan</h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                      <h6 class="mb-0">Informasi Stok Pakan</h6>
                    </div>
                    <div class="card-body" id="detailStokInfo">
                      <!-- Informasi stok akan diisi oleh JavaScript -->
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0">Detail Perubahan Stok</h6>
                </div>
                <div class="card-body" id="detailPerubahanInfo">
                  <!-- Detail perubahan stok akan diisi oleh JavaScript -->
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
      // Data stok dari PHP (untuk detail)
      const stokDetailData = {};

      // Inisialisasi DataTable
      $(document).ready(function () {
        // Load statistik
        loadStatistik();
        
        // Initialize DataTable
        $("#stokTable").DataTable({
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
            { targets: [9], orderable: false }, // Kolom keterangan tidak bisa diurutkan
            { targets: [10], orderable: false } // Kolom aksi tidak bisa diurutkan
          ]
        });

        // Filter button event
        $("#filterBtn").click(function () {
          const jenisValue = $("#filterJenisPakan").val();
          const merkValue = $("#filterMerkPakan").val();
          const demplotValue = $("#filterDemplot").val();
          const startDate = $("#startDate").val();
          const endDate = $("#endDate").val();
          
          let searchTerm = "";

          if (jenisValue !== "all") {
            searchTerm += jenisValue;
          }

          if (merkValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += merkValue;
          }

          if (demplotValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += "Demplot " + demplotValue;
          }

          // Filter berdasarkan tanggal menggunakan AJAX
          if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
          } else {
            $("#stokTable").DataTable().search(searchTerm).draw();
          }
        });

        // Reset button event
        $("#resetBtn").click(function () {
          $("#filterJenisPakan").val("all");
          $("#filterMerkPakan").val("all");
          $("#filterDemplot").val("all");
          $("#startDate").val("<?php echo date('Y-m-01'); ?>");
          $("#endDate").val("<?php echo date('Y-m-t'); ?>");
          $("#stokTable").DataTable().search("").draw();
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
          url: '<?php echo base_url("data_stok_pakan/get_statistik"); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#totalTransaksi').text(data.total_transaksi);
            $('#totalStokMasuk').text(data.total_stok_masuk);
            $('#totalStokKeluar').text(data.total_stok_keluar);
            $('#totalStokAkhir').text(data.total_stok_akhir);
          }
        });
      }

      // Fungsi untuk filter berdasarkan periode
      function filterByPeriode(startDate, endDate, searchTerm) {
        $.ajax({
          url: '<?php echo base_url("data_stok_pakan/filter_by_periode"); ?>',
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
        const table = $("#stokTable").DataTable();
        table.clear();
        
        if (data && data.length > 0) {
          let no = 1;
          data.forEach(item => {
            table.row.add([
              no++,
              formatDate(item.tanggal),
              `<span class="demplot-info">Demplot ${escapeHtml(item.id_demplot || '-')}</span>`,
              `<span class="badge-jenis">${escapeHtml(item.jenis_pakan || '-')}</span>`,
              `<span class="badge-merk">${escapeHtml(item.merk_pakan || '-')}</span>`,
              `<span class="badge-stok">${formatNumber(item.stok_awal || 0)}</span>`,
              `<span class="badge-masuk">+${formatNumber(item.stok_masuk || 0)}</span>`,
              `<span class="badge-keluar">-${formatNumber(item.stok_keluar || 0)}</span>`,
              formatStokAkhirCell(item.stok_awal, item.stok_akhir),
              `<small>${escapeHtml(substr(item.keterangan || '-', 0, 30))}${(item.keterangan && item.keterangan.length > 30 ? '...' : '')}</small>`,
              formatActionButtons(item.id_stok)
            ]);
          });
        } else {
          table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
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

      // Helper function to format number
      function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
      }

      // Helper function to escape HTML
      function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Helper function for substring
      function substr(text, start, length) {
        if (!text) return '';
        return text.substring(start, length);
      }

      // Helper function to format stok akhir cell with progress bar
      function formatStokAkhirCell(stokAwal, stokAkhir) {
        let html = `<span class="badge-akhir">${formatNumber(stokAkhir || 0)}</span>`;
        
        if (stokAwal && stokAwal > 0) {
          const persen = (stokAkhir / stokAwal) * 100;
          html += `<div class="stok-progress">
                    <div class="stok-progress-bar" style="width: ${Math.min(persen, 100)}%"></div>
                  </div>`;
        }
        
        return html;
      }

      // Helper function to format action buttons
      function formatActionButtons(id) {
        return `
          <div class="d-flex gap-1">
            <button class="btn btn-sm btn-info" title="Detail Data" onclick="showDetail(${id})">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning" title="Edit Data" onclick="window.location.href='<?php echo base_url(); ?>p_input_stok_pakan/edit/${id}'">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" title="Hapus Data" onclick="if(confirm('Apakah Anda yakin ingin menghapus data stok pakan ini?')) window.location.href='<?php echo base_url(); ?>data_stok_pakan/hapus/${id}'">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;
      }

      // Function to show detail
      function showDetail(id) {
        $.ajax({
          url: '<?php echo base_url("data_stok_pakan/detail/"); ?>' + id,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const data = response.data;
              
              $("#detailTitle").text(`Detail Stok Pakan: ${data.jenis_pakan} - ${data.merk_pakan}`);
              $("#detailInfo").html(`Tanggal: ${formatDate(data.tanggal)} | Demplot: ${data.id_demplot}`);

              // Informasi Stok
              $("#detailStokInfo").html(`
                <table class="table table-sm table-borderless">
                  <tr>
                    <td width="35%"><strong>Demplot</strong></td>
                    <td>: <span class="demplot-info">Demplot ${escapeHtml(data.id_demplot || '-')}</span></td>
                  </tr>
                  <tr>
                    <td><strong>Jenis Pakan</strong></td>
                    <td>: <span class="badge-jenis">${escapeHtml(data.jenis_pakan || '-')}</span></td>
                  </tr>
                  <tr>
                    <td><strong>Merk Pakan</strong></td>
                    <td>: <span class="badge-merk">${escapeHtml(data.merk_pakan || '-')}</span></td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: ${formatDate(data.tanggal)}</td>
                  </tr>
                </table>
              `);

              // Detail Perubahan Stok
              $("#detailPerubahanInfo").html(`
                <div class="row">
                  <div class="col-md-3">
                    <div class="card bg-light">
                      <div class="card-body text-center">
                        <span class="stat-label">Stok Awal</span>
                        <div class="stat-value" style="font-size: 1.5rem;">${formatNumber(data.stok_awal || 0)} kg</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-success text-white">
                      <div class="card-body text-center">
                        <span class="text-white">Stok Masuk</span>
                        <div class="fw-bold" style="font-size: 1.5rem;">+${formatNumber(data.stok_masuk || 0)} kg</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-danger text-white">
                      <div class="card-body text-center">
                        <span class="text-white">Stok Keluar</span>
                        <div class="fw-bold" style="font-size: 1.5rem;">-${formatNumber(data.stok_keluar || 0)} kg</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="card bg-warning">
                      <div class="card-body text-center">
                        <span>Stok Akhir</span>
                        <div class="fw-bold" style="font-size: 1.5rem;">${formatNumber(data.stok_akhir || 0)} kg</div>
                      </div>
                    </div>
                  </div>
                </div>
                
                ${data.stok_awal > 0 ? `
                <div class="mt-3">
                  <strong>Persentase Sisa Stok:</strong>
                  <div class="stok-progress" style="height: 20px;">
                    <div class="stok-progress-bar" style="width: ${Math.min((data.stok_akhir / data.stok_awal) * 100, 100)}%; height: 20px;"></div>
                  </div>
                  <small class="text-muted">${((data.stok_akhir / data.stok_awal) * 100).toFixed(1)}% dari stok awal</small>
                </div>
                ` : ''}
              `);

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
    </script>
  </body>
</html>