<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SIPETGIS - Laporan Tabulasi Data Peternakan</title>
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
      
      .report-title {
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 10px;
        color: #1e3a8a;
      }
      .report-subtitle {
        text-align: center;
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
      }
      .report-section {
        margin-bottom: 40px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: white;
      }
      .section-title {
        border-bottom: 2px solid #1a73e8;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #1e3a8a;
      }
      .table-selector {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 20px;
      }
      .table-selector-btn {
        border: 2px solid #dee2e6;
        border-radius: 20px;
        padding: 10px 25px;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
      }
      .table-selector-btn:hover {
        background: #f8f9fa;
        border-color: #1a73e8;
      }
      .table-selector-btn.active {
        background: #1a73e8;
        color: white;
        border-color: #1a73e8;
      }
      .tabulation-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
      }
      .copyright-footer {
        text-align: center;
        padding: 20px 0;
        margin-top: 40px;
        border-top: 1px solid #e0e0e0;
        color: #666;
        font-size: 14px;
      }
      .tahun-selector {
        max-width: 200px;
      }
      .total-row {
        background-color: #e8f5e9 !important;
        font-weight: bold;
      }
      .zero-value {
        color: #999;
        font-style: italic;
      }
      .table-container {
        display: none;
      }
      .table-container.active {
        display: block;
      }
      .tabulation-controls {
        margin-bottom: 15px;
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
                      <a href="<?php echo base_url(); ?>pelaku_usaha" class="nav-link"
                        >Pelaku Usaha</a
                      >
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>akses_pengguna" class="nav-link"
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
              <li class="nav-item active">
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
                <h3 class="fw-bold mb-1">Laporan Tabulasi Data</h3>
                <h6 class="op-7 mb-0">
                  Tabulasi Data Peternakan Kota Surabaya
                </h6>
              </div>
            </div>

            <!-- Main Report Content -->
            <div class="report-section">
              <!-- Table Selector -->
              <div class="table-selector">
                <button class="table-selector-btn active" data-table="table1">
                  Tabel 1
                </button>
                <button class="table-selector-btn" data-table="table2">
                  Tabel 2
                </button>
              </div>

              <!-- Table 1: Populasi Ternak -->
              <div id="table1" class="table-container active">
                <h5 class="section-title" id="table1Title">
                  Tabel 1. Jumlah Populasi Ternak (Ekor) Kota Surabaya
                </h5>

                <div class="tabulation-info">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label class="form-label fw-bold"
                        >Pilih Jenis Ternak:</label
                      >
                      <select class="form-select" id="jenisTernakSelect">
                        <option value="ternak_unggas" selected>
                          Ternak Unggas
                        </option>
                        <option value="ternak_besar">Ternak Besar</option>
                        <option value="ternak_kecil">Ternak Kecil</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-bold">Pilih Tahun:</label>
                      <select
                        class="form-select tahun-selector"
                        id="tahunSelect1"
                      >
                        <option value="2023" selected>2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Table for Ternak Unggas -->
                <div id="ternakUnggasTable" class="table-section">
                  <div class="table-responsive">
                    <table
                      id="populasiUnggasTable"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kecamatan</th>
                          <th>Ayam Buras</th>
                          <th>Ayam Ras Pedaging</th>
                          <th>Ayam Ras Petelur</th>
                          <th>Itik</th>
                          <th>Itik Manila</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data akan dimuat oleh JavaScript -->
                      </tbody>
                      <tfoot>
                        <tr class="total-row">
                          <td colspan="2">
                            <strong>Total Kota Surabaya</strong>
                          </td>
                          <td id="totalAyamBuras">0</td>
                          <td id="totalAyamRasPedaging">0</td>
                          <td id="totalAyamRasPetelur">0</td>
                          <td id="totalItik">0</td>
                          <td id="totalItikManila">0</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>

                <!-- Table for Ternak Besar (Hidden by default) -->
                <div
                  id="ternakBesarTable"
                  class="table-section"
                  style="display: none"
                >
                  <div class="table-responsive">
                    <table
                      id="populasiBesarTable"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kecamatan</th>
                          <th>Sapi Potong</th>
                          <th>Sapi Perah</th>
                          <th>Kerbau</th>
                          <th>Kuda</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data akan dimuat oleh JavaScript -->
                      </tbody>
                      <tfoot>
                        <tr class="total-row">
                          <td colspan="2">
                            <strong>Total Kota Surabaya</strong>
                          </td>
                          <td id="totalSapiPotong">0</td>
                          <td id="totalSapiPerah">0</td>
                          <td id="totalKerbau">0</td>
                          <td id="totalKuda">0</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>

                <!-- Table for Ternak Kecil (Hidden by default) -->
                <div
                  id="ternakKecilTable"
                  class="table-section"
                  style="display: none"
                >
                  <div class="table-responsive">
                    <table
                      id="populasiKecilTable"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kecamatan</th>
                          <th>Kambing</th>
                          <th>Domba</th>
                          <th>Babi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data akan dimuat oleh JavaScript -->
                      </tbody>
                      <tfoot>
                        <tr class="total-row">
                          <td colspan="2">
                            <strong>Total Kota Surabaya</strong>
                          </td>
                          <td id="totalKambing">0</td>
                          <td id="totalDomba">0</td>
                          <td id="totalBabi">0</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Table 2: Vaksinasi Ternak -->
              <div id="table2" class="table-container" style="display: none">
                <h5 class="section-title" id="table2Title">
                  Tabel 2. Jumlah Vaksinasi Ternak Kota Surabaya
                </h5>

                <div class="tabulation-info">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <label class="form-label fw-bold"
                        >Pilih Kegiatan Vaksinasi:</label
                      >
                      <select class="form-select" id="kegiatanVaksinasiSelect">
                        <option value="pmk_tahap_2" selected>
                          Vaksinasi PMK Tahap II
                        </option>
                        <option value="pmk_tahap_1">
                          Vaksinasi PMK Tahap I
                        </option>
                        <option value="brucellosis">
                          Vaksinasi Brucellosis
                        </option>
                        <option value="anthrax">Vaksinasi Anthrax</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-bold"
                        >Pilih Jenis Ternak:</label
                      >
                      <select class="form-select" id="jenisTernakVaksinSelect">
                        <option value="ternak_besar" selected>
                          Ternak Besar
                        </option>
                        <option value="ternak_kecil">Ternak Kecil</option>
                        <option value="ternak_unggas">Ternak Unggas</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label fw-bold">Pilih Tahun:</label>
                      <select
                        class="form-select tahun-selector"
                        id="tahunSelect2"
                      >
                        <option value="2023" selected>2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mt-3"></div>
                </div>

                <!-- Table for Vaksinasi -->
                <div class="table-responsive">
                  <table
                    id="vaksinasiTable"
                    class="table table-bordered table-hover"
                  >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Kerbau</th>
                        <th>Kuda</th>
                        <th>Sapi Perah</th>
                        <th>Sapi Potong</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data akan dimuat oleh JavaScript -->
                    </tbody>
                    <tfoot>
                      <tr class="total-row">
                        <td colspan="2">
                          <strong>Total Kota Surabaya</strong>
                        </td>
                        <td id="totalKerbauVaksin">0</td>
                        <td id="totalKudaVaksin">0</td>
                        <td id="totalSapiPerahVaksin">0</td>
                        <td id="totalSapiPotongVaksin">0</td>
                      </tr>
                    </tfoot>
                  </table>
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
      // Data kecamatan di Surabaya (31 kecamatan)
      const kecamatanSurabaya = [
        "Asemrowo",
        "Benowo",
        "Bubutan",
        "Bulak",
        "Dukuh Pakis",
        "Gayungan",
        "Genteng",
        "Gubeng",
        "Gunung Anyar",
        "Jambangan",
        "Karangpilang",
        "Kenjeran",
        "Krembangan",
        "Lakarsantri",
        "Mulyorejo",
        "Pabean Cantian",
        "Pakal",
        "Rungkut",
        "Sambikerep",
        "Sawahan",
        "Semampir",
        "Simokerto",
        "Sukolilo",
        "Sukomanunggal",
        "Tambaksari",
        "Tandes",
        "Tegalsari",
        "Tenggilis Mejoyo",
        "Wiyung",
        "Wonocolo",
        "Wonokromo",
      ];

      // Data populasi ternak unggas di Surabaya 2023
      const dataPopulasiUnggas2023 = kecamatanSurabaya.map((kec, index) => {
        // Generate realistic data for Surabaya
        return {
          no: index + 1,
          kecamatan: kec,
          ayamBuras: Math.floor(Math.random() * 2000) + 500,
          ayamRasPedaging: Math.floor(Math.random() * 1500) + 300,
          ayamRasPetelur: Math.floor(Math.random() * 3000) + 1000,
          itik: Math.floor(Math.random() * 500) + 100,
          itikManila: Math.floor(Math.random() * 300) + 50,
        };
      });

      // Data populasi ternak besar di Surabaya 2023
      const dataPopulasiBesar2023 = kecamatanSurabaya.map((kec, index) => {
        return {
          no: index + 1,
          kecamatan: kec,
          sapiPotong: Math.floor(Math.random() * 200) + 50,
          sapiPerah: Math.floor(Math.random() * 100) + 20,
          kerbau: Math.floor(Math.random() * 30) + 5,
          kuda: Math.floor(Math.random() * 20) + 2,
        };
      });

      // Data populasi ternak kecil di Surabaya 2023
      const dataPopulasiKecil2023 = kecamatanSurabaya.map((kec, index) => {
        return {
          no: index + 1,
          kecamatan: kec,
          kambing: Math.floor(Math.random() * 300) + 100,
          domba: Math.floor(Math.random() * 200) + 50,
          babi: Math.floor(Math.random() * 150) + 30,
        };
      });

      // Data vaksinasi PMK Tahap II 2023 (mengikuti pola dari gambar)
      const dataVaksinasiPMK2_2023 = kecamatanSurabaya.map((kec, index) => {
        let sapiPotong = 0;
        // Beri nilai 50 untuk beberapa kecamatan tertentu seperti dalam gambar
        if (
          index === 0 ||
          index === 5 ||
          index === 10 ||
          index === 15 ||
          index === 20
        ) {
          sapiPotong = 50;
        }
        // Beri nilai 100 untuk beberapa kecamatan lain
        else if (index === 3 || index === 8 || index === 13) {
          sapiPotong = 100;
        }

        return {
          no: index + 1,
          kecamatan: kec,
          kerbau: 0,
          kuda: 0,
          sapiPerah: 0,
          sapiPotong: sapiPotong,
        };
      });

      // Data untuk tahun berbeda (2022, 2021)
      function adjustDataForYear(data, year) {
        const multiplier = year === "2022" ? 0.9 : year === "2021" ? 0.8 : 1;
        return data.map((item) => {
          const newItem = { ...item };
          Object.keys(newItem).forEach((key) => {
            if (typeof newItem[key] === "number" && key !== "no") {
              newItem[key] = Math.round(newItem[key] * multiplier);
            }
          });
          return newItem;
        });
      }

      // Function untuk menampilkan nilai (jika 0, tampilkan "0" dengan style khusus)
      function formatNumber(value) {
        if (value === 0) {
          return '<span class="zero-value">0</span>';
        }
        // Format angka dengan titik untuk ribuan
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      // Function untuk menghitung total
      function calculateTotals(data, columns) {
        const totals = {};
        columns.forEach((col) => {
          totals[col] = 0;
        });

        data.forEach((row) => {
          columns.forEach((col) => {
            if (col in row) {
              totals[col] += row[col];
            }
          });
        });

        return totals;
      }

      // Function untuk memuat data ternak unggas
      function loadTernakUnggasData(tahun) {
        let data = dataPopulasiUnggas2023;
        if (tahun === "2022")
          data = adjustDataForYear(dataPopulasiUnggas2023, "2022");
        if (tahun === "2021")
          data = adjustDataForYear(dataPopulasiUnggas2023, "2021");

        const tbody = $("#populasiUnggasTable tbody");
        tbody.empty();

        // Render data
        data.forEach((item) => {
          const row = `
            <tr>
              <td>${item.no}</td>
              <td>${item.kecamatan}</td>
              <td class="text-end">${formatNumber(item.ayamBuras)}</td>
              <td class="text-end">${formatNumber(item.ayamRasPedaging)}</td>
              <td class="text-end">${formatNumber(item.ayamRasPetelur)}</td>
              <td class="text-end">${formatNumber(item.itik)}</td>
              <td class="text-end">${formatNumber(item.itikManila)}</td>
            </tr>
          `;
          tbody.append(row);
        });

        // Hitung dan update total
        const totals = calculateTotals(data, [
          "ayamBuras",
          "ayamRasPedaging",
          "ayamRasPetelur",
          "itik",
          "itikManila",
        ]);

        $("#totalAyamBuras").html(formatNumber(totals.ayamBuras));
        $("#totalAyamRasPedaging").html(formatNumber(totals.ayamRasPedaging));
        $("#totalAyamRasPetelur").html(formatNumber(totals.ayamRasPetelur));
        $("#totalItik").html(formatNumber(totals.itik));
        $("#totalItikManila").html(formatNumber(totals.itikManila));

        // Inisialisasi DataTables jika belum ada
        if (!$.fn.DataTable.isDataTable("#populasiUnggasTable")) {
          $("#populasiUnggasTable").DataTable({
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
                previous: "Sebelumnya",
              },
            },
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: false,
            paging: true,
            info: true,
            searching: true,
          });
        }
      }

      // Function untuk memuat data ternak besar
      function loadTernakBesarData(tahun) {
        let data = dataPopulasiBesar2023;
        if (tahun === "2022")
          data = adjustDataForYear(dataPopulasiBesar2023, "2022");
        if (tahun === "2021")
          data = adjustDataForYear(dataPopulasiBesar2023, "2021");

        const tbody = $("#populasiBesarTable tbody");
        tbody.empty();

        // Render data
        data.forEach((item) => {
          const row = `
            <tr>
              <td>${item.no}</td>
              <td>${item.kecamatan}</td>
              <td class="text-end">${formatNumber(item.sapiPotong)}</td>
              <td class="text-end">${formatNumber(item.sapiPerah)}</td>
              <td class="text-end">${formatNumber(item.kerbau)}</td>
              <td class="text-end">${formatNumber(item.kuda)}</td>
            </tr>
          `;
          tbody.append(row);
        });

        // Hitung dan update total
        const totals = calculateTotals(data, [
          "sapiPotong",
          "sapiPerah",
          "kerbau",
          "kuda",
        ]);

        $("#totalSapiPotong").html(formatNumber(totals.sapiPotong));
        $("#totalSapiPerah").html(formatNumber(totals.sapiPerah));
        $("#totalKerbau").html(formatNumber(totals.kerbau));
        $("#totalKuda").html(formatNumber(totals.kuda));

        // Inisialisasi DataTables jika belum ada
        if (!$.fn.DataTable.isDataTable("#populasiBesarTable")) {
          $("#populasiBesarTable").DataTable({
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
                previous: "Sebelumnya",
              },
            },
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: false,
            paging: true,
            info: true,
            searching: true,
          });
        }
      }

      // Function untuk memuat data ternak kecil
      function loadTernakKecilData(tahun) {
        let data = dataPopulasiKecil2023;
        if (tahun === "2022")
          data = adjustDataForYear(dataPopulasiKecil2023, "2022");
        if (tahun === "2021")
          data = adjustDataForYear(dataPopulasiKecil2023, "2021");

        const tbody = $("#populasiKecilTable tbody");
        tbody.empty();

        // Render data
        data.forEach((item) => {
          const row = `
            <tr>
              <td>${item.no}</td>
              <td>${item.kecamatan}</td>
              <td class="text-end">${formatNumber(item.kambing)}</td>
              <td class="text-end">${formatNumber(item.domba)}</td>
              <td class="text-end">${formatNumber(item.babi)}</td>
            </tr>
          `;
          tbody.append(row);
        });

        // Hitung dan update total
        const totals = calculateTotals(data, ["kambing", "domba", "babi"]);

        $("#totalKambing").html(formatNumber(totals.kambing));
        $("#totalDomba").html(formatNumber(totals.domba));
        $("#totalBabi").html(formatNumber(totals.babi));

        // Inisialisasi DataTables jika belum ada
        if (!$.fn.DataTable.isDataTable("#populasiKecilTable")) {
          $("#populasiKecilTable").DataTable({
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
                previous: "Sebelumnya",
              },
            },
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: false,
            paging: true,
            info: true,
            searching: true,
          });
        }
      }

      // Function untuk memuat data vaksinasi
      function loadVaksinasiData(kegiatan, jenisTernak, tahun) {
        // Gunakan data PMK Tahap II sebagai contoh utama
        let data = dataVaksinasiPMK2_2023;

        // Adjust for different years
        if (tahun === "2022")
          data = adjustDataForYear(dataVaksinasiPMK2_2023, "2022");
        if (tahun === "2021")
          data = adjustDataForYear(dataVaksinasiPMK2_2023, "2021");

        // Adjust for different vaccination programs
        if (kegiatan === "pmk_tahap_1") {
          data = data.map((item) => ({
            ...item,
            sapiPotong: Math.round(item.sapiPotong * 0.7),
          }));
        } else if (kegiatan === "brucellosis") {
          data = data.map((item) => ({
            ...item,
            sapiPotong: Math.round(item.sapiPotong * 0.5),
            sapiPerah: Math.round(item.sapiPotong * 0.3),
          }));
        } else if (kegiatan === "anthrax") {
          data = data.map((item) => ({
            ...item,
            sapiPotong: Math.round(item.sapiPotong * 0.4),
            kerbau: Math.round(item.sapiPotong * 0.2),
          }));
        }

        const tbody = $("#vaksinasiTable tbody");
        tbody.empty();

        // Render data
        data.forEach((item) => {
          const row = `
            <tr>
              <td>${item.no}</td>
              <td>${item.kecamatan}</td>
              <td class="text-end">${formatNumber(item.kerbau)}</td>
              <td class="text-end">${formatNumber(item.kuda)}</td>
              <td class="text-end">${formatNumber(item.sapiPerah)}</td>
              <td class="text-end">${formatNumber(item.sapiPotong)}</td>
            </tr>
          `;
          tbody.append(row);
        });

        // Hitung dan update total
        const totals = calculateTotals(data, [
          "kerbau",
          "kuda",
          "sapiPerah",
          "sapiPotong",
        ]);

        $("#totalKerbauVaksin").html(formatNumber(totals.kerbau));
        $("#totalKudaVaksin").html(formatNumber(totals.kuda));
        $("#totalSapiPerahVaksin").html(formatNumber(totals.sapiPerah));
        $("#totalSapiPotongVaksin").html(formatNumber(totals.sapiPotong));

        // Update judul tabel
        const kegiatanText = {
          pmk_tahap_2: "Vaksinasi PMK Tahap II",
          pmk_tahap_1: "Vaksinasi PMK Tahap I",
          brucellosis: "Vaksinasi Brucellosis",
          anthrax: "Vaksinasi Anthrax",
        }[kegiatan];

        const jenisTernakText = {
          ternak_besar: "Ternak Besar",
          ternak_kecil: "Ternak Kecil",
          ternak_unggas: "Ternak Unggas",
        }[jenisTernak];

        $("#table2Title").text(
          `Tabel 2. Jumlah ${kegiatanText} (${jenisTernakText}) Kota Surabaya Tahun ${tahun}`,
        );

        // Inisialisasi DataTables jika belum ada
        if (!$.fn.DataTable.isDataTable("#vaksinasiTable")) {
          $("#vaksinasiTable").DataTable({
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
                previous: "Sebelumnya",
              },
            },
            pageLength: 10,
            lengthChange: true,
            lengthMenu: [5, 10, 25, 50, 100],
            responsive: true,
            ordering: false,
            paging: true,
            info: true,
            searching: true,
          });
        }
      }

      // Function untuk menampilkan tabel berdasarkan jenis ternak (Table 1)
      function showTableByJenisTernak(jenisTernak, tahun) {
        // Sembunyikan semua tabel populasi terlebih dahulu
        $("#ternakUnggasTable, #ternakBesarTable, #ternakKecilTable").hide();

        // Tampilkan tabel yang dipilih
        if (jenisTernak === "ternak_unggas") {
          $("#ternakUnggasTable").show();
          loadTernakUnggasData(tahun);
        } else if (jenisTernak === "ternak_besar") {
          $("#ternakBesarTable").show();
          loadTernakBesarData(tahun);
        } else if (jenisTernak === "ternak_kecil") {
          $("#ternakKecilTable").show();
          loadTernakKecilData(tahun);
        }

        // Update section title
        const jenisText =
          jenisTernak === "ternak_unggas"
            ? "Ternak Unggas"
            : jenisTernak === "ternak_besar"
              ? "Ternak Besar"
              : "Ternak Kecil";
        $("#table1Title").text(
          `Tabel 1. Jumlah Populasi ${jenisText} (Ekor) Kota Surabaya Tahun ${tahun}`,
        );
      }

      // Function untuk menampilkan tabel vaksinasi (Table 2)
      function showVaksinasiTable(kegiatan, jenisTernak, tahun) {
        loadVaksinasiData(kegiatan, jenisTernak, tahun);
      }

      // Function untuk menghancurkan semua DataTables
      function destroyAllDataTables() {
        if ($.fn.DataTable.isDataTable("#populasiUnggasTable")) {
          $("#populasiUnggasTable").DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable("#populasiBesarTable")) {
          $("#populasiBesarTable").DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable("#populasiKecilTable")) {
          $("#populasiKecilTable").DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable("#vaksinasiTable")) {
          $("#vaksinasiTable").DataTable().destroy();
        }
      }

      // Inisialisasi saat halaman dimuat
      $(document).ready(function () {
        // Muat data awal (tabel 1 - ternak unggas 2023)
        showTableByJenisTernak("ternak_unggas", "2023");

        // Event listener untuk tombol pemilih tabel
        $(".table-selector-btn").click(function () {
          const tableId = $(this).data("table");

          // Update active button
          $(".table-selector-btn").removeClass("active");
          $(this).addClass("active");

          // Show selected table, hide others
          $(".table-container").hide();
          $("#" + tableId).show();

          // Destroy all DataTables before switching
          destroyAllDataTables();

          // Load appropriate data
          if (tableId === "table1") {
            const jenisTernak = $("#jenisTernakSelect").val();
            const tahun = $("#tahunSelect1").val();
            showTableByJenisTernak(jenisTernak, tahun);
          } else if (tableId === "table2") {
            const kegiatan = $("#kegiatanVaksinasiSelect").val();
            const jenisTernak = $("#jenisTernakVaksinSelect").val();
            const tahun = $("#tahunSelect2").val();
            showVaksinasiTable(kegiatan, jenisTernak, tahun);
          }
        });

        // Event listener untuk tombol "Lihat Tabulasi" pada tabel 1
        $("#lihatTabulasiBtn1").click(function () {
          const jenisTernak = $("#jenisTernakSelect").val();
          const tahun = $("#tahunSelect1").val();
          showTableByJenisTernak(jenisTernak, tahun);
        });

        // Event listener untuk perubahan dropdown pada tabel 1
        $("#jenisTernakSelect, #tahunSelect1").change(function () {
          const jenisTernak = $("#jenisTernakSelect").val();
          const tahun = $("#tahunSelect1").val();
          showTableByJenisTernak(jenisTernak, tahun);
        });

        // Event listener untuk tombol "Lihat Tabulasi" pada tabel 2
        $("#lihatTabulasiBtn2").click(function () {
          const kegiatan = $("#kegiatanVaksinasiSelect").val();
          const jenisTernak = $("#jenisTernakVaksinSelect").val();
          const tahun = $("#tahunSelect2").val();
          showVaksinasiTable(kegiatan, jenisTernak, tahun);
        });

        // Event listener untuk perubahan dropdown pada tabel 2
        $(
          "#kegiatanVaksinasiSelect, #jenisTernakVaksinSelect, #tahunSelect2",
        ).change(function () {
          const kegiatan = $("#kegiatanVaksinasiSelect").val();
          const jenisTernak = $("#jenisTernakVaksinSelect").val();
          const tahun = $("#tahunSelect2").val();
          showVaksinasiTable(kegiatan, jenisTernak, tahun);
        });
      });
    </script>
  </body>
</html>