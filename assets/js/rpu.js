/**
 * Master RPU
 * SIPETGIS - Kota Surabaya
 */

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
    // Initialize DataTable with custom buttons (SAMA PERSIS PELAKU USAHA)
    rpuTable = $('#rpuTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'copy',
            //     text: '<i class="fas fa-copy"></i> Copy',
            //     className: 'btn btn-sm btn-primary',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
            // {
            //     extend: 'csv',
            //     text: '<i class="fas fa-file-csv"></i> CSV',
            //     className: 'btn btn-sm btn-success',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-sm btn-success',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    window.location.href = base_url + "rpu/export_excel";
                }
            },
            // {
            //     extend: 'pdf',
            //     text: '<i class="fas fa-file-pdf"></i> PDF',
            //     className: 'btn btn-sm btn-danger',
            //     exportOptions: { columns: [0,1,2,3] }
            // },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-sm btn-info',
                exportOptions: { columns: [0,1,2,3] },
                action: function(e, dt, button, config) {
                    printWithCurrentData();
                }
            }
        ],
        ordering: false,
        searching: true,
        paging: true,
        pageLength: 15,
        lengthMenu: [10, 15, 25, 50, 100],
        info: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            zeroRecords: "Tidak ada data ditemukan",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        scrollX: true
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
        
        setTimeout(function() {
            if (editMap) {
                editMap.remove();
            }
            const result = initMap('editMapPreview', latitude, longitude, editMap);
            editMap = result.map;
            editMarker = result.marker;
        }, 500);
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

var rpuTable = null;

// ========== FUNCTION PRINT (DIPERBAIKI - SAMA PERSIS PELAKU USAHA) ==========
function printWithCurrentData() {
    var printWindow = window.open('', '_blank');
    
    // Ambil semua baris dari tabel yang tampil di layar (termasuk yang terfilter)
    var table = $('#rpuTable').DataTable();
    var rows = table.rows({ search: 'applied' }).data();
    
    var totalData = rows.length;
    
    // Current date
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
    printWindow.document.write('th { background-color: #832706; color: #000000; text-align: center; }');
    printWindow.document.write('td { color: #000000; }');
    printWindow.document.write('.total-row { background-color: #e8f5e9; font-weight: bold; }');
    printWindow.document.write('.total-row td { color: #000000; }');
    printWindow.document.write('.footer-note { margin-top: 30px; font-size: 10px; color: #000000; text-align: center; }');
    printWindow.document.write('@media print { .no-print { display: none; } }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    
    // Header Laporan
    printWindow.document.write('<div class="header">');
    printWindow.document.write('<h2>LAPORAN DATA RPU</h2>');
    printWindow.document.write('<h3>DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>');
    printWindow.document.write('<h3>KOTA SURABAYA</h3>');
    printWindow.document.write('<hr>');
    printWindow.document.write('<p>Tanggal Cetak: ' + formattedDateTime + '</p>');
    printWindow.document.write('</div>');
    
    // Tabel Data
    printWindow.document.write('<table>');
    printWindow.document.write('<thead>');
    printWindow.document.write('<tr>');
    printWindow.document.write('<th width="40">No</th>');
    printWindow.document.write('<th>Nama RPU/Pejagal</th>');
    printWindow.document.write('<th>Latitude</th>');
    printWindow.document.write('<th>Longitude</th>');
    printWindow.document.write('</tr>');
    printWindow.document.write('</thead>');
    printWindow.document.write('<tbody>');
    
    // Loop data dari tabel
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        printWindow.document.write('</tr>');
        printWindow.document.write('<td align="center">' + (i + 1) + '</td>');
        printWindow.document.write('<td align="left">' + stripHtml(row[1] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[2] || '-') + '</td>');
        printWindow.document.write('<td align="center">' + stripHtml(row[3] || '-') + '</td>');
        printWindow.document.write('</tr>');
    }
    
    // Total row
    printWindow.document.write('<tr class="total-row">');
    printWindow.document.write('<td colspan="3" align="center"><strong>TOTAL KESELURUHAN</strong></td>');
    printWindow.document.write('<td align="center"><strong>' + formatNumber(totalData) + ' Data RPU</strong></td>');
    printWindow.document.write('</tr>');
    
    printWindow.document.write('</tbody>');
    printWindow.document.write('</table>');
    
    // Footer Note
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

// Base URL untuk redirect
var base_url = "<?= base_url() ?>"; 