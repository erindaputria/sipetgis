<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Vaksinasi - SIPETGIS</title>
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

      /* Style untuk badge status */
      .badge-status {
        font-size: 12px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
      }

      .badge-hibah {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .badge-pengadaan {
        background-color: #fff3e0;
        color: #f57c00;
      }

      .badge-ya {
        background-color: #e3f2fd;
        color: #1976d2;
      }

      .badge-tidak {
        background-color: #ffebee;
        color: #c62828;
      }

      /* Flash Message */
      .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px;
      }
      
      .wrapper {
        min-height: 100vh;
      }
      
      .main-panel {
        min-height: calc(100vh - 70px);
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
                      <a href="<?= site_url('akses_pengguna') ?>" class="nav-link"
                        >Akses Pengguna</a
                      >
                    </li>
                    <li>
                      <a href="<?= site_url('pengobatan') ?>" class="nav-link">Pengobatan</a>
                    </li>
                    <li>
                      <a href="<?= site_url('vaksinasi') ?>" class="nav-link active">Vaksinasi</a>
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
                <a href="<?php echo base_url(); ?>laporan">
                  <i class="fas fa-chart-bar"></i>
                  <p>Laporan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>peta-sebaran">
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
            <!-- Flash Message -->
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
                <h6 class="op-7 mb-0">Kelola Data Vaksinasi</h6>
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
                  <form action="<?= base_url(); ?>vaksinasi/simpan" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-syringe me-2"></i>Tambah Data Vaksinasi
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label>Nama Vaksinasi</label>
                          <input type="text" name="nama_vaksin" class="form-control" required>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Tahun</label>
                          <select name="tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            <?php 
                            $currentYear = date('Y');
                            for($year = $currentYear; $year >= 2020; $year--): ?>
                              <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endfor; ?>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label>Status Perolehan</label>
                          <select name="status_perolehan" class="form-control" required>
                            <option value="">Pilih Status Perolehan</option>
                            <option value="Hibah/CSR">Hibah/CSR</option>
                            <option value="Pengadaan">Pengadaan</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Bantuan Provinsi</label>
                          <select name="bantuan_prov" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
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
                  <form action="<?= base_url(); ?>vaksinasi/update" method="post">
                    <input type="hidden" name="id_vaksin" id="edit_id">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Data Vaksinasi
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <label>Nama Vaksinasi</label>
                          <input type="text" name="nama_vaksin" id="edit_nama" class="form-control" required>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Tahun</label>
                          <select name="tahun" id="edit_tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            <?php 
                            $currentYear = date('Y');
                            for($year = $currentYear; $year >= 2020; $year--): ?>
                              <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endfor; ?>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                          <label>Status Perolehan</label>
                          <select name="status_perolehan" id="edit_status" class="form-control" required>
                            <option value="">Pilih Status Perolehan</option>
                            <option value="Hibah/CSR">Hibah/CSR</option>
                            <option value="Pengadaan">Pengadaan</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label>Bantuan Provinsi</label>
                          <select name="bantuan_prov" id="edit_bantuan" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
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

            <!-- Content -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="vaksinasiTable"
                        class="table table-hover w-100"
                      >
                        <thead>
                          <tr>
                            <th width="50">No</th>
                            <th>Nama Vaksinasi</th>
                            <th>Tahun</th>
                            <th>Status Perolehan</th>
                            <th>Bantuan Provinsi</th>
                            <th width="100">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($vaksinasi)): ?>
                            <?php $no = 1; ?>
                            <?php foreach($vaksinasi as $row): ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row->nama_vaksin ?? ''); ?></td>
                                <td><?= htmlspecialchars($row->tahun ?? ''); ?></td>
                                <td>
                                  <span class="badge-status 
                                    <?php 
                                      if(isset($row->status_perolehan)) {
                                        if($row->status_perolehan == 'Hibah/CSR') echo 'badge-hibah';
                                        else echo 'badge-pengadaan';
                                      }
                                    ?>">
                                    <?= htmlspecialchars($row->status_perolehan ?? ''); ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge-status 
                                    <?php 
                                      if(isset($row->bantuan_prov)) {
                                        if($row->bantuan_prov == 'Ya') echo 'badge-ya';
                                        else echo 'badge-tidak';
                                      }
                                    ?>">
                                    <?= htmlspecialchars($row->bantuan_prov ?? ''); ?>
                                  </span>
                                </td>
                                <td>
                                  <button class="btn btn-action btn-edit" 
                                          title="Edit"
                                          data-id="<?= $row->id_vaksin; ?>"
                                          data-nama="<?= htmlspecialchars($row->nama_vaksin); ?>"
                                          data-tahun="<?= htmlspecialchars($row->tahun); ?>"
                                          data-status="<?= htmlspecialchars($row->status_perolehan); ?>"
                                          data-bantuan="<?= htmlspecialchars($row->bantuan_prov); ?>">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <button class="btn btn-action btn-delete" 
                                          title="Hapus"
                                          data-id="<?= $row->id_vaksin; ?>"
                                          data-nama="<?= htmlspecialchars($row->nama_vaksin); ?>">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="6" class="text-center">Tidak ada data vaksinasi</td>
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

    <!-- DataTables JS -->
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
      $(document).ready(function () {
        // Inisialisasi DataTable
        var table = $("#vaksinasiTable").DataTable({
          dom:
            '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
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

        // Fungsi untuk edit data
        $(document).on("click", ".btn-edit", function () {
          var id = $(this).data('id');
          var nama = $(this).data('nama');
          var tahun = $(this).data('tahun');
          var status = $(this).data('status');
          var bantuan = $(this).data('bantuan');
          
          // Isi data ke modal edit
          $('#edit_id').val(id);
          $('#edit_nama').val(nama);
          $('#edit_tahun').val(tahun);
          $('#edit_status').val(status);
          $('#edit_bantuan').val(bantuan);
          
          // Tampilkan modal edit
          $('#editDataModal').modal('show');
        });

        // Fungsi untuk hapus data
        $(document).on("click", ".btn-delete", function () {
          var id = $(this).data('id');
          var nama = $(this).data('nama');
          
          if (confirm("Apakah Anda yakin ingin menghapus data vaksinasi: " + nama + "?")) {
            window.location.href = "<?= base_url('vaksinasi/hapus/'); ?>" + id;
          }
        });

        // Refresh halaman setelah modal tambah/edit data ditutup
        $('#tambahDataModal, #editDataModal').on('hidden.bs.modal', function () {
          location.reload();
        });
        
        // Auto close alert setelah 5 detik
        setTimeout(function() {
          $('.alert').alert('close');
        }, 5000);
      });
    </script>
  </body>
</html>