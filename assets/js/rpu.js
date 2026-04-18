// Variabel untuk menyimpan instance map
let map, editMap, viewMap;
let marker, editMarker, viewMarker;

// Fungsi untuk inisialisasi map
function initMap(containerId, lat, lng, mapRef) {
    if (mapRef) {
        mapRef.remove();
    }
    
    const defaultLat = -7.2574719;
    const defaultLng = 112.7520883;
    
    const mapLat = (lat && !isNaN(parseFloat(lat))) ? parseFloat(lat) : defaultLat;
    const mapLng = (lng && !isNaN(parseFloat(lng))) ? parseFloat(lng) : defaultLng;
    
    const newMap = L.map(containerId).setView([mapLat, mapLng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(newMap);
    
    if (lat && lng && !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng))) {
        const newMarker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(newMap);
        return { map: newMap, marker: newMarker };
    }
    
    return { map: newMap, marker: null };
}

// Fungsi untuk update marker
function updateMarker(mapInstance, markerRef, lat, lng) {
    if (!mapInstance) return null;
    
    const latNum = parseFloat(lat);
    const lngNum = parseFloat(lng);
    
    if (isNaN(latNum) || isNaN(lngNum)) return markerRef;
    
    mapInstance.setView([latNum, lngNum], 15);
    
    if (markerRef) {
        markerRef.setLatLng([latNum, lngNum]);
        return markerRef;
    } else {
        return L.marker([latNum, lngNum]).addTo(mapInstance);
    }
}

$(document).ready(function() {
    // Inisialisasi DataTable - SAMA PERSIS DENGAN PELAKU USAHA
    var table = $("#rpuTable").DataTable({
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
                        text: 'LAPORAN DATA RPU',
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
                        '<h2 style="color: #832706; margin-bottom: 5px;">LAPORAN DATA RPU</h2>' +
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
        order: [[1, 'asc']],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "40%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "15%", targets: 4 }
        ]
    });

    // Event untuk tombol lihat koordinat
    $(document).on("click", ".btn-view", function() {
        var pejagal = $(this).data('pejagal');
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        
        $('#view_pejagal').val(pejagal);
        $('#view_latitude').val(latitude || '-');
        $('#view_longitude').val(longitude || '-');
        
        $('#viewKoordinatModal').modal('show');
        
        setTimeout(function() {
            if (viewMap) {
                viewMap.remove();
            }
            const result = initMap('viewMapPreview', latitude, longitude, viewMap);
            viewMap = result.map;
            viewMarker = result.marker;
        }, 500);
    });

    // Event untuk tombol edit
    $(document).on("click", ".btn-edit", function() {
        var pejagal = $(this).data('pejagal');
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        
        $('#edit_pejagal_lama').val(pejagal);
        $('#edit_pejagal').val(pejagal);
        $('#edit_latitude').val(latitude);
        $('#edit_longitude').val(longitude);
        
        $('#editDataModal').modal('show');
    });

    // Event untuk tombol hapus
    $(document).on("click", ".btn-delete", function() {
        var pejagal = $(this).data('pejagal');
        
        if (confirm("Apakah Anda yakin ingin menghapus data RPU: " + pejagal + "?")) {
            window.location.href = base_url + "rpu/hapus/" + encodeURIComponent(pejagal);
        }
    });

    // Event ketika modal tambah ditampilkan
    $('#tambahDataModal').on('shown.bs.modal', function() {
        setTimeout(function() {
            if (map) {
                map.remove();
            }
            const lat = $('#latitude').val();
            const lng = $('#longitude').val();
            const result = initMap('mapPreview', lat, lng, map);
            map = result.map;
            marker = result.marker;
        }, 500);
    });

    // Event ketika modal edit ditampilkan
    $('#editDataModal').on('shown.bs.modal', function() {
        setTimeout(function() {
            if (editMap) {
                editMap.remove();
            }
            const lat = $('#edit_latitude').val();
            const lng = $('#edit_longitude').val();
            const result = initMap('editMapPreview', lat, lng, editMap);
            editMap = result.map;
            editMarker = result.marker;
        }, 500);
    });

    // Update map preview saat latitude/longitude berubah di modal tambah
    $('#latitude, #longitude').on('input', function() {
        if (map) {
            const lat = $('#latitude').val();
            const lng = $('#longitude').val();
            marker = updateMarker(map, marker, lat, lng);
        }
    });

    // Update map preview saat latitude/longitude berubah di modal edit
    $('#edit_latitude, #edit_longitude').on('input', function() {
        if (editMap) {
            const lat = $('#edit_latitude').val();
            const lng = $('#edit_longitude').val();
            editMarker = updateMarker(editMap, editMarker, lat, lng);
        }
    });

    // Validasi input koordinat (hanya angka, titik, dan minus)
    $('input[name="latitude"], input[name="longitude"], #edit_latitude, #edit_longitude').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9.-]/g, '');
        
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        if (value.indexOf('-') > 0) {
            value = value.replace(/-/g, '');
        }
        
        $(this).val(value);
    });

    // Auto close alerts
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

// Base URL untuk redirect
var base_url = "<?= base_url() ?>";