<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Peta Sebaran Peternakan - SIPETGIS</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url(); ?>assets/SIPETGIS/ assets/img/kaiadmin/favicon.ico"
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

    <!-- Leaflet CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"
    />

    <style>
      #map {
        height: calc(100vh - 150px);
        width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        z-index: 1;
      }

      .map-controls {
        position: absolute;
        top: 120px;
        right: 20px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 8px;
      }

      .map-control-btn {
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        width: 40px;
        height: 40px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #4361ee;
        cursor: pointer;
        transition: all 0.3s;
      }

      .map-control-btn:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
      }

      .map-legend {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        max-width: 250px;
      }

      .legend-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: #1e3a8a;
        font-size: 14px;
      }

      .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
      }

      .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid white;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
      }

      .legend-text {
        font-size: 13px;
        color: #495057;
      }

      .filter-panel {
        position: absolute;
        top: 120px;
        left: 20px;
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        width: 280px;
        max-height: calc(100vh - 160px);
        overflow-y: auto;
      }

      .filter-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #1e3a8a;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 8px;
      }

      .filter-section {
        margin-bottom: 20px;
      }

      .filter-section-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: #495057;
        font-size: 14px;
        display: flex;
        align-items: center;
      }

      .filter-section-title i {
        margin-right: 8px;
        color: #4361ee;
      }

      .jenis-ternak-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
      }

      .jenis-ternak-btn {
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 6px 15px;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 13px;
      }

      .jenis-ternak-btn:hover {
        background: #f8f9fa;
      }

      .jenis-ternak-btn.active {
        background: #4361ee;
        color: white;
        border-color: #4361ee;
      }

      .kecamatan-list {
        max-height: 200px;
        overflow-y: auto;
        margin-top: 10px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 10px;
      }

      .kecamatan-item {
        display: flex;
        align-items: center;
        padding: 8px 5px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background-color 0.2s;
      }

      .kecamatan-item:last-child {
        border-bottom: none;
      }

      .kecamatan-item:hover {
        background-color: #f8f9fa;
      }

      .kecamatan-checkbox {
        margin-right: 10px;
      }

      .kecamatan-name {
        flex-grow: 1;
        font-size: 14px;
      }

      .kecamatan-count {
        background-color: #4361ee;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
        min-width: 25px;
        text-align: center;
      }

      .leaflet-popup-content {
        min-width: 250px;
        font-family: "Public Sans", sans-serif;
      }

      .popup-title {
        font-weight: bold;
        color: #1e3a8a;
        margin-bottom: 10px;
        font-size: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
      }

      .popup-item {
        margin-bottom: 8px;
        display: flex;
      }

      .popup-label {
        font-weight: 600;
        width: 100px;
        color: #555;
        font-size: 13px;
      }

      .popup-value {
        flex-grow: 1;
        color: #333;
        font-size: 13px;
      }

      .popup-button {
        display: block;
        width: 100%;
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #4361ee;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        font-size: 13px;
        transition: background-color 0.2s;
      }

      .popup-button:hover {
        background-color: #3a56d4;
        color: white;
        text-decoration: none;
      }

      .peternak-detail-panel {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        width: 350px;
        max-height: 300px;
        overflow-y: auto;
        display: none;
      }

      .peternak-detail-panel.active {
        display: block;
      }

      .detail-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #1e3a8a;
        font-size: 16px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .detail-title .close-btn {
        background: none;
        border: none;
        color: #999;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .detail-title .close-btn:hover {
        color: #333;
      }

      .detail-item {
        margin-bottom: 10px;
        display: flex;
      }

      .detail-label {
        font-weight: 600;
        width: 120px;
        color: #555;
        font-size: 14px;
      }

      .detail-value {
        flex-grow: 1;
        color: #333;
        font-size: 14px;
      }

      .detail-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 6px;
      }

      .detail-section-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: #495057;
        font-size: 14px;
      }

      .search-container {
        margin-bottom: 15px;
      }

      .search-input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 14px;
      }

      .search-input:focus {
        outline: none;
        border-color: #4361ee;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
      }

      .total-peternak-card {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        text-align: center;
      }

      .total-peternak-card .total-label {
        font-size: 14px;
        opacity: 0.9;
      }

      .total-peternak-card .total-value {
        font-size: 24px;
        font-weight: bold;
        margin-top: 5px;
      }

      @media (max-width: 768px) {
        .filter-panel {
          width: 250px;
        }

        .peternak-detail-panel {
          width: 280px;
        }

        .map-legend {
          max-width: 200px;
        }

        .map-controls {
          top: 100px;
          right: 10px;
        }
      }

      .btn-filter-toggle {
        position: absolute;
        top: 120px;
        left: 20px;
        background-color: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        width: 40px;
        height: 40px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #4361ee;
        cursor: pointer;
        z-index: 1000;
      }

      @media (max-width: 576px) {
        .btn-filter-toggle {
          display: flex;
        }

        .filter-panel {
          display: none;
          left: 10px;
          width: calc(100% - 20px);
        }

        .filter-panel.active {
          display: block;
        }
      }

      /* Menghilangkan kontrol zoom Leaflet default di kiri atas */
      .leaflet-top.leaflet-left {
        display: none;
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
                      <a href="pelaku-usaha.html" class="nav-link"
                        >Pelaku Usaha</a
                      >
                    </li>
                    <li>
                      <a href="akses-pengguna.html" class="nav-link"
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
                      <a href="data-kepemilikan-ternak.html" class="nav-link"
                        >Kepemilikan Ternak</a
                      >
                    </li>
                    <li>
                      <a href="data-history-ternak.html" class="nav-link"
                        >History Data Ternak</a
                      >
                    </li>
                    <li>
                      <a href="data-vaksinasi.html" class="nav-link"
                        >Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="data-history-vaksinasi.html" class="nav-link"
                        >History Vaksinasi</a
                      >
                    </li>
                    <li>
                      <a href="data-pengobatan.html" class="nav-link"
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
              <li class="nav-item active">
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
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </nav>

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
            <!-- Page Header -->
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-1">Peta Sebaran Peternakan</h3>
                <h6 class="op-7 mb-0">
                  Visualisasi spasial data peternakan Kota Surabaya
                </h6>
              </div>
            </div>

            <!-- Map Container -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body p-0">
                    <!-- Filter Panel Toggle Button -->
                    <button
                      class="btn-filter-toggle"
                      id="filterToggle"
                      title="Toggle Filter Panel"
                    >
                      <i class="fas fa-layer-group"></i>
                    </button>

                    <!-- Filter Panel (Hidden by default) -->
                    <div
                      class="filter-panel"
                      id="filterPanel"
                      style="display: none"
                    >
                      <div class="filter-header">
                        <div class="filter-title">Filter Peta Sebaran</div>
                        <button
                          class="filter-close-btn"
                          id="filterCloseBtn"
                          title="Tutup"
                        >
                          <i class="fas fa-times"></i>
                        </button>
                      </div>

                      <div class="search-container">
                        <input
                          type="text"
                          class="search-input"
                          id="searchPeternak"
                          placeholder="Cari peternak..."
                        />
                      </div>

                      <div class="total-peternak-card">
                        <div class="total-label">Total Peternak Tampil</div>
                        <div class="total-value" id="totalPeternak">0</div>
                      </div>

                      <div class="filter-section">
                        <div class="filter-section-title">
                          <i class="fas fa-cow"></i> Jenis Ternak
                        </div>
                        <div class="jenis-ternak-selector">
                          <button
                            class="jenis-ternak-btn active"
                            data-jenis="semua"
                          >
                            Semua
                          </button>
                          <button class="jenis-ternak-btn" data-jenis="unggas">
                            Unggas
                          </button>
                          <button class="jenis-ternak-btn" data-jenis="besar">
                            Ternak Besar
                          </button>
                          <button class="jenis-ternak-btn" data-jenis="kecil">
                            Ternak Kecil
                          </button>
                        </div>
                      </div>

                      <div class="filter-section">
                        <div class="filter-section-title">
                          <i class="fas fa-map-marker-alt"></i> Pilih Kecamatan
                        </div>
                        <div class="form-check mb-2">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            id="selectAllKecamatan"
                            checked
                          />
                          <label
                            class="form-check-label"
                            for="selectAllKecamatan"
                          >
                            <strong>Pilih Semua Kecamatan</strong>
                          </label>
                        </div>

                        <div class="kecamatan-list" id="kecamatanList">
                          <!-- Kecamatan Surabaya akan ditambahkan via JavaScript -->
                        </div>
                      </div>
                    </div>

                    <!-- Map Controls -->
                    <div class="map-controls">
                      <button
                        class="map-control-btn"
                        id="zoomInBtn"
                        title="Zoom In"
                      >
                        <i class="fas fa-plus"></i>
                      </button>
                      <button
                        class="map-control-btn"
                        id="zoomOutBtn"
                        title="Zoom Out"
                      >
                        <i class="fas fa-minus"></i>
                      </button>
                      <button
                        class="map-control-btn"
                        id="resetViewBtn"
                        title="Reset View"
                      >
                        <i class="fas fa-home"></i>
                      </button>
                      <button
                        class="map-control-btn"
                        id="locateMeBtn"
                        title="Lokasi Saya"
                      >
                        <i class="fas fa-location-arrow"></i>
                      </button>
                    </div>

                    <!-- Map Legend -->
                    <div class="map-legend">
                      <div class="legend-title">Legenda</div>
                      <div class="legend-item">
                        <div
                          class="legend-color"
                          style="background-color: #ff5252"
                        ></div>
                        <div class="legend-text">Ternak Unggas</div>
                      </div>
                      <div class="legend-item">
                        <div
                          class="legend-color"
                          style="background-color: #4caf50"
                        ></div>
                        <div class="legend-text">Ternak Besar</div>
                      </div>
                      <div class="legend-item">
                        <div
                          class="legend-color"
                          style="background-color: #2196f3"
                        ></div>
                        <div class="legend-text">Ternak Kecil</div>
                      </div>
                      <div class="legend-item">
                        <div
                          class="legend-color"
                          style="background-color: #ff9800"
                        ></div>
                        <div class="legend-text">Campuran</div>
                      </div>
                    </div>

                    <!-- Peternak Detail Panel -->
                    <div class="peternak-detail-panel" id="peternakDetailPanel">
                      <div class="detail-title">
                        <span>Detail Peternak</span>
                        <button class="close-btn" id="closeDetailBtn">
                          &times;
                        </button>
                      </div>
                      <div class="detail-section">
                        <div class="detail-item">
                          <div class="detail-label">Nama:</div>
                          <div class="detail-value" id="detailNama">-</div>
                        </div>
                        <div class="detail-item">
                          <div class="detail-label">Alamat:</div>
                          <div class="detail-value" id="detailAlamat">-</div>
                        </div>
                        <div class="detail-item">
                          <div class="detail-label">Jenis Ternak:</div>
                          <div class="detail-value" id="detailJenis">-</div>
                        </div>
                        <div class="detail-item">
                          <div class="detail-label">Jumlah:</div>
                          <div class="detail-value" id="detailJumlah">-</div>
                        </div>
                        <div class="detail-item">
                          <div class="detail-label">Kecamatan:</div>
                          <div class="detail-value" id="detailKecamatan">-</div>
                        </div>
                        <div class="detail-item">
                          <div class="detail-label">Status:</div>
                          <div class="detail-value" id="detailStatus">-</div>
                        </div>
                      </div>
                    </div>

                    <!-- Map Container -->
                    <div id="map"></div>
                  </div>
                </div>

                <style>
                  /* Update styling untuk filter panel yang bisa ditutup */
                  .filter-panel {
                    position: absolute;
                    top: 120px;
                    left: 20px;
                    background-color: white;
                    padding: 15px;
                    border-radius: 8px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
                    z-index: 1000;
                    width: 280px;
                    max-height: calc(100vh - 160px);
                    overflow-y: auto;
                  }

                  .filter-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 15px;
                    border-bottom: 2px solid #f0f0f0;
                    padding-bottom: 8px;
                  }

                  .filter-title {
                    font-weight: 600;
                    color: #1e3a8a;
                    margin: 0;
                    font-size: 16px;
                  }

                  .filter-close-btn {
                    background: none;
                    border: none;
                    color: #999;
                    font-size: 18px;
                    cursor: pointer;
                    padding: 0;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    transition: all 0.2s;
                  }

                  .filter-close-btn:hover {
                    background-color: #f8f9fa;
                    color: #333;
                  }

                  .btn-filter-toggle {
                    position: absolute;
                    top: 120px;
                    left: 20px;
                    background-color: white;
                    border: 1px solid #dee2e6;
                    border-radius: 6px;
                    width: 45px;
                    height: 45px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.2rem;
                    color: #4361ee;
                    cursor: pointer;
                    z-index: 1000;
                    transition: all 0.3s;
                  }

                  .btn-filter-toggle:hover {
                    background-color: #f8f9fa;
                    transform: scale(1.05);
                  }

                  @media (max-width: 768px) {
                    .filter-panel {
                      width: 250px;
                      left: 10px;
                    }

                    .btn-filter-toggle {
                      left: 10px;
                    }
                  }
                </style>

                <script>
                  // Update JavaScript untuk menangani toggle filter panel
                  function setupFilterPanelToggle() {
                    const filterToggle =
                      document.getElementById("filterToggle");
                    const filterPanel = document.getElementById("filterPanel");
                    const filterCloseBtn =
                      document.getElementById("filterCloseBtn");

                    // Toggle panel filter
                    filterToggle.addEventListener("click", function () {
                      if (
                        filterPanel.style.display === "none" ||
                        filterPanel.style.display === ""
                      ) {
                        filterPanel.style.display = "block";
                        // Posisikan tombol toggle di atas panel
                        this.style.top =
                          parseInt(filterPanel.offsetHeight) + 140 + "px";
                      } else {
                        filterPanel.style.display = "none";
                        // Reset posisi tombol toggle
                        this.style.top = "120px";
                      }
                    });

                    // Close panel dengan tombol X
                    filterCloseBtn.addEventListener("click", function () {
                      filterPanel.style.display = "none";
                      // Reset posisi tombol toggle
                      filterToggle.style.top = "120px";
                    });

                    // Close panel saat klik di luar (opsional)
                    document.addEventListener("click", function (event) {
                      if (
                        !filterPanel.contains(event.target) &&
                        !filterToggle.contains(event.target) &&
                        filterPanel.style.display === "block"
                      ) {
                        filterPanel.style.display = "none";
                        // Reset posisi tombol toggle
                        filterToggle.style.top = "120px";
                      }
                    });

                    // Untuk mobile: pada layar kecil, panel filter akan menutupi sebagian besar layar
                    function handleResize() {
                      if (window.innerWidth <= 576) {
                        filterPanel.style.width = "calc(100% - 40px)";
                        filterPanel.style.maxHeight = "70vh";
                      } else {
                        filterPanel.style.width = "280px";
                        filterPanel.style.maxHeight = "calc(100vh - 160px)";
                      }
                    }

                    // Panggil saat resize
                    window.addEventListener("resize", handleResize);
                    // Panggil sekali saat awal
                    handleResize();
                  }

                  // Panggil fungsi setup saat halaman dimuat
                  window.addEventListener("DOMContentLoaded", function () {
                    setupFilterPanelToggle();
                    // ... kode inisialisasi peta lainnya ...
                  });
                </script>
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

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
      // Data 31 Kecamatan di Kota Surabaya
      const kecamatanSurabaya = [
        { id: 1, name: "Asemrowo", lat: -7.205, lng: 112.7079 },
        { id: 2, name: "Benowo", lat: -7.2296, lng: 112.6523 },
        { id: 3, name: "Bubutan", lat: -7.2455, lng: 112.7293 },
        { id: 4, name: "Bulak", lat: -7.2299, lng: 112.7871 },
        { id: 5, name: "Dukuh Pakis", lat: -7.2759, lng: 112.6907 },
        { id: 6, name: "Gayungan", lat: -7.3246, lng: 112.7349 },
        { id: 7, name: "Genteng", lat: -7.2569, lng: 112.7482 },
        { id: 8, name: "Gubeng", lat: -7.2841, lng: 112.7536 },
        { id: 9, name: "Gununganyar", lat: -7.3331, lng: 112.7866 },
        { id: 10, name: "Jambangan", lat: -7.3249, lng: 112.7135 },
        { id: 11, name: "Karangpilang", lat: -7.3193, lng: 112.6768 },
        { id: 12, name: "Kenjeran", lat: -7.2478, lng: 112.7799 },
        { id: 13, name: "Krembangan", lat: -7.2372, lng: 112.7377 },
        { id: 14, name: "Lakarsantri", lat: -7.2914, lng: 112.6495 },
        { id: 15, name: "Mulyorejo", lat: -7.276, lng: 112.7856 },
        { id: 16, name: "Pabean Cantian", lat: -7.2337, lng: 112.7311 },
        { id: 17, name: "Pakal", lat: -7.2876, lng: 112.6298 },
        { id: 18, name: "Rungkut", lat: -7.3177, lng: 112.7785 },
        { id: 19, name: "Sambikerep", lat: -7.2971, lng: 112.6668 },
        { id: 20, name: "Sawahan", lat: -7.2771, lng: 112.7291 },
        { id: 21, name: "Semampir", lat: -7.2347, lng: 112.7453 },
        { id: 22, name: "Simokerto", lat: -7.2448, lng: 112.7434 },
        { id: 23, name: "Sukolilo", lat: -7.2875, lng: 112.7772 },
        { id: 24, name: "Sukomanunggal", lat: -7.2963, lng: 112.6982 },
        { id: 25, name: "Tambaksari", lat: -7.2593, lng: 112.7604 },
        { id: 26, name: "Tandes", lat: -7.2591, lng: 112.6728 },
        { id: 27, name: "Tegalsari", lat: -7.2645, lng: 112.7428 },
        { id: 28, name: "Tenggilis Mejoyo", lat: -7.3158, lng: 112.7635 },
        { id: 29, name: "Wiyung", lat: -7.3202, lng: 112.6983 },
        { id: 30, name: "Wonocolo", lat: -7.3101, lng: 112.7246 },
        { id: 31, name: "Wonokromo", lat: -7.2995, lng: 112.7377 },
      ];

      // Warna untuk kecamatan (opsional, bisa digunakan jika ingin menampilkan area kecamatan)
      const colors = [
        "#FF5252",
        "#4CAF50",
        "#2196F3",
        "#FF9800",
        "#9C27B0",
        "#795548",
        "#607D8B",
        "#00BCD4",
        "#8BC34A",
        "#FFC107",
        "#E91E63",
        "#3F51B5",
        "#009688",
        "#CDDC39",
        "#FF5722",
        "#673AB7",
        "#FFEB3B",
        "#03A9F4",
        "#8BC34A",
        "#FF9800",
        "#9C27B0",
        "#00BCD4",
        "#FF5722",
        "#E91E63",
        "#3F51B5",
        "#009688",
        "#FFC107",
        "#607D8B",
        "#795548",
        "#CDDC39",
        "#FFEB3B",
      ];

      // Data peternak
      const peternakData = [];

      // Generate data peternak dummy untuk Surabaya
      function generatePeternakData() {
        const jenisTernakOptions = [
          "Ayam",
          "Sapi",
          "Kambing",
          "Domba",
          "Itik",
          "Babi",
          "Kerbau",
          "Kuda",
        ];
        const statusOptions = [
          "Aktif",
          "Non-Aktif",
          "Dalam Perkembangan",
          "Bersertifikat",
        ];

        // Generate 200 data peternak
        for (let i = 1; i <= 200; i++) {
          // Pilih kecamatan random
          const kecamatanIndex = Math.floor(
            Math.random() * kecamatanSurabaya.length,
          );
          const kecamatan = kecamatanSurabaya[kecamatanIndex];

          // Pilih jenis ternak random
          const jenisTernak =
            jenisTernakOptions[
              Math.floor(Math.random() * jenisTernakOptions.length)
            ];

          // Tentukan kategori berdasarkan jenis ternak
          let kategori = "unggas";
          if (["Sapi", "Kerbau", "Kuda"].includes(jenisTernak))
            kategori = "besar";
          if (["Kambing", "Domba", "Babi"].includes(jenisTernak))
            kategori = "kecil";

          // Tambahkan sedikit variasi pada koordinat dalam batas kecamatan
          const latVariation = Math.random() * 0.02 - 0.01; // ±0.01 derajat
          const lngVariation = Math.random() * 0.02 - 0.01; // ±0.01 derajat

          const lat = kecamatan.lat + latVariation;
          const lng = kecamatan.lng + lngVariation;

          peternakData.push({
            id: i,
            nama: `Peternak ${i}`,
            alamat: `Jl. Peternakan No. ${i}, ${kecamatan.name}, Surabaya`,
            jenis: jenisTernak,
            kategori: kategori,
            jumlah: Math.floor(Math.random() * 500) + 50,
            kecamatan: kecamatan.name,
            status:
              statusOptions[Math.floor(Math.random() * statusOptions.length)],
            lat: lat,
            lng: lng,
          });
        }
      }

      // Inisialisasi peta
      let map;
      let markersLayer;
      let selectedKecamatan = new Set(kecamatanSurabaya.map((k) => k.name));
      let selectedJenis = "semua";

      function initMap() {
        // Pusat peta di Surabaya
        map = L.map("map").setView([-7.2575, 112.7521], 12);

        // Tambahkan tile layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
          maxZoom: 19,
        }).addTo(map);

        // Nonaktifkan kontrol zoom default di kiri atas
        map.removeControl(map.zoomControl);

        // Inisialisasi layer untuk marker
        markersLayer = L.markerClusterGroup({
          maxClusterRadius: 40,
          spiderfyOnMaxZoom: true,
          showCoverageOnHover: false,
          zoomToBoundsOnClick: true,
        });

        // Generate dan tambahkan data peternak
        generatePeternakData();
        updateMarkers();

        // Tambahkan layer markers ke peta
        map.addLayer(markersLayer);

        // Setup event listeners untuk kontrol
        setupControls();

        // Setup pencarian
        setupSearch();
      }

      // Update markers berdasarkan filter
      function updateMarkers() {
        // Hapus semua marker yang ada
        markersLayer.clearLayers();

        // Filter data berdasarkan kecamatan dan jenis ternak
        const filteredData = peternakData.filter((peternak) => {
          const kecamatanMatch = selectedKecamatan.has(peternak.kecamatan);
          const jenisMatch =
            selectedJenis === "semua" || peternak.kategori === selectedJenis;
          return kecamatanMatch && jenisMatch;
        });

        // Update total peternak
        document.getElementById("totalPeternak").textContent =
          filteredData.length;

        // Tambahkan marker untuk setiap peternak yang difilter
        filteredData.forEach((peternak) => {
          // Tentukan warna marker berdasarkan kategori
          let markerColor;
          switch (peternak.kategori) {
            case "unggas":
              markerColor = "#FF5252";
              break;
            case "besar":
              markerColor = "#4CAF50";
              break;
            case "kecil":
              markerColor = "#2196F3";
              break;
            default:
              markerColor = "#FF9800";
          }

          // Buat custom icon
          const customIcon = L.divIcon({
            html: `<div style="background-color: ${markerColor}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>`,
            className: "custom-marker-icon",
            iconSize: [20, 20],
            iconAnchor: [10, 10],
          });

          // Buat marker
          const marker = L.marker([peternak.lat, peternak.lng], {
            icon: customIcon,
            title: peternak.nama,
          });

          // Tambahkan popup ke marker
          marker.bindPopup(`
            <div class="popup-title">${peternak.nama}</div>
            <div class="popup-item">
              <div class="popup-label">Alamat:</div>
              <div class="popup-value">${peternak.alamat}</div>
            </div>
            <div class="popup-item">
              <div class="popup-label">Jenis Ternak:</div>
              <div class="popup-value">${peternak.jenis}</div>
            </div>
            <div class="popup-item">
              <div class="popup-label">Jumlah:</div>
              <div class="popup-value">${peternak.jumlah} ekor</div>
            </div>
            <div class="popup-item">
              <div class="popup-label">Kecamatan:</div>
              <div class="popup-value">${peternak.kecamatan}</div>
            </div>
            <div class="popup-item">
              <div class="popup-label">Status:</div>
              <div class="popup-value">${peternak.status}</div>
            </div>
            <button class="popup-button" onclick="showPeternakDetail(${peternak.id})">
              <i class="fas fa-info-circle me-1"></i> Lihat Detail Lengkap
            </button>
          `);

          // Tambahkan event listener untuk klik marker
          marker.on("click", function () {
            showPeternakDetail(peternak.id);
          });

          // Tambahkan marker ke layer
          markersLayer.addLayer(marker);
        });

        // Update jumlah di sidebar
        updateKecamatanCounts();
      }

      // Update jumlah peternak per kecamatan di sidebar
      function updateKecamatanCounts() {
        kecamatanSurabaya.forEach((kecamatan, index) => {
          const count = peternakData.filter(
            (p) =>
              p.kecamatan === kecamatan.name &&
              (selectedJenis === "semua" || p.kategori === selectedJenis),
          ).length;

          const countElement = document.getElementById(
            `count-${kecamatan.name}`,
          );
          if (countElement) {
            countElement.textContent = count;
          }
        });
      }

      // Tampilkan detail peternak di panel
      function showPeternakDetail(id) {
        const peternak = peternakData.find((p) => p.id === id);
        if (!peternak) return;

        // Update detail di panel
        document.getElementById("detailNama").textContent = peternak.nama;
        document.getElementById("detailAlamat").textContent = peternak.alamat;
        document.getElementById("detailJenis").textContent = peternak.jenis;
        document.getElementById("detailJumlah").textContent =
          `${peternak.jumlah} ekor`;
        document.getElementById("detailKecamatan").textContent =
          peternak.kecamatan;
        document.getElementById("detailStatus").textContent = peternak.status;

        // Tampilkan panel detail
        document.getElementById("peternakDetailPanel").classList.add("active");

        // Zoom ke lokasi peternak
        map.setView([peternak.lat, peternak.lng], 15);
      }

      // Fokus ke kecamatan tertentu
      function focusOnKecamatan(kecamatanName) {
        const kecamatan = kecamatanSurabaya.find(
          (k) => k.name === kecamatanName,
        );
        if (kecamatan) {
          map.setView([kecamatan.lat, kecamatan.lng], 14);

          // Highlight kecamatan di sidebar
          document.querySelectorAll(".kecamatan-item").forEach((item) => {
            item.classList.remove("active");
            if (item.dataset.kecamatan === kecamatanName) {
              item.classList.add("active");
            }
          });
        }
      }

      // Setup pencarian
      function setupSearch() {
        // Setup event listener untuk input pencarian
        document
          .getElementById("searchPeternak")
          .addEventListener("input", function (e) {
            const searchTerm = e.target.value.toLowerCase();

            if (searchTerm.length > 0) {
              // Filter peternak berdasarkan pencarian
              const searchResults = peternakData.filter((peternak) => {
                return (
                  peternak.nama.toLowerCase().includes(searchTerm) ||
                  peternak.kecamatan.toLowerCase().includes(searchTerm) ||
                  peternak.jenis.toLowerCase().includes(searchTerm)
                );
              });

              if (searchResults.length > 0) {
                // Zoom ke hasil pencarian pertama
                const firstResult = searchResults[0];
                map.setView([firstResult.lat, firstResult.lng], 15);

                // Tampilkan detail peternak pertama
                showPeternakDetail(firstResult.id);
              }
            }
          });
      }

      // Setup kontrol peta dan filter
      function setupControls() {
        // Filter toggle button (mobile)
        document
          .getElementById("filterToggle")
          .addEventListener("click", function () {
            document.getElementById("filterPanel").classList.toggle("active");
          });

        // Filter jenis ternak
        document.querySelectorAll(".jenis-ternak-btn").forEach((btn) => {
          btn.addEventListener("click", function () {
            // Hapus kelas active dari semua tombol
            document.querySelectorAll(".jenis-ternak-btn").forEach((b) => {
              b.classList.remove("active");
            });

            // Tambahkan kelas active ke tombol yang diklik
            this.classList.add("active");

            // Update filter
            selectedJenis = this.dataset.jenis;
            updateMarkers();
          });
        });

        // Inisialisasi daftar kecamatan di sidebar
        const kecamatanList = document.getElementById("kecamatanList");
        kecamatanSurabaya.forEach((kecamatan, index) => {
          const count = peternakData.filter(
            (p) => p.kecamatan === kecamatan.name,
          ).length;
          const color = colors[index] || "#4361ee";

          const item = document.createElement("div");
          item.className = "kecamatan-item";
          item.dataset.kecamatan = kecamatan.name;
          item.innerHTML = `
            <input type="checkbox" class="kecamatan-checkbox form-check-input" id="kec-${kecamatan.id}" data-kecamatan="${kecamatan.name}" checked>
            <label class="kecamatan-name" for="kec-${kecamatan.id}">${kecamatan.name}</label>
            <span class="kecamatan-count" id="count-${kecamatan.name}">${count}</span>
          `;

          // Event listener untuk checkbox kecamatan
          item
            .querySelector(".kecamatan-checkbox")
            .addEventListener("change", function () {
              const kecamatanName = this.dataset.kecamatan;

              if (this.checked) {
                selectedKecamatan.add(kecamatanName);
              } else {
                selectedKecamatan.delete(kecamatanName);
              }

              updateMarkers();

              // Update checkbox "select all"
              const allChecked = kecamatanSurabaya.every((k) =>
                selectedKecamatan.has(k.name),
              );
              document.getElementById("selectAllKecamatan").checked =
                allChecked;
            });

          // Event listener untuk klik item kecamatan
          item.addEventListener("click", function (e) {
            if (!e.target.classList.contains("kecamatan-checkbox")) {
              focusOnKecamatan(kecamatan.name);
            }
          });

          kecamatanList.appendChild(item);
        });

        // Checkbox "select all"
        document
          .getElementById("selectAllKecamatan")
          .addEventListener("change", function () {
            const isChecked = this.checked;

            // Update semua checkbox kecamatan
            document
              .querySelectorAll(".kecamatan-checkbox")
              .forEach((checkbox) => {
                checkbox.checked = isChecked;
                const kecamatanName = checkbox.dataset.kecamatan;

                if (isChecked) {
                  selectedKecamatan.add(kecamatanName);
                } else {
                  selectedKecamatan.delete(kecamatanName);
                }
              });

            updateMarkers();
          });

        // Kontrol peta
        document
          .getElementById("zoomInBtn")
          .addEventListener("click", function () {
            map.zoomIn();
          });

        document
          .getElementById("zoomOutBtn")
          .addEventListener("click", function () {
            map.zoomOut();
          });

        document
          .getElementById("resetViewBtn")
          .addEventListener("click", function () {
            map.setView([-7.2575, 112.7521], 12);
          });

        document
          .getElementById("locateMeBtn")
          .addEventListener("click", function () {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(
                function (position) {
                  map.setView(
                    [position.coords.latitude, position.coords.longitude],
                    15,
                  );
                },
                function () {
                  alert(
                    "Tidak dapat mendapatkan lokasi Anda. Pastikan izin lokasi diaktifkan.",
                  );
                },
              );
            } else {
              alert("Browser Anda tidak mendukung geolokasi.");
            }
          });

        // Close detail panel
        document
          .getElementById("closeDetailBtn")
          .addEventListener("click", function () {
            document
              .getElementById("peternakDetailPanel")
              .classList.remove("active");
          });

        // Tutup panel detail saat klik di luar
        document.addEventListener("click", function (event) {
          const detailPanel = document.getElementById("peternakDetailPanel");
          if (
            detailPanel.classList.contains("active") &&
            !detailPanel.contains(event.target) &&
            !event.target.closest(".leaflet-popup-content")
          ) {
            detailPanel.classList.remove("active");
          }

          // Tutup panel filter jika klik di luar (mobile)
          const filterPanel = document.getElementById("filterPanel");
          const filterToggle = document.getElementById("filterToggle");
          if (
            window.innerWidth <= 576 &&
            filterPanel.classList.contains("active") &&
            !filterPanel.contains(event.target) &&
            !filterToggle.contains(event.target)
          ) {
            filterPanel.classList.remove("active");
          }
        });
      }

      // Inisialisasi peta saat halaman dimuat
      window.addEventListener("DOMContentLoaded", initMap);
    </script>
  </body>
</html>
