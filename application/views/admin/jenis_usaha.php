<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Master Data Jenis Usaha - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url('assets/SIPETGIS/assets/img/kaiadmin/favicon.ico'); ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/webfont/webfont.min.js'); ?>"></script>
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
                urls: ["<?php echo base_url('assets/SIPETGIS/assets/css/fonts.min.css'); ?>"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/plugins.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/SIPETGIS/assets/css/kaiadmin.min.css'); ?>" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    
    <style>
        /* ==============================================
           WARNA DASAR: #832706
           ============================================== */
        :root {
            --primary: #832706;
            --primary-dark: #6b1f04;
            --primary-light: #a13e1a;
            --primary-soft: #fef3ef;
        }

        .sipetgis-logo {
            color: var(--primary) !important;
            font-weight: 800;
            font-size: 24px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .nav-item.active > a {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-item.active > a i {
            color: var(--primary);
        }

        .sidebar .nav-secondary i {
            color: var(--primary) !important;
        }

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

        .dt-buttons .btn {
            border-radius: 5px;
            margin-right: 5px;
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
            box-shadow: 0 5px 15px rgba(131, 39, 6, 0.08);
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
            background-color: rgba(131, 39, 6, 0.1);
            color: #832706;
        }

        .btn-edit:hover {
            background-color: #832706;
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

        .dt-buttons .btn,
        .dt-buttons .btn-primary,
        .dt-buttons .btn-success,
        .dt-buttons .btn-danger,
        .dt-buttons .btn-info {
            background: linear-gradient(135deg, #832706 0%, #6b1f04 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            padding: 6px 15px !important;
            font-weight: 500 !important;
            transition: all 0.3s !important;
        }

        .dt-buttons .btn:hover {
            background: linear-gradient(135deg, #6b1f04 0%, #541802 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(131, 39, 6, 0.3) !important;
            color: white !important;
        }

        .dt-buttons .btn i {
            color: white !important;
            margin-right: 5px;
        }

        .pagination .page-link {
            border: none;
            color: #495057;
            margin: 0 3px;
            border-radius: 6px !important;
        }

        .pagination .page-item.active .page-link {
            background-color: #832706;
            color: white;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #832706 0%, #6b1f04 100%);
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            color: white;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #6b1f04 0%, #541802 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(131, 39, 6, 0.3);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #832706 0%, #6b1f04 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            padding: 8px 20px !important;
            font-weight: 500 !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6b1f04 0%, #541802 100%) !important;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .alamat-cell {
            max-width: 250px;
            white-space: normal;
            word-wrap: break-word;
        }

        .card {
            border-radius: 16px;
            border: 1px solid #eef2f6;
        }

        @media (max-width: 768px) {
            .dataTables_wrapper { padding: 10px; }
            .dt-buttons .btn { padding: 4px 10px !important; font-size: 12px !important; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo site_url('dashboard'); ?>" class="logo" style="text-decoration: none">
                        <div class="sipetgis-logo">SIPETGIS</div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item"><a href="<?php echo site_url('dashboard'); ?>"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Menu Utama</h4></li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#masterDataSubmenu" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center"><i class="fas fa-database me-2"></i><span>Master Data</span></div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse show" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a></li>
                                    <li class="nav-item active"><a href="<?= site_url('jenis_usaha') ?>" class="nav-link active">Jenis Usaha</a></li>
                                    <li><a href="<?= site_url('akses_pengguna') ?>" class="nav-link">Akses Pengguna</a></li>
                                    <li><a href="<?= site_url('obat') ?>" class="nav-link">Obat</a></li>
                                    <li><a href="<?= site_url('vaksin') ?>" class="nav-link">Vaksin</a></li>
                                    <li><a href="<?= site_url('komoditas') ?>" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                    <li><a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-users me-2"></i><span>Data</span></div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('data_kepemilikan') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('data_history_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('data_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('data_history_vaksinasi') ?>" class="nav-link">History Vaksinasi</a></li>
                                    <li><a href="<?= site_url('data_pengobatan') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('data_penjual_pakan') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('data_klinik') ?>" class="nav-link">Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('data_penjual_obat') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('data_rpu') ?>" class="nav-link">TPU/RPU</a></li>
                                    <li><a href="<?= site_url('data_pemotongan_unggas') ?>" class="nav-link">Pemotongan Unggas</a></li>
                                    <li><a href="<?= site_url('data_demplot') ?>" class="nav-link">Demplot</a></li>
                                    <li><a href="<?= site_url('data_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-chart-bar me-2"></i><span>Laporan</span></div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse" id="laporanSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>" class="nav-link">Data Klinik Hewan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a href="<?= site_url('peta_sebaran') ?>"><i class="fas fa-map-marked-alt"></i><p>Peta Sebaran</p></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url('assets/SIPETGIS/assets/img/logo dkpp.png'); ?>" alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username"><span class="fw-bold">Administrator</span></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <li><div class="user-box"><div class="u-text"><h4>Administrator</h4><p class="text-muted">admin@dkppsby.go.id</p></div></div></li>
                                    <li><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url(); ?>login"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container">
                <div class="page-inner">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    <?php endif; ?>
                    
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i><?php echo $this->session->flashdata('error'); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                    <?php endif; ?>

                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: #832706;">Master Data</h3>
                            <h6 class="op-7 mb-0">Kelola Data Jenis Usaha</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <button class="btn btn-primary-custom text-white" data-bs-toggle="modal" data-bs-target="#tambahDataModal"><i class="fas fa-plus me-2"></i>Tambah Data</button>
                        </div>
                    </div>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="<?= base_url('jenis_usaha/simpan'); ?>" method="post">
                                    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah Data Jenis Usaha</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6"><div class="form-group"><label>Nama Pelaku Usaha <span class="text-danger">*</span></label><input type="text" name="nama_peternak" class="form-control" required></div></div>
                                            <div class="col-md-6"><div class="form-group"><label>Jenis Usaha <span class="text-danger">*</span></label><input type="text" name="jenis_usaha" class="form-control" required></div></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><div class="form-group"><label>Jumlah <span class="text-danger">*</span></label><input type="number" name="jumlah" class="form-control" required></div></div>
                                            <div class="col-md-6"><div class="form-group"><label>Kecamatan <span class="text-danger">*</span></label>
                                                <select name="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    <?php $kecamatan = ['ASEMROWO','BENOWO','BUBUTAN','BULAK','DUKUH PAKIS','GAYUNGAN','GENTENG','GUBENG','GUNUNG ANYAR','JAMBANGAN','KARANG PILANG','KENJERAN','KREMBANGAN','LAKARSANTRI','MULYOREJO','PABEAN CANTIAN','PAKAL','RUNGKUT','SAMBIKEREP','SAWAHAN','SEMAMPIR','SIMOKERTO','SUKOLILO','SUKOMANUNGGAL','TAMBAKSARI','TANDES','TEGALSARI','TENGGILIS MEJOYO','WIYUNG','WONOCOLO','WONOKROMO']; ?>
                                                    <?php foreach($kecamatan as $kec): ?><option value="<?= $kec ?>"><?= $kec ?></option><?php endforeach; ?>
                                                </select>
                                            </div></div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><div class="form-group"><label>Alamat Lengkap <span class="text-danger">*</span></label><textarea name="alamat" class="form-control" rows="3" required></textarea></div></div></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editDataModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="<?= base_url('jenis_usaha/update'); ?>" method="post">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Data Jenis Usaha</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6"><div class="form-group"><label>Nama Pelaku Usaha <span class="text-danger">*</span></label><input type="text" id="edit_nama_peternak" name="nama_peternak" class="form-control" required></div></div>
                                            <div class="col-md-6"><div class="form-group"><label>Jenis Usaha <span class="text-danger">*</span></label><input type="text" id="edit_jenis_usaha" name="jenis_usaha" class="form-control" required></div></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"><div class="form-group"><label>Jumlah <span class="text-danger">*</span></label><input type="number" id="edit_jumlah" name="jumlah" class="form-control" required></div></div>
                                            <div class="col-md-6"><div class="form-group"><label>Kecamatan <span class="text-danger">*</span></label>
                                                <select id="edit_kecamatan" name="kecamatan" class="form-control" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                    <?php foreach($kecamatan as $kec): ?><option value="<?= $kec ?>"><?= $kec ?></option><?php endforeach; ?>
                                                </select>
                                            </div></div>
                                        </div>
                                        <div class="row"><div class="col-md-12"><div class="form-group"><label>Alamat Lengkap <span class="text-danger">*</span></label><textarea id="edit_alamat" name="alamat" class="form-control" rows="3" required></textarea></div></div></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal" style="background: #e6d2c8; border: none; color: #832706; border-radius: 6px; padding: 8px 20px; font-weight: 500;">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="jenisUsahaTable" class="table table-hover w-100">
                                            <thead>
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Nama Pelaku Usaha</th>
                                                    <th>Jenis Usaha</th>
                                                    <th>Jumlah</th>
                                                    <th>Alamat</th>
                                                    <th>Kecamatan</th>
                                                    <th width="100">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($jenis_usaha)): ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach($jenis_usaha as $row): ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= htmlspecialchars($row->nama_peternak ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->jenis_usaha ?? ''); ?></td>
                                                            <td><?= number_format($row->jumlah ?? 0, 0, ',', '.'); ?></td>
                                                            <td class="alamat-cell"><?= htmlspecialchars($row->alamat ?? ''); ?></td>
                                                            <td><?= htmlspecialchars($row->kecamatan ?? ''); ?></td>
                                                            <td>
                                                                <button class="btn btn-action btn-edit" title="Edit"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-nama_peternak="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>"
                                                                        data-jenis_usaha="<?= htmlspecialchars($row->jenis_usaha ?? ''); ?>"
                                                                        data-jumlah="<?= $row->jumlah ?? ''; ?>"
                                                                        data-alamat="<?= htmlspecialchars($row->alamat ?? ''); ?>"
                                                                        data-kecamatan="<?= htmlspecialchars($row->kecamatan ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-action btn-delete" title="Hapus"
                                                                        data-id="<?= $row->id ?? ''; ?>"
                                                                        data-nama="<?= htmlspecialchars($row->nama_peternak ?? ''); ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr><td colspan="7" class="text-center">Tidak ada data</td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td></tr>
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

    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/core/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/SIPETGIS/assets/js/kaiadmin.min.js'); ?>"></script>
    
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
        $(document).ready(function() {
            $("#jenisUsahaTable").DataTable({
                dom: "Bfrtip",
                buttons: [
                    { extend: "copy", text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm', exportOptions: { columns: [0,1,2,3,4,5] } },
                    { extend: "csv", text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm', exportOptions: { columns: [0,1,2,3,4,5] } },
                    { extend: "excel", text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm', exportOptions: { columns: [0,1,2,3,4,5] } },
                    { extend: "pdf", text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm', exportOptions: { columns: [0,1,2,3,4,5] }, title: 'Laporan Data Jenis Usaha' },
                    { extend: "print", text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm', exportOptions: { columns: [0,1,2,3,4,5] } }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                    zeroRecords: "Tidak ada data yang ditemukan",
                    paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" }
                },
                pageLength: 10,
                lengthChange: true,
                lengthMenu: [5, 10, 25, 50, 100],
                responsive: true,
                order: [[0, 'asc']],
                columnDefs: [{ width: '200px', targets: 4 }]
            });

            $(document).on("click", ".btn-edit", function() {
                $('#edit_id').val($(this).data('id'));
                $('#edit_nama_peternak').val($(this).data('nama_peternak'));
                $('#edit_jenis_usaha').val($(this).data('jenis_usaha'));
                $('#edit_jumlah').val($(this).data('jumlah'));
                $('#edit_alamat').val($(this).data('alamat'));
                $('#edit_kecamatan').val($(this).data('kecamatan'));
                $('#editDataModal').modal('show');
            });

            $(document).on("click", ".btn-delete", function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                if (confirm("Apakah Anda yakin ingin menghapus data jenis usaha: " + nama + "?")) {
                    window.location.href = "<?= base_url('jenis_usaha/hapus/'); ?>" + id;
                }
            });

            setTimeout(function() { $('.alert').alert('close'); }, 5000);
        });
    </script>
</body>
</html>