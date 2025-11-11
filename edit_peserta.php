<?php
// Pastikan file config.php, functions.php, dsb. sudah di-include
require_once 'config.php';
// Asumsi fungsi ini tersedia untuk keamanan sesi
check_login(); 

// Asumsi fungsi ini tersedia untuk layouting
get_header("Edit Data Peserta");

// Pastikan ID Peserta ada di URL
if (!isset($_GET['id'])) {
    die("<p class='error'>ID Peserta tidak ditemukan. Kembali ke halaman <a href='peserta.php'>Daftar Peserta</a>.</p>");
}

$id_peserta_edit = (int)$_GET['id'];
$error_message = '';
$success_message = '';

// --- BAGIAN 1: PROSES UPDATE DATA BARU (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_peserta'])) {
    // Amankan dan tangkap data
    $id             = (int)$_POST['id_peserta'];
    $nama_baru      = $conn->real_escape_string($_POST['nama_peserta']);
    $dojo_baru      = $conn->real_escape_string($_POST['asal_dojo']);
    $kategori_baru  = $conn->real_escape_string($_POST['kategori']);
    $berat_baru     = (float)$_POST['berat_badan'];
    $status_baru    = $conn->real_escape_string($_POST['status']); 

    // Query UPDATE
    $sql_update = "UPDATE peserta SET 
                        nama_peserta = '$nama_baru', 
                        asal_dojo = '$dojo_baru', 
                        kategori = '$kategori_baru', 
                        berat_badan = '$berat_baru',
                        status = '$status_baru'
                    WHERE id_peserta = $id";

    if ($conn->query($sql_update) === TRUE) {
        $success_message = "Data peserta **$nama_baru** berhasil diperbarui!";
        // Opsional: Redirect ke halaman daftar setelah sukses update
        // header("Location: peserta.php?status=success_edit");
        // exit(); 
    } else {
        $error_message = "Error saat memperbarui data: " . $conn->error;
    }
    
    // Perbarui variabel $id_peserta_edit untuk memastikan form memuat data terbaru setelah update
    $id_peserta_edit = $id; 
} 

// --- BAGIAN 2: MENGAMBIL DATA LAMA (GET atau Setelah POST) ---
$sql_select = "SELECT * FROM peserta WHERE id_peserta = $id_peserta_edit";
$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    // Ambil data peserta lama
    $data = $result_select->fetch_assoc();
} else {
    // Jika ID tidak ada di database
    die("<p class='error'>Data peserta dengan ID $id_peserta_edit tidak ditemukan.</p>");
}

// Daftar Kategori dan Status yang tersedia untuk dropdown (sesuaikan jika ada tabel master)
$kategori_list = ['Junior', 'Senior', 'Kadet', 'Pra-Kadet']; 
$status_list = ['aktif', 'gugur', 'juara'];
?>

<div class="card">
    <h2>📝 Edit Data Peserta: <?php echo htmlspecialchars($data['nama_peserta']); ?></h2>
    
    <?php 
    if ($success_message) { echo "<p class='success'>$success_message</p>"; } 
    if ($error_message) { echo "<p class='error'>$error_message</p>"; } 
    ?>

    <form method="POST">
        <input type="hidden" name="id_peserta" value="<?php echo $data['id_peserta']; ?>">
        
        <label for="nama_peserta">Nama Peserta:</label>
        <input type="text" id="nama_peserta" name="nama_peserta" value="<?php echo htmlspecialchars($data['nama_peserta']); ?>" required><br>

        <label for="asal_dojo">Asal Dojo:</label>
        <input type="text" id="asal_dojo" name="asal_dojo" value="<?php echo htmlspecialchars($data['asal_dojo']); ?>" required><br>

        <label for="kategori">Kategori:</label>
        <select id="kategori" name="kategori" required>
            <?php
            foreach ($kategori_list as $kategori) {
                $selected = ($kategori == $data['kategori']) ? 'selected' : '';
                echo "<option value='".htmlspecialchars($kategori)."' $selected>".htmlspecialchars($kategori)."</option>";
            }
            ?>
        </select><br>

        <label for="berat_badan">Berat Badan (kg):</label>
        <input type="number" id="berat_badan" name="berat_badan" step="0.1" value="<?php echo $data['berat_badan']; ?>" required><br>
        
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <?php
            foreach ($status_list as $status) {
                $selected = ($status == $data['status']) ? 'selected' : '';
                echo "<option value='".htmlspecialchars($status)."' $selected>".strtoupper($status)."</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="update_peserta">Simpan Perubahan</button>
        <a href="peserta.php" class="button-batal">Batal / Kembali ke Daftar</a>
    </form>
</div>

<?php
get_footer();
?>