-- ======================================
-- CREATE TABLE PERTANDINGAN
-- ======================================
CREATE TABLE IF NOT EXISTS pertandingan (
id_pertandingan INT AUTO_INCREMENT PRIMARY KEY,
id_peserta1 INT NOT NULL,
id_peserta2 INT,
pemenang INT NOT NULL,
babak ENUM('penyisihan','perempat_final','semifinal','final','bob') NOT NULL,
FOREIGN KEY (id_peserta1) REFERENCES peserta(id_peserta),
FOREIGN KEY (id_peserta2) REFERENCES peserta(id_peserta),
FOREIGN KEY (pemenang) REFERENCES peserta(id_peserta)
);
-- INSERT DATA PERTANDINGAN
INSERT INTO pertandingan (id_peserta1, id_peserta2, pemenang, babak) VALUES
(1, 2, 1, 'penyisihan'),
(3, 7, 3, 'penyisihan'),
(4, 5, 5, 'penyisihan'),
(6, 9, 6, 'penyisihan'),
(8, 10, 10, 'penyisihan'),
(11, 12, 11, 'penyisihan'),
(13, 14, 13, 'penyisihan'),
(15, 1, 1, 'penyisihan'), -- Catatan: Peserta 1 bertanding lagi (asumsi babak berbeda atau skenario khusus)
(1, 3, 1, 'perempat_final'),
(5, 6, 5, 'perempat_final'),
(10, 11, 10, 'perempat_final'),
(13, 1, 1, 'perempat_final'), -- Catatan: Peserta 1 bertanding lagi
(1, 5, 1, 'semifinal'),
(10, 1, 10, 'semifinal'), -- Catatan: Peserta 1 bertanding lagi
(1, 10, 1, 'final'),
(5, NULL, 5, 'bob');
