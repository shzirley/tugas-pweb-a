# LaundryCrafty - Sistem Manajemen Laundry

## 📋 Deskripsi
LaundryCrafty adalah sistem manajemen usaha laundry berbasis web yang membantu pengelola laundry dalam mengelola transaksi, pelanggan, layanan, dan laporan pendapatan. Aplikasi ini dirancang untuk mengotomatisasi pencatatan dan pengelolaan data laundry agar lebih cepat, efisien, dan terintegrasi menggunakan database MySQL.

## ✨ Fitur Utama

### 1. Dashboard
- Statistik real-time (Total Pelanggan, Transaksi Hari Ini, Cucian Proses, Pendapatan)
- Tabel transaksi terbaru
- Antarmuka yang modern dan responsif

### 2. Manajemen Pelanggan
- Tambah, edit, dan hapus data pelanggan
- Pencarian pelanggan
- Data lengkap: nama, alamat, no HP, email

### 3. Manajemen Transaksi
- Input transaksi baru dengan perhitungan otomatis
- Update status cucian (Proses → Selesai → Sudah Diambil)
- Filter berdasarkan status dan pencarian
- Detail transaksi lengkap
- Estimasi tanggal selesai otomatis

### 4. Manajemen Layanan
- Kelola paket layanan laundry
- Harga per kilogram
- Durasi pengerjaan
- Tampilan kartu yang menarik

### 5. Laporan Keuangan
- Filter berdasarkan periode (Hari Ini, Minggu, Bulan, Tahun, Custom)
- Grafik pendapatan harian (Chart.js)
- Pendapatan per layanan dengan persentase
- Detail transaksi periode
- Fitur cetak laporan

### 6. Manajemen Pengguna (Admin Only)
- Tambah dan kelola user (Admin/Kasir)
- Role-based access control
- Password terenkripsi (bcrypt)

## 🚀 Teknologi yang Digunakan

### Front-End
- HTML5
- CSS3 (Custom design dengan gradients & animations)
- JavaScript (Vanilla JS)
- Chart.js untuk grafik
- Font Awesome untuk icons
- Google Fonts (Sora & Space Mono)

### Back-End
- PHP 8.x
- MySQL / MariaDB

### Server
- Apache (XAMPP / Laragon)

## 📦 Instalasi

### Persyaratan Sistem
- PHP >= 8.0
- MySQL >= 5.7 atau MariaDB >= 10.3
- Apache Web Server
- Browser modern (Chrome, Firefox, Edge, Safari)

### Langkah Instalasi

1. **Install XAMPP atau Laragon**
   - Download dan install [XAMPP](https://www.apachefriends.org/) atau [Laragon](https://laragon.org/)
   - Jalankan Apache dan MySQL

2. **Clone/Copy Project**
   ```bash
   # Copy folder laundrycrafty ke htdocs (XAMPP) atau www (Laragon)
   # Contoh path: C:\xampp\htdocs\laundrycrafty
   ```

3. **Buat Database**
   - Buka phpMyAdmin di browser: `http://localhost/phpmyadmin`
   - Buat database baru bernama `laundrycrafty`
   - Import file `database.sql`

4. **Konfigurasi Database**
   - Buka file `includes/config.php`
   - Sesuaikan konfigurasi database jika diperlukan:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'laundrycrafty');
   ```

5. **Akses Aplikasi**
   - Buka browser dan akses: `http://localhost/laundrycrafty`
   - Login dengan kredensial default

## 🔐 Login Default

### Admin
- Username: `admin`
- Password: `password`
- Akses: Full access (semua fitur)

### Kasir
- Username: `kasir1`
- Password: `password`
- Akses: Terbatas (tidak bisa mengelola pengguna)

**⚠️ PENTING:** Segera ubah password default setelah login pertama!

## 📁 Struktur Folder

```
laundrycrafty/
├── css/
│   └── style.css          # Stylesheet utama
├── js/
│   └── main.js            # JavaScript utama
├── includes/
│   ├── config.php         # Konfigurasi database
│   └── functions.php      # Fungsi helper
├── api/                   # (Opsional) REST API endpoints
├── dashboard.php          # Dashboard utama
├── pelanggan.php          # Manajemen pelanggan
├── transaksi.php          # Manajemen transaksi
├── layanan.php            # Manajemen layanan
├── laporan.php            # Laporan keuangan
├── pengguna.php           # Manajemen pengguna (admin)
├── login.php              # Halaman login
├── logout.php             # Proses logout
├── database.sql           # Schema database
└── README.md              # Dokumentasi
```

## 🗄️ Struktur Database

### Tabel: `user`
- `id_user` (PK)
- `username`
- `password` (bcrypt)
- `nama_lengkap`
- `role` (admin/kasir)
- `created_at`

### Tabel: `pelanggan`
- `id_pelanggan` (PK)
- `nama`
- `alamat`
- `no_hp`
- `email`
- `created_at`

### Tabel: `layanan`
- `id_layanan` (PK)
- `nama_layanan`
- `harga_per_kg`
- `deskripsi`
- `durasi_hari`
- `created_at`

### Tabel: `transaksi`
- `id_transaksi` (PK)
- `id_pelanggan` (FK)
- `id_layanan` (FK)
- `id_user` (FK)
- `tanggal_masuk`
- `tanggal_selesai`
- `berat`
- `total_harga`
- `status` (Proses/Selesai/Sudah Diambil)
- `catatan`
- `created_at`
- `updated_at`

## 🎨 Fitur Design

- **Modern UI/UX**: Desain minimalis dengan gradient yang menarik
- **Responsive**: Berfungsi sempurna di desktop, tablet, dan mobile
- **Dark Sidebar**: Sidebar gelap dengan animasi smooth
- **Interactive Cards**: Kartu statistik dengan hover effects
- **Smooth Animations**: Transisi dan animasi yang halus
- **Custom Fonts**: Typography yang profesional (Sora & Space Mono)
- **Color Scheme**: Palet warna yang konsisten dan eye-friendly

## 🔒 Keamanan

- ✅ Password hashing menggunakan `password_hash()` (bcrypt)
- ✅ SQL Injection protection dengan Prepared Statements
- ✅ XSS Protection dengan `htmlspecialchars()`
- ✅ Session-based authentication
- ✅ Role-based access control (RBAC)
- ✅ Input validation (client & server side)

## 📊 Workflow Aplikasi

1. **Admin/Kasir Login** → Sistem mengecek kredensial
2. **Dashboard** → Melihat ringkasan statistik
3. **Input Pelanggan Baru** → Jika pelanggan belum terdaftar
4. **Buat Transaksi** → Pilih pelanggan, layanan, input berat
5. **Sistem Kalkulasi Otomatis** → Hitung total harga & estimasi selesai
6. **Update Status** → Proses → Selesai → Sudah Diambil
7. **Lihat Laporan** → Filter periode untuk melihat pendapatan

## 🛠️ Troubleshooting

### Error: "Connection failed"
- Pastikan MySQL/MariaDB sudah berjalan
- Cek konfigurasi di `includes/config.php`
- Pastikan database `laundrycrafty` sudah dibuat

### Error: "Call to undefined function password_hash()"
- Update PHP ke versi >= 5.5
- Atau gunakan PHP >= 7.0 untuk performa terbaik

### Sidebar tidak muncul di mobile
- Tekan tombol menu (hamburger icon) di kiri atas
- Atau refresh halaman

### Grafik tidak muncul
- Pastikan koneksi internet aktif (Chart.js dari CDN)
- Atau download Chart.js dan simpan lokal

## 🚀 Pengembangan Lebih Lanjut

### Fitur yang Dapat Ditambahkan:
- ✨ Notifikasi WhatsApp otomatis
- ✨ Barcode/QR Code untuk tracking
- ✨ Payment gateway integration
- ✨ Export laporan ke PDF/Excel
- ✨ Multi-branch support
- ✨ Customer mobile app
- ✨ Inventory management (detergen, pewangi, dll)
- ✨ Employee attendance tracking
- ✨ Loyalty program
- ✨ SMS notification

### API Endpoints (Opsional untuk Mobile App):
```
GET    /api/pelanggan          - List pelanggan
POST   /api/pelanggan          - Tambah pelanggan
GET    /api/transaksi          - List transaksi
POST   /api/transaksi          - Tambah transaksi
PUT    /api/transaksi/{id}     - Update status
GET    /api/laporan?periode=   - Laporan keuangan
```

## 📝 Lisensi
Proyek ini dibuat untuk keperluan pendidikan dan pembelajaran. Anda bebas menggunakan, memodifikasi, dan mendistribusikan dengan tetap mencantumkan kredit.

## 👨‍💻 Kontak & Support
Jika ada pertanyaan atau butuh bantuan:
- 📧 Email: support@laundrycrafty.com
- 💬 GitHub Issues: (link repository)

## 🙏 Terima Kasih
Terima kasih telah menggunakan LaundryCrafty! Semoga sistem ini membantu meningkatkan efisiensi bisnis laundry Anda.

---

**Dibuat dengan ❤️ untuk usaha laundry Indonesia**

*Version 1.0.0 - December 2025*
