<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan Stok Pakan - SIPETGIS</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
    
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
        
        .dataTables_wrapper {
            padding: 0;
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
            text-align: center;
        }
        
        table.dataTable thead th:first-child {
            text-align: left;
        }
        
        table.dataTable tbody td {
            background-color: white;
            border: none !important;
            padding: 12px 10px;
            vertical-align: middle;
            text-align: center;
        }
        
        table.dataTable tbody td:first-child {
            text-align: left;
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
        
        .total-row td {
            background-color: #e8f5e9 !important;
            font-weight: bold;
            border-top: 2px solid #4caf50 !important;
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
            .card {
                box-shadow: none !important;
                border: none !important;
            }
            table.dataTable tbody tr {
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
        
        .nama-demplot {
            font-weight: 600;
            color: #1e3a8a;
        }
        
        .jenis-pakan {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .merk-pakan {
            font-weight: 500;
            color: #f57c00;
        }
        
        .stok-awal {
            font-weight: 600;
            color: #9c27b0;
        }
        
        .stok-masuk {
            font-weight: 600;
            color: #2e7d32;
        }
        
        .stok-keluar {
            font-weight: 600;
            color: #c62828;
        }
        
        .stok-akhir {
            font-weight: 600;
            color: #0288d1;
        }
        
        .keterangan {
            font-style: italic;
            color: #6c757d;
        }
        
        .badge-stok {
            background-color: #fff3e0;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
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
                                    <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>" class="nav-link">Data TPU / RPU</a></li>
                                    <li><a href="<?= site_url('laporan_demplot_peternakan') ?>" class="nav-link">Demplot Peternakan</a></li>
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>" class="nav-link active">Stok Pakan</a></li>
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
                                                    <h4>Kepala Dinas DKPP Surabaya</h4>
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
                            <h3 class="fw-bold mb-1">Laporan Stok Pakan</h3>
                            <h6 class="op-7 mb-0">Data Stok Pakan Demplot Peternakan Kota Surabaya</h6>
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
    <label class="form-label">Demplot</label>
    <select class="form-select" id="filterDemplot">
        <option value="semua">Semua Demplot</option>
        <?php foreach($demplot as $d): ?>
            <option value="<?= $d->id_demplot ?>"><?= $d->nama_demplot ?></option>
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
                            DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN
                        </div>
                        <div class="report-subtitle" id="reportSubtitle">
                            Silakan pilih tahun terlebih dahulu
                        </div>
                        <div class="table-responsive">
                            <table id="stokPakanTable" class="table table-hover w-100">
                                <thead id="tableHeader">
                                    <tr id="headerRow">
                                        <th width="50">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Demplot</th>
                                        <th>Jenis Pakan</th>
                                        <th>Merk Pakan</th>
                                        <th>Stok Awal (kg)</th>
                                        <th>Stok Masuk (kg)</th>
                                        <th>Stok Keluar (kg)</th>
                                        <th>Stok Akhir (kg)</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Silakan pilih filter untuk menampilkan数据
                                    </tr>
                                </tbody>
                                <tfoot id="tableFooter"></tfoot>
                            </table>
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
        var stokPakanTable = null;
        
        $(document).ready(function() {
            initDataTable();
            
            $("#btnFilter").click(function() {
                loadData();
            });
            
            $("#btnExport").click(function() {
                var tahun = $("#filterTahun").val();
                var demplot = $("#filterDemplot").val();
                
                if(!tahun) {
                    alert("Silakan pilih tahun terlebih dahulu!");
                    return;
                }
                
                window.location.href = "<?= base_url('laporan_stok_pakan/export_excel') ?>?tahun=" + tahun + "&demplot=" + demplot;
            });
        });
        
        function initDataTable() {
            if (stokPakanTable !== null) {
                stokPakanTable.destroy();
                stokPakanTable = null;
            }
            
            $("#stokPakanTable tbody").empty();
            $("#tableFooter").empty();
            
            stokPakanTable = $("#stokPakanTable").DataTable({
                dom: "Bfrtip",
                buttons: [
                    { extend: "copy", text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary' },
                    { extend: "csv", text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success' },
                    { extend: "excel", text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success' },
                    { extend: "pdf", text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger' },
                    { extend: "print", text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info' }
                ],
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
                pageLength: 15,
                ordering: false,
                searching: true,
                responsive: true,
                scrollX: true
            });
        }
        
        function loadData() {
    var tahun = $("#filterTahun").val();
    var demplotFilter = $("#filterDemplot").val();
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    var demplotText = (demplotFilter && demplotFilter !== 'semua') ? demplotFilter : 'Seluruh Demplot';
    $("#reportTitle").html('DATA DETAIL STOK PAKAN DEMPLOT PETERNAKAN TAHUN ' + tahun);
    $("#reportSubtitle").html(demplotText);
    
    $.ajax({
        url: "<?= base_url('laporan_stok_pakan/get_data') ?>",
        type: "POST",
        data: {
            tahun: tahun,
            demplot: demplotFilter
        },
        dataType: "json",
        success: function(response) {
            console.log("Response:", response);
            
            if (stokPakanTable !== null) {
                stokPakanTable.destroy();
                stokPakanTable = null;
            }
            
            $("#stokPakanTable tbody").empty();
            $("#tableFooter").empty();
            
            // Gunakan data dari response langsung (sudah JOIN dengan tabel demplot)
            var filteredData = response.data;
            
            if(filteredData && filteredData.length > 0) {
                var tbody = $("#stokPakanTable tbody");
                var totalStokAwal = 0;
                var totalStokMasuk = 0;
                var totalStokKeluar = 0;
                var totalStokAkhir = 0;
                var no = 1;
                
                for (var i = 0; i < filteredData.length; i++) {
                    var item = filteredData[i];
                    
                    totalStokAwal += parseInt(item.stok_awal) || 0;
                    totalStokMasuk += parseInt(item.stok_masuk) || 0;
                    totalStokKeluar += parseInt(item.stok_keluar) || 0;
                    totalStokAkhir += parseInt(item.stok_akhir) || 0;
                    
                    // Nama demplot sudah diambil dari JOIN dengan tabel demplot
                    var namaDemplot = (item.nama_demplot && item.nama_demplot !== 'null') ? item.nama_demplot : '-';
                    var jenisPakan = item.jenis_pakan || '-';
                    var merkPakan = item.merk_pakan || '-';
                    var keterangan = item.keterangan || '-';
                    
                    var row = '<tr>' +
                        '<td>' + no++ + '</td>' +
                        '<td>' + formatDate(item.tanggal) + '</td>' +
                        '<td><span class="nama-demplot">' + escapeHtml(namaDemplot) + '</span></td>' +
                        '<td><span class="jenis-pakan">' + escapeHtml(jenisPakan) + '</span></td>' +
                        '<td><span class="merk-pakan">' + escapeHtml(merkPakan) + '</span></td>' +
                        '<td><span class="stok-awal">' + formatNumber(item.stok_awal) + ' kg</span></td>' +
                        '<td><span class="stok-masuk">+' + formatNumber(item.stok_masuk) + ' kg</span></td>' +
                        '<td><span class="stok-keluar">-' + formatNumber(item.stok_keluar) + ' kg</span></td>' +
                        '<td><span class="stok-akhir">' + formatNumber(item.stok_akhir) + ' kg</span></td>' +
                        '<td><span class="keterangan">' + escapeHtml(keterangan) + '</span></td>' +
                        '</tr>';
                    
                    tbody.append(row);
                }
                
                var totalTransaksi = filteredData.length;
                var footerHtml = '<tr class="total-row">' +
                    '<td colspan="5"><strong>TOTAL</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokAwal) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokMasuk) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokKeluar) + ' kg</strong></td>' +
                    '<td><strong>' + formatNumber(totalStokAkhir) + ' kg</strong></td>' +
                    '<td><strong>' + totalTransaksi + ' Transaksi</strong></td>' +
                    '</tr>';
                $("#tableFooter").html(footerHtml);
            } else {
                var tbody = $("#stokPakanTable tbody");
                var row = '<tr>' +
                    '<td colspan="10" class="text-center text-muted">Tidak ada data untuk tahun ' + tahun + ' dengan filter ' + demplotText + '</td>' +
                    '</tr>';
                tbody.append(row);
            }
            
            initDataTable();
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            console.error("Response Text:", xhr.responseText);
            alert("Gagal memuat data. Silakan coba lagi.\nError: " + error);
            $("#loadingOverlay").fadeOut();
            
            $("#stokPakanTable tbody").empty();
            var row = '<tr><td colspan="10" class="text-center text-danger">Error: ' + error + '</td></tr>';
            $("#stokPakanTable tbody").append(row);
            initDataTable();
        }
    });
}

        function escapeHtml(text) {
            if(!text) return '';
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
        
        function formatNumber(num) {
            if (num === null || num === undefined || num === 0) return '0';
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
    </script>
</body>
</html>