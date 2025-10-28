# Identitas
- **Nama**: Angela Vania Sugiyono
- **NRP**: 5025241226
- **Kelas**: PWEB A

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 1

## Deskripsi Latihan
Pada pertemuan ke-1 ini, kami belajar typewriting untuk melatih kemampuan mengetik kami.
Untuk melihat hasil dapat dilihat di bawah berikut:

### Link Web
Untuk melihat hasil dapat dilihat berikut:
[https://shzirley.github.io/tugas-5-pweb-a/](https://shzirley.github.io/tugas-1-pweb-a/)

### Link Folder
Bisa dilihat pada [folder1](pertemuan1/)

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 2

## Deskripsi Latihan

Website profil personal ini dibuat sebagai bentuk ke-10, yaitu Tugas Profil dengan Semua Elemen yang berisikan:
- Judul profil (heading)
- Paragraf deskripsi diri
- Foto profil (image)
- Daftar hobi (list)
- Tabel riwayat pendidikan
- Form kontak sederhana
- Link ke media sosial

---

## Fitur dan Komponen Website

### 1. Header dan Profil
![ss_profil](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_profil.jpg?raw=true)

Bagian header menampilkan:
- **Foto profil** dengan border radius 50% untuk membuat bentuk lingkaran
- **Nama lengkap** dengan typography yang menonjol
- **Subtitle** yang menjelaskan status sebagai mahasiswa Teknik Informatika ITS
- **Background gradient** berwarna biru gelap (#2c3e50) karena biru warna favorit saya hehe

**Implementasi Teknis:**
```css
.header {
    background: #2c3e50;
    color: white;
    padding: 30px;
    text-align: center;
}

.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid white;
    object-fit: cover;
}
```

### 2. Deskripsi Diri
Berisi paragraf yang menjelaskan:
- Latar belakang akademik
- Passion terhadap teknologi dan penelitian
- Minat pada teknologi ramah lingkungan
- Visi untuk menciptakan dampak positif

### 3. Hobi dan Minat
![hobipendidikan](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_hobinpendidikan.jpg?raw=true)

**Implementasi Grid Layout:**
```css
.hobbies-list {
    list-style: none;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}

.hobbies-list li {
    background: #3498db;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-align: center;
}
```

Fitur yang ditampilkan:
- **Penelitian Teknologi**
- **Teknologi Ramah Lingkungan** 
- **Pengembangan Aplikasi**
- **Menulis Esai Ilmiah**
- **Video Editing**
- **Sustainability Project**

### 4. Tabel Riwayat Pendidikan
Menampilkan informasi pendidikan dalam format tabel dengan:
- **Header berwarna gelap** (#2c3e50) dengan teks putih
- **Alternating row colors** untuk kemudahan membaca
- **Border styling** untuk pemisah yang jelas

**Implementasi Teknis:**
```css
.education-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

.education-table th {
    background: #2c3e50;
    color: white;
}

.education-table tr:nth-child(even) {
    background: #f9f9f9;
}
```

### 5. Form Kontak
![medsos](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_medsos.jpg?raw=true)

Form kontak interaktif ini dibuat untuk memudahkan pengunjung jika ingin menghubungi saya tanpa membuka banyak aplikasi secara manual. Fitur form kontak sebagai berikut:
- **Input fields** untuk Nama, Email, Subjek, dan Pesan
- **Styling konsisten** dengan border radius dan padding
- **Focus state** dengan perubahan warna border
- **JavaScript validation** dan feedback

**Implementasi Teknis:**
```css
.contact-form {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3498db;
}
```

**JavaScript untuk Handling:**
```javascript
function handleSubmit(event) {
    event.preventDefault();
    alert('Terima kasih! Pesan Anda telah diterima.');
    event.target.reset();
}
```

### 6. Media Sosial
![medsos](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_medsos.jpg?raw=true)

Links ke platform media sosial dengan:
- **Button styling** yang konsisten
- **Hover effects** untuk interaktivitas
- **Target blank** untuk link eksternal

**Implementasi Teknis:**
```css
.social-link {
    background: #3498db;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    display: inline-block;
}

.social-link:hover {
    background: #2980b9;
    color: white;
}
```

---

## Aspek Teknis Website

### 1. Struktur HTML
- **Semantic HTML5** dengan penggunaan tag yang appropriate
- **Container-based layout** untuk kontrol yang lebih baik
- **Section-based organization** untuk kemudahan maintenance

### 2. CSS Styling
- **CSS Grid** untuk layout hobi yang responsive
- **Flexbox** untuk alignment media sosial
- **Box model** dengan box-sizing: border-box
- **Custom properties** untuk konsistensi warna
- **Media queries** untuk responsivitas

### 3. Responsive Design
```css
@media (max-width: 600px) {
    .hobbies-list {
        grid-template-columns: 1fr;
    }
    
    .social-links {
        flex-direction: column;
        align-items: center;
    }
}
```

### 4. Typography dan Visual Hierarchy
- **Font stack**: Arial, sans-serif untuk compatibility
- **Color scheme**: Biru (#3498db) dan abu-abu gelap (#2c3e50)
- **Consistent spacing** dengan padding dan margin yang teratur
- **Visual separation** menggunakan border dan background colors

### 5. Interaktivity
- **Form handling** dengan JavaScript
- **Hover states** pada buttons dan links
- **Focus states** pada form inputs
- **Smooth transitions** untuk better UX

### 6. Accessibility Features
- **Alt text** pada gambar
- **Proper labeling** pada form elements
- **Color contrast** yang memenuhi standar
- **Keyboard navigation** support

---

## Deployment
Website ini di-deploy menggunakan **GitHub Pages** dengan:
- Single HTML file untuk kemudahan deployment
- Inline CSS dan JavaScript untuk portability
- Optimized untuk loading speed
- Compatible dengan static hosting

---

## Kesimpulan
Tugas ini melatih mahasiswa untuk bisa kenal lebih dalam mengenai HTML dan CSS, yaitu layouting dengan berbagai teknik seperti CSS Grid untuk mengatur daftar hobi, Flexbox untuk alignment media sosial, responsive design dengan media queries, serta styling components seperti form, table, dan button. Melalui pembuatan website profil ini, mahasiswa dapat memahami konsep semantic HTML, CSS positioning, dan best practices dalam web development yang dapat diterapkan untuk proyek-proyek web development selanjutnya.

### Link Web
Untuk melihat hasil dapat dilihat berikut:
[!pertemuan2](https://shzirley.github.io/tugas-2-pweb-a/pertemuan2.html)

### Link Folder
Bisa dilihat pada [folder2](pertemuan2/)

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 3

## Deskripsi Latihan
Pada pertemuan ke-3 kali ini, kami belajar pembuatan table, frame, dan juga form menggunakan HTML

Untuk melihat hasil dapat dilihat di bawah berikut:

### a. table
![ss_table](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_table.png?raw=true)

### b. frame
![ss_frame0(https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_frame.png?raw=true)

### c. form
![ss_form](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ss_form.png?raw=true)

---
## Kesimpulan
Melalui latihan ini, mahasiswa dapat memahami dan mempraktikkan tiga hal penting dalam pemrograman web dasar, yaitu:

1. Layout halaman web → dengan memanfaatkan elemen HTML5 (header, nav, main, footer) serta CSS, mahasiswa belajar menyusun tampilan web agar rapi, terstruktur, dan enak dibaca.
2. Tabel data → penggunaan tabel (table, thead, tbody, tr, th, td) melatih mahasiswa menyajikan informasi dalam bentuk yang mudah dipahami, sekaligus melatih keterampilan styling tabel agar lebih menarik.
3. Formulir (Form) → pembuatan form dengan berbagai input (teks, email, select, password, tombol) melatih mahasiswa membuat antarmuka interaktif yang dapat digunakan untuk mengumpulkan data pengguna.

Dengan menggabungkan ketiga komponen tersebut, mahasiswa tidak hanya belajar menulis kode HTML, tetapi juga memahami konsep perancangan antarmuka web yang baik, yakni terstruktur, fungsional, dan user-friendly.

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 4

## Deskripsi Latihan
Pada pertemuan ke-4 ini, kami belajar bagaimana cara memperindah web menggunakan css

Untuk melihat hasul dapat dilihat di bawah berikut:

### Dokumentasi page 1
![edusmart1](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/edusmart1.jpg?raw=true)

### Dokumentasi page 2
![edusmart2](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/edusmart2.jpg?raw=true)

### Link Web
Untuk melihat hasil dapat dilihat berikut:
https://shzirley.github.io/tugas-4-pweb-a/

### Link Folder
Bisa dilihat pada [folder4](pertemuan4/)

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 5

## Deskripsi Latihan
Pada pertemuan ke-5 ini, kami belajar bagaimana perngimpelentasian JS pada form Mahasiswa dan Produk

Untuk melihat hasil dapat dilihat di bawah berikut:

### Dokumentasi page form produk
![formproduk](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/formjenisproduk.jpg?raw=true)

### Dokumentasi page form mahasiswa
![formmahasiswa](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/formmahasiswa.jpg?raw=true)

### Link Web
Untuk melihat hasil dapat dilihat berikut:
https://shzirley.github.io/tugas-5-pweb-a/

### Link Folder
Bisa dilihat pada [folder5](pertemuan5/)

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 6

## Deskripsi Latihan
Pada pertemuan ke-6 ini, kami belajar bagaimana pengimpelentasian bootstrap pada page login dan registrasi.

Untuk melihat hasil dapat dilihat di bawah berikut:

### Dokumentasi page form login
![formlogin](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/formlogin.jpg?raw=true)

### Dokumentasi page form registrasi
![formregistrasi](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/formregistrasi.jpg?raw=true)

### Link Web
Untuk melihat hasil dapat dilihat berikut:
https://shzirley.github.io/tugas-6-pweb-a/login.html

### Link Folder
Bisa dilihat pada [folder6](pertemuan6/)

--- 

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 7

## Deskripsi Latihan

Pada pertemuan ke-7 ini, kami belajar bagaimana pengimplementasian **Asynchronous JavaScript and XML (AJAX)** dalam proses pengiriman *form* (*submit form*) **tanpa memuat ulang halaman** (*without refresh*). Implementasi ini memanfaatkan kombinasi **jQuery** di sisi klien (*client-side*) untuk berkomunikasi secara asinkron dengan skrip **PHP** di sisi server (*server-side*). Seluruh proyek ini kemudian di-*hosting* secara *online* agar dapat didemonstrasikan.

-----

## Analisis Kode dan Implementasi Fungsi Utama

Tugas ini berhasil diimplementasikan menggunakan tiga file utama yang saling berinteraksi: `index.html`, `style.css`, dan `process.php`.

### 1\. `index.html` (Antarmuka dan Mesin AJAX)

| Komponen | Fungsi Utama | Keterangan Implementasi |
| :--- | :--- | :--- |
| **HTML Form** | Menampilkan elemen input (`Name`, `Email`, `Message`) dan tombol *submit*. | Menggunakan `id="contactForm"` yang menjadi target JavaScript. Atribut `action` form dikosongkan karena pengiriman dikendalikan oleh AJAX. |
| **Validasi Klien (jQuery)** | Melakukan pemeriksaan awal pada input (kolom kosong, format email) sebelum data dikirim ke server. | Menggunakan fungsi `if(name === '') { ... }` dan `if(!email.match(emailPattern)) { ... }` untuk validasi instan. |
| **Mekanisme AJAX** | Mengirim data formulir ke server secara asinkron dan menangani respons. | Fungsi `e.preventDefault()` mencegah *refresh*. Objek `$.ajax()` mengirim data formulir (`$(this).serialize()`) ke **`process.php`** menggunakan metode **POST**. |
| **Status Umpan Balik** | Memberikan indikator kepada pengguna selama proses pengiriman. | Fungsi `beforeSend` menampilkan gambar *loader*. Fungsi `success` menerima respons dari PHP dan menampilkannya di `div class="message_box"`. |

### 2\. `process.php` (Logika Server)

| Baris Kode | Fungsi Utama | Keterangan Implementasi |
| :--- | :--- | :--- |
| `if ($_SERVER["REQUEST_METHOD"] == "POST")` | **Pemeriksaan Metode** | Memastikan skrip hanya memproses permintaan yang datang dari metode HTTP POST (sesuai dengan permintaan AJAX). |
| `trim($_POST['name'])` | **Pengambilan dan Sanitasi Data** | Mengambil data yang dikirim oleh formulir AJAX dan membersihkan spasi putih di awal/akhir input. |
| `if ($name == '' || ...)` | **Validasi Server** | Melakukan pemeriksaan wajib terhadap data untuk mencegah data kosong masuk ke pemrosesan lebih lanjut. |
| `filter_var($email, FILTER_VALIDATE_EMAIL)` | **Validasi Format Email** | Menggunakan fungsi bawaan PHP yang kuat untuk memverifikasi keabsahan format alamat email. |
| `echo "<span style='color:green;'>...</span>";` | **Pencetakan Respons** | Mencetak string HTML (pesan sukses atau error) yang akan menjadi balasan (**`data`**) yang diterima dan ditampilkan oleh JavaScript. |

### 3\. `style.css` (Gaya Tampilan)

File ini berisi *style sheet* yang mengatur desain agar *form* terlihat modern dan responsif, termasuk penataan posisi form di tengah layar dan pemberian gaya visual pada pesan status (`.success` dan `.error`).

-----

## Dokumentasi dan Hasil Demo Online
Seluruh file telah diunggah dan di-*hosting* secara *online* menggunakan platform **GreatSite**, memungkinkan demonstrasi fungsionalitas AJAX secara *live*.

### Dokumentasi Tampilan Form
![ajax](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ajax1.jpg?raw=true)

### Link Web Demo
Untuk melihat hasil implementasi secara langsung:
[https://shzirley.great-site.net/pertemuan7/](https://shzirley.great-site.net/pertemuan7/)

### Link Folder Proyek
Struktur file dalam direktori *hosting* dapat dilihat pada:
[folder7](https://www.google.com/search?q=pertemuan7/)

-----

## Kesimpulan

Latihan ini berhasil mengimplementasikan AJAX untuk *form submission*, memberikan **pengalaman pengguna (UX) yang ditingkatkan**.

1.  **Pengalaman Non-Blocking:** Dengan AJAX, pengguna tidak perlu menunggu halaman dimuat ulang. Data formulir dikirim di latar belakang, memberikan umpan balik yang cepat dan efisien.
2.  **Efisiensi Sumber Daya:** Hanya data yang relevan yang dipertukarkan antara klien dan server, bukan seluruh halaman HTML.
3.  **Keamanan Berlapis:** Validasi dilakukan baik di sisi klien (untuk kecepatan) maupun di sisi server (`process.php`) sebagai langkah keamanan penting untuk memastikan data yang diproses selalu valid.
