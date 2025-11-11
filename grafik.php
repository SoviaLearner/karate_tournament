<?php
require_once 'config.php';
check_login(); 

get_header("Grafik Visualisasi Statistik");

// --- Data untuk Grafik 1: Peserta per Kategori ---
$sql_kategori = "SELECT kategori, COUNT(id_peserta) as jumlah FROM peserta GROUP BY kategori";
$result_kategori = $conn->query($sql_kategori);

$labels_kategori = [];
$data_kategori = [];
while($row = $result_kategori->fetch_assoc()) {
    $labels_kategori[] = $row['kategori'];
    $data_kategori[] = $row['jumlah'];
}

$labels_kategori_json = json_encode($labels_kategori);
$data_kategori_json = json_encode($data_kategori);


// --- Data untuk Grafik 2 (BARU): Peserta per Status ---
$sql_status = "SELECT status, COUNT(id_peserta) as jumlah FROM peserta GROUP BY status";
$result_status = $conn->query($sql_status);

$labels_status = [];
$data_status = [];
while($row = $result_status->fetch_assoc()) {
    $labels_status[] = ucfirst($row['status']); // Aktif, Gugur, Juara
    $data_status[] = $row['jumlah'];
}

$labels_status_json = json_encode($labels_status);
$data_status_json = json_encode($data_status);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<div class="card">
    <h2>1. Grafik Jumlah Peserta per Kategori</h2>
    <div class="chart-container">
        <canvas id="chartKategori"></canvas>
    </div>
</div>

<div class="card">
    <h2>2. Grafik Distribusi Peserta berdasarkan Status (Akhir)</h2>
    <div class="chart-container">
        <canvas id="chartStatus"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Inisialisasi Grafik 1: Kategori ---
    const ctxKategori = document.getElementById('chartKategori');
    new Chart(ctxKategori, {
        type: 'doughnut',
        data: {
            labels: <?= $labels_kategori_json ?>,
            datasets: [{
                label: 'Jumlah Peserta',
                data: <?= $data_kategori_json ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', 
                    'rgba(54, 162, 235, 0.7)', 
                    'rgba(255, 206, 86, 0.7)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Distribusi Peserta Berdasarkan Kategori' }
            }
        }
    });

    // --- Inisialisasi Grafik 2 (BARU): Status ---
    const ctxStatus = document.getElementById('chartStatus');
    new Chart(ctxStatus, {
        type: 'bar', // Menggunakan Bar Chart agar mudah membandingkan jumlah
        data: {
            labels: <?= $labels_status_json ?>,
            datasets: [{
                label: 'Jumlah Peserta',
                data: <?= $data_status_json ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)', // Biru untuk Aktif
                    'rgba(255, 99, 132, 0.8)', // Merah untuk Gugur
                    'rgba(40, 167, 69, 0.8)'  // Hijau untuk Juara
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Jumlah Peserta Berdasarkan Status' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah' }
                }
            }
        }
    });
});
</script>

<?php
get_footer();
?>