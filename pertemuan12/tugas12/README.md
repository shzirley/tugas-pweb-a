# Aplikasi CRUD Data Siswa

Aplikasi web sederhana untuk mengelola data siswa dengan operasi Create, Read, Update, dan Delete (CRUD).

## 📋 Fitur

- ✅ Tambah data siswa baru
- ✅ Lihat daftar semua siswa
- ✅ Edit/ubah data siswa
- ✅ Hapus data siswa
- ✅ Upload foto siswa
- ✅ Desain modern dan minimalist
- ✅ Responsive design

## 🛠️ Teknologi yang Digunakan

- PHP 7.4+
- MySQL/MariaDB
- HTML5
- CSS3
- JavaScript (Vanilla)

## 📦 Instalasi

### 1. Persiapan

Pastikan Anda sudah menginstall:
- XAMPP / WAMPP / LAMPP
- PHP 7.4 atau lebih tinggi
- MySQL / MariaDB

### 2. Clone atau Download Project

Download semua file dan letakkan di folder `htdocs` (untuk XAMPP):
```
C:/xampp/htdocs/crud-siswa/
```

### 3. Struktur Folder

Pastikan struktur folder seperti ini:
```
crud-siswa/
├── images/              (folder untuk foto siswa - akan dibuat otomatis)
├── index.php           (halaman utama)
├── koneksi.php         (konfigurasi database)
├── form_simpan.php     (form tambah siswa)
├── form_ubah.php       (form edit siswa)
├── proses_simpan.php   (proses tambah data)
├── proses_ubah.php     (proses update data)
├── proses_hapus.php    (proses hapus data)
├── mydatascole.sql     (file database)
└── README.md           (dokumentasi)
```

### 4. Setup Database

**Cara 1: Import via phpMyAdmin**
1. Buka phpMyAdmin (http://localhost/phpmyadmin)
2. Klik tab "Import"
3. Pilih file `mydatascole.sql`
4. Klik "Go"

**Cara 2: Manual**
1. Buka phpMyAdmin
2. Buat database baru dengan nama `db_siswa`
3. Copy isi file `mydatascole.sql` dan jalankan di tab SQL

### 5. Konfigurasi Database

Jika perlu, edit file `koneksi.php` untuk menyesuaikan kredensial database:

```php
define('DB_HOST', 'localhost');    // Host database
define('DB_USER', 'root');         // Username database
define('DB_PASS', '');             // Password database
define('DB_NAME', 'db_siswa');     // Nama database
```

### 6. Jalankan Aplikasi

1. Start Apache dan MySQL dari XAMPP Control Panel
2. Buka browser dan akses:
   ```
   http://localhost/crud-siswa/
   ```

## 🎯 Cara Penggunaan

### Menambah Data Siswa
1. Klik tombol "Tambah Siswa"
2. Isi semua field yang diperlukan:
   - NIS (wajib, harus unik)
   - Nama Lengkap (wajib)
   - Jenis Kelamin (wajib)
   - Nomor Telepon (wajib)
   - Alamat Lengkap (wajib)
   - Foto Siswa (opsional)
3. Klik "Simpan Data"

### Mengubah Data Siswa
1. Klik tombol "Ubah" pada baris siswa yang ingin diubah
2. Edit data yang diperlukan
3. Klik "Simpan Perubahan"

### Menghapus Data Siswa
1. Klik tombol "Hapus" pada baris siswa yang ingin dihapus
2. Konfirmasi penghapusan
3. Data akan terhapus permanen

### Upload Foto
- Format yang didukung: JPG, PNG, GIF
- Ukuran maksimal: 2MB
- Foto akan disimpan di folder `images/`

## 📱 Fitur Desain

- **Clean & Minimalist**: Tampilan modern yang tidak ramai
- **Smooth Animations**: Transisi dan animasi yang halus
- **User-Friendly**: Interface yang mudah digunakan
- **Responsive**: Tampil baik di desktop dan mobile
- **Alert System**: Notifikasi success/error yang jelas

## 🔧 Troubleshooting

### Error: "Koneksi database gagal"
- Pastikan MySQL sudah running
- Cek kredensial di `koneksi.php`
- Pastikan database `db_siswa` sudah dibuat

### Error: "Failed to move uploaded file"
- Pastikan folder `images/` ada dan memiliki permission write
- Di Windows, buat folder `images/` secara manual jika belum ada

### Error: "NIS sudah terdaftar"
- NIS harus unik untuk setiap siswa
- Gunakan NIS yang berbeda

### Foto tidak tampil
- Pastikan folder `images/` ada di root project
- Cek permission folder images/
- Pastikan path foto di database sudah benar

## 📝 Catatan Penting

1. **Keamanan**: Aplikasi ini untuk pembelajaran. Untuk production, tambahkan:
   - Validasi input yang lebih ketat
   - Prepared statements untuk mencegah SQL Injection
   - Password hashing untuk autentikasi
   - CSRF protection

2. **Backup**: Selalu backup database secara berkala

3. **Foto**: Foto disimpan di folder `images/`. Pastikan folder ini di-backup juga.

## 🎓 Untuk Tugas Kuliah

Struktur yang sudah dibuat:
- ✅ CRUD lengkap (Create, Read, Update, Delete)
- ✅ Upload file/foto
- ✅ Validasi form
- ✅ Design modern
- ✅ Database relasional
- ✅ Error handling
- ✅ User feedback (alert success/error)

## 📧 Support

Jika ada pertanyaan atau masalah, silakan buka issue atau hubungi developer.

## 📄 License

Project ini dibuat untuk keperluan pembelajaran.

---

**Selamat menggunakan! 🚀**
