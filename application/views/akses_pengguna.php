<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Akses Pengguna - SIPETGIS</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

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

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/kaiadmin.min.css" />

    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"
    />
    <style>
      .dataTables_wrapper {
        padding: 20px;
      }

      .dataTables_length select {
        border-radius: 5px;
        border: 1px solid #dee2e6;
        padding: 5px 10px;
      }

      .dataTables_filter input {
        border-radius: 5px;
        border: 1px solid #dee2e6;
        padding: 5px 10px;
        width: 200px;
      }

      table.dataTable {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
      }

      table.dataTable thead th {
        border: none !important;
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 15px 10px;
        white-space: nowrap;
      }

      table.dataTable tbody td {
        background-color: white;
        border: none !important;
        padding: 15px 10px;
        vertical-align: middle;
      }

      table.dataTable tbody tr {
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.3s;
      }

      table.dataTable tbody tr:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
      }

      .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
        transition: all 0.2s;
      }

      .btn-edit {
        background-color: rgba(67, 97, 238, 0.1);
        color: #4361ee;
      }

      .btn-edit:hover {
        background-color: #4361ee;
        color: white;
      }

      .btn-delete {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
      }

      .btn-delete:hover {
        background-color: #dc3545;
        color: white;
      }

      .btn-view {
        background-color: rgba(32, 201, 151, 0.1);
        color: #20c997;
      }

      .btn-view:hover {
        background-color: #20c997;
        color: white;
      }

      .dt-buttons .btn {
        border-radius: 5px;
        font-weight: 500;
        padding: 6px 15px;
        margin-right: 5px;
        border: 1px solid #dee2e6;
        background: white;
        color: #495057;
      }

      .dt-buttons .btn:hover {
        background-color: #f8f9fa;
      }

      .dt-buttons .btn-export-blue {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
      }

      .dt-buttons .btn-export-blue:hover {
        background-color: #0b5ed7 !important;
      }

      .badge-kelompok {
        background-color: #e3f2fd;
        color: #1976d2;
        font-size: 12px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
      }

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

      .btn-primary-custom {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        border: none;
        border-radius: 6px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s;
      }

      .btn-primary-custom:hover {
        background: linear-gradient(135deg, #3a56d4 0%, #3046b8 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
      }

      /* ===== CUSTOM PAGINATION CARDS ===== */
      .pagination-cards {
        display: flex;
        gap: 15px;
        margin: 15px 0;
        flex-wrap: wrap;
        align-items: center;
      }

      .pagination-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        min-width: 200px;
      }

      .pagination-card .card-label {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        white-space: nowrap;
      }

      .pagination-card .card-value {
        font-weight: 700;
        color: #0d6efd;
        font-size: 15px;
      }

      .page-btn {
        background: #fff;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 4px 10px;
        margin: 0 2px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
        min-width: 32px;
        text-align: center;
      }

      .page-btn:hover:not(:disabled) {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
      }

      .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
      }

      .current-page {
        display: inline-block;
        padding: 4px 12px;
        background: #0d6efd;
        color: white;
        border-radius: 4px;
        margin: 0 5px;
        min-width: 30px;
        text-align: center;
        font-weight: 600;
      }

      .dataTables_info {
        display: none !important;
      }

      /* Advanced Pagination Navigator */
      .advanced-pagination {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        justify-content: flex-end;
        flex-wrap: wrap;
      }

      .page-navigation {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
      }

      .page-input {
        width: 70px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px;
        font-size: 14px;
      }

      .page-jump {
        background: #0d6efd;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
      }

      .page-jump:hover {
        background: #0b5ed7;
      }

      .page-range {
        font-weight: 600;
        color: #0d6efd;
        white-space: nowrap;
      }

      .total-pages {
        color: #6c757d;
        font-size: 14px;
      }

      /* Compact Page Buttons */
      .compact-pages {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
      }

      .compact-pages .page-btn {
        min-width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .ellipsis {
        padding: 0 5px;
        color: #6c757d;
      }

      /* Pagination Controls */
      .pagination-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
      }

      .nav-control-btn {
        background: #fff;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .nav-control-btn:hover:not(:disabled) {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
      }

      .nav-control-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
      }

      /* Responsif untuk mobile */
      @media (max-width: 768px) {
        .pagination-cards {
          flex-direction: column;
          gap: 10px;
        }

        .pagination-card {
          justify-content: space-between;
          min-width: auto;
          width: 100%;
        }

        .page-btn {
          padding: 4px 8px;
          min-width: 28px;
        }

        .advanced-pagination {
          justify-content: center;
        }

        .compact-pages {
          justify-content: center;
        }

        .pagination-controls {
          margin-left: 0;
          width: 100%;
          justify-content: center;
        }
      }

      /* Style untuk badge peran */
      .badge-peran {
        font-size: 12px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
      }

      .badge-admin {
        background-color: #e3f2fd;
        color: #1976d2;
      }

      .badge-kepala {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .badge-petugas {
        background-color: #fff3e0;
        color: #f57c00;
      }

      .badge-aktif {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .badge-nonaktif {
        background-color: #ffebee;
        color: #d32f2f;
      }

      /* Password field styles */
      .password-field {
        position: relative;
      }

      .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
      }

      .password-toggle:hover {
        color: #495057;
      }

      /* Flash message styles */
      .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
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
            <a href="index.html" class="logo" style="text-decoration: none">
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
              <li class="nav-item">
                <a href="<?php echo site_url('dashboard'); ?>">
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
              <li class="nav-item active">
                <a
                  class="nav-link d-flex align-items-center justify-content-between"
                  data-bs-toggle="collapse"
                  href="#masterDataSubmenu"
                  role="button"
                  aria-expanded="true"
                >
                  <div class="d-flex align-items-center">
                    <i class="fas fa-database me-2"></i>
                    <span>Master Data</span>
                  </div>
                  <i class="fas fa-chevron-down ms-2"></i>
                </a>
                <div class="collapse show" id="masterDataSubmenu">
                  <ul class="list-unstyled ps-4">
                    <li>
                       <a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a>
                    </li>
                    <li>
                      <a href="<?= site_url('akses_pengguna') ?>" class="nav-link active"
                        >Akses Pengguna</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('pengobatan') ?>" class="nav-link">Pengobatan</a>
                    </li>
                    <li>
                      <a href="<?= site_url('vaksinasi') ?>" class="nav-link">Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a>
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
                      <a href="<?= site_url('data_kepemilikan_ternak') ?>" class="nav-link"
                        >Kepemilikan Ternak</a
                      >
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
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="laporan.html">
                  <i class="fas fa-chart-bar"></i>
                  <p>Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="peta-sebaran.html">
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
                        <a class="dropdown-item" href="login.html">
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
            <!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <!-- Page Header -->
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-1">Master Data</h3>
                <h6 class="op-7 mb-0">Kelola Data Akses Pengguna</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-primary-custom text-white"
                        data-bs-toggle="modal"
                        data-bs-target="#tambahDataModal">
                  <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
              </div>
            </div>

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content modal-form">
                  <form action="<?= base_url('akses_pengguna/simpan'); ?>" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Tambah Data Akses Pengguna
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Username <span class="text-danger">*</span></label>
                          <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Password <span class="text-danger">*</span></label>
                          <div class="password-field">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                              <i class="fas fa-eye"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Konfirmasi Password <span class="text-danger">*</span></label>
                          <div class="password-field">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                              <i class="fas fa-eye"></i>
                            </button>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Level <span class="text-danger">*</span></label>
                          <select name="level" class="form-control" required>
                            <option value="">Pilih Level</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Petugas Lapangan">Petugas Lapangan</option>
                            <option value="Kepala Dinas">Kepala Dinas</option>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Telepon <span class="text-danger">*</span></label>
                          <input type="text" name="telepon" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Kecamatan <span class="text-danger">*</span></label>
                          <select name="kecamatan" class="form-control" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="ASEMROWO">ASEMROWO</option>
                            <option value="BENOWO">BENOWO</option>
                            <option value="BUBUTAN">BUBUTAN</option>
                            <option value="BULAK">BULAK</option>
                            <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                            <option value="GAYUNGAN">GAYUNGAN</option>
                            <option value="GENTENG">GENTENG</option>
                            <option value="GUBENG">GUBENG</option>
                            <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                            <option value="JAMBANGAN">JAMBANGAN</option>
                            <option value="KARANG PILANG">KARANG PILANG</option>
                            <option value="KENJERAN">KENJERAN</option>
                            <option value="KREMBANGAN">KREMBANGAN</option>
                            <option value="LAKARSANTRI">LAKARSANTRI</option>
                            <option value="MULYOREJO">MULYOREJO</option>
                            <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                            <option value="PAKAL">PAKAL</option>
                            <option value="RUNGKUT">RUNGKUT</option>
                            <option value="SAMBIKEREP">SAMBIKEREP</option>
                            <option value="SAWAHAN">SAWAHAN</option>
                            <option value="SEMAMPIR">SEMAMPIR</option>
                            <option value="SIMOKERTO">SIMOKERTO</option>
                            <option value="SUKOLILO">SUKOLILO</option>
                            <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                            <option value="TAMBAKSARI">TAMBAKSARI</option>
                            <option value="TANDES">TANDES</option>
                            <option value="TEGALSARI">TEGALSARI</option>
                            <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                            <option value="WIYUNG">WIYUNG</option>
                            <option value="WONOCOLO">WONOCOLO</option>
                            <option value="WONOKROMO">WONOKROMO</option>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Status <span class="text-danger">*</span></label>
                          <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Simpan Data
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Edit Data -->
            <div class="modal fade" id="editDataModal" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content modal-form">
                  <form action="<?= base_url('akses_pengguna/update'); ?>" method="post">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Data Akses Pengguna
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Username <span class="text-danger">*</span></label>
                          <input type="text" id="edit_username" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Password <span class="text-muted">(Kosongkan jika tidak diubah)</span></label>
                          <div class="password-field">
                            <input type="password" id="edit_password" name="password" class="form-control">
                            <button type="button" class="password-toggle" onclick="togglePassword('edit_password')">
                              <i class="fas fa-eye"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Level <span class="text-danger">*</span></label>
                          <select id="edit_level" name="level" class="form-control" required>
                            <option value="">Pilih Level</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Petugas Lapangan">Petugas Lapangan</option>
                            <option value="Kepala Dinas">Kepala Dinas</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Telepon <span class="text-danger">*</span></label>
                          <input type="text" id="edit_telepon" name="telepon" class="form-control" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Kecamatan <span class="text-danger">*</span></label>
                          <select id="edit_kecamatan" name="kecamatan" class="form-control" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="ASEMROWO">ASEMROWO</option>
                            <option value="BENOWO">BENOWO</option>
                            <option value="BUBUTAN">BUBUTAN</option>
                            <option value="BULAK">BULAK</option>
                            <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                            <option value="GAYUNGAN">GAYUNGAN</option>
                            <option value="GENTENG">GENTENG</option>
                            <option value="GUBENG">GUBENG</option>
                            <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                            <option value="JAMBANGAN">JAMBANGAN</option>
                            <option value="KARANG PILANG">KARANG PILANG</option>
                            <option value="KENJERAN">KENJERAN</option>
                            <option value="KREMBANGAN">KREMBANGAN</option>
                            <option value="LAKARSANTRI">LAKARSANTRI</option>
                            <option value="MULYOREJO">MULYOREJO</option>
                            <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                            <option value="PAKAL">PAKAL</option>
                            <option value="RUNGKUT">RUNGKUT</option>
                            <option value="SAMBIKEREP">SAMBIKEREP</option>
                            <option value="SAWAHAN">SAWAHAN</option>
                            <option value="SEMAMPIR">SEMAMPIR</option>
                            <option value="SIMOKERTO">SIMOKERTO</option>
                            <option value="SUKOLILO">SUKOLILO</option>
                            <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                            <option value="TAMBAKSARI">TAMBAKSARI</option>
                            <option value="TANDES">TANDES</option>
                            <option value="TEGALSARI">TEGALSARI</option>
                            <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                            <option value="WIYUNG">WIYUNG</option>
                            <option value="WONOCOLO">WONOCOLO</option>
                            <option value="WONOKROMO">WONOKROMO</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Status <span class="text-danger">*</span></label>
                          <select id="edit_status" name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Update Data
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal View Password -->
            <div class="modal fade" id="viewPasswordModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">
                      <i class="fas fa-key me-2"></i>Password Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" id="view_username" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" id="view_password" class="form-control" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('view_password')">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="aksesPenggunaTable"
                        class="table table-hover w-100"
                      >
                        <thead>
                          <tr>
                            <th width="50">No</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Telepon</th>
                            <th>Kecamatan</th>
                            <th>Status</th>
                            <th width="130">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($akses)): ?>
                            <?php $no = 1; ?>
                            <?php foreach($akses as $row): ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row->username ?? ''); ?></td>
                                <td>
                                  <span class="badge-peran 
                                    <?php 
                                      if(isset($row->level)) {
                                        if($row->level == 'Administrator') echo 'badge-admin';
                                        elseif($row->level == 'Kepala Dinas') echo 'badge-kepala';
                                        else echo 'badge-petugas';
                                      }
                                    ?>">
                                    <?= htmlspecialchars($row->level ?? ''); ?>
                                  </span>
                                </td>
                                <td><?= htmlspecialchars($row->telepon ?? ''); ?></td>
                                <td><?= htmlspecialchars($row->kecamatan ?? ''); ?></td>
                                <td>
                                  <span class="badge-peran 
                                    <?php 
                                      if(isset($row->status)) {
                                        if($row->status == 'Aktif') echo 'badge-aktif';
                                        else echo 'badge-nonaktif';
                                      }
                                    ?>">
                                    <?= htmlspecialchars($row->status ?? ''); ?>
                                  </span>
                                </td>
                                <td>
                                  <button class="btn btn-action btn-view" title="Lihat Password"
                                          data-id="<?= $row->id ?? ''; ?>"
                                          data-username="<?= htmlspecialchars($row->username ?? ''); ?>"
                                          data-password="<?= htmlspecialchars($row->password ?? ''); ?>">
                                    <i class="fas fa-key"></i>
                                  </button>
                                  <button class="btn btn-action btn-edit" title="Edit"
                                          data-id="<?= $row->id ?? ''; ?>"
                                          data-username="<?= htmlspecialchars($row->username ?? ''); ?>"
                                          data-level="<?= htmlspecialchars($row->level ?? ''); ?>"
                                          data-telepon="<?= htmlspecialchars($row->telepon ?? ''); ?>"
                                          data-kecamatan="<?= htmlspecialchars($row->kecamatan ?? ''); ?>"
                                          data-status="<?= htmlspecialchars($row->status ?? ''); ?>">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <button class="btn btn-action btn-delete" title="Hapus"
                                          data-id="<?= $row->id ?? ''; ?>"
                                          data-username="<?= htmlspecialchars($row->username ?? ''); ?>">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
      // Fungsi toggle password visibility
      function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.parentElement.querySelector('.password-toggle');
        
        if (input.type === 'password') {
          input.type = 'text';
          button.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
          input.type = 'password';
          button.innerHTML = '<i class="fas fa-eye"></i>';
        }
      }

      // Password validation
      function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password !== confirmPassword) {
          alert('Password dan Konfirmasi Password tidak sama!');
          return false;
        }
        
        if (password.length < 6) {
          alert('Password minimal 6 karakter!');
          return false;
        }
        
        return true;
      }

      $(document).ready(function () {
        // Inisialisasi DataTable
        var table = $("#aksesPenggunaTable").DataTable({
          dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-5"B>>',
          buttons: [
            {
              extend: "excel",
              className: "btn btn-export-blue",
              text: '<i class="fas fa-file-excel me-1"></i>Excel',
            },
            {
              extend: "pdf",
              className: "btn btn-export-blue",
              text: '<i class="fas fa-file-pdf me-1"></i>PDF',
            },
            {
              extend: "print",
              className: "btn btn-export-blue",
              text: '<i class="fas fa-print me-1"></i>Print',
            },
          ],
          language: {
            search: "Cari:",
            lengthMenu: "",
            info: "",
            infoEmpty: "",
            infoFiltered: "",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
              first: "«",
              last: "»",
              next: "›",
              previous: "‹",
            },
          },
          pageLength: 10,
          lengthChange: false,
          responsive: true,
        });

        // Event untuk tombol lihat password
        $(document).on("click", ".btn-view", function () {
          var username = $(this).data('username');
          var password = $(this).data('password');
          
          $('#view_username').val(username);
          $('#view_password').val(password);
          $('#viewPasswordModal').modal('show');
        });

        // Event untuk tombol edit
        $(document).on("click", ".btn-edit", function () {
          var id = $(this).data('id');
          var username = $(this).data('username');
          var level = $(this).data('level');
          var telepon = $(this).data('telepon');
          var kecamatan = $(this).data('kecamatan');
          var status = $(this).data('status');
          
          $('#edit_id').val(id);
          $('#edit_username').val(username);
          $('#edit_level').val(level);
          $('#edit_telepon').val(telepon);
          $('#edit_kecamatan').val(kecamatan);
          $('#edit_status').val(status);
          
          $('#editDataModal').modal('show');
        });

        // Event untuk tombol hapus
        $(document).on("click", ".btn-delete", function () {
          var id = $(this).data('id');
          var username = $(this).data('username');
          
          if (confirm("Apakah Anda yakin ingin menghapus data pengguna: " + username + "?")) {
            // Redirect langsung ke controller hapus
            window.location.href = "<?= base_url('akses_pengguna/hapus/'); ?>" + id;
          }
        });

        // Form validation untuk tambah data
        $('form').submit(function(e) {
          const formId = $(this).attr('id') || '';
          
          if (formId.includes('tambah') || $(this).attr('action').includes('simpan')) {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            
            if (password !== confirmPassword) {
              e.preventDefault();
              alert('Password dan Konfirmasi Password tidak sama!');
              return false;
            }
            
            if (password.length < 6) {
              e.preventDefault();
              alert('Password minimal 6 karakter!');
              return false;
            }
          }
        });

        // Auto close alerts
        setTimeout(function() {
          $('.alert').alert('close');
        }, 5000);

        // Refresh halaman setelah modal ditutup
        $('#tambahDataModal, #editDataModal, #viewPasswordModal').on('hidden.bs.modal', function () {
          location.reload();
        });
      });
    </script>
  </body>
</html>