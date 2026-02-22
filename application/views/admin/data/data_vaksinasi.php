<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Data Vaksinasi Ternak</title>
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
                      <a
                        href="<?php echo base_url(); ?>data_kepemilikan_ternak"
                        class="nav-link active"
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
                <h3 class="fw-bold mb-1">Data Vaksinasi Ternak</h3>
                <h6 class="op-7 mb-0">
                  Manajemen data vaksinasi ternak di Kota Surabaya
                </h6>
              </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="form-group mb-0">
                    <label for="filterKomoditas" class="form-label fw-bold">
                      Filter Komoditas Ternak:
                    </label>
                    <select class="form-select" id="filterKomoditas">
                      <option selected>- Pilih Komoditas Ternak -</option>
                      <option value="all">Semua Komoditas</option>
                      <option value="sapi_potong">Sapi Potong</option>
                      <option value="kambing">Kambing</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 text-end">
                  <button id="filterBtn" class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Filter Data
                  </button>
                </div>
              </div>
            </div>

            <!-- Data Table -->
            <div class="card stat-card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="dataVaksinasiTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tahun</th>
                        <th>Jumlah Ternak</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Vaksinasi PMK Tahap II</td>
                        <td>2022</td>
                        <td>60 <span class="text-muted">Ekor</span></td>
                        <td>
                          <button
                            class="btn btn-detail btn-sm"
                            onclick="
                              showDetail('Vaksinasi PMK Tahap II', '2022', '60')
                            "
                          >
                            <i class="fas fa-eye me-1"></i>Detail
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Vaksinasi Brucellosis Tahap I</td>
                        <td>2023</td>
                        <td>45 <span class="text-muted">Ekor</span></td>
                        <td>
                          <button
                            class="btn btn-detail btn-sm"
                            onclick="
                              showDetail(
                                'Vaksinasi Brucellosis Tahap I',
                                '2023',
                                '45',
                              )
                            "
                          >
                            <i class="fas fa-eye me-1"></i>Detail
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Vaksinasi PMK Tahap I</td>
                        <td>2022</td>
                        <td>35 <span class="text-muted">Ekor</span></td>
                        <td>
                          <button
                            class="btn btn-detail btn-sm"
                            onclick="
                              showDetail('Vaksinasi PMK Tahap I', '2022', '35')
                            "
                          >
                            <i class="fas fa-eye me-1"></i>Detail
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Vaksinasi Anthrax</td>
                        <td>2023</td>
                        <td>28 <span class="text-muted">Ekor</span></td>
                        <td>
                          <button
                            class="btn btn-detail btn-sm"
                            onclick="
                              showDetail('Vaksinasi Anthrax', '2023', '28')
                            "
                          >
                            <i class="fas fa-eye me-1"></i>Detail
                          </button>
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
                <h5 class="fw-bold mb-0">Daftar Rincian Transaksi Vaksinasi</h5>
                <div id="detailInfo" class="text-muted mt-2">
                  <!-- Detail info will be inserted here -->
                </div>
              </div>

              <div class="table-responsive">
                <table id="detailTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Peternak</th>
                      <th>Komoditas Ternak</th>
                      <th>Kec / Desa</th>
                      <th>Jumlah Ternak</th>
                      <th>Tanggal Vaksinasi</th>
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
      // Data untuk detail transaksi vaksinasi (berdasarkan gambar)
      const detailData = {
        "Vaksinasi PMK Tahap II": [
          {
            no: 1,
            nama: "LUKAH BANUA BARU",
            komoditas: "Kambing",
            kecamatan: "Paringin Solatan / Batu Piring",
            jumlah: 10,
            tanggal: "13-11-2022",
          },
          {
            no: 2,
            nama: "Meleleh Raya",
            komoditas: "Sapi Potong",
            kecamatan: "Paringin Solatan / Halubau",
            jumlah: 50,
            tanggal: "13-11-2022",
          },
        ],
        "Vaksinasi Brucellosis Tahap I": [
          {
            no: 1,
            nama: "Ternak Maju Jaya",
            komoditas: "Sapi Potong",
            kecamatan: "Genteng / Sudiroprajan",
            jumlah: 25,
            tanggal: "15-03-2023",
          },
          {
            no: 2,
            nama: "Makmur Sejahtera",
            komoditas: "Sapi Potong",
            kecamatan: "Tambaksari / Rangkah",
            jumlah: 20,
            tanggal: "16-03-2023",
          },
        ],
        "Vaksinasi PMK Tahap I": [
          {
            no: 1,
            nama: "Peternak Mandiri",
            komoditas: "Kambing",
            kecamatan: "Sawahan / Putat Jaya",
            jumlah: 15,
            tanggal: "10-05-2022",
          },
          {
            no: 2,
            nama: "Karya Tani",
            komoditas: "Sapi Potong",
            kecamatan: "Genteng / Embong Kaliasin",
            jumlah: 20,
            tanggal: "12-05-2022",
          },
        ],
        "Vaksinasi Anthrax": [
          {
            no: 1,
            nama: "Ternak Sehat",
            komoditas: "Sapi Potong",
            kecamatan: "Tambaksari / Tanjungsari",
            jumlah: 18,
            tanggal: "20-08-2023",
          },
          {
            no: 2,
            nama: "Makmur Farm",
            komoditas: "Kambing",
            kecamatan: "Sawahan / Bendul Merisi",
            jumlah: 10,
            tanggal: "22-08-2023",
          },
        ],
      };

      // Inisialisasi DataTable
      $(document).ready(function () {
        $("#dataVaksinasiTable").DataTable({
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
          const selectedValue = $("#filterKomoditas").val();

          if (
            selectedValue === "all" ||
            selectedValue === "- Pilih Komoditas Ternak -"
          ) {
            $("#dataVaksinasiTable").DataTable().search("").draw();
          } else {
            let searchTerm = "";
            switch (selectedValue) {
              case "sapi_potong":
                searchTerm = "Sapi Potong";
                break;
              case "kambing":
                searchTerm = "Kambing";
                break;
            }
            // Search in the komoditas column (not directly in this table, but in detail)
            // For main table, we'll just filter by matching data
            $("#dataVaksinasiTable").DataTable().search(searchTerm).draw();
          }
        });

        // Close detail button event
        $("#closeDetailBtn").click(function () {
          $("#detailSection").hide();
        });
      });

      // Function to show detail
      function showDetail(namaKegiatan, tahun, jumlah) {
        // Update detail info
        $("#detailInfo").html(`
          <span class="fw-bold">Nama Kegiatan:</span> ${namaKegiatan} (${tahun})<br>
          <span class="fw-bold">Total Ternak Divaksin:</span> ${jumlah} Ekor
        `);

        // Clear and populate detail table
        const detailTableBody = $("#detailTableBody");
        detailTableBody.empty();

        if (detailData[namaKegiatan]) {
          detailData[namaKegiatan].forEach((item) => {
            detailTableBody.append(`
              <tr>
                <td>${item.no}</td>
                <td>${item.nama}</td>
                <td><span class="badge-ternak">${item.komoditas}</span></td>
                <td>${item.kecamatan}</td>
                <td>${item.jumlah} <span class="text-muted">Ekor</span></td>
                <td>${item.tanggal}</td>
              </tr>
            `);
          });
        }

        // Show detail section
        $("#detailSection").show();

        // Scroll to detail section
        $("html, body").animate(
          {
            scrollTop: $("#detailSection").offset().top - 20,
          },
          500,
        );
      }
    </script>
  </body>
</html>