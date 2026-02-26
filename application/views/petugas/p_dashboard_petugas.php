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
      .district-bar {
        background: #1a73e8;
        height: 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        color: white;
        padding-left: 10px;
        line-height: 20px;
        font-size: 12px;
      }
      .map-container {
        height: 400px;
        background: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
      }
      .commodity-chart {
        height: 250px;
        position: relative;
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
      .action-card {
        border-radius: 10px;
        transition: all 0.3s;
        cursor: pointer;
        height: 100%;
        margin-bottom: 20px;
      }
      .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      }
      .action-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
      }
      .action-link {
        text-decoration: none;
        color: inherit;
      }
      .action-link:hover {
        text-decoration: none;
        color: inherit;
      }
      .card-title-action {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 5px;
      }
      .card-subtitle-action {
        font-size: 0.9rem;
        color: #666;
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
              href="<?php echo base_url(); ?>p_dashboard_petugas"
              class="logo"
              style="text-decoration: none"
            >
              <div
                style="
                  color: #1e3a8a;
                  font-weight: 800;
                  font-size: 24px;
                  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
                <a href="<?php echo base_url(); ?>p_dashboard_petugas">
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
                <a href="<?php echo base_url(); ?>P_Input_Pengobatan">
                  <i class="fas fa-heartbeat"></i>
                  <p>Pengobatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>P_Input_Vaksinasi">
                  <i class="fas fa-syringe"></i>
                  <p>Vaksinasi</p>
                </a>
              </li>

               <!-- Pelaku Usaha -->
                        <li class="nav-item active">
                            <a href="<?php echo base_url(); ?>P_Input_Pelaku_Usaha">
                                <i class="fas fa-users"></i>
                                <p>Pelaku Usaha</p>
                            </a>
                        </li>
                        
              <li class="nav-item active">
        <a href="<?php echo base_url(); ?>P_Input_Jenis_Usaha">
            <i class="fas fa-store"></i>
            <p>Jenis Usaha</p>
        </a>
    </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>p_input_penjual_pakan">
                  <i class="fas fa-seedling"></i>
                  <p>Penjual Pakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>p_input_klinik_hewan">
                  <i class="fas fa-stethoscope"></i>
                  <p>Klinik Hewan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>p_input_penjual_obat_hewan">
                 <i class="fas fa-pills"></i>
                  <p>Penjual Obat Hewan</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo base_url(); ?>p_input_rpu">
                 <i class="fas fa-cut"></i>
                  <p>RPU</p>
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
                        src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/petugas lapangan.png"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="fw-bold"><?php echo $this->session->userdata('username') ?: 'Petugas Lapangan'; ?></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="u-text">
                            <h4>Kecamatan <?php echo $this->session->userdata('kecamatan'); ?></h4>
                            <p class="text-muted"><?php echo $this->session->userdata('username'); ?></p>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>">
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
                <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan'); ?>, Surabaya</h6>
              </div>
            </div>

           <!-- Statistics Cards - Ubah bagian ini -->
<div class="row">
  <!-- Kotak 1: Jumlah Pemilik Usaha -->
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
              <p class="card-category">Jumlah Pemilik Usaha</p>
              <h4 class="card-title"><?php echo isset($total_pemilik_usaha) ? number_format($total_pemilik_usaha, 0, ',', '.') : '0'; ?></h4>
              <p class="card-subtitle">Pemilik</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Kotak 2: Jenis Usaha -->
  <div class="col-md-4">
    <div class="card card-stats card-round stat-card">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-success">
              <i class="fas fa-store stat-icon"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <p class="card-category">Jenis Usaha</p>
              <h4 class="card-title"><?php echo isset($jumlah_jenis_usaha) ? $jumlah_jenis_usaha : '0'; ?></h4>
              <p class="card-subtitle">Jenis Usaha</p>
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
              <h4 class="card-title"><?php echo isset($total_ternak) ? number_format($total_ternak, 0, ',', '.') : '0'; ?></h4>
              <p class="card-subtitle">Ekor</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tambahkan informasi Total Usaha -->
<div class="row mt-2">
  <div class="col-md-12">
    <div class="alert alert-info">
      <i class="fas fa-info-circle me-2"></i>
      Total Usaha Ternak: <strong><?php echo isset($total_usaha) ? number_format($total_usaha, 0, ',', '.') : '0'; ?></strong> data usaha
    </div>
  </div>
</div>

<!-- Action Cards Section - Perbaiki link untuk Jenis Usaha -->
<div class="row mt-4">
  <!-- Card Pengobatan -->
  <div class="col-md-12 mb-4">
    <a href="<?php echo base_url(); ?>P_Input_Pengobatan" class="action-link">
      <div class="card card-stats card-round action-card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-2 text-center">
              <div class="icon-big text-center icon-danger">
                <i class="fas fa-heartbeat action-icon"></i>
              </div>
            </div>
            <div class="col-md-8">
              <h4 class="card-title-action mb-1">PENGOBATAN</h4>
              <p class="card-subtitle-action mb-0">
                Input data pengobatan ternak
              </p>
            </div>
            <div class="col-md-2 text-end">
              <i class="fas fa-chevron-right fa-2x text-muted"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Card Vaksinasi -->
  <div class="col-md-12 mb-4">
    <a href="<?php echo base_url(); ?>P_Input_Vaksinasi" class="action-link">
      <div class="card card-stats card-round action-card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-2 text-center">
              <div class="icon-big text-center icon-info">
                <i class="fas fa-syringe action-icon"></i>
              </div>
            </div>
            <div class="col-md-8">
              <h4 class="card-title-action mb-1">VAKSINASI</h4>
              <p class="card-subtitle-action mb-0">
                Input data vaksinasi ternak
              </p>
            </div>
            <div class="col-md-2 text-end">
              <i class="fas fa-chevron-right fa-2x text-muted"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>


 <!-- Card Jenis Usaha -->
<div class="col-md-12">
    <a href="<?php echo base_url(); ?>P_Input_Jenis_Usaha" class="action-link">
        <div class="card card-stats card-round action-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="icon-big text-center icon-success">
                            <i class="fas fa-store action-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4 class="card-title-action mb-1">
                            JENIS USAHA
                        </h4>
                        <p class="card-subtitle-action mb-0">
                            Input data jenis usaha ternak
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <i class="fas fa-chevron-right fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Core JS Files -->
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
      // Commodity Chart dengan data dinamis
      document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById("commodityChart").getContext("2d");
        var commodityChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [
              {
                data: <?php echo json_encode($chart_data); ?>,
                backgroundColor: <?php echo json_encode($chart_colors); ?>,
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: "bottom",
              },
            },
          },
        });
      });
    </script>
  </body>
</html>