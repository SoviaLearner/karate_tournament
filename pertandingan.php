<?php
require_once 'config.php';
check_login();

get_header("Manajemen Pertandingan");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['input_pertandingan'])) {
    $p1 = (int)$_POST['id_peserta1'];
    $p2_value = isset($_POST['id_peserta2']) && $_POST['id_peserta2'] != 0 ? (int)$_POST['id_peserta2'] : 0;
    $pemenang = (int)$_POST['pemenang'];
    $babak = $conn->real_escape_string($_POST['babak']);

    $id_peserta2_sql = ($p2_value === 0) ? 'NULL' : $p2_value;

    $sql = "INSERT INTO pertandingan (id_peserta1, id_peserta2, pemenang, babak) VALUES ($p1, $id_peserta2_sql, $pemenang, '$babak')";
    
    if ($conn->query($sql) === TRUE) {
        if ($p2_value !== 0) {
            $kalah = ($pemenang == $p1) ? $p2_value : $p1;
            if ($kalah != $pemenang) {
                $conn->query("UPDATE peserta SET status = 'gugur' WHERE id_peserta = $kalah");
                $conn->query("INSERT INTO hasil (id_peserta, babak_terakhir, juara) VALUES ($kalah, '$babak', '-') ON DUPLICATE KEY UPDATE babak_terakhir = '$babak'");
            }
        }
        $conn->query("INSERT INTO hasil (id_peserta, babak_terakhir, juara) VALUES ($pemenang, '$babak', '-') ON DUPLICATE KEY UPDATE babak_terakhir = '$babak'");

        echo "<p class='success'>Hasil pertandingan babak <b>$babak</b> berhasil dicatat! Peserta ID <b>$pemenang</b> menang.</p>";
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

$peserta_aktif = $conn->query("SELECT id_peserta, nama_peserta FROM peserta WHERE status = 'aktif' OR status = 'juara' ORDER BY nama_peserta ASC");
?>

<div class="card">
    <h2>Input Hasil Pertandingan Baru</h2>
    <form method="POST">
        <label for="babak">Babak Pertandingan:</label>
        <select id="babak" name="babak" required>
            <option value="penyisihan">Penyisihan</option>
            <option value="perempat_final">Perempat Final</option>
            <option value="semifinal">Semifinal</option>
            <option value="final">Final</option>
            <option value="bob">BOB (Bronze/Perebutan Juara 3)</option>
        </select><br>

        <label for="id_peserta1">Peserta 1:</label>
        <select id="id_peserta1" name="id_peserta1" required>
            <option value="">Pilih Peserta 1</option>
            <?php 
            while($p = $peserta_aktif->fetch_assoc()) {
                echo "<option value='{$p['id_peserta']}'>" . htmlspecialchars($p['nama_peserta']) . " ({$p['id_peserta']})</option>";
            }
            $peserta_aktif->data_seek(0);
            ?>
        </select><br>

        <label for="id_peserta2">Peserta 2 (Kosongkan jika hanya 1/bye):</label>
        <select id="id_peserta2" name="id_peserta2">
            <option value="0">Pilih Peserta 2 / BYE</option>
            <?php 
            $peserta_aktif->data_seek(0);
            while($p = $peserta_aktif->fetch_assoc()) {
                echo "<option value='{$p['id_peserta']}'>" . htmlspecialchars($p['nama_peserta']) . " ({$p['id_peserta']})</option>";
            }
            ?>
        </select><br>
        
        <label for="pemenang">Pemenang:</label>
        <select id="pemenang" name="pemenang" required>
            <option value="">Pilih Pemenang (Opsi akan terisi otomatis)</option>
        </select><br>

        <button type="submit" name="input_pertandingan">Simpan Hasil Pertandingan</button>
    </form>
</div>

<h2>Tabel Hasil Pertandingan</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Babak</th>
            <th>Peserta 1</th>
            <th>Peserta 2</th>
            <th>Pemenang</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT 
                    t.id_pertandingan, t.babak, 
                    p1.nama_peserta AS peserta1_nama, 
                    p2.nama_peserta AS peserta2_nama, 
                    pw.nama_peserta AS pemenang_nama 
                FROM pertandingan t
                JOIN peserta p1 ON t.id_peserta1 = p1.id_peserta
                LEFT JOIN peserta p2 ON t.id_peserta2 = p2.id_peserta
                JOIN peserta pw ON t.pemenang = pw.id_peserta
                ORDER BY t.id_pertandingan DESC";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_pertandingan'] . "</td>";
                echo "<td>" . ucfirst($row['babak']) . "</td>";
                echo "<td>" . htmlspecialchars($row['peserta1_nama']) . "</td>";
                echo "<td>" . (!empty($row['peserta2_nama']) ? htmlspecialchars($row['peserta2_nama']) : 'BYE / N/A') . "</td>";
                echo "<td><b>" . htmlspecialchars($row['pemenang_nama']) . "</b></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Belum ada data pertandingan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
get_footer();
?>
