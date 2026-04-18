// ================ VARIABLES ================
let dataTable = null;
let deleteId = null;

// ================ EDIT DATA ================
function editData(id) {
    var btn = $('.btn-edit[data-id="' + id + '"]');
    
    if (btn.length > 0) {
        $('#edit_id').val(btn.data('id'));
        $('#edit_tanggal').val(btn.data('tanggal'));
        $('#edit_rpu').val(btn.data('rpu'));
        $('#edit_ayam').val(btn.data('ayam'));
        $('#edit_itik').val(btn.data('itik'));
        $('#edit_dst').val(btn.data('dst'));
        $('#edit_daerah_asal').val(btn.data('daerah_asal'));
        $('#edit_petugas').val(btn.data('petugas'));
        $('#edit_keterangan').val(btn.data('keterangan'));
        
        $('#editModal').modal('show');
    } else {
        alert("Data tidak ditemukan");
    }
}

// ================ CONFIRM DELETE ================
function confirmDelete(id, nama) {
    deleteId = id;
    $("#deleteInfo").text("Data pemotongan unggas: " + nama);
    $("#deleteModal").modal("show");
}

// ================ DELETE DATA ================
function deleteData(id) {
    window.location.href = base_url + "data_pemotongan_unggas/hapus/" + id;
}

// ================ SHOW FOTO PREVIEW ================
function showFotoPreview(src) {
    $('#modalFoto').attr('src', src);
    $('#fotoModal').modal('show');
}

// ================ FILTER FUNCTIONS ================
function filterByPeriode(startDate, endDate, searchTerm) {
    $.ajax({
        url: base_url + 'data_pemotongan_unggas/filter_by_periode',
        type: 'POST',
        data: {
            start_date: startDate,
            end_date: endDate
        },
        dataType: 'json',
        success: function(response) {
            updateTableWithData(response.data, searchTerm);
        },
        error: function() {
            alert('Gagal memuat data filter');
        }
    });
}

function updateTableWithData(data, searchTerm) {
    const table = $("#pemotonganTable").DataTable();
    table.clear();
    
    if (data && data.length > 0) {
        let no = 1;
        data.forEach(function(item) {
            table.row.add([
                no++,
                formatDate(item.tanggal),
                '<span class="rpu-info">' + escapeHtml(item.nama_rpu || 'RPU ' + item.id_rpu) + '</span>',
                '<small>' + escapeHtml(item.komoditas_list || '-') + '</small>',
                '<span class="badge-ekor">' + (item.total_ekor || 0) + ' ekor</span>',
                '<span class="badge-berat">' + parseFloat(item.total_berat || 0).toFixed(2) + ' kg</span>',
                '<span class="badge-asal">' + escapeHtml(item.daerah_asal || '-') + '</span>',
                '<span class="badge-petugas">' + escapeHtml(item.nama_petugas || '-') + '</span>',
                formatFotoCell(item.foto_kegiatan),
                formatActionButtons(item.id_pemotongan, item.nama_rpu || 'RPU ' + item.id_rpu)
            ]);
        });
    } else {
        table.row.add(['-', '-', '-', '-', '-', '-', '-', '-', '-', '-']);
    }
    
    table.draw();
    
    if (searchTerm) {
        table.search(searchTerm).draw();
    }
}

// Helper function to format date
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

// Helper function to escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper function to format foto cell
function formatFotoCell(foto) {
    if (!foto) {
        return '<span class="text-muted">-</span>';
    }
    return '<img src="' + base_url + 'uploads/pemotongan_unggas/' + escapeHtml(foto) + '" alt="Foto" class="photo-thumbnail" onclick="showFotoPreview(this.src)">';
}

// Helper function to format action buttons (HANYA EDIT DAN HAPUS)
function formatActionButtons(id, nama) {
    return '<div class="btn-action-group">' +
        '<button class="btn btn-action btn-edit" title="Edit" data-id="' + id + '" onclick="editData(' + id + ')"><i class="fas fa-edit"></i></button>' +
        '<button class="btn btn-action btn-delete" title="Hapus" data-id="' + id + '" data-nama="' + escapeHtml(nama) + '" onclick="confirmDelete(' + id + ', \'' + escapeHtml(nama) + '\')"><i class="fas fa-trash"></i></button>' +
        '</div>';
}

// Fungsi untuk load statistik
function loadStatistik() {
    $.ajax({
        url: base_url + 'data_pemotongan_unggas/get_statistik',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#totalKegiatan').text(data.total_kegiatan);
            $('#totalEkor').text(data.total_ekor);
            $('#totalBerat').text(data.total_berat.toFixed(2));
            $('#totalRPU').text(data.total_rpu);
        },
        error: function() {
            console.log('Gagal load statistik');
        }
    });
}

function getFirstDayOfMonth() {
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    return firstDay.toISOString().split('T')[0];
}

function getLastDayOfMonth() {
    var date = new Date();
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    return lastDay.toISOString().split('T')[0];
}

// ================ DOCUMENT READY ================
$(document).ready(function() {
    $("#pemotonganTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                text: '<i class="fas fa-copy"></i> Copy',
                className: 'btn btn-sm btn-primary',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: "csv",
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] }
            },
            {
                extend: "pdf",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-sm btn-danger',
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
                customize: function(doc) {
                    doc.content.splice(0, 1);
                    
                    var currentDate = new Date();
                    var formattedDate = currentDate.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    
                    doc.content.unshift({
                        text: 'LAPORAN DATA PEMOTONGAN UNGGAS',
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
                exportOptions: { columns: [0,1,2,3,4,5,6,7,8] },
                customize: function(win) {
                    $(win.document.body).find('table').addClass('print-table');
                    $(win.document.body).find('table thead th').css({
                        'background-color': '#832706',
                        'color': 'white',
                        'padding': '10px'
                    });
                    $(win.document.body).prepend(
                        '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA PEMOTONGAN UNGGAS</h2>' +
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
        order: [[1, 'desc']],
        columnDefs: [
            { targets: [8], orderable: false },
            { targets: [9], orderable: false }
        ]
    });

    // Event listener untuk tombol edit (delegasi)
    $(document).on("click", ".btn-edit", function() {
        var id = $(this).data('id');
        if (id) {
            editData(id);
        }
    });

    // Event listener untuk tombol hapus (delegasi)
    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        if (id) {
            confirmDelete(id, nama);
        }
    });

    // Filter button event
    $("#filterBtn").click(function() {
        const rpuValue = $("#filterRPU").val();
        const petugasValue = $("#filterPetugas").val();
        const komoditasValue = $("#filterKomoditas").val();
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();
        
        let searchTerm = "";

        if (rpuValue !== "all") {
            searchTerm += "RPU " + rpuValue;
        }
        if (petugasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += petugasValue;
        }
        if (komoditasValue !== "all") {
            if (searchTerm !== "") searchTerm += " ";
            searchTerm += komoditasValue;
        }

        if (startDate && endDate) {
            filterByPeriode(startDate, endDate, searchTerm);
        } else {
            $("#pemotonganTable").DataTable().search(searchTerm).draw();
        }
    });

    // Reset button event
    $("#resetBtn").click(function() {
        $("#filterRPU").val("all");
        $("#filterPetugas").val("all");
        $("#filterKomoditas").val("all");
        $("#startDate").val(getFirstDayOfMonth());
        $("#endDate").val(getLastDayOfMonth());
        $("#pemotonganTable").DataTable().search("").draw();
        loadStatistik();
    });

    // Close detail button event (detail section dihapus, tapi tetap ada untuk jaga-jaga)
    $("#closeDetailBtn").click(function() {
        $("#detailSection").hide();
    });

    // Confirm delete button
    $("#confirmDelete").click(function() {
        if (deleteId) {
            deleteData(deleteId);
        }
    });

    // Form edit submit
    $("#formEdit").submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: base_url + 'data_pemotongan_unggas/update',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Data berhasil diupdate');
                    location.reload();
                } else {
                    alert('Gagal mengupdate data: ' + (response.message || 'Unknown error'));
                }
            },
            error: function() {
                alert('Gagal mengupdate data');
            }
        });
    });

    loadStatistik();
});

// Base URL
var base_url = "<?= base_url() ?>";