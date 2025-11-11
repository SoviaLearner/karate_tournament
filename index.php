<?php
require_once 'config.php';
check_login(); 

get_header("Dashboard Admin | Ringkasan Statistik");

// Logika untuk mengambil data ringkasan dan statistik umum
$total_peserta = $conn->query("SELECT COUNT(id_peserta) FROM peserta")->fetch_row()[0];
$juara1 = $conn->query("SELECT COUNT(id_peserta) FROM hasil WHERE juara = '1'")->fetch_row()[0];
$juara2 = $conn->query("SELECT COUNT(id_peserta) FROM hasil WHERE juara = '2'")->fetch_row()[0];
$juara3 = $conn->query("SELECT COUNT(id_peserta) FROM hasil WHERE juara = '3'")->fetch_row()[0];
$total_gugur = $conn->query("SELECT COUNT(id_peserta) FROM peserta WHERE status = 'gugur'")->fetch_row()[0];
$semifinalis = $conn->query("SELECT COUNT(DISTINCT id_peserta) FROM hasil WHERE babak_terakhir IN ('semifinal', 'final', 'bob')")->fetch_row()[0];
$finalis = $conn->query("SELECT COUNT(DISTINCT id_peserta) FROM hasil WHERE babak_terakhir IN ('final', 'bob')")->fetch_row()[0];

?>

<h2>Statistik Umum Pertandingan</h2>
<div class="stats-grid">
    <div class="stat-box">
        <h3>Total Peserta</h3>
        <p><?= $total_peserta ?></p>
    </div>
    <div class="stat-box">
        <h3>Semifinalis</h3>
        <p><?= $semifinalis ?></p>
    </div>
    <div class="stat-box">
        <h3>Finalis</h3>
        <p><?= $finalis ?></p>
    </div>
    <div class="stat-box">
        <h3>Total Gugur</h3>
        <p><?= $total_gugur ?></p>
    </div>
</div>

<hr>

<h2>Rekap Juara</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Posisi</th>
            <th>Nama Peserta</th>
            <th>Asal Dojo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_juara = "SELECT p.nama_peserta, p.asal_dojo, h.juara FROM hasil h JOIN peserta p ON h.id_peserta = p.id_peserta WHERE h.juara IN ('1', '2', '3') ORDER BY h.juara ASC";
        $result = $conn->query($sql_juara);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Perubahan di sini: Hanya angka juara yang di-bold
                echo "<tr><td>Juara <strong>" . htmlspecialchars($row['juara']) . "</strong></td><td>" . htmlspecialchars($row['nama_peserta']) . "</td><td>" . htmlspecialchars($row['asal_dojo']) . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Belum ada data juara yang tercatat.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
get_footer();
?>