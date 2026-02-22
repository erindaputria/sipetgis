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
      href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initSurabayaMap"
      async
      defer
    ></script>

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
        height: 100%;
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
      .chart-container {
        height: 200px !important;
        position: relative;
      }
      .compact-card {
        height: 100%;
        display: flex;
        flex-direction: column;
      }
      .compact-card .card-body {
        flex: 1;
        padding: 15px !important;
      }
      .compact-card .card-header {
        padding: 12px 15px;
      }
      .compact-card .card-footer {
        padding: 10px 15px;
      }
      .map-card {
        height: 100%;
      }
      .map-container-wrapper {
        height: 300px;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
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
            <a
              href="k_dashboard_kepala.php"
              class="logo"
              style="text-decoration: none"
            >
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
                 <a href="<?php echo site_url('k_dashboard_kepala'); ?>" class="logo" style="text-decoration: none">
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
                  <a href="<?php echo site_url('k_laporan_kepala'); ?>" class="logo" style="text-decoration: none">
                  <i class="fas fa-chart-bar"></i>
                  <p>Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                 <a href="<?php echo site_url('k_peta_sebaran_kepala'); ?>" class="logo" style="text-decoration: none">
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
                      <span class="fw-bold">Kepala Dinas DKPP Surabaya</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="u-text">
                            <h4>
                              Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota
                              Surabaya
                            </h4>
                            <p class="text-muted">kepala@dkppsby.go.id</p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('login'); ?>" class="logo" style="text-decoration: none">
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

            <!-- Statistics Cards -->
            <div class="row">
              <!-- Kotak 1: Jumlah Peternak -->
              <div class="col-md-4">
                <div class="card card-stats card-round stat-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary">
                          <i class="fas fa-users stat-icon"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Jumlah Peternak</p>
                          <h4 class="card-title">12</h4>
                          <p class="card-subtitle">Peternak</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kotak 2: Komoditas Ternak -->
              <div class="col-md-4">
                <div class="card card-stats card-round stat-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-success">
                          <i class="fas fa-paw stat-icon"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Komoditas Ternak</p>
                          <h4 class="card-title">5</h4>
                          <p class="card-subtitle">Jenis Ternak</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kotak 3: Total Ternak -->
              <div class="col-md-4">
                <div class="card card-stats card-round stat-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-warning">
                          <i class="fas fa-warehouse stat-icon"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Total Ternak</p>
                          <h4 class="card-title">1,225</h4>
                          <p class="card-subtitle">Ekor</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Main Content: Grafik dan Peta -->
            <div class="row mt-4">
              <!-- Kolom Kiri: Grafik Kecamatan -->
              <div class="col-md-6">
                <div class="card compact-card stat-card">
                  <div class="card-header">
                    <h6 class="mb-0">Distribusi Peternak per Kecamatan</h6>
                  </div>
                  <div class="card-body">
                    <canvas
                      id="kecamatanChart"
                      class="chart-container"
                    ></canvas>
                  </div>
                  <div class="card-footer bg-transparent border-top-0 pt-0">
                    <div class="text-end">
                      <a href="#" class="btn btn-link text-primary p-0">
                        Lihat Detail
                        <i class="fas fa-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Kolom Kanan: Peta Surabaya -->
              <div class="col-md-6">
                <div class="card map-card stat-card">
                  <div class="card-header">
                    <h6 class="mb-0">Peta Sebaran Peternak Surabaya</h6>
                  </div>
                  <div class="card-body p-0">
                    <div class="map-container-wrapper">
                      <!-- Gambar peta Surabaya -->
                      <div class="position-relative w-100 h-100">
                        <!-- Jika punya gambar peta Surabaya -->
                        <img
                          src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/peta surabaya.jpeg"
                          alt="Peta Surabaya"
                          class="w-100 h-100 object-fit-cover"
                        />

                        <!-- Fallback jika gambar tidak ada -->
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

                          <!-- Mini peta dengan dots -->
                          <div
                            class="d-flex flex-wrap justify-content-center gap-2 mb-3"
                          >
                            <span class="badge bg-primary">Genteng</span>
                            <span class="badge bg-success">Sawahan</span>
                            <span class="badge bg-info">Tambaksari</span>
                            <span class="badge bg-warning">Simokerto</span>
                            <span class="badge bg-danger">Gubeng</span>
                            <span class="badge bg-secondary">+26 lainnya</span>
                          </div>
                        </div>

                        <!-- Overlay info -->
                        <div
                          class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white"
                        >
                          <div
                            class="d-flex justify-content-between align-items-center"
                          >
                            <div>
                              <h6 class="mb-0">Peta Sebaran Peternak</h6>
                              <small>Klik untuk melihat peta interaktif</small>
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
                  <div class="card-footer bg-transparent border-top-0">
                    <div class="text-end">
                      <a
                        href="peta-sebaran-kepala.html"
                        class="btn btn-link text-primary p-0"
                      >
                        Buka Peta Interaktif
                        <i class="fas fa-arrow-right ms-1"></i>
                      </a>
                    </div>
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

    <!-- Chart JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
      // Grafik Distribusi Peternak per Kecamatan - Versi Compact
      document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("kecamatanChart").getContext("2d");
        var kecamatanChart = new Chart(ctx, {
          type: "bar",
          data: {
            labels: ["Genteng", "Sawahan", "Tambaksari", "Gubeng", "Wonokromo"],
            datasets: [
              {
                label: "Jumlah Peternak",
                data: [42, 38, 32, 28, 25],
                backgroundColor: [
                  "#1a73e8",
                  "#34a853",
                  "#fbbc05",
                  "#ea4335",
                  "#9334e6",
                ],
                borderColor: [
                  "#0d47a1",
                  "#2e7d32",
                  "#f57c00",
                  "#c62828",
                  "#7b1fa2",
                ],
                borderWidth: 1,
                borderRadius: 3,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              },
              tooltip: {
                backgroundColor: "rgba(0, 0, 0, 0.8)",
                titleColor: "#fff",
                bodyColor: "#fff",
                borderColor: "#1a73e8",
                borderWidth: 1,
                callbacks: {
                  label: function (context) {
                    return `Peternak: ${context.raw} orang`;
                  },
                },
              },
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  drawBorder: false,
                  color: "rgba(0, 0, 0, 0.05)",
                },
                ticks: {
                  font: {
                    size: 10,
                  },
                  stepSize: 10,
                  padding: 5,
                  callback: function (value) {
                    return value + "";
                  },
                },
              },
              x: {
                grid: {
                  display: false,
                },
                ticks: {
                  font: {
                    size: 10,
                  },
                  padding: 5,
                },
              },
            },
            animation: {
              duration: 1000,
              easing: "easeOutQuart",
            },
          },
        });
      });

      // Script untuk menangani jika gambar tidak ada
      document.addEventListener("DOMContentLoaded", function () {
        const mapImage = document.querySelector(
          'img[src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/peta surabaya.jpeg"]',
        );
        const mapFallback = document.getElementById("map-fallback");

        if (mapImage) {
          mapImage.onerror = function () {
            this.style.display = "none";
            if (mapFallback) {
              mapFallback.classList.remove("d-none");
              mapFallback.classList.add("d-flex");
            }
          };

          mapImage.onload = function () {
            if (mapFallback) {
              mapFallback.classList.add("d-none");
              mapFallback.classList.remove("d-flex");
            }
          };
        }
      });

      function openFullMap() {
        window.location.href = "peta-sebaran-kepala.html";
      }
    </script>
  </body>
</html>
