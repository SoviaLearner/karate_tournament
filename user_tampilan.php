<?php
require_once 'config.php';

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// DEFINISI WARNA FINAL
$color_primary_maroon = '#800000'; // Merah Marun
$color_secondary_black = '#1A1A1A'; // Hitam Pekat

// --- HEADER KHUSUS USER ---
function get_user_header($title = "Hasil Pertandingan Resmi") {
    global $color_primary_maroon, $color_secondary_black;
    
    $maroon = $color_primary_maroon;
    $black = $color_secondary_black;

    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Karate Match Tracker | ' . htmlspecialchars($title) . '</title>
        <link rel="stylesheet" href="css/style.css"> 
        <style>
            /* --- Gaya Merah Marun/Hitam (Override) --- */
            
            /* Reset/Base Styles */
            body { display: block; padding: 0; margin: 0; background-color: #f8f9fa; }
            h2 { color:' . $maroon . '; margin: 40px 0 20px 0; text-align:center; } /* Marun */

            /* Header Style (Hitam Header, Marun Judul) */
            .user-header { 
                background:' . $black . '; /* HITAM */
                color:#fff; 
                padding:30px 20px; 
                box-shadow:0 4px 10px rgba(0,0,0,0.5); 
                width: 100%; 
                box-sizing: border-box;
                
                /* PERBAIKAN ALIGNMENT JUDUL */
                display: flex; 
                flex-direction: column; 
                align-items: center; /* Memusatkan konten secara horizontal */
            }
            .user-header h1 { 
                margin:0; 
                font-size:2rem; 
                color:' . $maroon . '; /* Marun pada Judul Utama */
            }
            .user-header p { margin:5px 0 0; font-size:1rem; }
            .user-content { max-width:1200px; margin:30px auto; padding:0 20px; }

            /* Statistik Card Layout (Override Warna) */
            .stats-grid { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px; justify-content:center; }
            .stat-box { 
                flex: 1 1 250px; 
                max-width: 350px; 
                background:#fff; 
                padding:25px; 
                text-align:center; 
                border-radius:12px; 
                box-shadow:0 3px 8px rgba(0,0,0,0.1); 
                border-left: 5px solid ' . $maroon . '; /* Garis Marun */
            }
            .stat-box h3 { margin-bottom:10px; color:' . $black . '; font-size:1.2rem; } 
            .stat-box p { font-size:1.8rem; font-weight:bold; margin:0; color:' . $maroon . '; } /* Marun pada Angka Stat */

            /* Table Style (Override Header Warna) */
            table.data-table th { background:' . $maroon . '; color:#fff; font-weight:600; } /* Marun pada Header Tabel */
            table.data-table tr:hover { background:#f5e0e0; } /* Highlight Marun Sangat Muda */

            /* Hapus Chart/Grafik Element */
            .chart-container, .card > canvas { display: none !important; }
        </style>
        </head>
    <body>
        <div class="user-header">
            <h1>HASIL PERTANDINGAN KARATE RESMI</h1>
            <p>Klasifikasi Juara dan Statistik Turnamen</p>
        </div>
        <div class="user-content">
    ';
}

function get_user_footer() {
    echo '
        </div>
    </body>
    </html>
    ';
    global $conn;
    $conn->close();
}

// Panggil header
get_user_header();

// --- AMBIL DATA DARI DATABASE ---
// Statistik umum
$total_peserta = $conn->query("SELECT COUNT(id_peserta) FROM peserta")->fetch_row()[0];
$total_juara = $conn->query("SELECT COUNT(id_peserta) FROM hasil WHERE juara IN ('1','2','3')")->fetch_row()[0];
$total_gugur = $conn->query("SELECT COUNT(id_peserta) FROM peserta WHERE status='gugur'")->fetch_row()[0];

// Data juara
$sql_juara = "SELECT p.nama_peserta, p.asal_dojo, p.kategori, h.juara 
              FROM hasil h 
              JOIN peserta p ON h.id_peserta = p.id_peserta 
              WHERE h.juara IN ('1','2','3')
              ORDER BY h.juara ASC";
$result_juara = $conn->query($sql_juara);

// Data 5 pertandingan terbaru
$sql_pertandingan = "SELECT t.babak, p1.nama_peserta AS peserta1_nama, 
                            p2.nama_peserta AS peserta2_nama, 
                            pw.nama_peserta AS pemenang_nama 
                     FROM pertandingan t
                     JOIN peserta p1 ON t.id_peserta1 = p1.id_peserta
                     LEFT JOIN peserta p2 ON t.id_peserta2 = p2.id_peserta
                     JOIN peserta pw ON t.pemenang = pw.id_peserta
                     ORDER BY t.id_pertandingan DESC
                     LIMIT 5";
$result_pertandingan = $conn->query($sql_pertandingan);
?>

<h2>Statistik Umum Turnamen</h2>
<div class="stats-grid">
    <div class="stat-box">
        <h3>Total Peserta</h3>
        <p><?php echo $total_peserta; ?></p>
    </div>
    <div class="stat-box">
        <h3>Total Juara (1,2,3)</h3>
        <p><?php echo $total_juara; ?></p>
    </div>
    <div class="stat-box">
        <h3>Peserta Gugur</h3>
        <p><?php echo $total_gugur; ?></p>
    </div>
</div>

<hr>

<h2>Daftar Juara Kumite</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Posisi Juara</th>
            <th>Nama Peserta</th>
            <th>Asal Dojo</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result_juara->num_rows > 0) {
            while($row = $result_juara->fetch_assoc()) {
                echo "<tr>";
                echo "<td>Juara <strong>".htmlspecialchars($row['juara'])."</strong></td>";
                echo "<td>".htmlspecialchars($row['nama_peserta'])."</td>";
                echo "<td>".htmlspecialchars($row['asal_dojo'])."</td>";
                echo "<td>".htmlspecialchars($row['kategori'])."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Belum ada data juara yang tercatat.</td></tr>";
        }
        ?>
    </tbody>
</table>

<hr>

<hr>

<h2>5 Hasil Pertandingan Terbaru</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>Babak</th>
            <th>Peserta 1</th>
            <th>Peserta 2</th>
            <th>Pemenang</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result_pertandingan->num_rows > 0) {
            while($row = $result_pertandingan->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".ucfirst($row['babak'])."</td>";
                echo "<td>".htmlspecialchars($row['peserta1_nama'])."</td>";
                echo "<td>".(!empty($row['peserta2_nama']) ? htmlspecialchars($row['peserta2_nama']) : 'BYE / N/A')."</td>";
                echo "<td><strong>".htmlspecialchars($row['pemenang_nama'])."</strong></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Belum ada data pertandingan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
get_user_footer();
?>