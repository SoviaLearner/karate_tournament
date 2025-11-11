<?php
require_once "config.php";

echo "<h2>File config.php berhasil di-include!</h2>";
if ($conn) {
    echo "<p>Koneksi ke database <b>" . DB_DATABASE . "</b> di port <b>" . DB_PORT . "</b> berhasil.</p>";
} else {
    echo "<p>Koneksi gagal.</p>";
}
?>
