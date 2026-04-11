<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan Pengobatan Ternak - SIPETGIS</title>
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
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 12px 10px;
            text-align: center;
            border: 1px solid #dee2e6;
            white-space: nowrap;
        }
        
        table tbody td {
            padding: 10px;
            vertical-align: middle;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        
        table tbody td:first-child {
            text-align: center;
            font-weight: 500;
        }
        
        .total-row {
            background-color: #e8f5e9 !important;
            font-weight: bold;
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
        
        @media print {
            .no-print {
                display: none !important;
            }
            .main-panel {
                margin-left: 0 !important;
                padding: 0 !important;
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
        
        .dt-buttons .btn {
            border-radius: 6px;
            margin-right: 5px;
            transition: all 0.3s;
        }
        
        .dt-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .badge-diagnosa {
            background-color: #fff3e0;
            color: #e67e22;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-tindakan {
            background-color: #e8f5e9;
            color: #27ae60;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .sub-table-wrapper {
            margin-top: 30px;
        }
        
        .sub-table-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .sub-table-header {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 16px;
        }
        
        .sub-table-header i {
            margin-right: 8px;
        }
        
        .dataTables_empty {
            text-align: center !important;
        }
        
        /* Reset button style */
        .btn-reset {
            background: #6c757d;
            border: none;
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            color: white;
            margin-left: 10px;
        }
        
        .btn-reset:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
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
                        <div style="color: #1e3a8a; font-weight: 800; font-size: 24px;">
                            SIPETGIS
                        </div>
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                    </div>
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
                                    <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>" class="nav-link active">Pengobatan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>" class="nav-link">Penjual Pakan Ternak</a></li>
                                    <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>" class="nav-link">Data Klinik Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>" class="nav-link">Penjual Obat Hewan</a></li>
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>" class="nav-link">Data TPU / RPU</a></li>
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
                                                    <h4>Dinas Ketahanan Pangan dan Pertanian (DKPP) Kota
                              Surabaya</h4>
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
                            <h3 class="fw-bold mb-1">Laporan Pengobatan Ternak</h3>
                            <h6 class="op-7 mb-0">Data Pengobatan Ternak Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section no-print">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="filterTahun">
                                    <option value="">-- SEMUA TAHUN --</option>
                                    <?php foreach($tahun as $t): ?>
                                        <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select class="form-select" id="filterKecamatan">
                                    <option value="semua">Semua Kecamatan</option>
                                    <?php 
                                    $kecamatanList = [
                                        'Asemrowo', 'Benowo', 'Bubutan', 'Bulak', 'Dukuh Pakis',
                                        'Gayungan', 'Genteng', 'Gubeng', 'Gunung Anyar', 'Jambangan',
                                        'Karangpilang', 'Kenjeran', 'Krembangan', 'Lakarsantri', 'Mulyorejo',
                                        'Pabean Cantian', 'Pakal', 'Rungkut', 'Sambikerep', 'Sawahan',
                                        'Semampir', 'Simokerto', 'Sukolilo', 'Sukomanunggal', 'Tambaksari',
                                        'Tandes', 'Tegalsari', 'Tenggilis Mejoyo', 'Wiyung', 'Wonocolo', 'Wonokromo'
                                    ];
                                    foreach($kecamatanList as $kec): 
                                    ?>
                                        <option value="<?= $kec ?>"><?= $kec ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jenis Hewan</label>
                                <select class="form-select" id="filterJenisHewan">
                                    <option value="semua">Semua Jenis Hewan</option>
                                    <option value="Sapi Potong">Sapi Potong</option>
                                    <option value="Sapi Perah">Sapi Perah</option>
                                    <option value="Kambing">Kambing</option>
                                    <option value="Domba">Domba</option>
                                    <option value="Ayam">Ayam</option>
                                    <option value="Itik">Itik</option>
                                    <option value="Kelinci">Kelinci</option>
                                    <option value="Kucing">Kucing</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                             <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary-custom" id="btnFilter">
                                    <i class="fas fa-search me-2"></i>Tampilkan Data
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- Report Title -->
                    <div class="report-title" id="reportTitle">
                        REKAP DATA PENGOBATAN TERNAK
                    </div>
                    <div class="report-subtitle" id="reportSubtitle">
                        Kota Surabaya - Seluruh Data
                    </div>

                    <!-- Main Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pengobatanTable" style="width:100%">
                                    <thead id="tableHeader">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Petugas</th>
                                            <th>Nama Peternak</th>
                                            <th>NIK</th>
                                            <th>Alamat</th>
                                            <th>Kecamatan</th>
                                            <th>Kelurahan</th>
                                            <th>Jenis Hewan</th>
                                            <th>Gejala Klinis</th>
                                            <th>Jenis Pengobatan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <!-- Data akan diisi via JavaScript -->
                                    </tbody>
                                    <tfoot id="tableFooter" style="display: table-footer-group;"></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>
    
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        var dataTable = null;
        var currentData = {
            tahun: '',      // Kosong untuk ambil semua data
            kecamatan: 'semua',
            jenis_hewan: 'semua'
        };
        
        $(document).ready(function() {
            // Inisialisasi DataTables
            dataTable = $('#pengobatanTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary',
                        exportOptions: { columns: ':visible' }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success',
                        action: function(e, dt, button, config) {
                            exportWithParams('csv');
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success',
                        action: function(e, dt, button, config) {
                            exportWithParams('excel');
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger',
                        action: function(e, dt, button, config) {
                            exportWithParams('pdf');
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-info',
                        action: function(e, dt, button, config) {
                            printWithCurrentData();
                        }
                    }
                ],
                order: [],
                pageLength: 15,
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
                destroy: true,
                retrieve: true
            });
            
            // Load semua data saat halaman pertama kali dibuka
            loadAllData();
            
            // Event filter button
            $("#btnFilter").click(function() {
                currentData.tahun = $("#filterTahun").val();
                currentData.kecamatan = $("#filterKecamatan").val();
                currentData.jenis_hewan = $("#filterJenisHewan").val();
                
                if(currentData.tahun === '') {
                    // Jika tahun kosong, ambil semua data
                    loadAllData();
                } else {
                    loadDataWithFilter();
                }
            });
            
            // Event reset button
            $("#btnReset").click(function() {
                $("#filterTahun").val('');
                $("#filterKecamatan").val('semua');
                $("#filterJenisHewan").val('semua');
                currentData.tahun = '';
                currentData.kecamatan = 'semua';
                currentData.jenis_hewan = 'semua';
                loadAllData();
            });
        });
        
        function loadAllData() {
            $("#loadingOverlay").fadeIn();
            
            $.ajax({
                url: "<?= base_url('laporan_pengobatan_ternak/get_all_data') ?>",
                type: "POST",
                dataType: "json",
                success: function(response) {
                    $("#reportTitle").html('REKAP DATA PENGOBATAN TERNAK');
                    $("#reportSubtitle").html('Kota Surabaya - Seluruh Data');
                    
                    dataTable.clear().draw();
                    
                    if(response.data && response.data.length > 0) {
                        var no = 1;
                        var totalJumlah = 0;
                        
                        $.each(response.data, function(index, item) {
                            var rowData = [
                                no,
                                formatDate(item.tanggal_pengobatan),
                                escapeHtml(item.nama_petugas || '-'),
                                escapeHtml(item.nama_peternak || '-'),
                                escapeHtml(item.nik || '-'),
                                escapeHtml(item.alamat || '-'),
                                escapeHtml(item.kecamatan || '-'),
                                escapeHtml(item.kelurahan || '-'),
                                escapeHtml(item.komoditas_ternak || '-'),
                                '<span class="badge-diagnosa">' + escapeHtml(item.gejala_klinis || '-') + '</span>',
                                '<span class="badge-tindakan">' + escapeHtml(item.jenis_pengobatan || '-') + '</span>',
                                formatNumber(item.jumlah || 0)
                            ];
                            dataTable.row.add(rowData);
                            totalJumlah += parseInt(item.jumlah) || 0;
                            no++;
                        });
                        
                        dataTable.draw();
                        
                        var footerHtml = '<tr class="total-row">' +
                            '<td colspan="11" style="text-align: right;"><strong>TOTAL JUMLAH TERNAK</strong></td>' +
                            '<td><strong>' + formatNumber(totalJumlah) + '</strong></td>' +
                            '</tr>';
                        $("#tableFooter").html(footerHtml);
                        $("#tableFooter").show();
                        
                        $("#subTableWrapper").show();
                        $("#subTableKecamatanWrapper").show();
                        
                        populateRekapJenis(response.rekap_jenis || [], totalJumlah);
                        populateRekapKecamatan(response.rekap_kecamatan || [], totalJumlah);
                        
                    } else {
                        dataTable.clear().draw();
                        $("#tableFooter").hide();
                        $("#subTableWrapper").hide();
                        $("#subTableKecamatanWrapper").hide();
                    }
                    
                    $("#loadingOverlay").fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Gagal memuat data. Silakan coba lagi.");
                    $("#loadingOverlay").fadeOut();
                }
            });
        }
        
        function loadDataWithFilter() {
            var tahun = currentData.tahun;
            var kecamatan = currentData.kecamatan;
            var jenisHewan = currentData.jenis_hewan;
            
            if(!tahun || tahun === '') {
                alert("Silakan pilih tahun terlebih dahulu!");
                return;
            }
            
            $("#loadingOverlay").fadeIn();
            
            $.ajax({
                url: "<?= base_url('laporan_pengobatan_ternak/get_data') ?>",
                type: "POST",
                data: {
                    tahun: tahun,
                    kecamatan: kecamatan,
                    jenis_hewan: jenisHewan
                },
                dataType: "json",
                success: function(response) {
                    var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
                    var jenisText = (jenisHewan && jenisHewan !== 'semua') ? ' - Jenis Hewan: ' + jenisHewan : '';
                    
                    $("#reportTitle").html('REKAP DATA PENGOBATAN TERNAK TAHUN ' + tahun);
                    $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + jenisText);
                    
                    dataTable.clear().draw();
                    
                    if(response.data && response.data.length > 0) {
                        var no = 1;
                        var totalJumlah = 0;
                        
                        $.each(response.data, function(index, item) {
                            var rowData = [
                                no,
                                formatDate(item.tanggal_pengobatan),
                                escapeHtml(item.nama_petugas || '-'),
                                escapeHtml(item.nama_peternak || '-'),
                                escapeHtml(item.nik || '-'),
                                escapeHtml(item.alamat || '-'),
                                escapeHtml(item.kecamatan || '-'),
                                escapeHtml(item.kelurahan || '-'),
                                escapeHtml(item.komoditas_ternak || '-'),
                                '<span class="badge-diagnosa">' + escapeHtml(item.gejala_klinis || '-') + '</span>',
                                '<span class="badge-tindakan">' + escapeHtml(item.jenis_pengobatan || '-') + '</span>',
                                formatNumber(item.jumlah || 0)
                            ];
                            dataTable.row.add(rowData);
                            totalJumlah += parseInt(item.jumlah) || 0;
                            no++;
                        });
                        
                        dataTable.draw();
                        
                        var footerHtml = '<tr class="total-row">' +
                            '<td colspan="11" style="text-align: right;"><strong>TOTAL JUMLAH TERNAK</strong></td>' +
                            '<td><strong>' + formatNumber(totalJumlah) + '</strong></td>' +
                            '</tr>';
                        $("#tableFooter").html(footerHtml);
                        $("#tableFooter").show();
                        
                        $("#subTableWrapper").show();
                        $("#subTableKecamatanWrapper").show();
                        
                        populateRekapJenis(response.rekap_jenis || [], totalJumlah);
                        populateRekapKecamatan(response.rekap_kecamatan || [], totalJumlah);
                        
                    } else {
                        dataTable.clear().draw();
                        $("#tableFooter").hide();
                        $("#subTableWrapper").hide();
                        $("#subTableKecamatanWrapper").hide();
                    }
                    
                    $("#loadingOverlay").fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Gagal memuat data. Silakan coba lagi.");
                    $("#loadingOverlay").fadeOut();
                }
            });
        }
        
        function exportWithParams(format) {
            var url = "<?= base_url('laporan_pengobatan_ternak/export_') ?>" + format;
            
            if(currentData.tahun) {
                url += "?tahun=" + currentData.tahun;
                url += "&kecamatan=" + currentData.kecamatan;
                url += "&jenis_hewan=" + currentData.jenis_hewan;
            } else {
                url += "?tahun=all";
                url += "&kecamatan=" + currentData.kecamatan;
                url += "&jenis_hewan=" + currentData.jenis_hewan;
            }
            
            window.location.href = url;
        }
        
        function printWithCurrentData() {
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Laporan Pengobatan Ternak</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
            printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
            printWindow.document.write('.header h2 { margin: 0; }');
            printWindow.document.write('.header p { margin: 5px 0; }');
            printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
            printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
            printWindow.document.write('th { background-color: #f2f2f2; }');
            printWindow.document.write('.badge-diagnosa { background-color: #fff3e0; color: #e67e22; padding: 2px 6px; border-radius: 12px; }');
            printWindow.document.write('.badge-tindakan { background-color: #e8f5e9; color: #27ae60; padding: 2px 6px; border-radius: 12px; }');
            printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            
            var tableContent = document.getElementById('pengobatanTable').cloneNode(true);
            $(tableContent).find('.dataTables_empty').remove();
            
            printWindow.document.write('<div class="header">');
            printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
            printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML + '</p>');
            printWindow.document.write('</div>');
            printWindow.document.write(tableContent.outerHTML);
            
            if($('#rekapJenisBody tr').length > 0 && $('#rekapJenisBody tr').text().trim() !== 'Tidak ada data') {
                printWindow.document.write('<div style="margin-top: 30px;"><h3>Rekapitulasi Berdasarkan Jenis Hewan</h3>');
                printWindow.document.write($('#rekapJenisTable')[0].outerHTML);
                printWindow.document.write('</div>');
            }
            
            if($('#rekapKecamatanBody tr').length > 0 && $('#rekapKecamatanBody tr').text().trim() !== 'Tidak ada data') {
                printWindow.document.write('<div style="margin-top: 30px;"><h3>Rekapitulasi Berdasarkan Kecamatan</h3>');
                printWindow.document.write($('#rekapKecamatanTable')[0].outerHTML);
                printWindow.document.write('</div>');
            }
            
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        
        function populateRekapJenis(data, totalJumlah) {
            var html = '';
            var no = 1;
            
            $.each(data, function(index, item) {
                var persentase = totalJumlah > 0 ? ((item.total_jumlah / totalJumlah) * 100).toFixed(2) : 0;
                html += '<tr>' +
                    '<td class="text-center">' + no++ + '</td>' +
                    '<td class="text-start">' + escapeHtml(item.jenis_hewan) + '</td>' +
                    '<td class="text-center">' + formatNumber(item.jumlah_kasus) + '</td>' +
                    '<td class="text-center">' + formatNumber(item.total_jumlah) + '</td>' +
                    '<td class="text-center">' + persentase + '%</td>' +
                    '</tr>';
            });
            
            if(data.length === 0) {
                html = '<tr><td colspan="5" class="text-center text-muted">Tidak ada数据</td></tr>';
            }
            
            $("#rekapJenisBody").html(html);
        }
        
        function populateRekapKecamatan(data, totalJumlah) {
            var html = '';
            var no = 1;
            
            $.each(data, function(index, item) {
                var persentase = totalJumlah > 0 ? ((item.total_jumlah / totalJumlah) * 100).toFixed(2) : 0;
                html += '<tr>' +
                    '<td class="text-center">' + no++ + '</td>' +
                    '<td class="text-start">' + escapeHtml(item.kecamatan) + '</td>' +
                    '<td class="text-center">' + formatNumber(item.jumlah_kasus) + '</td>' +
                    '<td class="text-center">' + formatNumber(item.total_jumlah) + '</td>' +
                    '<td class="text-center">' + persentase + '%</td>' +
                    '</tr>';
            });
            
            if(data.length === 0) {
                html = '<tr><td colspan="5" class="text-center text-muted">Tidak ada数据</td></tr>';
            }
            
            $("#rekapKecamatanBody").html(html);
        }
        
        function formatNumber(num) {
            if(num === null || num === undefined || num === 0) return '0';
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function formatDate(dateString) {
            if(!dateString) return '-';
            var parts = dateString.split('-');
            if(parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return dateString;
        }
        
        function escapeHtml(text) {
            if(!text) return '';
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    </script>
</body>
</html>