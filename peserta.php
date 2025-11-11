<?php
require_once 'config.php';
check_login(); 

get_header("Manajemen Data Peserta");

// Logika Tambah Peserta (CRUD Create)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_peserta'])) {
    $nama = $conn->real_escape_string($_POST['nama_peserta']);
    $dojo = $conn->real_escape_string($_POST['asal_dojo']);
    $kategori = $conn->real_escape_string($_POST['kategori']);
    $berat = (float)$_POST['berat_badan'];
    
    // Status default 'aktif' [cite: 17]
    $sql = "INSERT INTO peserta (nama_peserta, asal_dojo, kategori, berat_badan, status) VALUES ('$nama', '$dojo', '$kategori', '$berat', 'aktif')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Data peserta **$nama** berhasil ditambahkan!</p>";
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Logika Hapus Peserta (CRUD Delete - sederhana)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    // Hapus data terkait di tabel hasil dan pertandingan terlebih dahulu untuk menghindari error FOREIGN KEY
    $conn->query("DELETE FROM hasil WHERE id_peserta = $id");
    $conn->query("DELETE FROM pertandingan WHERE id_peserta1 = $id OR id_peserta2 = $id OR pemenang = $id");

    $sql_delete = "DELETE FROM peserta WHERE id_peserta = $id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<p class='success'>Peserta dengan ID $id berhasil dihapus!</p>";
    } else {
        echo "<p class='error'>Error menghapus data: " . $conn->error . "</p>";
    }
}
?>

<div class="card">
    <h2>Input Data Peserta Baru</h2>
    <form method="POST">
        <label for="nama_peserta">Nama Peserta:</label>
        <input type="text" id="nama_peserta" name="nama_peserta" required><br>

        <label for="asal_dojo">Asal Dojo:</label>
        <input type="text" id="asal_dojo" name="asal_dojo" required><br>

        <label for="kategori">Kategori:</label>
        <select id="kategori" name="kategori" required>
            <option value="Junior">Junior</option>
            <option value="Senior">Senior</option>
            </select><br>

        <label for="berat_badan">Berat Badan (FLOAT):</label>
        <input type="number" id="berat_badan" name="berat_badan" step="0.1" required><br>

        <button type="submit" name="tambah_peserta">Tambah Peserta</button>
    </form>
</div>

<h2>Daftar Seluruh Peserta</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Asal Dojo</th>
            <th>Kategori</th>
            <th>Berat Badan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM peserta ORDER BY id_peserta DESC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_peserta'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_peserta']) . "</td>";
                echo "<td>" . htmlspecialchars($row['asal_dojo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                echo "<td>" . $row['berat_badan'] . " kg</td>";
                echo "<td><span class='status-" . $row['status'] . "'>" . strtoupper($row['status']) . "</span></td>";
                // Aksi CRUD: Edit & Hapus
                echo "<td><a href='edit_peserta.php?id=" . $row['id_peserta'] . "'>Edit</a> | <a href='peserta.php?action=delete&id=" . $row['id_peserta'] . "' onclick=\"return confirm('Yakin ingin menghapus peserta ini? (Data pertandingan/hasil terkait akan ikut terhapus)')\">Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Belum ada data peserta.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
get_footer();
?>
