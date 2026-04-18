<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sipetgis - Data Kepemilikan Ternak</title>
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

    <!-- Custom CSS Data Kepemilikan -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/data_kepemilikan.css'); ?>" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="white">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="white">
                    <a href="<?php echo base_url(); ?>" class="logo" style="text-decoration: none">
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
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                            <h4 class="text-section">Menu Utama</h4>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#masterDataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-database me-2" style="color: #832706 !important;"></i><span>Master Data</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="masterDataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?= site_url('pelaku_usaha') ?>" class="nav-link">Pelaku Usaha</a></li>
                                    <li><a href="<?= site_url('jenis_usaha') ?>" class="nav-link">Jenis Usaha</a></li>
                                    <li><a href="<?php echo base_url(); ?>akses_pengguna" class="nav-link">Akses Pengguna</a></li>
                                    <li><a href="<?php echo base_url(); ?>obat" class="nav-link">Obat</a></li>
                                    <li><a href="<?php echo base_url(); ?>vaksin" class="nav-link">Vaksin</a></li>
                                    <li><a href="<?php echo base_url(); ?>komoditas" class="nav-link">Komoditas</a></li>
                                    <li><a href="<?= site_url('layanan_klinik') ?>" class="nav-link">Layanan Klinik</a></li>
                                    <li><a href="<?= site_url('rpu') ?>" class="nav-link">RPU</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link d-flex align-items-center justify-content-between collapsed" data-bs-toggle="collapse" href="#dataSubmenu" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center"><i class="fas fa-users me-2" style="color: #832706 !important;"></i><span>Data</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="dataSubmenu">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url(); ?>data_kepemilikan" class="nav-link active">Kepemilikan Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_ternak" class="nav-link">History Data Ternak</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_vaksinasi" class="nav-link">Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_history_vaksinasi" class="nav-link">History Vaksinasi</a></li>
                                    <li><a href="<?php echo base_url(); ?>data_pengobatan" class="nav-link">Pengobatan Ternak</a></li>
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
                                <div class="d-flex align-items-center"><i class="fas fa-chart-bar me-2" style="color: #832706 !important;"></i><span>Laporan</span></div>
                                <i class="fas fa-chevron-down ms-2" style="color: #832706 !important;"></i>
                            </a>
                            <div class="collapse" id="laporanSubmenu">
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
                                    <li><a href="<?= site_url('laporan_stok_pakan') ?>" class="nav-link">Stok Pakan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>peta_sebaran">
                                <i class="fas fa-map-marked-alt" style="color: #832706 !important;"></i>
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
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="<?php echo base_url(); ?>assets/SIPETGIS/assets/img/logo dkpp.png" alt="..." class="avatar-img rounded-circle" />
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
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>login/logout">
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
                            <h3 class="fw-bold mb-1" style="color: #832706; font-weight: 900;">Data Kepemilikan Ternak</h3>
                            <h6 class="op-7 mb-0">Manajemen data kepemilikan ternak di Kota Surabaya</h6>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="filterKomoditas" class="form-label fw-bold">Filter Jenis Usaha:</label>
                                    <select class="form-select" id="filterKomoditas">
                                        <option selected value="all">- Semua Jenis Usaha -</option>
                                        <?php foreach($jenis_usaha_list as $ju): ?>
                                            <option value="<?= htmlspecialchars($ju->jenis_usaha) ?>"><?= htmlspecialchars($ju->jenis_usaha) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button id="filterBtn" class="btn btn-primary-custom">
                                    <i class="fas fa-filter me-2"></i>Filter Data
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTernakTable" class="table table-hover w-100">
                                    <thead>
                                        <tr> 
                                            <th>No</th>
                                            <th>Jenis Usaha</th>
                                            <th>Jumlah Peternak</th>
                                            <th>Total Ternak</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($data_ternak) && !empty($data_ternak)): ?>
                                            <?php foreach($data_ternak as $index => $dt): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($dt->jenis_ternak) ?></td>
                                                    <td><?= $dt->total_peternak ?> <span class="text-muted">Peternak</span></td>
                                                    <td><?= number_format($dt->total_ekor, 0, ',', '.') ?> <span class="badge-ternak">Ekor</span></td>
                                                    <td>
                                                        <button class="btn btn-detail btn-sm" onclick="showDetail('<?= urlencode($dt->jenis_ternak) ?>')">
                                                            <i class="fas fa-eye me-1"></i>Detail
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="5" class="text-center">Tidak ada data</td><tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Section (Initially Hidden) -->
                    <div id="detailSection" class="detail-section" style="display: none;">
                        <div class="detail-header">
                            <h5 class="fw-bold mb-0">Daftar Rincian Peternak</h5>
                            <div id="detailInfo" class="text-muted mt-2"></div>
                        </div>
                        <div class="table-responsive">
                            <table id="detailTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peternak</th>
                                        <th>NIK</th>
                                        <th>Kecamatan</th>
                                        <th>Alamat</th>
                                        <th>Jumlah Ternak</th>
                                        <th>Telepon</th>
                                    </tr>
                                </thead>
                                <tbody id="detailTableBody"></tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <button id="closeDetailBtn" class="btn btn-outline-primary-custom">
                                <i class="fas fa-times me-2"></i>Tutup Detail
                            </button>
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
        var base_url = '<?= base_url() ?>';
        
        $(document).ready(function() {
            var table = $("#dataTernakTable").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "copy",
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-sm btn-primary',
                        exportOptions: { columns: [0,1,2,3] }
                    },
                    {
                        extend: "csv",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-sm btn-success',
                        exportOptions: { columns: [0,1,2,3] }
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-sm btn-success',
                        exportOptions: { columns: [0,1,2,3] }
                    },
                    {
                        extend: "pdf",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger',
                        exportOptions: { columns: [0,1,2,3] },
                        customize: function(doc) {
                            doc.content.splice(0, 1);
                            var currentDate = new Date();
                            var formattedDate = currentDate.toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                            doc.content.unshift({
                                text: 'LAPORAN DATA KEPEMILIKAN TERNAK',
                                style: 'title',
                                alignment: 'center',
                                margin: [0, 0, 0, 5]
                            });
                            doc.content.unshift({
                                text: 'DINAS PETERNAKAN KOTA SURABAYA',
                                style: 'subtitle',
                                alignment: 'center',
                                margin: [0, 0, 0, 3]
                            });
                            doc.content.unshift({
                                text: 'PEMERINTAH KOTA SURABAYA',
                                style: 'header',
                                alignment: 'center',
                                margin: [0, 0, 0, 15]
                            });
                            doc.content.push({
                                text: 'Tanggal Cetak: ' + formattedDate,
                                style: 'date',
                                alignment: 'center',
                                margin: [0, 15, 0, 0]
                            });
                            if (doc.content[3] && doc.content[3].table) {
                                var rows = doc.content[3].table.body;
                                for (var i = 0; i < rows[0].length; i++) {
                                    rows[0][i].fillColor = '#832706';
                                    rows[0][i].color = '#ffffff';
                                    rows[0][i].bold = true;
                                    rows[0][i].alignment = 'center';
                                }
                                for (var i = 1; i < rows.length; i++) {
                                    for (var j = 0; j < rows[i].length; j++) {
                                        rows[i][j].alignment = 'center';
                                        rows[i][j].color = '#333333';
                                        rows[i][j].fontSize = 9;
                                    }
                                }
                            }
                            doc.pageMargins = [20, 60, 20, 40];
                            var headerText = 'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya';
                            doc.header = {
                                text: headerText,
                                alignment: 'center',
                                fontSize: 8,
                                color: '#666666',
                                margin: [20, 15, 20, 0]
                            };
                            doc.footer = function(currentPage, pageCount) {
                                return {
                                    text: 'Halaman ' + currentPage + ' dari ' + pageCount,
                                    alignment: 'center',
                                    fontSize: 8,
                                    color: '#666666',
                                    margin: [20, 0, 20, 15]
                                };
                            };
                        }
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-sm btn-info',
                        exportOptions: { columns: [0,1,2,3] },
                        customize: function(win) {
                            $(win.document.body).find('table').addClass('print-table');
                            $(win.document.body).find('table thead th').css({
                                'background-color': '#832706',
                                'color': 'white',
                                'padding': '10px'
                            });
                            $(win.document.body).prepend(
                                '<div style="text-align: center; margin-bottom: 20px;">' +
                                '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA KEPEMILIKAN TERNAK</h2>' +
                                '<p style="margin: 0;">Dinas Peternakan Kota Surabaya</p>' +
                                '<p style="margin: 0;">Pemerintah Kota Surabaya</p>' +
                                '<hr style="margin: 15px 0;">' +
                                '<p>Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID') + '</p>' +
                                '</div>'
                            );
                            $(win.document.body).append(
                                '<div style="text-align: center; margin-top: 30px; font-size: 10px; color: #666;">' +
                                'SIPETGIS - Sistem Informasi Peternakan Kota Surabaya' +
                                '</div>'
                            );
                        }
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
                    { width: "5%", targets: 0 },
                    { width: "35%", targets: 1 },
                    { width: "20%", targets: 2 },
                    { width: "25%", targets: 3 },
                    { width: "15%", targets: 4 }
                ]
            });

            $('#filterBtn').on('click', function() {
                var jenisUsaha = $('#filterKomoditas').val();
                
                $('#dataTernakTable tbody').html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data...</p></td></tr>');
                
                $.ajax({
                    url: base_url + 'index.php/data_kepemilikan/filter_data',
                    type: 'POST',
                    data: { jenis_usaha: jenisUsaha },
                    dataType: 'json',
                    success: function(response) {
                        if (response.html) {
                            if ($.fn.DataTable.isDataTable('#dataTernakTable')) {
                                $('#dataTernakTable').DataTable().destroy();
                            }
                            $('#dataTernakTable tbody').html(response.html);
                            $('#dataTernakTable').DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                    { extend: "copy", text: '<i class="fas fa-copy"></i> Copy', className: 'btn btn-sm btn-primary', exportOptions: { columns: [0,1,2,3] } },
                                    { extend: "csv", text: '<i class="fas fa-file-csv"></i> CSV', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3] } },
                                    { extend: "excel", text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-sm btn-success', exportOptions: { columns: [0,1,2,3] } },
                                    { extend: "pdf", text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-sm btn-danger', exportOptions: { columns: [0,1,2,3] } },
                                    { extend: "print", text: '<i class="fas fa-print"></i> Print', className: 'btn btn-sm btn-info', exportOptions: { columns: [0,1,2,3] } }
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
                                order: [[0, 'asc']]
                            });
                        }
                    },
                    error: function() { alert('Terjadi kesalahan saat memfilter data'); }
                });
            });

            $("#closeDetailBtn").click(function() {
                $("#detailSection").hide();
                $("#detailTableBody").empty();
                $("#detailInfo").empty();
            });
        });

        function showDetail(jenisUsaha) {
            $('#detailSection').show();
            $('#detailTableBody').html('<tr><td colspan="7" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Memuat data peternak...</p></td></tr>');
            $("#detailInfo").html('<i class="fas fa-spinner fa-spin me-2"></i> Sedang mengambil data untuk: <strong>' + decodeURIComponent(jenisUsaha) + '</strong>');
            
            $.ajax({
                url: base_url + 'index.php/data_kepemilikan/get_detail_pelaku_usaha',
                type: 'POST',
                data: { jenis_usaha: jenisUsaha },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#detailTableBody').html('<tr><td colspan="7" class="text-center text-danger">' + response.error + '</td></tr>');
                        return;
                    }
                    if (response.html && response.total_data > 0) {
                        $('#detailTableBody').html(response.html);
                        $('#detailInfo').html('<i class="fas fa-check-circle text-success me-2"></i> Menampilkan <strong>' + response.total_data + '</strong> data peternak untuk: <strong>' + response.jenis_usaha + '</strong>');
                    } else {
                        $('#detailTableBody').html('<tr><td colspan="7" class="text-center">Tidak ada data ditemukan</td></tr>');
                    }
                },
                error: function() {
                    $('#detailTableBody').html('<tr><td colspan="7" class="text-center text-danger">Terjadi kesalahan saat memuat data</td></tr>');
                }
            });
        }
    </script>
</body>
</html>