-- ======================================
-- CREATE TABLE PESERTA
-- ======================================
CREATE TABLE IF NOT EXISTS peserta (
id_peserta INT AUTO_INCREMENT PRIMARY KEY,
nama_peserta VARCHAR(100) NOT NULL,
asal_dojo VARCHAR(100) NOT NULL,
kategori VARCHAR(50) NOT NULL,
berat_badan FLOAT NOT NULL,
status ENUM('aktif','gugur','juara') DEFAULT 'aktif'
);
-- INSERT DATA PESERTA
INSERT INTO peserta (nama_peserta, asal_dojo, kategori, berat_badan, status) VALUES
('Andi Pratama', 'Dojo Sakura', 'Junior', 55.5, 'juara'),
('Budi Santoso', 'Dojo Hitam', 'Junior', 57.0, 'gugur'),
('Citra Lestari', 'Dojo Merah', 'Junior', 54.0, 'gugur'),
('Dedi Kurniawan', 'Dojo Sakura', 'Senior', 68.5, 'gugur'),
('Eka Purnama', 'Dojo Hitam', 'Senior', 70.0, 'juara'),
('Fajar Nugroho', 'Dojo Merah', 'Senior', 66.5, 'gugur'),
('Gita Ananda', 'Dojo Sakura', 'Junior', 53.0, 'gugur'),
('Hadi Prasetyo', 'Dojo Hitam', 'Junior', 56.5, 'gugur'),
('Intan Maharani', 'Dojo Merah', 'Senior', 69.0, 'gugur'),
('Jaya Ramadhan', 'Dojo Sakura', 'Senior', 71.0, 'juara'),
('Kevin Hartono', 'Dojo Hitam', 'Junior', 55.0, 'gugur'),
('Lila Sari', 'Dojo Merah', 'Junior', 52.5, 'gugur'),
('Muhammad Fadli', 'Dojo Sakura', 'Senior', 67.5, 'gugur'),
('Nadia Fitri', 'Dojo Hitam', 'Senior', 68.0, 'gugur'),
('Rian Prakoso', 'Dojo Merah', 'Senior', 70.5, 'gugur');
