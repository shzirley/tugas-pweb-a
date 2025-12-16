# PANDUAN INSTALASI LAUNDRYCRAFTY

## Langkah-Langkah Instalasi Lengkap

### 1. Persiapan Sistem

#### A. Install XAMPP (Untuk Windows)
1. Download XAMPP dari https://www.apachefriends.org/
2. Install XAMPP di drive C:\ (atau lokasi pilihan Anda)
3. Jalankan XAMPP Control Panel
4. Start Apache dan MySQL

#### B. Install Laragon (Alternatif untuk Windows)
1. Download Laragon dari https://laragon.org/
2. Install Laragon (lebih ringan dan modern)
3. Start All services

### 2. Setup Database

#### Via phpMyAdmin
1. Buka browser dan akses: `http://localhost/phpmyadmin`
2. Klik tab "New" atau "Baru"
3. Buat database baru dengan nama: `laundrycrafty`
4. Pilih collation: `utf8mb4_general_ci`
5. Klik tab "Import"
6. Pilih file `database.sql` dari folder project
7. Klik "Go" untuk import

#### Via Command Line (MySQL Client)
```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE laundrycrafty;

# Pilih database
USE laundrycrafty;

# Import file SQL
SOURCE /path/to/laundrycrafty/database.sql;

# Keluar
EXIT;
```

### 3. Copy Project ke Server

#### Untuk XAMPP
```
C:\xampp\htdocs\laundrycrafty\
```

#### Untuk Laragon
```
C:\laragon\www\laundrycrafty\
```

Pastikan semua file berada di dalam folder tersebut:
- login.php
- dashboard.php
- pelanggan.php
- transaksi.php
- layanan.php
- laporan.php
- pengguna.php
- dll

### 4. Konfigurasi Database

Buka file `includes/config.php` dan sesuaikan jika diperlukan:

```php
define('DB_HOST', 'localhost');  // Host database (biasanya localhost)
define('DB_USER', 'root');       // Username MySQL (default: root)
define('DB_PASS', '');           // Password MySQL (default: kosong)
define('DB_NAME', 'laundrycrafty'); // Nama database
```

### 5. Testing Aplikasi

1. Buka browser (Chrome/Firefox/Edge)
2. Akses: `http://localhost/laundrycrafty`
3. Akan redirect ke halaman login
4. Login dengan kredensial default:
   - **Admin**: username=`admin`, password=`password`
   - **Kasir**: username=`kasir1`, password=`password`

### 6. Verifikasi Instalasi

Setelah login, pastikan:
- ✅ Dashboard menampilkan statistik
- ✅ Menu sidebar berfungsi
- ✅ Dapat menambah pelanggan
- ✅ Dapat membuat transaksi
- ✅ Dapat melihat laporan
- ✅ Grafik muncul dengan benar

## Troubleshooting Common Issues

### Problem: "Connection failed" error
**Solusi:**
1. Pastikan MySQL/MariaDB sudah running di XAMPP/Laragon
2. Cek username & password di `includes/config.php`
3. Pastikan database `laundrycrafty` sudah dibuat
4. Test koneksi MySQL dengan phpMyAdmin

### Problem: "Access denied" saat import database
**Solusi:**
1. Pastikan login sebagai user root
2. Cek apakah ada password untuk user root
3. Update `DB_PASS` di config.php jika ada password

### Problem: Page not found (404)
**Solusi:**
1. Pastikan Apache sudah running
2. Cek path folder: harus di htdocs (XAMPP) atau www (Laragon)
3. Akses: `http://localhost/laundrycrafty` (sesuai nama folder)

### Problem: CSS/JS tidak load
**Solusi:**
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+F5)
3. Cek path relatif di HTML
4. Pastikan folder css/ dan js/ ada

### Problem: Session expired terus
**Solusi:**
1. Cek file `includes/functions.php`
2. Pastikan `session_start()` dipanggil
3. Clear browser cookies
4. Restart browser

### Problem: Grafik tidak muncul
**Solusi:**
1. Pastikan internet aktif (Chart.js dari CDN)
2. Atau download Chart.js dan simpan lokal
3. Update link di laporan.php

### Problem: Error "Headers already sent"
**Solusi:**
1. Pastikan tidak ada output sebelum `session_start()`
2. Cek BOM di awal file PHP
3. Pastikan tidak ada spasi/enter sebelum `<?php`

## Konfigurasi Tambahan

### Mengubah Port Apache (Jika Port 80 Conflict)

1. Buka XAMPP Control Panel
2. Klik Config > Apache (httpd.conf)
3. Cari `Listen 80` dan ubah ke `Listen 8080`
4. Cari `ServerName localhost:80` ubah ke `ServerName localhost:8080`
5. Save dan restart Apache
6. Akses: `http://localhost:8080/laundrycrafty`

### Mengaktifkan Error Display (Development Mode)

Edit `includes/config.php`, tambahkan:
```php
// Development mode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

**PENTING:** Matikan saat production!

### Backup Database

#### Via phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database `laundrycrafty`
3. Klik tab "Export"
4. Pilih "Quick" atau "Custom"
5. Format: SQL
6. Klik "Go" untuk download

#### Via Command Line
```bash
mysqldump -u root -p laundrycrafty > backup_laundrycrafty.sql
```

## Post-Installation Checklist

- [ ] Database berhasil dibuat dan terisi data default
- [ ] Dapat login dengan user admin
- [ ] Dashboard menampilkan data dengan benar
- [ ] Semua menu dapat diakses
- [ ] Form tambah data berfungsi
- [ ] Edit dan delete berfungsi
- [ ] Laporan dan grafik muncul
- [ ] Password default sudah diubah
- [ ] Testing di berbagai browser (Chrome, Firefox, Edge)
- [ ] Testing responsive di mobile
- [ ] Backup database dibuat

## Keamanan Production

Jika deploy ke production server:

1. **Ubah semua password default**
2. **Update config.php dengan kredensial yang aman**
3. **Matikan display_errors**
4. **Aktifkan HTTPS (SSL Certificate)**
5. **Set permission file yang benar:**
   ```bash
   chmod 644 *.php
   chmod 755 includes/
   chmod 644 includes/*.php
   ```
6. **Backup database secara berkala**
7. **Monitor log error**
8. **Update PHP ke versi terbaru**

## Support

Jika mengalami masalah:
1. Cek file README.md untuk dokumentasi lengkap
2. Review error log di `C:\xampp\apache\logs\error.log`
3. Test koneksi database dengan script sederhana
4. Pastikan semua service (Apache, MySQL) running

---

**Happy Laundering! 🧺✨**

Version: 1.0.0
Last Updated: December 2025
