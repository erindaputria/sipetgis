// Data Kecamatan (31 Kecamatan)
const kecamatanData = [
    { no: 1, nama: "Karang Pilang", peternak: 15, sapiPotong: 45, sapiPerah: 12, kambing: 38, domba: 25, ayamBuras: 120, ayamBroiler: 0, ayamLayer: 0, itik: 50, angsa: 5, kalkun: 2, burung: 15, kerbau: 8, kuda: 3 },
    { no: 2, nama: "Jambangan", peternak: 12, sapiPotong: 0, sapiPerah: 0, kambing: 25, domba: 18, ayamBuras: 200, ayamBroiler: 0, ayamLayer: 8500, itik: 30, angsa: 3, kalkun: 0, burung: 20, kerbau: 0, kuda: 0 },
    { no: 3, nama: "Gayungan", peternak: 10, sapiPotong: 0, sapiPerah: 0, kambing: 30, domba: 22, ayamBuras: 350, ayamBroiler: 0, ayamLayer: 0, itik: 180, angsa: 8, kalkun: 0, burung: 45, kerbau: 0, kuda: 0 },
    { no: 4, nama: "Wonocolo", peternak: 18, sapiPotong: 0, sapiPerah: 0, kambing: 20, domba: 15, ayamBuras: 0, ayamBroiler: 12500, ayamLayer: 0, itik: 25, angsa: 2, kalkun: 0, burung: 10, kerbau: 0, kuda: 0 },
    { no: 5, nama: "Tenggilis Mejoyo", peternak: 14, sapiPotong: 28, sapiPerah: 35, kambing: 15, domba: 10, ayamBuras: 80, ayamBroiler: 0, ayamLayer: 0, itik: 20, angsa: 4, kalkun: 1, burung: 8, kerbau: 5, kuda: 2 },
    { no: 6, nama: "Gunung Anyar", peternak: 20, sapiPotong: 52, sapiPerah: 18, kambing: 45, domba: 30, ayamBuras: 150, ayamBroiler: 0, ayamLayer: 0, itik: 35, angsa: 6, kalkun: 2, burung: 12, kerbau: 10, kuda: 4 },
    { no: 7, nama: "Rungkut", peternak: 22, sapiPotong: 0, sapiPerah: 0, kambing: 35, domba: 28, ayamBuras: 420, ayamBroiler: 0, ayamLayer: 0, itik: 95, angsa: 10, kalkun: 3, burung: 25, kerbau: 0, kuda: 0 },
    { no: 8, nama: "Sukolilo", peternak: 19, sapiPotong: 38, sapiPerah: 0, kambing: 22, domba: 18, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 15, angsa: 3, kalkun: 0, burung: 8, kerbau: 6, kuda: 1 },
    { no: 9, nama: "Mulyorejo", peternak: 16, sapiPotong: 0, sapiPerah: 0, kambing: 18, domba: 12, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 11200, itik: 22, angsa: 2, kalkun: 0, burung: 15, kerbau: 0, kuda: 0 },
    { no: 10, nama: "Gubeng", peternak: 28, sapiPotong: 65, sapiPerah: 42, kambing: 38, domba: 25, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 0, angsa: 8, kalkun: 4, burung: 30, kerbau: 12, kuda: 8 },
    { no: 11, nama: "Wonokromo", peternak: 25, sapiPotong: 0, sapiPerah: 0, kambing: 28, domba: 20, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 6500, itik: 18, angsa: 5, kalkun: 2, burung: 22, kerbau: 0, kuda: 0 },
    { no: 12, nama: "Dukuh Pakis", peternak: 13, sapiPotong: 0, sapiPerah: 0, kambing: 32, domba: 20, ayamBuras: 95, ayamBroiler: 0, ayamLayer: 0, itik: 12, angsa: 2, kalkun: 0, burung: 8, kerbau: 0, kuda: 0 },
    { no: 13, nama: "Wiyung", peternak: 17, sapiPotong: 0, sapiPerah: 0, kambing: 25, domba: 18, ayamBuras: 0, ayamBroiler: 14800, ayamLayer: 0, itik: 28, angsa: 4, kalkun: 1, burung: 12, kerbau: 0, kuda: 0 },
    { no: 14, nama: "Lakarsantri", peternak: 21, sapiPotong: 48, sapiPerah: 15, kambing: 35, domba: 28, ayamBuras: 180, ayamBroiler: 0, ayamLayer: 0, itik: 25, angsa: 6, kalkun: 2, burung: 18, kerbau: 8, kuda: 3 },
    { no: 15, nama: "Sambikerep", peternak: 11, sapiPotong: 0, sapiPerah: 0, kambing: 22, domba: 15, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 85, angsa: 12, kalkun: 3, burung: 8, kerbau: 0, kuda: 0 },
    { no: 16, nama: "Tandes", peternak: 23, sapiPotong: 12, sapiPerah: 0, kambing: 28, domba: 20, ayamBuras: 320, ayamBroiler: 0, ayamLayer: 0, itik: 22, angsa: 5, kalkun: 1, burung: 15, kerbau: 5, kuda: 2 },
    { no: 17, nama: "Sukomanunggal", peternak: 14, sapiPotong: 0, sapiPerah: 0, kambing: 28, domba: 18, ayamBuras: 75, ayamBroiler: 0, ayamLayer: 0, itik: 10, angsa: 2, kalkun: 0, burung: 6, kerbau: 0, kuda: 0 },
    { no: 18, nama: "Sawahan", peternak: 38, sapiPotong: 0, sapiPerah: 0, kambing: 45, domba: 32, ayamBuras: 0, ayamBroiler: 11280, ayamLayer: 0, itik: 42, angsa: 8, kalkun: 2, burung: 20, kerbau: 0, kuda: 0 },
    { no: 19, nama: "Tegalsari", peternak: 19, sapiPotong: 42, sapiPerah: 8, kambing: 22, domba: 15, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 0, angsa: 4, kalkun: 1, burung: 12, kerbau: 5, kuda: 2 },
    { no: 20, nama: "Genteng", peternak: 42, sapiPotong: 520, sapiPerah: 42, kambing: 520, domba: 42, ayamBuras: 520, ayamBroiler: 42, ayamLayer: 520, itik: 42, angsa: 520, kalkun: 42, burung: 520, kerbau: 42, kuda: 520 },
    { no: 21, nama: "Bubutan", peternak: 15, sapiPotong: 0, sapiPerah: 0, kambing: 18, domba: 12, ayamBuras: 0, ayamBroiler: 11500, ayamLayer: 0, itik: 15, angsa: 3, kalkun: 0, burung: 10, kerbau: 0, kuda: 0 },
    { no: 22, nama: "Krembangan", peternak: 12, sapiPotong: 0, sapiPerah: 0, kambing: 20, domba: 14, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 65, angsa: 5, kalkun: 1, burung: 8, kerbau: 0, kuda: 0 },
    { no: 23, nama: "Semampir", peternak: 24, sapiPotong: 18, sapiPerah: 0, kambing: 35, domba: 22, ayamBuras: 280, ayamBroiler: 0, ayamLayer: 0, itik: 28, angsa: 6, kalkun: 2, burung: 15, kerbau: 4, kuda: 1 },
    { no: 24, nama: "Kenjeran", peternak: 27, sapiPotong: 58, sapiPerah: 12, kambing: 32, domba: 25, ayamBuras: 150, ayamBroiler: 0, ayamLayer: 0, itik: 45, angsa: 8, kalkun: 3, burung: 18, kerbau: 6, kuda: 2 },
    { no: 25, nama: "Bulak", peternak: 18, sapiPotong: 0, sapiPerah: 0, kambing: 15, domba: 10, ayamBuras: 0, ayamBroiler: 14500, ayamLayer: 0, itik: 20, angsa: 4, kalkun: 0, burung: 8, kerbau: 0, kuda: 0 },
    { no: 26, nama: "Tambaksari", peternak: 32, sapiPotong: 0, sapiPerah: 0, kambing: 48, domba: 35, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 0, angsa: 10, kalkun: 4, burung: 25, kerbau: 8, kuda: 3 },
    { no: 27, nama: "Simokerto", peternak: 16, sapiPotong: 0, sapiPerah: 0, kambing: 28, domba: 18, ayamBuras: 85, ayamBroiler: 0, ayamLayer: 0, itik: 12, angsa: 3, kalkun: 0, burung: 10, kerbau: 0, kuda: 0 },
    { no: 28, nama: "Pabean Cantian", peternak: 10, sapiPotong: 0, sapiPerah: 0, kambing: 12, domba: 8, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 25, angsa: 15, kalkun: 5, burung: 20, kerbau: 0, kuda: 0 },
    { no: 29, nama: "Kandangan", peternak: 13, sapiPotong: 25, sapiPerah: 18, kambing: 20, domba: 14, ayamBuras: 60, ayamBroiler: 0, ayamLayer: 0, itik: 15, angsa: 3, kalkun: 1, burung: 10, kerbau: 5, kuda: 2 },
    { no: 30, nama: "Benowo", peternak: 20, sapiPotong: 8, sapiPerah: 0, kambing: 25, domba: 18, ayamBuras: 0, ayamBroiler: 17000, ayamLayer: 0, itik: 15, angsa: 4, kalkun: 0, burung: 12, kerbau: 3, kuda: 6 },
    { no: 31, nama: "Pakal", peternak: 17, sapiPotong: 35, sapiPerah: 10, kambing: 28, domba: 20, ayamBuras: 95, ayamBroiler: 0, ayamLayer: 0, itik: 18, angsa: 5, kalkun: 2, burung: 14, kerbau: 7, kuda: 3 }
];

function calculateTotals() {
    const totals = { peternak: 0, sapiPotong: 0, sapiPerah: 0, kambing: 0, domba: 0, ayamBuras: 0, ayamBroiler: 0, ayamLayer: 0, itik: 0, angsa: 0, kalkun: 0, burung: 0, kerbau: 0, kuda: 0 };
    kecamatanData.forEach(item => { for (let key in totals) if (item[key] !== undefined) totals[key] += item[key]; });
    return totals;
}

function renderTable() {
    const tbody = document.getElementById('tableBody');
    const tfoot = document.getElementById('tableFooter');
    if (!tbody) return;
    tbody.innerHTML = '';
    kecamatanData.forEach(item => {
        tbody.innerHTML += `<tr>
            <td class="text-center">${item.no}</td>
            <td class="fw-semibold">${item.nama}</td>
            ${['peternak','sapiPotong','sapiPerah','kambing','domba','ayamBuras','ayamBroiler','ayamLayer','itik','angsa','kalkun','burung','kerbau','kuda'].map(k => `<td class="text-end">${item[k].toLocaleString()}</td>`).join('')}
        </tr>`;
    });
    const totals = calculateTotals();
    if (tfoot) tfoot.innerHTML = `<tr class="fw-bold bg-light"><td class="text-center" colspan="2">TOTAL 31 KECAMATAN</td>${Object.values(totals).map(v => `<td class="text-end">${v.toLocaleString()}</td>`).join('')}</tr>`;
}

function initChart() {
    var ctx = document.getElementById("commodityChart");
    if (!ctx) return;
    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Ayam Ras Petelur", "Sapi Potong", "Kambing", "Ayam Kampung", "Itik"],
            datasets: [{
                data: [1225, 850, 620, 450, 320],
                backgroundColor: ["#832706", "#a84d2a", "#c46a42", "#e0885a", "#f5a67a"],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: "bottom" } },
        },
    });
}

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

function fixSidebarMiniDropdown() {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar) return;
    
    function checkAndFix() {
        if (sidebar.classList.contains('sidebar_mini')) {
            document.querySelectorAll('.sidebar .collapse.show').forEach(c => c.classList.remove('show'));
            document.querySelectorAll('.sidebar .fa-chevron-down, .sidebar .fa-chevron-right').forEach(el => el.style.display = 'none');
        } else {
            document.querySelectorAll('.sidebar .fa-chevron-down, .sidebar .fa-chevron-right').forEach(el => el.style.display = '');
        }
    }
    
    const observer = new MutationObserver(checkAndFix);
    observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
    checkAndFix();
}

document.addEventListener("DOMContentLoaded", function () {
    renderTable();
    initChart();
    initResponsiveSidebar();
    fixSidebarMiniDropdown();
});