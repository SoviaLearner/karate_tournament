-- ======================================
-- CREATE TABLE HASIL
-- ======================================
CREATE TABLE IF NOT EXISTS hasil (
id_hasil INT AUTO_INCREMENT PRIMARY KEY,
id_peserta INT NOT NULL,
babak_terakhir VARCHAR(50) NOT NULL,
juara ENUM('1','2','3','-') DEFAULT '-',
FOREIGN KEY (id_peserta) REFERENCES peserta(id_peserta)
);
-- INSERT DATA HASIL
INSERT INTO hasil (id_peserta, babak_terakhir, juara) VALUES
(1, 'final', '1'),
(2, 'penyisihan', '-'),
(3, 'perempat_final', '-'),
(4, 'penyisihan', '-'),
(5, 'BOB', '2'),
(6, 'perempat_final', '-'),
(7, 'penyisihan', '-'),
(8, 'penyisihan', '-'),
(9, 'perempat_final', '-'),
(10, 'final', '3'),
(11, 'penyisihan', '-'),
(12, 'penyisihan', '-'),
(13, 'perempat_final', '-'),
(14, 'penyisihan', '-'),
(15, 'penyisihan', '-');
