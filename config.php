<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_PORT', 3308);
define('DB_USERNAME', 'karate_user');
define('DB_PASSWORD', 'Karate123');
define('DB_DATABASE', 'karate_tournament');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

if ($conn->connect_error) {
    die("<h2>Koneksi Gagal!</h2><p>Error: " . $conn->connect_error . "</p>");
}

function get_header($title = "Dashboard Admin") {
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Karate Match Tracker | ' . htmlspecialchars($title) . '</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="peserta.php">Data Peserta</a></li>
                <li><a href="pertandingan.php">Manajemen Pertandingan</a></li>
                <li><a href="rekap.php">Rekapitulasi Hasil</a></li>
                <li><a href="grafik.php">Grafik Statistik</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <h1>' . htmlspecialchars($title) . '</h1>
            <hr>
    ';
}

function get_footer() {
    global $conn;
    echo '
        </div>
        <script src="js/script.js"></script>
    </body>
    </html>
    ';
    $conn->close();
}

function check_login() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }
}
?>