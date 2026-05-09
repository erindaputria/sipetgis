var csrf_token = $('meta[name="csrf-token"]').attr('content');
var csrf_name = $('meta[name="csrf-name"]').attr('content');

let map, editMap, viewMap;
let marker, editMarker, viewMarker;

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
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(newMap);
    
    if (lat && lng && !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng))) {
        const newMarker = L.marker([parseFloat(lat), parseFloat(lng)]).addTo(newMap);
        return { map: newMap, marker: newMarker };
    }
    
    return { map: newMap, marker: null };
}

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
    $("#rpuTable").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    window.location.href = base_url + "rpu/export_excel";
                }
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
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
        pageLength: 15,
        lengthChange: false,
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "40%", targets: 1 },
            { width: "20%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "15%", targets: 4 }
        ]
    });

    $(document).on("click", ".btn-view", function() {
        var pejagal = $(this).data('pejagal');
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        
        $('#view_pejagal').val(pejagal);
        $('#view_latitude').val(latitude && latitude !== '' ? latitude : '-');
        $('#view_longitude').val(longitude && longitude !== '' ? longitude : '-');
        
        $('#viewKoordinatModal').modal('show');
    });

    // Inisialisasi peta saat modal view benar-benar tampil
    $('#viewKoordinatModal').on('shown.bs.modal', function() {
        var latitude = $('#view_latitude').val();
        var longitude = $('#view_longitude').val();
        
        // Bersihkan map lama jika ada
        if (viewMap) {
            viewMap.remove();
            viewMap = null;
            viewMarker = null;
        }
        
        setTimeout(function() {
            const result = initMap('viewMapPreview', latitude, longitude, null);
            viewMap = result.map;
            viewMarker = result.marker;
        }, 300);
    });

    // Bersihkan map saat modal view ditutup
    $('#viewKoordinatModal').on('hidden.bs.modal', function() {
        if (viewMap) {
            viewMap.remove();
            viewMap = null;
            viewMarker = null;
        }
    });

    $(document).on("click", ".btn-edit", function() {
        var pejagal = $(this).data('pejagal');
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        
        $('#edit_pejagal_lama').val(pejagal);
        $('#edit_pejagal').val(pejagal);
        $('#edit_latitude').val(latitude || '');
        $('#edit_longitude').val(longitude || '');
        
        $('#editDataModal').modal('show');
    });

    // Inisialisasi peta saat modal edit benar-benar tampil
    $('#editDataModal').on('shown.bs.modal', function() {
        var latitude = $('#edit_latitude').val();
        var longitude = $('#edit_longitude').val();
        
        if (editMap) {
            editMap.remove();
            editMap = null;
            editMarker = null;
        }
        
        setTimeout(function() {
            const result = initMap('editMapPreview', latitude, longitude, null);
            editMap = result.map;
            editMarker = result.marker;
        }, 300);
    });

    // Bersihkan map saat modal edit ditutup
    $('#editDataModal').on('hidden.bs.modal', function() {
        if (editMap) {
            editMap.remove();
            editMap = null;
            editMarker = null;
        }
    });

    $(document).on("click", ".btn-delete", function(e) {
        e.preventDefault();
        
        var pejagal = $(this).data('pejagal');
        
        if (confirm("Apakah Anda yakin ingin menghapus data RPU: " + pejagal + "?")) {
            
            var postData = {
                pejagal: pejagal,
                action: 'delete'
            };
            
            if (csrf_name && csrf_token) {
                postData[csrf_name] = csrf_token;
            } else {
                postData[$('meta[name="csrf-name"]').attr('content')] = $('meta[name="csrf-token"]').attr('content');
            }
            
            $.ajax({
                url: base_url + "rpu/hapus_ajax",
                type: 'POST',
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-delete').prop('disabled', true);
                },
                success: function(res) {
                    if (res.status === 'success') {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message || 'Gagal menghapus data');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 403) {
                        alert('Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
                    } else if (xhr.status === 500) {
                        alert('Error server. Silakan coba lagi.');
                    } else {
                        alert('Gagal menghapus data. Error: ' + error);
                    }
                },
                complete: function() {
                    $('.btn-delete').prop('disabled', false);
                }
            });
        }
    });

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

    $('#latitude, #longitude').on('input', function() {
        if (map) {
            const lat = $('#latitude').val();
            const lng = $('#longitude').val();
            marker = updateMarker(map, marker, lat, lng);
        }
    });

    $('#edit_latitude, #edit_longitude').on('input', function() {
        if (editMap) {
            const lat = $('#edit_latitude').val();
            const lng = $('#edit_longitude').val();
            editMarker = updateMarker(editMap, editMarker, lat, lng);
        }
    });

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

    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
});

function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    var tableData = [];
    var totalData = 0;
    
    var table = $('#rpuTable').DataTable();
    table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        var rowData = this.data();
        tableData.push(rowData);
    });
    
    totalData = tableData.length;
    
    var currentDate = new Date();
    var formattedDateTime = currentDate.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }) + ' ' + currentDate.toLocaleTimeString('id-ID');
    
    printWindow.document.write('<html><head><title>Laporan RPU</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
    printWindow.document.write('.header { text-align: center; margin-bottom: 20px; }');
    printWindow.document.write('.header h2 { margin: 0; color: #000000; }');
    printWindow.document.write('.header h3 { margin: 5px 0; color: #000000; }');
    printWindow.document.write('.header p { margin: 5px 0; color: #000000; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
    printWindow.document.write('th, td { border: 1px solid #000; padding: 8px; }');
    printWindow.document.write('th { background-color: #832706; color: #ffffff; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA RPU</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    printWindow.document.write('<table border="1" cellpadding="8" cellspacing="0" width="100%">');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>'); 
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama RPU</th>');
    printWindow.document.write('<th>Latitude</th>');
    printWindow.document.write('<th>Longitude</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    for (var i = 0; i < tableData.length; i++) {
        var row = tableData[i];
        printWindow.document.write('<tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data RPU</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    printWindow.document.write('<div class="footer-note">');
    printWindow.document.write('SIPETGIS - Sistem Informasi Peternakan Kota Surabaya');
    printWindow.document.write('</div>');
    
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function formatNumber(num) {
    if (num === null || num === undefined || num === 0) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function stripHtml(html) {
    if (!html) return '-';
    var tmp = document.createElement('DIV');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '-';
}