<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Laporan Demplot Peternakan - SIPETGIS</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

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

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/SIPETGIS/assets/css/kaiadmin.min.css" />
    
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
        
        table tbody td:nth-child(2) {
            text-align: left;
            font-weight: 600;
            color: #1e3a8a;
        }
        
        .total-row-bottom td {
            background-color: #e8f5e9 !important;
            font-weight: bold;
        }
        
        .data-link {
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            min-width: 30px;
        }
        
        .data-link:hover {
            color: #000000;
            text-decoration: underline;
            background-color: #f0f0f0;
            transform: scale(1.05);
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
            .data-link {
                color: black !important;
                text-decoration: none !important;
                background: none !important;
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
        
        .dt-buttons .btn-primary {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%) !important;
            border: none !important;
            color: white !important;
        }
        
        .dt-buttons .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
            border: none !important;
            color: white !important;
        }
        
        .dt-buttons .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%) !important;
            border: none !important;
            color: white !important;
        }
        
        .dt-buttons .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
            border: none !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 10px;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 6px 12px;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 6px 12px;
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
        
        .dt-buttons {
            margin-bottom: 15px;
        }
        
        table.dataTable {
            border-collapse: collapse !important;
        }
        
        .luas-cell {
            font-weight: 600;
            color: #9c27b0;
        }
        
        .jumlah-cell {
            font-weight: 600;
            color: #f57c00;
        }
        
        .badge-jenis {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .stok-pakan {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .filter-info {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e3f2fd;
            border-radius: 8px;
            color: #1976d2;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="white">
                <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
                    <div style="color: #1e3a8a; font-weight: 800; font-size: 24px;">SIPETGIS</div>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                </div>
            </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item"><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                   
                    <li class="nav-item active">
                        <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse" href="#laporanSubmenu" aria-expanded="true">
                            <div class="d-flex align-items-center"><i class="fas fa-chart-bar me-2"></i><span>Laporan</span></div>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </a>
                        <div class="collapse show" id="laporanSubmenu">
                            <ul class="list-unstyled ps-4">
                                <li><a href="<?= site_url('laporan_kepemilikan_ternak') ?>">Kepemilikan Ternak</a></li>
                                <li><a href="<?= site_url('laporan_history_data_ternak') ?>">History Data Ternak</a></li>
                                <li><a href="<?= site_url('laporan_vaksinasi') ?>">Vaksinasi</a></li>
                                <li><a href="<?= site_url('laporan_history_data_vaksinasi') ?>">History Vaksinasi</a></li>
                                <li><a href="<?= site_url('laporan_pengobatan_ternak') ?>">Pengobatan Ternak</a></li>
                                <li><a href="<?= site_url('laporan_penjual_pakan_ternak') ?>">Penjual Pakan Ternak</a></li>
                                <li><a href="<?= site_url('laporan_data_klinik_hewan') ?>">Data Klinik Hewan</a></li>
                                <li><a href="<?= site_url('laporan_penjual_obat_hewan') ?>">Penjual Obat Hewan</a></li>
                                <li><a href="<?= site_url('laporan_data_tpu_rpu') ?>">Data TPU / RPU</a></li>
                                <li><a href="<?= site_url('laporan_demplot_peternakan') ?>" class="active">Demplot Peternakan</a></li>
                                <li><a href="<?= site_url('laporan_stok_pakan') ?>">Stok Pakan</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item"><a href="<?php echo base_url(); ?>peta-sebaran"><i class="fas fa-map-marked-alt"></i><p>Peta Sebaran</p></a></li>
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
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                                <div class="avatar-sm">
                                    <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" class="avatar-img rounded-circle" />
                                </div>
                                <span class="profile-username"><span class="fw-bold">Kepala Dinas DKPP Surabaya</span></span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <li><div class="user-box"><div class="u-text"><h4>Kepala Dinas DKPP Surabaya</h4><p class="text-muted">kepala@dkppsby.go.id</p></div></div></li>
                                <li><div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url(); ?>login"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-1">Laporan Demplot Peternakan</h3>
                        <h6 class="op-7 mb-0">Data Demplot Peternakan Kota Surabaya</h6>
                    </div>
                </div>

                <div class="filter-section no-print">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun</label>
                            <select class="form-select" id="filterTahun">
                                <option value="semua">-- Semua Tahun --</option>
                                <?php foreach($tahun as $t): ?>
                                    <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kecamatan</label>
                            <select class="form-select" id="filterKecamatan">
                                <option value="semua">Semua Kecamatan</option>
                                <?php foreach($kecamatan as $k): ?>
                                    <option value="<?= $k->kecamatan ?>"><?= $k->kecamatan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama Demplot</label>
                            <select class="form-select" id="filterDemplot">
                                <option value="semua">Semua Demplot</option>
                                <?php foreach($demplot as $d): ?>
                                    <option value="<?= $d->nama_demplot ?>"><?= $d->nama_demplot ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn btn-primary-custom" id="btnFilter"><i class="fas fa-search me-2"></i>Tampilkan Data</button>
                        
                        </div>
                    </div>
                </div>

                <div class="report-title" id="reportTitle">DATA DEMPLOT PETERNAKAN</div>
                <div class="report-subtitle" id="reportSubtitle">Kota Surabaya</div>
               

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="demplotTable">
                                <thead id="tableHeader">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Demplot</th>
                                        <th>Alamat</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan</th>
                                        <th>Luas (m²)</th>
                                        <th>Jenis Hewan</th>
                                        <th>Jumlah (ekor)</th>
                                        <th>Stok Pakan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
</div>

<script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/core/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/SIPETGIS/assets/js/kaiadmin.min.js"></script>

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
    tahun: 'semua',
    kecamatan: 'semua',
    demplot: 'semua'
};

$(document).ready(function() {
    // Initialize DataTable
    dataTable = $('#demplotTable').DataTable({
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
        ordering: false,
        searching: true,
        paging: true,
        pageLength: 15,
        lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Semua"]],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        scrollX: true
    });
    
    $("#btnFilter").click(function() {
        currentData.tahun = $("#filterTahun").val();
        currentData.kecamatan = $("#filterKecamatan").val();
        currentData.demplot = $("#filterDemplot").val();
        loadData();
    });
    
    $("#btnReset").click(function() {
        $("#filterTahun").val('semua');
        $("#filterKecamatan").val('semua');
        $("#filterDemplot").val('semua');
        currentData.tahun = 'semua';
        currentData.kecamatan = 'semua';
        currentData.demplot = 'semua';
        loadData();
    });
    
    // LANGSUNG LOAD DATA SAAT HALAMAN DIBUKA (tanpa pilih filter)
    loadData();
});

function exportWithParams(format) {
    var url = "<?= base_url('laporan_demplot_peternakan/export_') ?>" + format;
    url += "?tahun=" + currentData.tahun;
    url += "&kecamatan=" + currentData.kecamatan;
    url += "&demplot=" + currentData.demplot;
    
    window.location.href = url;
}

function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Laporan Demplot Peternakan</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; }');
    printWindow.document.write('.header p { margin: 5px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: center; }');
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('td:first-child { text-align: center; }');
    printWindow.document.write('td:nth-child(2) { text-align: left; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    var tableContent = document.getElementById('demplotTable').cloneNode(true);
    $(tableContent).find('.dataTables_empty').remove();
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>' + document.getElementById('reportTitle').innerHTML + '</h2>');
    printWindow.document.write('<p>' + document.getElementById('reportSubtitle').innerHTML + '</p>');
    printWindow.document.write('</div>');
    printWindow.document.write(tableContent.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function loadData() {
    var tahun = currentData.tahun;
    var kecamatan = currentData.kecamatan;
    var demplot = currentData.demplot;
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: "<?= base_url('laporan_demplot_peternakan/get_data') ?>",
        type: "POST",
        data: {
            tahun: tahun,
            kecamatan: kecamatan,
            demplot: demplot
        },
        dataType: "json",
        success: function(response) {
            var demplotText = (demplot && demplot !== 'semua') ? demplot : 'Seluruh Demplot';
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            var tahunText = (tahun && tahun !== 'semua') ? 'Tahun ' + tahun : 'Semua Tahun';
            
            var titleText = 'DATA DEMPLOT PETERNAKAN';
            if(tahun && tahun !== 'semua') {
                titleText += ' TAHUN ' + tahun;
            }
            
            $("#reportTitle").html(titleText);
            $("#reportSubtitle").html('Kota Surabaya');
            
            var filterInfoText = '';
            if(tahun !== 'semua' || kecamatan !== 'semua' || demplot !== 'semua') {
                filterInfoText = '<i class="fas fa-filter me-2"></i> Filter aktif: ';
                if(tahun !== 'semua') filterInfoText += tahunText + ' | ';
                if(kecamatan !== 'semua') filterInfoText += kecamatanText + ' | ';
                if(demplot !== 'semua') filterInfoText += 'Demplot: ' + demplotText;
                $("#filterInfo").html(filterInfoText).show();
            } else {
                $("#filterInfo").html('<i class="fas fa-info-circle me-2"></i> Menampilkan semua data demplot').show();
            }
            
            dataTable.clear();
            
            var totalLuas = 0, totalJumlah = 0;
            
            if(response.data && response.data.length > 0) {
                var no = 1;
                $.each(response.data, function(i, item) {
                    var rowData = [
                        no++,
                        '<a href="<?= base_url('laporan_demplot_peternakan/detail_demplot/') ?>' + encodeURIComponent(item.nama_demplot) + '?tahun=' + (tahun !== 'semua' ? tahun : '') + '" class="data-link" target="_blank">' + (item.nama_demplot || '-') + '</a>',
                        item.alamat || '-',
                        item.kecamatan || '-',
                        item.kelurahan || '-',
                        '<span class="luas-cell">' + formatNumber(parseFloat(item.luas_m2 || 0)) + ' m²</span>',
                        '<span class="badge-jenis">' + (item.jenis_hewan || '-') + '</span>',
                        '<span class="jumlah-cell">' + formatNumber(parseInt(item.jumlah_hewan || 0)) + ' ekor</span>',
                        '<span class="stok-pakan">' + (item.stok_pakan || '-') + '</span>',
                        item.keterangan || '-'
                    ];
                    dataTable.row.add(rowData);
                    totalLuas += parseFloat(item.luas_m2 || 0);
                    totalJumlah += parseInt(item.jumlah_hewan || 0);
                });
            } else {
                dataTable.row.add(['1', 'Tidak ada data', '-', '-', '-', '-', '-', '-', '-', '-']);
            }
            
            dataTable.draw();
            
            
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi.");
            $("#loadingOverlay").fadeOut();
        }
    });
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
</body>
</html>