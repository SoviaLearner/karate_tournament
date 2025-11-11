<?php
require_once 'config.php';
check_login();

get_header("Rekapitulasi Hasil & Daftar Juara");

// Ambil Statistik Umum
$total_peserta = $conn->query("SELECT COUNT(id_peserta) FROM peserta")->fetch_row()[0];
$juara = $conn->query("SELECT COUNT(id_peserta) FROM hasil WHERE juara IN ('1', '2', '3')")->fetch_row()[0];
$gugur = $conn->query("SELECT COUNT(id_peserta) FROM peserta WHERE status = 'gugur'")->fetch_row()[0];
?>

<h2>Statistik Utama</h2>
<div class="stats-grid">
    <div class="stat-box"><h3>Total Peserta</h3><p><?= $total_peserta ?></p></div>
    <div class="stat-box"><h3>Peserta Juara</h3><p><?= $juara ?></p></div>
    <div class="stat-box"><h3>Peserta Gugur</h3><p><?= $gugur ?></p></div>
</div>

<hr>

<h2>Tabel Rekapitulasi Juara</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Posisi Juara</th>
            <th>Nama Peserta</th>
            <th>Asal Dojo</th>
            <th>Babak Terakhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT p.nama_peserta, p.asal_dojo, h.babak_terakhir, h.juara 
                FROM hasil h 
                JOIN peserta p ON h.id_peserta = p.id_peserta 
                WHERE h.juara IN ('1', '2', '3')
                ORDER BY h.juara ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                // Perubahan di sini: Hanya angka juara yang di-bold
                echo "<td>Juara <strong>" . $row['juara'] . "</strong></td>"; 
                echo "<td>" . htmlspecialchars($row['nama_peserta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['asal_dojo']) . "</td>";
                echo "<td>" . ucfirst($row['babak_terakhir']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Belum ada data juara yang tercatat.</td></tr>";
        }
        ?>
    </tbody>
</table>

<hr>

<h2>Daftar Peserta yang Gugur</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Nama Peserta</th>
            <th>Asal Dojo</th>
            <th>Babak Terakhir Gugur</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_gugur = "SELECT p.nama_peserta, p.asal_dojo, h.babak_terakhir 
                      FROM peserta p 
                      LEFT JOIN hasil h ON p.id_peserta = h.id_peserta
                      WHERE p.status = 'gugur' AND h.juara = '-'";
        $result_gugur = $conn->query($sql_gugur);
        
        if ($result_gugur->num_rows > 0) {
            while($row = $result_gugur->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nama_peserta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['asal_dojo']) . "</td>";
                echo "<td>" . (isset($row['babak_terakhir']) ? ucfirst($row['babak_terakhir']) : 'N/A') . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Semua peserta masih aktif atau sudah tercatat sebagai juara.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
get_footer();
?>