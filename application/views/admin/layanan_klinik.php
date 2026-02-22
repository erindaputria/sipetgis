<!doctype html>
<html lang="id">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Layanan Klinik - SIPETGIS</title>
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
      /* DataTables Custom Style */
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

      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter,
      .dataTables_wrapper .dataTables_info,
      .dataTables_wrapper .dataTables_paginate {
        padding: 10px;
      }
      
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

      .btn-toggle {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
      }

      .btn-toggle:hover {
        background-color: #28a745;
        color: white;
      }

      .btn-toggle.inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
      }

      .btn-toggle.inactive:hover {
        background-color: #6c757d;
        color: white;
      }

      .badge-kategori {
        font-size: 12px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
      }

      .badge-grooming {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .badge-penitipan {
        background-color: #fff3e0;
        color: #f57c00;
      }

      .badge-vaksinasi {
        background-color: #e3f2fd;
        color: #1976d2;
      }

      .badge-bedah {
        background-color: #f3e5f5;
        color: #7b1fa2;
      }

      .badge-sterilisasi {
        background-color: #fce4ec;
        color: #c2185b;
      }

      .badge-perawatan {
        background-color: #e0f7fa;
        color: #006064;
      }

      .badge-diagnostik {
        background-color: #fff9c4;
        color: #f57f17;
      }

      .badge-emergensi {
        background-color: #ffebee;
        color: #b71c1c;
      }

      .badge-default {
        background-color: #f5f5f5;
        color: #616161;
      }

      .badge-status {
        font-size: 11px;
        font-weight: 500;
        padding: 3px 8px;
        border-radius: 15px;
        white-space: nowrap;
      }

      .badge-active {
        background-color: #e8f5e9;
        color: #2e7d32;
      }

      .badge-inactive {
        background-color: #ffebee;
        color: #b71c1c;
      }

      .btn-primary-custom {
        background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
        border: none;
        border-radius: 6px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s;
        color: white;
      }

      .btn-primary-custom:hover {
        background: linear-gradient(135deg, #3a56d4 0%, #3046b8 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
      }

      /* Alert Styles */
      .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px;
      }

      .harga-text {
        font-weight: 600;
        color: #2e7d32;
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
                  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                  letter-spacing: 0.5px;
                  line-height: 1;
                "
              >
                SIPETGIS
              </div>
            </a>
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
                      <a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a>
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
                    <li>
                      <a href="<?= site_url('layanan_klinik') ?>" class="nav-link active">Layanan Klinik</a>
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
                      <a href="<?= site_url('data_kepemilikan') ?>" class="nav-link">Kepemilikan Ternak</a>
                    </li>
                    <li>
                      <a href="<?= site_url('data_history_ternak') ?>" class="nav-link">History Data Ternak</a>
                    </li>
                    <li>
                      <a href="<?= site_url('data_vaksinasi') ?>" class="nav-link">Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?= site_url('data_history_vaksinasi') ?>" class="nav-link">History Vaksinasi</a>
                    </li>
                    <li>
                      <a href="<?= site_url('data_pengobatan') ?>" class="nav-link">Pengobatan Ternak</a>
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
          <div class="main-header-logo"></div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
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
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-1">Master Data</h3>
                <h6 class="op-7 mb-0">Kelola Data Layanan Klinik</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
                  <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
              </div>
            </div>

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="<?= base_url('layanan_klinik/simpan'); ?>" method="post">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-clinic-medical me-2"></i>Tambah Data Layanan Klinik
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_layanan" class="form-control" required>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Kategori <span class="text-danger">*</span></label>
                          <select name="kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach($kategori_options as $key => $value): ?>
                              <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Harga (Rp)</label>
                          <input type="number" name="harga" class="form-control" min="0" step="1000" value="0">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                      </div>
                      <div class="mb-3">
                        <div class="form-check">
                          <input type="checkbox" name="status" class="form-check-input" value="1" checked>
                          <label class="form-check-label">Aktif</label>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Modal Edit Data -->
            <div class="modal fade" id="editDataModal" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="<?= base_url('layanan_klinik/update'); ?>" method="post">
                    <input type="hidden" name="id_layanan" id="edit_id">
                    <div class="modal-header">
                      <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Data Layanan Klinik
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_layanan" id="edit_nama" class="form-control" required>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Kategori <span class="text-danger">*</span></label>
                          <select name="kategori" id="edit_kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach($kategori_options as $key => $value): ?>
                              <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Harga (Rp)</label>
                          <input type="number" name="harga" id="edit_harga" class="form-control" min="0" step="1000">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                      </div>
                      <div class="mb-3">
                        <div class="form-check">
                          <input type="checkbox" name="status" id="edit_status" class="form-check-input" value="1">
                          <label class="form-check-label">Aktif</label>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Update</button>
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
                      <table id="layananKlinikTable" class="table table-hover w-100">
                        <thead>
                          <tr>
                            <th width="50">No</th>
                            <th>Nama Layanan</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($layanan_klinik)): ?>
                            <?php $no = 1; ?>
                            <?php foreach($layanan_klinik as $row): ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row->nama_layanan ?? ''); ?></td>
                                <td>
                                  <?php
                                    $kategori = $row->kategori ?? '';
                                    $badge_class = 'badge-default';
                                    
                                    if($kategori == 'Grooming') $badge_class = 'badge-grooming';
                                    elseif($kategori == 'Penitipan') $badge_class = 'badge-penitipan';
                                    elseif($kategori == 'Vaksinasi') $badge_class = 'badge-vaksinasi';
                                    elseif($kategori == 'Bedah') $badge_class = 'badge-bedah';
                                    elseif($kategori == 'Sterilisasi') $badge_class = 'badge-sterilisasi';
                                    elseif($kategori == 'Perawatan') $badge_class = 'badge-perawatan';
                                    elseif($kategori == 'Diagnostik') $badge_class = 'badge-diagnostik';
                                    elseif($kategori == 'Emergensi') $badge_class = 'badge-emergensi';
                                  ?>
                                  <span class="badge-kategori <?= $badge_class ?>">
                                    <?= htmlspecialchars($kategori); ?>
                                  </span>
                                </td>
                                <td><?= htmlspecialchars($row->deskripsi ?? '-'); ?></td>
                                <td>
                                  <span class="harga-text">
                                    Rp <?= number_format($row->harga ?? 0, 0, ',', '.'); ?>
                                  </span>
                                </td>
                                <td>
                                  <?php if($row->status == 1): ?>
                                    <span class="badge-status badge-active">
                                      <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                  <?php else: ?>
                                    <span class="badge-status badge-inactive">
                                      <i class="fas fa-times-circle me-1"></i>Tidak Aktif
                                    </span>
                                  <?php endif; ?>
                                </td>
                                <td>
                                  <button class="btn btn-action btn-edit" 
                                          title="Edit"
                                          data-id="<?= $row->id_layanan; ?>"
                                          data-nama="<?= htmlspecialchars($row->nama_layanan); ?>"
                                          data-kategori="<?= htmlspecialchars($row->kategori); ?>"
                                          data-deskripsi="<?= htmlspecialchars($row->deskripsi); ?>"
                                          data-harga="<?= $row->harga; ?>"
                                          data-status="<?= $row->status; ?>">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <a href="<?= base_url('layanan_klinik/toggle_status/'.$row->id_layanan); ?>" 
                                     class="btn btn-action <?= ($row->status == 1) ? 'btn-toggle' : 'btn-toggle inactive' ?>" 
                                     title="<?= ($row->status == 1) ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                    <i class="fas <?= ($row->status == 1) ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                  </a>
                                  <button class="btn btn-action btn-delete" 
                                          title="Hapus"
                                          data-id="<?= $row->id_layanan; ?>"
                                          data-nama="<?= htmlspecialchars($row->nama_layanan); ?>">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="7" class="text-center">Tidak ada data layanan klinik</td>
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

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    
    <script>
      $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#layananKlinikTable').DataTable({
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
          order: [[0, 'asc']],
          columnDefs: [
            { orderable: false, targets: [6] } // Non-aktifkan sorting untuk kolom Aksi
          ]
        });

        // Edit button click
        $(document).on('click', '.btn-edit', function() {
          var id = $(this).data('id');
          var nama = $(this).data('nama');
          var kategori = $(this).data('kategori');
          var deskripsi = $(this).data('deskripsi');
          var harga = $(this).data('harga');
          var status = $(this).data('status');
          
          $('#edit_id').val(id);
          $('#edit_nama').val(nama);
          $('#edit_kategori').val(kategori);
          $('#edit_deskripsi').val(deskripsi);
          $('#edit_harga').val(harga);
          $('#edit_status').prop('checked', status == 1);
          
          $('#editDataModal').modal('show');
        });

        // Delete button click
        $(document).on('click', '.btn-delete', function() { 
          var id = $(this).data('id');
          var nama = $(this).data('nama');
          
          if (confirm('Apakah Anda yakin ingin menghapus data layanan: ' + nama + '?')) {
            window.location.href = '<?= base_url("layanan_klinik/hapus/"); ?>' + id;
          }
        });

        // Auto close alerts
        setTimeout(function() {
          $('.alert').alert('close');
        }, 5000);
      });
    </script>
  </body>
</html>