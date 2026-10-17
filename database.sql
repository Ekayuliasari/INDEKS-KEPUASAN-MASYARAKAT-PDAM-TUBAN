CREATE DATABASE IF NOT EXISTS db_ikm_pdam;
USE db_ikm_pdam;

-- Tabel Responden
CREATE TABLE IF NOT EXISTS responden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_survei DATETIME DEFAULT CURRENT_TIMESTAMP,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    usia INT NOT NULL,
    pendidikan VARCHAR(50) NOT NULL,
    pekerjaan VARCHAR(100) NOT NULL,
    pekerjaan_lainnya VARCHAR(150) NULL,
    jenis_layanan VARCHAR(100) NOT NULL
);

-- Tabel Jawaban 9 Unsur Pelayanan SKM
CREATE TABLE IF NOT EXISTS jawaban_survei (
    id INT AUTO_INCREMENT PRIMARY KEY,
    responden_id INT NOT NULL,
    u1 INT NOT NULL, -- Kesesuaian persyaratan
    u2 INT NOT NULL, -- Kemudahan prosedur
    u3 INT NOT NULL, -- Kecepatan waktu
    u4 INT NOT NULL, -- Kewajaran biaya/tarif
    u5 INT NOT NULL, -- Kesesuaian produk pelayanan
    u6 INT NOT NULL, -- Kompetensi petugas
    u7 INT NOT NULL, -- Perilaku petugas (kesopanan & keramahan)
    u8 INT NOT NULL, -- Kualitas sarana prasarana
    u9 INT NOT NULL, -- Penanganan pengaduan
    saran TEXT NULL,
    FOREIGN KEY (responden_id) REFERENCES responden(id) ON DELETE CASCADE
);

-- Tabel Admin untuk melihat rekapitulasi
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Default admin (Username: admin_merakurak, Password: admin123)
INSERT INTO admin (username, password) VALUES ('admin_merakurak', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') ON DUPLICATE KEY UPDATE id=id;
