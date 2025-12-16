-- Database: laundrycrafty
-- Tabel user (admin/kasir)
CREATE TABLE IF NOT EXISTS user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'kasir') DEFAULT 'kasir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel pelanggan
CREATE TABLE IF NOT EXISTS pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel layanan
CREATE TABLE IF NOT EXISTS layanan (
    id_layanan INT PRIMARY KEY AUTO_INCREMENT,
    nama_layanan VARCHAR(50) NOT NULL,
    harga_per_kg DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    durasi_hari INT DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_pelanggan INT NOT NULL,
    id_layanan INT NOT NULL,
    id_user INT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    berat DECIMAL(5,2) NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('Proses', 'Selesai', 'Sudah Diambil') DEFAULT 'Proses',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
    FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE
);

-- Insert data user default
INSERT INTO user (username, password, nama_lengkap, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('kasir1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kasir 1', 'kasir');
-- Password default: password

-- Insert data layanan default
INSERT INTO layanan (nama_layanan, harga_per_kg, deskripsi, durasi_hari) VALUES
('Cuci Kering', 5000, 'Layanan cuci dan pengeringan tanpa setrika', 3),
('Cuci Setrika', 7000, 'Layanan cuci, kering, dan setrika rapi', 3),
('Express', 10000, 'Layanan kilat selesai dalam 1 hari', 1),
('Setrika Only', 4000, 'Layanan setrika saja tanpa cuci', 2);

-- Insert data pelanggan contoh
INSERT INTO pelanggan (nama, alamat, no_hp, email) VALUES
('Budi Santoso', 'Jl. Merdeka No. 123, Surabaya', '081234567890', 'budi@email.com'),
('Siti Nurhaliza', 'Jl. Sudirman No. 45, Surabaya', '081298765432', 'siti@email.com'),
('Ahmad Yani', 'Jl. Pahlawan No. 67, Surabaya', '081376543210', 'ahmad@email.com');

-- Insert data transaksi contoh
INSERT INTO transaksi (id_pelanggan, id_layanan, id_user, tanggal_masuk, tanggal_selesai, berat, total_harga, status) VALUES
(1, 2, 1, '2025-12-10', '2025-12-13', 5.5, 38500, 'Sudah Diambil'),
(2, 1, 2, '2025-12-12', '2025-12-15', 3.0, 15000, 'Selesai'),
(3, 3, 1, '2025-12-15', '2025-12-16', 2.5, 25000, 'Proses'),
(1, 1, 2, '2025-12-14', '2025-12-17', 4.0, 20000, 'Proses');
