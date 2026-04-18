var table;
var bulanNama = {
    '01': 'Januari', '02': 'Februari', '03': 'Maret',
    '04': 'April', '05': 'Mei', '06': 'Juni',
    '07': 'Juli', '08': 'Agustus', '09': 'September',
    '10': 'Oktober', '11': 'November', '12': 'Desember'
};

var base_url = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '') + '/';

$(document).ready(function() {
    // Initialize DataTable
    table = $("#historyTable").DataTable({
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
            zeroRecords: "Tidak ada data yang ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 15,
        lengthChange: true,
        lengthMenu: [10, 15, 25, 50, 100],
        ordering: false,
        searching: true,
        responsive: false,
        scrollX: true,
        autoWidth: false,
        destroy: true
    });
    
    // Filter button click
    $("#btnFilter").click(function() {
        loadData();
    });
});

function loadData() {
    var tahun = $("#filterTahun").val();
    var bulan = $("#filterBulan").val();
    var kecamatan = $("#filterKecamatan").val();
    
    if(!tahun || tahun === '') {
        alert("Silakan pilih tahun terlebih dahulu!");
        return;
    }
    
    if(!bulan || bulan === '') {
        alert("Silakan pilih bulan terlebih dahulu!");
        return;
    }
    
    $("#loadingOverlay").fadeIn();
    
    $.ajax({
        url: base_url + "k_laporan_kepala/get_history_data",
        type: "POST",
        data: {
            tahun: tahun,
            bulan: bulan,
            kecamatan: kecamatan
        },
        dataType: "json",
        success: function(response) {
            // Clear table
            table.clear().draw();
            
            var bulanText = bulanNama[bulan] || bulan;
            var kecamatanText = (kecamatan && kecamatan !== 'semua') ? 'Kecamatan ' + kecamatan : 'Seluruh Kecamatan';
            
            $("#reportTitle").html('Data Peternak dan Populasi Ternak Tahun ' + tahun);
            $("#reportSubtitle").html('Kota Surabaya - ' + kecamatanText + '<br>Periode: ' + bulanText + ' ' + tahun);
            
            var totalData = {
                sapi_potong_jantan: 0, sapi_potong_betina: 0,
                sapi_perah_jantan: 0, sapi_perah_betina: 0,
                kambing_jantan: 0, kambing_betina: 0,
                domba_jantan: 0, domba_betina: 0,
                kerbau_jantan: 0, kerbau_betina: 0,
                kuda_jantan: 0, kuda_betina: 0,
                ayam_buras: 0, ayam_broiler: 0, ayam_layer: 0,
                itik: 0, angsa: 0, kalkun: 0, burung: 0, lainnya: 0
            };
            
            if(response.data && response.data.length > 0) {
                $.each(response.data, function(index, item) {
                    totalData.sapi_potong_jantan += parseInt(item.sapi_potong_jantan) || 0;
                    totalData.sapi_potong_betina += parseInt(item.sapi_potong_betina) || 0;
                    totalData.sapi_perah_jantan += parseInt(item.sapi_perah_jantan) || 0;
                    totalData.sapi_perah_betina += parseInt(item.sapi_perah_betina) || 0;
                    totalData.kambing_jantan += parseInt(item.kambing_jantan) || 0;
                    totalData.kambing_betina += parseInt(item.kambing_betina) || 0;
                    totalData.domba_jantan += parseInt(item.domba_jantan) || 0;
                    totalData.domba_betina += parseInt(item.domba_betina) || 0;
                    totalData.kerbau_jantan += parseInt(item.kerbau_jantan) || 0;
                    totalData.kerbau_betina += parseInt(item.kerbau_betina) || 0;
                    totalData.kuda_jantan += parseInt(item.kuda_jantan) || 0;
                    totalData.kuda_betina += parseInt(item.kuda_betina) || 0;
                    totalData.ayam_buras += parseInt(item.ayam_buras) || 0;
                    totalData.ayam_broiler += parseInt(item.ayam_broiler) || 0;
                    totalData.ayam_layer += parseInt(item.ayam_layer) || 0;
                    totalData.itik += parseInt(item.itik) || 0;
                    totalData.angsa += parseInt(item.angsa) || 0;
                    totalData.kalkun += parseInt(item.kalkun) || 0;
                    totalData.burung += parseInt(item.burung) || 0;
                    totalData.lainnya += parseInt(item.lainnya) || 0;
                    
                    var detailUrl = base_url + "k_laporan_kepala/detail_peternak/" + encodeURIComponent(item.nik);
                    var namaLink = '<a href="'+ detailUrl +'" class="peternak-link" target="_blank">' + (item.nama_peternak || '-') + '</a>';
                    
                    table.row.add([
                        (index + 1),
                        item.nik || '-',
                        namaLink,
                        item.alamat || '-',
                        item.kecamatan || '-',
                        item.kelurahan || '-',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.sapi_potong_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.sapi_potong_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.sapi_perah_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.sapi_perah_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kambing_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kambing_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.domba_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.domba_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kerbau_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kerbau_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kuda_jantan) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kuda_betina) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.ayam_buras) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.ayam_broiler) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.ayam_layer) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.itik) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.angsa) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.kalkun) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.burung) + '</a>',
                        '<a href="'+ detailUrl +'" class="data-link" target="_blank">' + formatNumber(item.lainnya) + '</a>'
                    ]).draw(false);
                });
            } else {
                table.row.add([
                    '1', '-', '-', '-', '-', '-',
                    '0', '0', '0', '0', '0', '0', '0', '0',
                    '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'
                ]).draw(false);
            }
            
            var footerHtml = '<tr class="total-row">' +
                '<td colspan="6"><strong>TOTAL</strong></td>' +
                '<td><strong>' + formatNumber(totalData.sapi_potong_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.sapi_potong_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.sapi_perah_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.sapi_perah_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kambing_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kambing_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.domba_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.domba_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kerbau_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kerbau_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kuda_jantan) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kuda_betina) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.ayam_buras) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.ayam_broiler) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.ayam_layer) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.itik) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.angsa) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.kalkun) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.burung) + '</strong></td>' +
                '<td><strong>' + formatNumber(totalData.lainnya) + '</strong></td>' +
                '</tr>';
            $("#tableFooter").html(footerHtml);
            
            $("#loadingOverlay").fadeOut();
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            alert("Gagal memuat data. Silakan coba lagi. Error: " + error);
            $("#loadingOverlay").fadeOut();
        }
    });
}

function formatNumber(num) {
    if(num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}