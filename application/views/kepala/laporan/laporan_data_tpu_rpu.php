<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan Data TPU/RPU - SIPETGIS</title>
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
    
    <style>
        .filter-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .report-title {
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 5px;
            color: #1e3a8a;
        }
        
        .report-subtitle {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        
        .table-custom thead th {
            border: none;
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 15px 10px;
            white-space: nowrap;
            text-align: center;
        }
        
        .table-custom thead th:first-child {
            text-align: left;
        }
        
        .table-custom tbody td {
            background-color: white;
            border: none;
            padding: 12px 10px;
            vertical-align: middle;
            text-align: center;
        }
        
        .table-custom tbody td:first-child {
            text-align: left;
        }
        
        .table-custom tbody tr {
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .table-custom tbody tr:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }
        
        .total-row td {
            background-color: #e8f5e9 !important;
            font-weight: bold;
            border-top: 2px solid #4caf50 !important;
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
            color: white;
        }
        
        .btn-success-custom {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            color: white;
        }
        
        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .form-select, .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            .main-panel {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .table-custom tbody tr {
                box-shadow: none !important;
            }
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .nav-link.active {
            color: #4361ee !important;
            font-weight: 600;
        }
        
        .nav-link.active i {
            color: #4361ee !important;
        }
        
        .report-section {
            margin-bottom: 40px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: white;
        }
        
        .nama-tpu {
            font-weight: 600;
            color: #1e3a8a;
        }
        
        .badge-izin {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-juleha-ya {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-juleha-tidak {
            background-color: #ffebee;
            color: #c62828;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .jumlah-pemotongan {
            font-weight: 600;
            color: #f57c00;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .search-box {
            margin-bottom: 15px;
            display: flex;
            justify-content: flex-end;
        }
        
        .search-box input {
            width: 250px;
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }
        
        .custom-pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .custom-pagination button {
            padding: 5px 12px;
            border: 1px solid #dee2e6;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .custom-pagination button.active {
            background: #4361ee;
            color: white;
            border-color: #4361ee;
        }
        
        .custom-pagination button:hover:not(.active) {
            background: #f0f0f0;
        }
        
        .custom-pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .info-data {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px; letter-spacing: 0.5px;">
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
                       
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="true">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <span>Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down ms-2"></i>
                            </a>
                            <div class="collapse show" id="laporanSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>" class="nav-link">Kepemilikan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_ternak') ?>" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_vaksinasi') ?>" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_history_data_vaksinasi') ?>" class="nav-link">History Data Vaksinasi</a></li>
                                    <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>" class="nav-link">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>" class="nav-link">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>" class="nav-link active">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('laporan_demplot_peternakan') ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
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
                <div class="main-header-logo"></div>
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
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
            </div>

            <div class="container">
                <div class="page-inner">
                    <!-- Page Header -->
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-1">Laporan Data TPU/RPU</h3>
                            <h6 class="op-7 mb-0">Data Tempat Pemotongan Unggas / Rumah Potong Unggas Kota Surabaya</h6>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0 no-print">
                            <button class="btn btn-primary-custom" onclick="window.print();">
                                <i class="fas fa-print me-2"></i>Cetak Laporan
                            </button>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section no-print">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="filterTahun">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php foreach($tahun as $t): ?>
                                        <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select class="form-select" id="filterKecamatan">
                                    <option value="semua">Semua Kecamatan</option>
                                    <?php foreach($kecamatan as $k): ?>
                                        <option value="<?= $k->kecamatan ?>"><?= $k->kecamatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary-custom" id="btnFilter">
                                    <i class="fas fa-search me-2"></i>Tampilkan Data
                                </button>
                                <button class="btn btn-success-custom ms-2" id="btnExport">
                                    <i class="fas fa-file-excel me-2"></i>Export Excel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Report Section -->
                    <div class="report-section">
                        <div class="report-title" id="reportTitle">
                            DATA TPU / RPU KOTA SURABAYA
                        </div>
                        <div class="report-subtitle" id="reportSubtitle">
                            Silakan pilih tahun dan kecamatan untuk menampilkan data
                        </div>
                        
                        <div class="search-box no-print">
                            <input type="text" id="searchInput" placeholder="Cari data..." onkeyup="cariData()">
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table-custom" id="tpuRpuTable">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama TPU/RPU</th>
                                        <th>Perizinan</th>
                                        <th>Alamat</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Penanggung Jawab</th>
                                        <th>No Telepon</th>
                                        <th>Jumlah Pemotongan Per Hari</th>
                                        <th>Tersedia Juleha</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Silakan pilih filter untuk menampilkan</td>
                                    </tr>
                                </tbody>
                                <tfoot id="tableFooter"></tfoot>
                            </table>
                        </div>
                        
                        <div class="custom-pagination no-print" id="pagination"></div>
                        <div class="info-data" id="infoData"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Memuat...</span>
        </div>
    </div>
    
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

    <script>
        var semuaData = [];
        var dataTampil = [];
        var halamanSekarang = 1;
        var barisPerHalaman = 15;
        
        $(document).ready(function() {
            $("#btnFilter").click(function() {
                ambilData();
            });
            
            $("#btnExport").click(function() {
                var tahun = $("#filterTahun").val();
                var kecamatan = $("#filterKecamatan").val();
                
                if(!tahun) {
                    alert("Silakan pilih tahun terlebih dahulu!");
                    return;
                }
                
                window.location.href = "<?= base_url('laporan_data_tpu_rpu/export_excel') ?>?tahun=" + tahun + "&kecamatan=" + kecamatan;
            });
        });
        
        function ambilData() {
            var tahun = $("#filterTahun").val();
            var kecamatan = $("#filterKecamatan").val();
            
            if(!tahun) {
                alert("Silakan pilih tahun terlebih dahulu!");
                return;
            }
            
            $("#loadingOverlay").fadeIn();
            
            $.ajax({
                url: "<?= base_url('laporan_data_tpu_rpu/get_data') ?>",
                type: "POST",
                data: {
                    tahun: tahun,
                    kecamatan: kecamatan
                },
                dataType: "json",
                success: function(respon) {
                    if(respon.status === 'success') {
                        var teksKecamatan = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
                        $("#reportTitle").html('DATA TPU / RPU KOTA SURABAYA TAHUN ' + respon.tahun);
                        $("#reportSubtitle").html(teksKecamatan);
                        
                        semuaData = respon.data;
                        dataTampil = [...semuaData];
                        halamanSekarang = 1;
                        
                        tampilkanTabel();
                        hitungTotal();
                    } else {
                        alert("Gagal mengambil data");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat mengambil data");
                },
                complete: function() {
                    $("#loadingOverlay").fadeOut();
                }
            });
        }
        
        function tampilkanTabel() {
            var mulai = (halamanSekarang - 1) * barisPerHalaman;
            var selesai = mulai + barisPerHalaman;
            var dataHalaman = dataTampil.slice(mulai, selesai);
            
            var html = '';
            
            if (dataHalaman.length > 0) {
                for (var i = 0; i < dataHalaman.length; i++) {
                    var item = dataHalaman[i];
                    var kelasJuleha = (item.tersedia_juleha === 'Ya') ? 'badge-juleha-ya' : 'badge-juleha-tidak';
                    var teksJuleha = item.tersedia_juleha || 'Tidak';
                    
                    var htmlJumlah = '<span class="jumlah-pemotongan">Ayam: ' + formatAngka(item.jumlah_pemotongan.ayam) + 
                                        '<br>Itik: ' + formatAngka(item.jumlah_pemotongan.itik) + 
                                        '<br>Lainnya: ' + formatAngka(item.jumlah_pemotongan.lainnya) + '</span>';
                    
                    html += '<tr>' +
                        '<td>' + (mulai + i + 1) + '</td>' +
                        '<td class="nama-tpu">' + amanHtml(item.nama_tpu) + '</td>' +
                        '<td><span class="badge-izin">' + amanHtml(item.perizinan) + '</span></td>' +
                        '<td>' + amanHtml(item.alamat) + '</td>' +
                        '<td>' + amanHtml(item.kecamatan) + '</td>' +
                        '<td>' + amanHtml(item.kelurahan) + '</td>' +
                        '<td>' + amanHtml(item.pj) + '</td>' +
                        '<td>' + amanHtml(item.no_telp) + '</td>' +
                        '<td>' + htmlJumlah + '</td>' +
                        '<td><span class="' + kelasJuleha + '">' + teksJuleha + '</span></td>' +
                        '</tr>';
                }
            } else {
                html = '<tr><td colspan="10" class="text-center">Tidak ada data</td></tr>';
            }
            
            $("#tableBody").html(html);
            tampilkanNavigasi();
            
            var infoMulai = (dataTampil.length > 0) ? mulai + 1 : 0;
            var infoSelesai = Math.min(selesai, dataTampil.length);
            $("#infoData").html('Menampilkan ' + infoMulai + ' sampai ' + infoSelesai + ' dari ' + dataTampil.length + ' data');
        }
        
        function tampilkanNavigasi() {
            var totalHalaman = Math.ceil(dataTampil.length / barisPerHalaman);
            var html = '';
            
            html += '<button onclick="pindahHalaman(' + (halamanSekarang - 1) + ')" ' + (halamanSekarang === 1 ? 'disabled' : '') + '>Sebelumnya</button>';
            
            var mulaiHalaman = Math.max(1, halamanSekarang - 2);
            var akhirHalaman = Math.min(totalHalaman, halamanSekarang + 2);
            
            for (var i = mulaiHalaman; i <= akhirHalaman; i++) {
                html += '<button onclick="pindahHalaman(' + i + ')" class="' + (halamanSekarang === i ? 'active' : '') + '">' + i + '</button>';
            }
            
            html += '<button onclick="pindahHalaman(' + (halamanSekarang + 1) + ')" ' + (halamanSekarang === totalHalaman ? 'disabled' : '') + '>Selanjutnya</button>';
            
            $("#pagination").html(html);
        }
        
        function pindahHalaman(halaman) {
            var totalHalaman = Math.ceil(dataTampil.length / barisPerHalaman);
            if (halaman < 1 || halaman > totalHalaman) return;
            halamanSekarang = halaman;
            tampilkanTabel();
        }
        
        function cariData() {
            var kataKunci = $("#searchInput").val().toLowerCase();
            
            if (kataKunci === '') {
                dataTampil = [...semuaData];
            } else {
                dataTampil = semuaData.filter(function(item) {
                    return (item.nama_tpu || '').toLowerCase().includes(kataKunci) ||
                           (item.perizinan || '').toLowerCase().includes(kataKunci) ||
                           (item.alamat || '').toLowerCase().includes(kataKunci) ||
                           (item.kecamatan || '').toLowerCase().includes(kataKunci) ||
                           (item.kelurahan || '').toLowerCase().includes(kataKunci) ||
                           (item.pj || '').toLowerCase().includes(kataKunci);
                });
            }
            
            halamanSekarang = 1;
            tampilkanTabel();
        }
        
        function hitungTotal() {
            var totalAyam = 0;
            var totalItik = 0;
            var totalLainnya = 0;
            
            for (var i = 0; i < semuaData.length; i++) {
                totalAyam += parseInt(semuaData[i].jumlah_pemotongan.ayam) || 0;
                totalItik += parseInt(semuaData[i].jumlah_pemotongan.itik) || 0;
                totalLainnya += parseInt(semuaData[i].jumlah_pemotongan.lainnya) || 0;
            }
            
            var totalTpu = semuaData.length;
        
        } 
        
        function formatAngka(angka) {
            if (angka === null || angka === undefined || angka === 0) return '0';
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function amanHtml(str) {
            if (!str) return '-';
            if (str === '-') return str;
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }
    </script>
</body>
</html>