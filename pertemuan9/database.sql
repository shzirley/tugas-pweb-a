-- Create database
CREATE DATABASE IF NOT EXISTS smk_mbg_sehat;
USE smk_mbg_sehat;

-- Create table peserta
CREATE TABLE IF NOT EXISTS peserta (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    agama VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    nilai_rapor DECIMAL(5,2) NOT NULL,
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_tanggal_daftar (tanggal_daftar),
    INDEX idx_nilai_rapor (nilai_rapor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data (optional)
INSERT INTO peserta (nama_lengkap, email, tanggal_lahir, jenis_kelamin, agama, alamat, jurusan, nilai_rapor, tanggal_daftar) VALUES
('Ahmad Rizki Pratama', 'ahmad.rizki@email.com', '2007-05-15', 'Laki-laki', 'Islam', 'Jl. Merdeka No. 123, Surabaya', 'Teknik Komputer dan Jaringan (TKJ)', 85.50, NOW()),
('Siti Nurhaliza', 'siti.nur@email.com', '2007-08-22', 'Perempuan', 'Islam', 'Jl. Pahlawan No. 45, Surabaya', 'Tata Boga', 92.75, NOW()),
('Budi Santoso', 'budi.santoso@email.com', '2007-03-10', 'Laki-laki', 'Kristen', 'Jl. Pemuda No. 67, Surabaya', 'Rekayasa Perangkat Lunak (RPL)', 88.00, NOW()),
('Dewi Anggraini', 'dewi.anggraini@email.com', '2007-11-30', 'Perempuan', 'Hindu', 'Jl. Raya Darmo No. 89, Surabaya', 'Desain Komunikasi Visual (DKV)', 90.25, NOW()),
('Eko Prasetyo', 'eko.prasetyo@email.com', '2007-07-18', 'Laki-laki', 'Buddha', 'Jl. Diponegoro No. 234, Surabaya', 'Akuntansi', 87.80, NOW());