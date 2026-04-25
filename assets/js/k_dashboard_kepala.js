/* ========== DASHBOARD KEPALA DINAS - CUSTOM SCRIPTS ========== */
/* File ini adalah hasil pemisahan dari view k_dashboard_kepala.php */
/* Tidak ada perubahan fungsi atau tampilan */

// Data grafik akan diisi dari PHP melalui variable global
// chartLabels dan chartData didefinisikan di view sebelum file JS ini dipanggil

/**
 * Inisialisasi Chart.js untuk grafik distribusi pelaku usaha per kecamatan
 */
function initKecamatanChart() {
    var ctx = document.getElementById("kecamatanChart");
    
    if (!ctx) {
        console.error("Element kecamatanChart tidak ditemukan");
        return;
    }
    
    // Cek apakah data tersedia
    if (typeof chartLabels === 'undefined' || typeof chartData === 'undefined') {
        console.error("Data chart tidak tersedia");
        return;
    }
    
    console.log('Labels:', chartLabels);
    console.log('Data:', chartData);
    
    var canvasContext = ctx.getContext("2d");
    canvasContext.canvas.style.backgroundColor = "#ffffff";
    
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: chartLabels,
            datasets: [{
                label: "Jumlah Pelaku Usaha",
                data: chartData,
                backgroundColor: "#832706",
                borderColor: "#6b2005",
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
                    backgroundColor: "#832706",
                    titleColor: "#ffffff",
                    bodyColor: "#ffffff",
                    callbacks: {
                        label: function(context) {
                            return "Pelaku Usaha: " + context.raw + " peternak";
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        font: { size: 10 },
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
            animation: {
                duration: 1000,
                easing: "easeOutQuart"
            },
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
}

// Inisialisasi Chart ketika DOM sudah siap
document.addEventListener("DOMContentLoaded", function() {
    initKecamatanChart();
});