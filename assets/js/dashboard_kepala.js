// Data untuk modal tabel pelaku usaha
const allKecamatanData = [
    { nama: "Karang Pilang", pelakuUsaha: 15 }, { nama: "Jambangan", pelakuUsaha: 12 },
    { nama: "Gayungan", pelakuUsaha: 10 }, { nama: "Wonocolo", pelakuUsaha: 18 },
    { nama: "Tenggilis Mejoyo", pelakuUsaha: 14 }, { nama: "Gunung Anyar", pelakuUsaha: 20 },
    { nama: "Rungkut", pelakuUsaha: 22 }, { nama: "Sukolilo", pelakuUsaha: 19 },
    { nama: "Mulyorejo", pelakuUsaha: 16 }, { nama: "Gubeng", pelakuUsaha: 28 },
    { nama: "Wonokromo", pelakuUsaha: 25 }, { nama: "Dukuh Pakis", pelakuUsaha: 13 },
    { nama: "Wiyung", pelakuUsaha: 17 }, { nama: "Lakarsantri", pelakuUsaha: 21 },
    { nama: "Sambikerep", pelakuUsaha: 11 }, { nama: "Tandes", pelakuUsaha: 23 },
    { nama: "Sukomanunggal", pelakuUsaha: 14 }, { nama: "Sawahan", pelakuUsaha: 38 },
    { nama: "Tegalsari", pelakuUsaha: 19 }, { nama: "Genteng", pelakuUsaha: 42 },
    { nama: "Bubutan", pelakuUsaha: 15 }, { nama: "Krembangan", pelakuUsaha: 12 },
    { nama: "Semampir", pelakuUsaha: 24 }, { nama: "Kenjeran", pelakuUsaha: 27 },
    { nama: "Bulak", pelakuUsaha: 18 }, { nama: "Tambaksari", pelakuUsaha: 32 },
    { nama: "Simokerto", pelakuUsaha: 16 }, { nama: "Pabean Cantian", pelakuUsaha: 10 },
    { nama: "Kandangan", pelakuUsaha: 13 }, { nama: "Benowo", pelakuUsaha: 20 },
    { nama: "Pakal", pelakuUsaha: 17 }
];

// Data lengkap untuk modal 31 kecamatan
const fullKecamatanData = [
    { no: 1, nama: "Karang Pilang", pelakuUsaha: 15, jenisTernak: "Sapi Potong, Kambing", vaksinPMK: "195 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "112 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 2, nama: "Jambangan", pelakuUsaha: 12, jenisTernak: "Ayam Layer", vaksinPMK: "0 Ekor", vaksinNDAI: "9.840 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 3, nama: "Gayungan", pelakuUsaha: 10, jenisTernak: "Itik, Burung", vaksinPMK: "0 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 1, penjualPakan: 0, rpu: 0 },
    { no: 4, nama: "Wonocolo", pelakuUsaha: 18, jenisTernak: "Ayam Broiler", vaksinPMK: "0 Ekor", vaksinNDAI: "15.300 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 1, rpu: 0 },
    { no: 5, nama: "Tenggilis Mejoyo", pelakuUsaha: 14, jenisTernak: "Sapi Perah", vaksinPMK: "112 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "56 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 6, nama: "Gunung Anyar", pelakuUsaha: 20, jenisTernak: "Kambing, Domba", vaksinPMK: "166 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "80 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 7, nama: "Rungkut", pelakuUsaha: 22, jenisTernak: "Ayam Buras, Itik", vaksinPMK: "0 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 8, nama: "Sukolilo", pelakuUsaha: 19, jenisTernak: "Sapi Potong", vaksinPMK: "150 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "76 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 1, rpu: 0 },
    { no: 9, nama: "Mulyorejo", pelakuUsaha: 16, jenisTernak: "Ayam Layer", vaksinPMK: "0 Ekor", vaksinNDAI: "13.440 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 10, nama: "Gubeng", pelakuUsaha: 28, jenisTernak: "Sapi Perah, Kuda", vaksinPMK: "227 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "185 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 11, nama: "Wonokromo", pelakuUsaha: 25, jenisTernak: "Ayam Layer, Burung", vaksinPMK: "173 Ekor", vaksinNDAI: "7.800 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 12, nama: "Dukuh Pakis", pelakuUsaha: 13, jenisTernak: "Kambing", vaksinPMK: "95 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "46 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 13, nama: "Wiyung", pelakuUsaha: 17, jenisTernak: "Ayam Broiler", vaksinPMK: "0 Ekor", vaksinNDAI: "14.790 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 1, penjualPakan: 0, rpu: 0 },
    { no: 14, nama: "Lakarsantri", pelakuUsaha: 21, jenisTernak: "Sapi Potong, Domba", vaksinPMK: "185 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "94 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 15, nama: "Sambikerep", pelakuUsaha: 11, jenisTernak: "Itik", vaksinPMK: "0 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 16, nama: "Tandes", pelakuUsaha: 23, jenisTernak: "Ayam Buras, Kerbau", vaksinPMK: "45 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "23 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 1, rpu: 0 },
    { no: 17, nama: "Sukomanunggal", pelakuUsaha: 14, jenisTernak: "Kambing", vaksinPMK: "106 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "51 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 18, nama: "Sawahan", pelakuUsaha: 38, jenisTernak: "Ayam Broiler, Itik", vaksinPMK: "370 Ekor", vaksinNDAI: "11.280 Ekor", vaksinLSD: "165 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 1, rpu: 0 },
    { no: 19, nama: "Tegalsari", pelakuUsaha: 19, jenisTernak: "Sapi Potong", vaksinPMK: "152 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "73 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 20, nama: "Genteng", pelakuUsaha: 42, jenisTernak: "Sapi Potong, Kambing", vaksinPMK: "480 Ekor", vaksinNDAI: "520 Ekor", vaksinLSD: "210 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 21, nama: "Bubutan", pelakuUsaha: 15, jenisTernak: "Ayam Layer", vaksinPMK: "0 Ekor", vaksinNDAI: "11.550 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 22, nama: "Krembangan", pelakuUsaha: 12, jenisTernak: "Itik", vaksinPMK: "0 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 23, nama: "Semampir", pelakuUsaha: 24, jenisTernak: "Ayam Buras, Kambing", vaksinPMK: "78 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "42 Ekor", klinik: 0, penjualObat: 1, penjualPakan: 0, rpu: 0 },
    { no: 24, nama: "Kenjeran", pelakuUsaha: 27, jenisTernak: "Sapi Potong, Itik", vaksinPMK: "232 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 1 },
    { no: 25, nama: "Bulak", pelakuUsaha: 18, jenisTernak: "Ayam Broiler", vaksinPMK: "0 Ekor", vaksinNDAI: "14.580 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 26, nama: "Tambaksari", pelakuUsaha: 32, jenisTernak: "Domba, Kerbau", vaksinPMK: "237 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "98 Ekor", klinik: 0, penjualObat: 1, penjualPakan: 0, rpu: 0 },
    { no: 27, nama: "Simokerto", pelakuUsaha: 16, jenisTernak: "Kambing", vaksinPMK: "120 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "58 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 28, nama: "Pabean Cantian", pelakuUsaha: 10, jenisTernak: "Burung", vaksinPMK: "0 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 29, nama: "Kandangan", pelakuUsaha: 13, jenisTernak: "Sapi Perah", vaksinPMK: "103 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "49 Ekor", klinik: 1, penjualObat: 0, penjualPakan: 0, rpu: 0 },
    { no: 30, nama: "Benowo", pelakuUsaha: 20, jenisTernak: "Ayam Broiler, Kuda", vaksinPMK: "34 Ekor", vaksinNDAI: "17.000 Ekor", vaksinLSD: "0 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 1, rpu: 0 },
    { no: 31, nama: "Pakal", pelakuUsaha: 17, jenisTernak: "Sapi Potong, Domba", vaksinPMK: "141 Ekor", vaksinNDAI: "0 Ekor", vaksinLSD: "68 Ekor", klinik: 0, penjualObat: 0, penjualPakan: 0, rpu: 1 }
];

// Render modal pelaku usaha
function renderModalPelakuUsaha() {
    const tbody = document.getElementById('modalTableBody');
    if (!tbody) return;
    tbody.innerHTML = '';
    let total = 0;
    allKecamatanData.forEach((item, index) => {
        total += item.pelakuUsaha;
        tbody.innerHTML += `<tr><td class="text-center">${index + 1}</td><td>${item.nama}</td><td class="text-end">${item.pelakuUsaha}</td></tr>`;
    });
    document.getElementById('modalTotalPelaku').innerText = total;
}

// Render full table modal
function renderFullTableModal() {
    const tbody = document.getElementById('fullTableBody');
    const tfoot = document.getElementById('fullTableFooter');
    if (!tbody) return;
    tbody.innerHTML = '';
    fullKecamatanData.forEach((item) => {
        tbody.innerHTML += `<tr>
            <td class="text-center">${item.no}</td>
            <td>${item.nama}</td>
            <td class="text-end">${item.pelakuUsaha}</td>
            <td>${item.jenisTernak}</td>
            <td class="text-end">${item.vaksinPMK}</td>
            <td class="text-end">${item.vaksinNDAI}</td>
            <td class="text-end">${item.vaksinLSD}</td>
            <td class="text-end">${item.klinik}</td>
            <td class="text-end">${item.penjualObat}</td>
            <td class="text-end">${item.penjualPakan}</td>
            <td class="text-end">${item.rpu}</td>
        </tr>`;
    });
    if (tfoot) {
        tfoot.innerHTML = `<tr class="fw-bold">
            <td colspan="2">Total 31 Kecamatan</td>
            <td class="text-end">648</td>
            <td>13 Jenis Ternak</td>
            <td class="text-end">2.487 Ekor</td>
            <td class="text-end">74.000 Ekor</td>
            <td class="text-end">1.258 Ekor</td>
            <td class="text-end">8 Unit</td>
            <td class="text-end">4 Toko</td>
            <td class="text-end">5 Outlet</td>
            <td class="text-end">6 Unit</td>
        </tr>`;
    }
}

// Grafik Distribusi Pelaku Usaha per 31 Kecamatan
document.addEventListener("DOMContentLoaded", function () {
    renderModalPelakuUsaha();
    renderFullTableModal();
    
    var ctx = document.getElementById("kecamatanChart").getContext("2d");
    
    // Set background canvas menjadi putih
    ctx.canvas.style.backgroundColor = "#ffffff";
    
    var kecamatanChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Karang Pilang", "Jambangan", "Gayungan", "Wonocolo", "Tenggilis Mejoyo", "Gunung Anyar", "Rungkut", "Sukolilo", "Mulyorejo", "Gubeng", "Wonokromo", "Dukuh Pakis", "Wiyung", "Lakarsantri", "Sambikerep", "Tandes", "Sukomanunggal", "Sawahan", "Tegalsari", "Genteng", "Bubutan", "Krembangan", "Semampir", "Kenjeran", "Bulak", "Tambaksari", "Simokerto", "Pabean Cantian", "Kandangan", "Benowo", "Pakal"],
            datasets: [{
                label: "Jumlah Pelaku Usaha",
                data: [15, 12, 10, 18, 14, 20, 22, 19, 16, 28, 25, 13, 17, 21, 11, 23, 14, 38, 19, 42, 15, 12, 24, 27, 18, 32, 16, 10, 13, 20, 17],
                backgroundColor: "#832706",  // Warna dasar untuk batang
                borderColor: "#6b2005",      // Border lebih gelap dari warna dasar
                borderWidth: 1,
                borderRadius: 3,
                barPercentage: 0.7,
                categoryPercentage: 0.9
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#832706',
                        font: { size: 11, weight: 'bold' },
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                tooltip: {
                    backgroundColor: "#832706",  // Tooltip warna dasar
                    titleColor: "#ffffff",
                    bodyColor: "#ffffff",
                    callbacks: {
                        label: function (context) {
                            return `Pelaku Usaha: ${context.raw} peternak`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 50,
                    grid: { drawBorder: false, color: "rgba(0, 0, 0, 0.08)" },
                    ticks: { 
                        font: { size: 10, weight: 'normal' }, 
                        stepSize: 10,
                        color: "#333333"
                    },
                    title: { 
                        display: true, 
                        text: "Jumlah Pelaku Usaha", 
                        font: { size: 11, weight: 'bold' },
                        color: "#832706"
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 8 }, 
                        rotation: 45,
                        color: "#333333"
                    },
                    title: { 
                        display: true, 
                        text: "Kecamatan", 
                        font: { size: 11, weight: 'bold' },
                        color: "#832706"
                    }
                }
            },
            animation: { duration: 1000, easing: "easeOutQuart" },
            layout: { 
                padding: { 
                    top: 20,
                    bottom: 10,
                    left: 10,
                    right: 10
                } 
            }
        }
    });
});

// Script untuk menangani jika gambar tidak ada
document.addEventListener("DOMContentLoaded", function () {
    const mapImage = document.querySelector('img[src*="peta surabaya.jpeg"]');
    if (mapImage) {
        mapImage.onerror = function () {
            this.style.display = "none";
        };
    }
});

function openFullMap() {
    window.location.href = "<?php echo site_url('k_peta_sebaran_kepala'); ?>";
}

// Responsive sidebar
function initResponsiveSidebar() {
    setTimeout(function() {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.toggle-sidebar');
        if (!sidebar || !toggleBtn) return;
        
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:998;display:none;cursor:pointer;';
            document.body.appendChild(overlay);
        }
        
        function openSidebar() {
            sidebar.style.transform = 'translateX(0)';
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeSidebar() {
            sidebar.style.transform = 'translateX(-100%)';
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }
        
        function toggleSidebar(e) {
            if (e) e.preventDefault();
            if (window.innerWidth <= 768) {
                if (sidebar.style.transform === 'translateX(0px)') closeSidebar();
                else openSidebar();
            }
        }
        
        if (window.innerWidth <= 768) {
            sidebar.style.position = 'fixed';
            sidebar.style.top = '0';
            sidebar.style.left = '0';
            sidebar.style.height = '100%';
            sidebar.style.width = '260px';
            sidebar.style.zIndex = '999';
            sidebar.style.transform = 'translateX(-100%)';
            sidebar.style.transition = 'transform 0.3s ease';
        }
        
        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', closeSidebar);
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) closeSidebar();
            else if (sidebar.style.transform !== 'translateX(0px)') sidebar.style.transform = 'translateX(-100%)';
        });
    }, 100);
}

document.addEventListener("DOMContentLoaded", function() {
    initResponsiveSidebar();
});
