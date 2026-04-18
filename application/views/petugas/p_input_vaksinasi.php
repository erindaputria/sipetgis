<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Input Vaksinasi Ternak - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" />

    <style>
        .form-header {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .table-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
        }
        .btn-submit:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1a73e8 100%);
            color: white;
        }
        .btn-get-location {
            background: #34a853;
            color: white;
            border: none;
        }
        .btn-get-location:hover {
            background: #2e8b47;
            color: white;
        }
        .btn-toggle-form {
            background: linear-gradient(90deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            border: none;
            font-weight: 600;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-toggle-form:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1a73e8 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
            color: white;
        }
        .photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px dashed #ddd;
            display: none;
        }
        .photo-placeholder {
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            cursor: pointer;
        }
        .coordinate-info {
            background: #f8f9fa;
            border-left: 4px solid #1a73e8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .address-card {
            border-left: 4px solid #34a853;
            margin-bottom: 20px;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .table-custom th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .action-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .action-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        .form-container {
            display: none;
            overflow: hidden;
            transition: all 0.5s ease;
        }
        .form-container.show {
            display: block !important;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-header-address {
            background: #f8f9fa;
            border-bottom: 2px solid #34a853;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
        .profile-username {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #1a73e8;
        }
        .topbar-user .dropdown-toggle::after {
            display: none;
        }
        .komoditas-table th {
            background-color: #e9f0fa;
            font-size: 0.9rem;
        }
        .btn-add-row {
            background-color: #28a745;
            color: white;
        }
        .btn-add-row:hover {
            background-color: #218838;
            color: white;
        }
        .btn-remove-row {
            background-color: #dc3545;
            color: white;
        }
        .btn-remove-row:hover {
            background-color: #c82333;
            color: white;
        }
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
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
        .dataTables_filter { float: right !important; }
        .dataTables_length { float: left !important; }
        .dt-buttons { float: left !important; margin-right: 10px; }
        .foto-link { color: #1a73e8; text-decoration: none; cursor: pointer; }
        .foto-link:hover { text-decoration: underline; color: #0d47a1; }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>p_dashboard_petugas" class="logo" style="text-decoration: none">
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px;">SIPETGIS</div>
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
                        <li class="nav-item"><a href="<?php echo base_url(); ?>p_dashboard_petugas"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Menu Utama</h4></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>P_Input_Pengobatan"><i class="fas fa-heartbeat"></i><p>Pengobatan</p></a></li>
                        <li class="nav-item active"><a href="<?php echo base_url(); ?>P_Input_Vaksinasi"><i class="fas fa-syringe"></i><p>Vaksinasi</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>P_Input_Pelaku_Usaha"><i class="fas fa-users"></i><p>Pelaku Usaha</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>P_Input_Jenis_Usaha"><i class="fas fa-store"></i><p>Jenis Usaha</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>P_Input_Penjual"><i class="fas fa-store-alt"></i><p>Penjual</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>P_Input_Klinik_Hewan"><i class="fas fa-stethoscope"></i><p>Klinik Hewan</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>p_input_rpu"><i class="fas fa-chart-line"></i><p>RPU</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>p_input_pemotongan_unggas"><i class="fas fa-cut"></i><p>Pemotongan Unggas</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>p_input_demplot"><i class="fas fa-seedling"></i><p>Demplot</p></a></li>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>p_input_stok_pakan"><i class="fas fa-warehouse"></i><p>Stok Pakan</p></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm"><img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/petugas lapangan.png" alt="..." class="avatar-img rounded-circle" /></div>
                                    <span class="profile-username"><span class="fw-bold">Petugas Lapangan</span></span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li><div class="user-box"><div class="u-text"><h4>Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?></h4><p class="text-muted"><?php echo $this->session->userdata('username'); ?></p></div></div></li>
                                        <li><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                                    </div>
                                </ul>
                            </li> 
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div class="flex-grow-1">
                            <h3 class="fw-bold mb-1">Vaksinasi Ternak</h3>
                            <h6 class="op-7 mb-0">Kecamatan <?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>, Surabaya</h6>
                        </div>
                    </div>

                    <div id="alert-container"></div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card action-card">
                                <div class="card-body text-center p-4">
                                    <button type="button" class="btn btn-toggle-form" id="toggleFormBtn" onclick="toggleForm()">
                                        <i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI
                                    </button>
                                </div>
                            </div>

                            <div class="form-container" id="formContainer">
                                <div class="card form-card">
                                    <div class="card-header"><h4 class="card-title">INPUT DATA VAKSINASI BARU</h4></div>
                                    <div class="card-body">
                                        <form id="formVaksinasi" enctype="multipart/form-data">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="kecamatan_session" id="kecamatan_session" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>">
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Peternak</label>
                                                    <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" placeholder="Masukkan nama peternak" required />
                                                    <div class="invalid-feedback">Nama peternak harus diisi</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">NIK</label>
                                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" />
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Nama Petugas</label>
                                                    <select class="form-control" id="nama_petugas" name="nama_petugas" required>
                                                        <option value="">Pilih Petugas</option>
                                                        <option value="Drh. Sunarno Aristono, M.Si">Drh. Sunarno Aristono, M.Si</option>
                                                        <option value="Drh. Gagat Rahino H S, M.SI">Drh. Gagat Rahino H S, M.SI</option>
                                                        <option value="Drh. Wafiroh">Drh. Wafiroh</option>
                                                        <option value="Samsul Arifin">Samsul Arifin</option>
                                                        <option value="Drh. Arfiandy Noorrahman">Drh. Arfiandy Noorrahman</option>
                                                        <option value="Drh. Kartika Eka Paksi">Drh. Kartika Eka Paksi</option>
                                                        <option value="Drh. Romadhony Arif">Drh. Romadhony Arif</option>
                                                        <option value="Drh. Rinenggo Palupi">Drh. Rinenggo Palupi</option>
                                                        <option value="Drh. Rieska Nursita">Drh. Rieska Nursita</option>
                                                        <option value="Drh. Albert Fabio S">Drh. Albert Fabio S</option>
                                                        <option value="Drh. Rizal Maulana I">Drh. Rizal Maulana I</option>
                                                        <option value="Drh. Moch Rozali">Drh. Moch Rozali</option>
                                                        <option value="Drh. Arsanti Arsy">Drh. Arsanti Arsy</option>
                                                        <option value="Drh. Richa Putri A">Drh. Richa Putri A</option>
                                                        <option value="Drh. Niken Rahmawati">Drh. Niken Rahmawati</option>
                                                    </select>
                                                    <div class="invalid-feedback">Nama petugas harus dipilih</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Tanggal Vaksinasi</label>
                                                    <input type="date" class="form-control" id="tanggal_vaksinasi" name="tanggal_vaksinasi" required />
                                                    <div class="invalid-feedback">Tanggal vaksinasi harus diisi</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label required-field">Bantuan Provinsi</label>
                                                    <select class="form-control" id="bantuan_prov" name="bantuan_prov" required>
                                                        <option value="">Pilih Status Bantuan</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                    <div class="invalid-feedback">Status bantuan provinsi harus dipilih</div>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">No. Telepon</label>
                                                    <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukkan telepon" />
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label required-field">Alamat Lengkap</label>
                                                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap (Jalan, Gang, No. Rumah, dll)" required></textarea>
                                                    <div class="invalid-feedback">Alamat lengkap harus diisi</div>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0"><i class="fas fa-list me-2 text-success"></i>DATA HEWAN TERNAK</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered komoditas-table" id="komoditasTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="20%">Jenis Hewan <span class="text-danger">*</span></th>
                                                                            <th width="20%">Jenis Vaksinasi <span class="text-danger">*</span></th>
                                                                            <th width="15%">Dosis <span class="text-danger">*</span></th>
                                                                            <th width="15%">Jumlah Hewan <span class="text-danger">*</span></th>
                                                                            <th width="10%">Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="komoditasBody">
                                                                        <tr class="komoditas-row">
                                                                            <td>
                                                                                <select class="form-control komoditas_ternak" name="komoditas_ternak[]" required>
                                                                                    <option value="">Pilih Hewan</option>
                                                                                    <option value="Sapi Potong">Sapi Potong</option>
                                                                                    <option value="Sapi Perah">Sapi Perah</option>
                                                                                    <option value="Kambing">Kambing</option>
                                                                                    <option value="Ayam">Ayam</option>
                                                                                    <option value="Itik">Itik</option>
                                                                                    <option value="Angsa">Angsa</option>
                                                                                    <option value="Kalkun">Kalkun</option>
                                                                                    <option value="Burung">Burung</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control jenis_vaksinasi" name="jenis_vaksinasi[]" required>
                                                                                    <option value="">Pilih Vaksinasi</option>
                                                                                    <option value="Vaksinasi PMK">Vaksinasi PMK</option>
                                                                                    <option value="Vaksinasi ND-AI">Vaksinasi ND-AI</option>
                                                                                    <option value="Vaksinasi LSD">Vaksinasi LSD</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control dosis" name="dosis[]" required>
                                                                                    <option value="">Pilih Dosis</option>
                                                                                    <option value="1">1 (Dosis Pertama)</option>
                                                                                    <option value="2">2 (Dosis Kedua)</option>
                                                                                    <option value="Booster">Booster</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Jumlah" min="1" required />
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris"><i class="fas fa-plus"></i></button>
                                                                                <button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris" style="display: none;"><i class="fas fa-trash"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2 text-success"></i>WILAYAH ADMINISTRASI</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kecamatan</label>
                                                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>" readonly />
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Kelurahan</label>
                                                                    <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                                        <option value="">Pilih Kelurahan</option>
                                                                        <?php 
                                                                        $user_kec = $this->session->userdata('kecamatan') ?: 'Benowo';
                                                                        if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): 
                                                                            foreach ($kel_list[$user_kec] as $kel): ?>
                                                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                                                        <?php endforeach; endif; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback">Desa/kelurahan harus dipilih</div>
                                                                </div>

                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">RT</label>
                                                                    <input type="text" class="form-control" id="rt" name="rt" placeholder="RT" />
                                                                </div>
                                                                
                                                                <div class="col-md-3 mb-3">
                                                                    <label class="form-label">RW</label>
                                                                    <input type="text" class="form-control" id="rw" name="rw" placeholder="RW" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0"><i class="fas fa-globe me-2 text-success"></i>TITIK KOORDINAT</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Latitude</label>
                                                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Latitude harus diisi. Klik tombol 'Ambil Lokasi'</div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label required-field">Longitude</label>
                                                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude akan diambil otomatis" readonly required />
                                                                    <div class="invalid-feedback">Longitude harus diisi. Klik tombol 'Ambil Lokasi'</div>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <button class="btn btn-get-location" type="button" id="btnGetLocation" onclick="ambilLokasi()">
                                                                        <i class="fas fa-map-marker-alt me-2"></i>Ambil Lokasi
                                                                    </button>
                                                                    <div class="coordinate-info mt-2" id="coordinateInfo" style="display: none">
                                                                        <small><i class="fas fa-info-circle me-1"></i>Koordinat berhasil diambil: <span id="latDisplay"></span>, <span id="lngDisplay"></span><br /><span id="accuracyInfo"></span></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card address-card">
                                                        <div class="card-header card-header-address">
                                                            <h5 class="card-title mb-0"><i class="fas fa-camera me-2 text-success"></i>FOTO VAKSINASI</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div class="d-flex align-items-start">
                                                                        <div class="me-3">
                                                                            <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('foto_vaksinasi').click()">
                                                                                <div class="text-center"><i class="fas fa-camera fa-2x mb-2"></i><div>Klik untuk upload foto</div></div>
                                                                            </div>
                                                                            <img id="photoPreview" class="photo-preview" alt="Preview Foto" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <input type="file" class="form-control d-none" id="foto_vaksinasi" name="foto_vaksinasi" accept="image/jpeg, image/jpg, image/png" onchange="previewFoto(this)" />
                                                                            <small class="text-muted d-block mb-2">Upload foto vaksinasi (maks. 5MB, format: JPG, PNG)</small>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('foto_vaksinasi').click()"><i class="fas fa-upload me-1"></i>Pilih File</button>
                                                                            <button type="button" class="btn btn-outline-danger btn-sm ms-2" id="btnRemovePhoto" style="display: none" onclick="hapusFoto()"><i class="fas fa-trash me-1"></i>Hapus</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-md-12">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-light me-2" id="btnCancel" onclick="batalForm()"><i class="fas fa-times me-1"></i>Batal</button>
                                                        <button type="submit" class="btn btn-submit"><i class="fas fa-save me-1"></i>Simpan Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FILTER SECTION -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Jenis Hewan:</label>
                                    <select class="form-select" id="filterKomoditas">
                                        <option selected value="all">Semua Jenis Hewan</option>
                                        <option value="Sapi Potong">Sapi Potong</option>
                                        <option value="Sapi Perah">Sapi Perah</option>
                                        <option value="Kambing">Kambing</option>
                                        <option value="Ayam">Ayam</option>
                                        <option value="Itik">Itik</option>
                                        <option value="Angsa">Angsa</option>
                                        <option value="Kalkun">Kalkun</option>
                                        <option value="Burung">Burung</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterKelurahan" class="form-label fw-bold">Filter Kelurahan:</label>
                                    <select class="form-select" id="filterKelurahan">
                                        <option selected value="all">Semua Kelurahan</option>
                                        <?php if (isset($kel_list[$user_kec]) && is_array($kel_list[$user_kec])): foreach ($kel_list[$user_kec] as $kel): ?>
                                            <option value="<?php echo $kel; ?>"><?php echo $kel; ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label for="filterPeriode" class="form-label fw-bold">Filter Periode:</label>
                                    <select class="form-select" id="filterPeriode">
                                        <option selected value="all">Semua Periode</option>
                                        <option value="2026">Tahun 2026</option>
                                        <option value="2025">Tahun 2025</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <button id="filterBtn" class="btn btn-primary" onclick="filterData()"><i class="fas fa-filter me-2"></i>Filter Data</button>
                                <button id="resetBtn" class="btn btn-outline-secondary" onclick="resetFilter()"><i class="fas fa-redo me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card form-card mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="vaksinasiTable" class="table table-bordered table-hover table-custom">
                                    <thead>
                                        <tr>
                                            <th width="30">No</th>
                                            <th>Nama Peternak</th>
                                            <th>Jenis Vaksin</th>
                                            <th>Dosis</th>
                                            <th>Jumlah</th>
                                            <th>Tahun</th>
                                            <th>Kelurahan</th>
                                            <th>Alamat</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTableBody">
                                        <?php if (!empty($vaksinasi_data)): ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($vaksinasi_data as $data): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($data['nama_peternak'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['jenis_vaksinasi'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['dosis'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['jumlah'] ?? '0'); ?></td>
                                                    <td><?php echo isset($data['tanggal_vaksinasi']) ? date('Y', strtotime($data['tanggal_vaksinasi'])) : '-'; ?></td>
                                                    <td><?php echo htmlspecialchars($data['kelurahan'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($data['alamat'] ?? '-'); ?></td>
                                                    <td>
                                                        <?php if (!empty($data['foto_vaksinasi'])): ?>
                                                            <a href="javascript:void(0)" class="foto-link" onclick="showFoto('<?php echo base_url(); ?>uploads/vaksinasi/<?php echo $data['foto_vaksinasi']; ?>')"><i class="fas fa-image me-1"></i>Lihat Foto</a>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary">Tidak Ada Foto</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="9" class="text-center">Tidak ada data vaksinasi</td><th>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>

                    <!-- Modal Foto -->
                    <div class="modal fade modal-foto" id="fotoModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header"><h5 class="modal-title">Foto Vaksinasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body text-center"><img id="fotoModalImg" src="" alt="Foto Vaksinasi" style="max-width: 100%; max-height: 80vh;"></div>
                            </div>
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
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        // VARIABEL GLOBAL
        var dataTable;
        
        // ==================== FUNGSI VALIDASI KOMODITAS ====================
        function validateKomoditasRows() {
            var isValid = true;
            var errorMessage = '';
            
            $('.komoditas-row').each(function(index) {
                var komoditas = $(this).find('select[name="komoditas_ternak[]"]').val();
                var jenisVaksin = $(this).find('select[name="jenis_vaksinasi[]"]').val();
                var dosis = $(this).find('select[name="dosis[]"]').val();
                var jumlah = $(this).find('input[name="jumlah[]"]').val();
                
                if (!komoditas || komoditas === '') {
                    isValid = false;
                    errorMessage = 'Jenis hewan baris ke-' + (index + 1) + ' harus diisi';
                    return false;
                }
                
                if (!jenisVaksin || jenisVaksin === '') {
                    isValid = false;
                    errorMessage = 'Jenis vaksinasi baris ke-' + (index + 1) + ' harus dipilih';
                    return false;
                }
                
                if (!dosis || dosis === '') {
                    isValid = false;
                    errorMessage = 'Dosis baris ke-' + (index + 1) + ' harus dipilih';
                    return false;
                }
                
                if (!jumlah || parseInt(jumlah) < 1) {
                    isValid = false;
                    errorMessage = 'Jumlah baris ke-' + (index + 1) + ' harus diisi (minimal 1)';
                    return false;
                }
            });
            
            if (!isValid) {
                alert(errorMessage);
                return false;
            }
            return true;
        }
        
        // ==================== FUNGSI LAINNYA ====================
        function toggleForm() {
            var formContainer = document.getElementById('formContainer');
            var toggleBtn = document.getElementById('toggleFormBtn');
            
            if (formContainer.classList.contains('show')) {
                formContainer.classList.remove('show');
                toggleBtn.innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI';
            } else {
                formContainer.classList.add('show');
                toggleBtn.innerHTML = '<i class="fas fa-minus-circle me-2"></i> TUTUP FORM INPUT VAKSINASI';
                setTimeout(function() {
                    formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }

        function batalForm() {
            resetForm();
            document.getElementById('formContainer').classList.remove('show');
            document.getElementById('toggleFormBtn').innerHTML = '<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI';
        }

        function ambilLokasi() {
            if (navigator.geolocation) {
                var btn = document.getElementById('btnGetLocation');
                var originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengambil lokasi...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        var accuracy = position.coords.accuracy;
                        var formattedLat = lat.toFixed(6);
                        var formattedLng = lng.toFixed(6);

                        document.getElementById('latitude').value = formattedLat;
                        document.getElementById('longitude').value = formattedLng;
                        document.getElementById('latitude').classList.remove('is-invalid');
                        document.getElementById('longitude').classList.remove('is-invalid');
                        document.getElementById('latDisplay').innerText = formattedLat;
                        document.getElementById('lngDisplay').innerText = formattedLng;
                        document.getElementById('accuracyInfo').innerText = 'Akurasi: ±' + Math.round(accuracy) + ' meter';
                        document.getElementById('coordinateInfo').style.display = 'block';
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        showAlert('success', 'Lokasi berhasil diambil!');
                    },
                    function(error) {
                        var errorMessage = 'Gagal mendapatkan lokasi. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED: errorMessage += 'Izin lokasi ditolak.'; break;
                            case error.POSITION_UNAVAILABLE: errorMessage += 'Informasi lokasi tidak tersedia.'; break;
                            case error.TIMEOUT: errorMessage += 'Waktu permintaan lokasi habis.'; break;
                            default: errorMessage += 'Terjadi kesalahan.';
                        }
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        showAlert('danger', errorMessage);
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                showAlert('danger', 'Browser Anda tidak mendukung geolocation.');
            }
        }

        function previewFoto(input) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('danger', 'Ukuran file maksimal 5MB');
                    input.value = '';
                    return;
                }
                var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    showAlert('danger', 'Format file harus JPG atau PNG');
                    input.value = '';
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                    document.getElementById('photoPreview').style.display = 'block';
                    document.getElementById('photoPlaceholder').style.display = 'none';
                    document.getElementById('btnRemovePhoto').style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        }

        function hapusFoto() {
            document.getElementById('foto_vaksinasi').value = '';
            document.getElementById('photoPreview').style.display = 'none';
            document.getElementById('photoPlaceholder').style.display = 'flex';
            document.getElementById('btnRemovePhoto').style.display = 'none';
        }

        function filterData() {
            var komoditas = document.getElementById('filterKomoditas').value;
            var kelurahan = document.getElementById('filterKelurahan').value;
            var periode = document.getElementById('filterPeriode').value;
            var searchTerm = "";
            if (komoditas !== "all") searchTerm += komoditas;
            if (kelurahan !== "all") {
                if (searchTerm) searchTerm += " ";
                searchTerm += kelurahan;
            }
            if (periode !== "all") {
                if (searchTerm) searchTerm += " ";
                searchTerm += periode;
            }
            dataTable.search(searchTerm).draw();
        }

        function resetFilter() {
            document.getElementById('filterKomoditas').value = "all";
            document.getElementById('filterKelurahan').value = "all";
            document.getElementById('filterPeriode').value = "all";
            dataTable.search("").draw();
        }

        function resetForm() {
            $('#formContainer').removeClass('show');
            $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI');
            $('#formVaksinasi')[0].reset();
            $('#komoditasBody').empty();
            const defaultRow = `<tr class="komoditas-row"><td><select class="form-control komoditas_ternak" name="komoditas_ternak[]" required><option value="">Pilih Hewan</option><option value="Sapi Potong">Sapi Potong</option><option value="Sapi Perah">Sapi Perah</option><option value="Kambing">Kambing</option><option value="Ayam">Ayam</option><option value="Itik">Itik</option><option value="Angsa">Angsa</option><option value="Kalkun">Kalkun</option><option value="Burung">Burung</option></select></td><td><select class="form-control jenis_vaksinasi" name="jenis_vaksinasi[]" required><option value="">Pilih Vaksinasi</option><option value="Vaksinasi PMK">Vaksinasi PMK</option><option value="Vaksinasi ND-AI">Vaksinasi ND-AI</option><option value="Vaksinasi LSD">Vaksinasi LSD</option></select></td><td><select class="form-control dosis" name="dosis[]" required><option value="">Pilih Dosis</option><option value="1">1 (Dosis Pertama)</option><option value="2">2 (Dosis Kedua)</option><option value="Booster">Booster</option></select></td><td><input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Jumlah" min="1" required /></td><td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris"><i class="fas fa-plus"></i></button><button type="button" class="btn btn-danger btn-sm btn-remove-row" style="display: none;" title="Hapus baris"><i class="fas fa-trash"></i></button></td></tr>`;
            $('#komoditasBody').html(defaultRow);
            updateRemoveButtons();
            $('#kecamatan').val('<?php echo $this->session->userdata('kecamatan') ?: 'Benowo'; ?>');
            const today = new Date().toISOString().split('T')[0];
            $('#tanggal_vaksinasi').val(today);
            $('#coordinateInfo').hide();
            $('#photoPreview').hide();
            $('#photoPlaceholder').show();
            $('#btnRemovePhoto').hide();
            $('.is-invalid').removeClass('is-invalid');
        }

        function showAlert(type, message) {
            var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
            $('#alert-container').html(alertHtml);
            setTimeout(function() { 
                $('.alert-dismissible').alert('close'); 
            }, 5000);
        }

        function showFoto(url) {
            $('#fotoModalImg').attr('src', url);
            $('#fotoModal').modal('show');
        }

        function updateRemoveButtons() {
            if ($('.komoditas-row').length > 1) {
                $('.btn-remove-row').show();
            } else {
                $('.btn-remove-row').hide();
            }
        }

        function addKomoditasRow() {
            const newRow = `<tr class="komoditas-row"><td><select class="form-control komoditas_ternak" name="komoditas_ternak[]" required><option value="">Pilih Hewan</option><option value="Sapi Potong">Sapi Potong</option><option value="Sapi Perah">Sapi Perah</option><option value="Kambing">Kambing</option><option value="Ayam">Ayam</option><option value="Itik">Itik</option><option value="Angsa">Angsa</option><option value="Kalkun">Kalkun</option><option value="Burung">Burung</option></select></td><td><select class="form-control jenis_vaksinasi" name="jenis_vaksinasi[]" required><option value="">Pilih Vaksinasi</option><option value="Vaksinasi PMK">Vaksinasi PMK</option><option value="Vaksinasi ND-AI">Vaksinasi ND-AI</option><option value="Vaksinasi LSD">Vaksinasi LSD</option></select></td><td><select class="form-control dosis" name="dosis[]" required><option value="">Pilih Dosis</option><option value="1">1 (Dosis Pertama)</option><option value="2">2 (Dosis Kedua)</option><option value="Booster">Booster</option></select></td><td><input type="number" class="form-control jumlah" name="jumlah[]" placeholder="Jumlah" min="1" required /></td><td class="text-center"><button type="button" class="btn btn-success btn-sm btn-add-row" title="Tambah baris"><i class="fas fa-plus"></i></button><button type="button" class="btn btn-danger btn-sm btn-remove-row" title="Hapus baris"><i class="fas fa-trash"></i></button></td></tr>`;
            $('#komoditasBody').append(newRow);
            updateRemoveButtons();
        }

        function removeKomoditasRow(btn) {
            if ($('.komoditas-row').length > 1) {
                $(btn).closest('tr').remove();
                updateRemoveButtons();
            }
        }

        $(document).ready(function() {
            // Hancurkan DataTable jika sudah ada
            if ($.fn.DataTable.isDataTable('#vaksinasiTable')) {
                $('#vaksinasiTable').DataTable().destroy();
            }
            
            const today = new Date().toISOString().split('T')[0];
            $('#tanggal_vaksinasi').val(today);
            
            dataTable = $('#vaksinasiTable').DataTable({
                language: { 
                    search: "Cari:", 
                    lengthMenu: "Tampilkan _MENU_ data", 
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", 
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data", 
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
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success' },
                    { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info' }
                ],
                columnDefs: [{ orderable: false, targets: [8] }]
            });
            
            updateRemoveButtons();
            
            $(document).on('click', '.btn-add-row', function(e) {
                e.preventDefault();
                addKomoditasRow();
            });
            
            $(document).on('click', '.btn-remove-row', function(e) {
                e.preventDefault();
                removeKomoditasRow(this);
            });
        });
        
        // Form Submission
        $('#formVaksinasi').on('submit', function(e) {
            e.preventDefault();

            const commonFields = ['nama_peternak', 'nama_petugas', 'tanggal_vaksinasi', 'bantuan_prov', 'alamat', 'kelurahan', 'latitude', 'longitude'];
            let isValid = true;

            commonFields.forEach(function(fieldId) {
                $('#' + fieldId).removeClass('is-invalid');
            });

            commonFields.forEach(function(fieldId) {
                const field = $('#' + fieldId);
                if (!field.val() || field.val() === '') {
                    field.addClass('is-invalid');
                    isValid = false;
                }
            });

            if (!validateKomoditasRows()) {
                isValid = false;
            }

            if (!isValid) {
                showAlert('danger', 'Harap lengkapi semua field yang wajib diisi!');
                return;
            }

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
            submitBtn.prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url: '<?php echo base_url("P_Input_Vaksinasi/save"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showAlert('success', response.message);
                        resetForm();
                        $('#formContainer').removeClass('show');
                        $('#toggleFormBtn').html('<i class="fas fa-plus-circle me-2"></i> INPUT VAKSINASI');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        showAlert('danger', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    showAlert('danger', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
                },
                complete: function() {
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>