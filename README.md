-----

# 🥋 KARATE MATCH TRACKER 🥋

Aplikasi web untuk sistem pengelolaan dan statistik pertandingan Karate (Kumite/Kata) berbasis PHP dan MySQL.

## 🌟 Tinjauan Proyek

Proyek **Karate Match Tracker** adalah aplikasi web yang dirancang untuk mempermudah panitia turnamen dalam mengelola data peserta, mencatat hasil pertandingan, dan menampilkan statistik serta klasifikasi juara secara cepat dan otomatis. Aplikasi ini dibangun dengan fokus pada efisiensi dan keakuratan data pertandingan.

-----

## ✨ Fitur Utama

Aplikasi ini menyediakan fungsionalitas utama sebagai berikut:

### Dashboard Admin

  * **Input Data Peserta:** Form untuk menambahkan data peserta baru (Nama, Asal Dojo, Kategori, Berat Badan).
  * **Manajemen Pertandingan:** Mencatat hasil pertandingan antar dua peserta dan menentukan pemenang per babak.
  * **Klasifikasi Babak Otomatis:** Sistem yang secara otomatis menentukan peserta yang maju ke babak berikutnya (penyisihan, perempat final, semifinal, final, BOB).
  * **Rekapitulasi Hasil:** Menampilkan daftar Juara 1, Juara 2, Juara 3, dan peserta yang gugur.
  * **Statistik Umum:** Menyajikan total peserta, jumlah finalis, dan data ringkasan lainnya.

### Tampilan Publik (`user_tampilan.php`)

  * Menampilkan hasil pertandingan dan daftar juara secara *real-time* tanpa memerlukan *login* admin.

-----

## 🛠️ Teknologi & Struktur

  * **Backend:** PHP (Native)
  * **Database:** MySQL/MariaDB
  * **Frontend:** HTML, CSS
  * **Styling:** Custom CSS (`css/style.css` dan inline CSS)

-----

## 🚀 Instalasi dan Setup

Ikuti langkah-langkah di bawah untuk menjalankan aplikasi secara lokal:

### 1\. Klon Repositori

Buka *terminal* atau Git Bash dan klon repositori ini ke dalam direktori `htdocs` XAMPP atau `www` WAMP Anda.

```bash
git clone https://github.com/SoviaLearner/karate_tournament.git
cd karate_tournament
```

### 2\. Setup Database

Buka phpMyAdmin atau *tool* manajemen database Anda.

Buat database baru dengan nama: **`karate_tournament`**.

Impor tiga file SQL dari folder `sql/` secara berurutan:

  * `create_peserta.sql`
  * `create_pertandingan.sql`
  * `create_hasil.sql`

### 3\. Konfigurasi Koneksi

Buka file **`config.php`** dan sesuaikan kredensial database Anda:

```php
define('DB_SERVER', 'localhost');
define('DB_PORT', '3306'); 
define('DB_USERNAME', 'karate_user'); // Sesuaikan
define('DB_PASSWORD', 'Karate123');   // Sesuaikan
define('DB_DATABASE', 'karate_tournament'); 
```

### 4\. Jalankan Aplikasi

Akses aplikasi melalui *browser*:

  * **Panel Admin (Login):** `http://localhost/karate_tournament/login.php`

      * **Username:** `admin`
      * **Password:** `admin123`

  * **Tampilan Publik:** `http://localhost/karate_tournament/user_tampilan.php`

**Terima kasih**
