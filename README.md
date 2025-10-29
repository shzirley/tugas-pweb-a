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
| <code>if ($_SERVER["REQUEST_METHOD"] == "POST")</code> | **Pemeriksaan Metode** | Memastikan skrip hanya memproses permintaan yang datang dari metode HTTP POST (sesuai dengan permintaan AJAX). |
| <code>trim($_POST['name'])</code> | **Pengambilan dan Sanitasi Data** | Mengambil data yang dikirim oleh formulir AJAX dan membersihkan spasi putih di awal/akhir input. |
| <code>if ($name == '' &#124;&#124; ...)</code> | **Validasi Server** | Melakukan pemeriksaan wajib terhadap data untuk mencegah data kosong masuk ke pemrosesan lebih lanjut. |
| <code>filter_var($email, FILTER_VALIDATE_EMAIL)</code> | **Validasi Format Email** | Menggunakan fungsi bawaan PHP yang kuat untuk memverifikasi keabsahan format alamat email. |
| <code>echo "&lt;span style='color:green;'&gt;...&lt;/span&gt;";</code> | **Pencetakan Respons** | Mencetak string HTML (pesan sukses atau error) yang akan menjadi balasan (<code>data</code>) yang diterima dan ditampilkan oleh JavaScript. |

### 3\. `style.css` (Gaya Tampilan)

File ini berisi *style sheet* yang mengatur desain agar *form* terlihat modern dan responsif, termasuk penataan posisi form di tengah layar dan pemberian gaya visual pada pesan status (`.success` dan `.error`).

-----

## Dokumentasi dan Hasil Demo Online
Seluruh file telah diunggah dan di-*hosting* secara *online* menggunakan platform **GreatSite**, memungkinkan demonstrasi fungsionalitas AJAX secara *live*.

### Dokumentasi Tampilan Form
![ajax](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/ajax1.jpg?raw=true)

### Link Web Demo
Untuk melihat hasil implementasi secara langsung:
[Klik Disini](https://shzirley.great-site.net/pertemuan7/)

### Link Folder Proyek
Struktur file dalam direktori *hosting* dapat dilihat pada:
[folder7](https://www.google.com/search?q=pertemuan7/)

-----

## Kesimpulan

Latihan ini berhasil mengimplementasikan AJAX untuk *form submission*, memberikan **pengalaman pengguna (UX) yang ditingkatkan**.

1.  **Pengalaman Non-Blocking:** Dengan AJAX, pengguna tidak perlu menunggu halaman dimuat ulang. Data formulir dikirim di latar belakang, memberikan umpan balik yang cepat dan efisien.
2.  **Efisiensi Sumber Daya:** Hanya data yang relevan yang dipertukarkan antara klien dan server, bukan seluruh halaman HTML.
3.  **Keamanan Berlapis:** Validasi dilakukan baik di sisi klien (untuk kecepatan) maupun di sisi server (`process.php`) sebagai langkah keamanan penting untuk memastikan data yang diproses selalu valid.

---

# LAPORAN TUGAS PEMROGRAMAN WEBSITE PERTEMUAN 9

## Deskripsi Latihan

Pada pertemuan ke-9 ini, kami belajar bagaimana membangun **Sistem Informasi Manajemen (SIM)** lengkap dengan mengimplementasikan operasi **CRUD (Create, Read, Update, Delete)** menggunakan kombinasi **AJAX**, **PHP**, dan **MySQL**. Sistem yang dibuat adalah aplikasi pendaftaran siswa baru SMK MBG SEHAT yang memungkinkan pengelolaan data peserta **tanpa memuat ulang halaman** (*without page refresh*). Implementasi ini memanfaatkan teknologi **Asynchronous JavaScript** di sisi klien untuk berkomunikasi dengan **REST API berbasis PHP** di sisi server, dengan data disimpan dalam database **MySQL**.

---

## Analisis Kode dan Implementasi Fungsi Utama

### 1. `index.html` (Halaman Utama - Menu Navigasi)

| Komponen | Fungsi Utama | Keterangan Implementasi |
|:---------|:-------------|:------------------------|
| **Header Section** | Menampilkan identitas sekolah (logo, nama, alamat). | Menggunakan kombinasi div dengan class `logo`, `logo-icon`, dan `logo-text` untuk menciptakan tampilan header yang profesional dan informatif. |
| **Menu Cards** | Menyediakan navigasi visual ke dua fitur utama sistem. | Implementasi card-based design dengan dua kartu interaktif: "Daftar Baru" (navigasi ke form pendaftaran) dan "Peserta Terdaftar" (navigasi ke tabel data). Menggunakan tag `<a>` dengan class `card` untuk navigasi. |
| **Responsive Layout** | Memastikan tampilan optimal di berbagai ukuran layar. | Grid layout dengan `grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))` yang otomatis menyesuaikan jumlah kolom berdasarkan lebar layar. |
| **Visual Feedback** | Memberikan efek hover yang menarik pada menu cards. | CSS transition dengan `transform: translateY(-10px)` dan `box-shadow` yang berubah saat hover untuk meningkatkan user experience. |

### 2. `daftar_baru.html` (Form Pendaftaran Siswa)

| Komponen | Fungsi Utama | Keterangan Implementasi |
|:---------|:-------------|:------------------------|
| **HTML Form** | Menampilkan formulir dengan 9 field input (Nama Lengkap, Email, Tanggal Lahir, Jenis Kelamin, Agama, Alamat, Jurusan, Nilai Rapor). | Menggunakan `id="formDaftar"` sebagai target JavaScript. Form tidak memiliki atribut `action` karena submission dikendalikan sepenuhnya oleh AJAX. |
| **Input Types** | Menggunakan berbagai tipe input sesuai jenis data. | `type="text"` untuk nama, `type="email"` untuk validasi email otomatis, `type="date"` untuk date picker, `type="radio"` untuk jenis kelamin, `<select>` dropdown untuk agama dan jurusan, `type="number"` dengan `step="0.01"` untuk nilai rapor. |
| **Dynamic Dropdown** | Dropdown jurusan dengan 8 pilihan program keahlian SMK. | Option values mencakup: Tata Boga, TKJ, RPL, DKV, Akuntansi, Otomotif, Multimedia, dan Perhotelan. |
| **Success Message** | Div tersembunyi yang muncul setelah pendaftaran berhasil. | `id="successMessage"` dengan class `success-message` yang awalnya `display: none`, akan ditampilkan dengan class `show` setelah AJAX berhasil. Berisi link langsung ke halaman peserta terdaftar. |
| **Alert Box** | Menampilkan notifikasi validasi dan status pengiriman. | `id="alertBox"` dengan class dinamis (`alert-success` atau `alert-error`) yang dikendalikan oleh JavaScript untuk feedback real-time. |

### 3. `daftar.js` (JavaScript Form Pendaftaran - AJAX Client)

| Fungsi | Fungsi Utama | Keterangan Implementasi |
|:-------|:-------------|:------------------------|
| **Event Listener** | Menangkap event submit form dan mencegah reload halaman. | `document.getElementById('formDaftar').addEventListener('submit', function(e) { e.preventDefault(); })` untuk intercept form submission. |
| **Client-Side Validation** | Validasi lengkap sebelum data dikirim ke server. | Memeriksa: (1) Field tidak boleh kosong, (2) Format email valid dengan regex `/^[^\s@]+@[^\s@]+\.[^\s@]+$/`, (3) Nilai rapor dalam rentang 0.00-100.00, (4) Radio button jenis kelamin sudah dipilih. |
| **Data Collection** | Mengambil nilai dari semua input form. | Menggunakan kombinasi `getElementById().value.trim()` untuk text input dan `querySelector('input[name="jenisKelamin"]:checked')` untuk radio button. |
| **AJAX Request (Fetch API)** | Mengirim data ke server secara asinkron. | Menggunakan `fetch('api/create.php', { method: 'POST', body: formData })` dengan FormData object untuk mengirim data multipart. Promise-based dengan `.then()` untuk handle response. |
| **Response Handling** | Memproses respons JSON dari server. | Parse JSON response, tampilkan alert sukses/error, reset form jika berhasil dengan `document.getElementById('formDaftar').reset()`, dan tampilkan link ke daftar peserta dengan smooth scroll. |
| **Helper Functions** | Fungsi utilitas untuk validasi dan UI. | `showAlert(message, type)` untuk menampilkan notifikasi dengan animasi, `validateEmail(email)` untuk validasi format email menggunakan regex. |

### 4. `peserta_terdaftar.html` (Tabel Daftar Peserta)

| Komponen | Fungsi Utama | Keterangan Implementasi |
|:---------|:-------------|:------------------------|
| **Table Structure** | Menampilkan data peserta dalam format tabel responsif. | Tabel dengan 7 kolom: No (auto-increment), Nama, Tanggal Daftar, Jenis Kelamin, Jurusan, Nilai, dan Aksi. `id="tableBody"` sebagai target untuk rendering data dinamis. |
| **Filter & Sort Control** | Kontrol untuk mengurutkan data. | Dropdown `id="sortBy"` dengan 6 opsi sorting: Tanggal Terbaru/Terlama, Nama A-Z/Z-A, Nilai Tertinggi/Terendah. Event listener untuk sorting real-time tanpa reload. |
| **Action Buttons** | Tombol Edit dan Delete untuk setiap baris data. | Icon SVG untuk edit (pensil) dan delete (trash) dengan `onclick` handler yang memanggil `editPeserta(id)` dan `deletePeserta(id, nama)`. |
| **Modal Edit** | Dialog popup untuk mengedit data peserta. | `id="editModal"` dengan struktur yang sama seperti form pendaftaran, pre-filled dengan data existing. Close button dan click-outside-to-close functionality. |
| **Add New Button** | Link navigasi kembali ke form pendaftaran. | Button dengan class `btn-primary` yang mengarah ke `daftar_baru.html` untuk menambah peserta baru. |

### 5. `peserta.js` (JavaScript Peserta - AJAX CRUD Operations)

| Fungsi | Fungsi Utama | Keterangan Implementasi |
|:-------|:-------------|:------------------------|
| **loadData()** | Mengambil semua data peserta dari server. | Fetch request ke `api/read.php`, parse JSON response, simpan ke variabel global `currentData`, dan panggil `sortAndRenderData()`. Error handling untuk koneksi gagal. |
| **sortAndRenderData()** | Mengurutkan data berdasarkan pilihan user. | Switch-case untuk 6 tipe sorting: menggunakan `new Date().getTime()` untuk sorting tanggal, `localeCompare()` untuk sorting alfabetik, dan `parseFloat()` untuk sorting numerik. Memanfaatkan array spread operator `[...currentData]` untuk immutable sorting. |
| **renderTable(data)** | Render data array menjadi HTML table rows. | Loop `forEach()` dengan counter untuk nomor urut, format tanggal menggunakan `toLocaleDateString('id-ID')` dengan options untuk format Indonesia, escape HTML dengan `escapeHtml()` untuk security, dan generate action buttons dengan SVG icons. |
| **editPeserta(id)** | Membuka modal edit dengan data pre-filled. | Find data dari array dengan `currentData.find(item => item.id === id)`, populate semua field form dengan data existing, set radio button dengan conditional check, dan tampilkan modal dengan `classList.add('show')`. |
| **Form Edit Submit** | Mengirim data update ke server. | Event listener pada `formEdit`, validasi client-side, kirim via fetch ke `api/update.php` dengan method POST, handle response, close modal jika sukses, dan reload data untuk refresh tabel. |
| **deletePeserta(id, nama)** | Menghapus data peserta dari database. | Konfirmasi dengan `confirm()` dialog yang menampilkan nama peserta, kirim DELETE request via POST dengan `FormData` berisi ID, update UI jika sukses dengan reload data otomatis. |
| **escapeHtml(text)** | Mencegah XSS attack di output HTML. | Replace karakter berbahaya (`<`, `>`, `&`, `"`, `'`) dengan HTML entities menggunakan object mapping dan `replace()` dengan regex. |

### 6. `style.css` (Stylesheet - UI/UX Design)

| Section | Fungsi Utama | Keterangan Implementasi |
|:--------|:-------------|:------------------------|
| **CSS Variables** | Definisi warna tema secara terpusat. | `:root` dengan custom properties untuk primary color (#2c3e50), secondary, accent (#3498db), success (#27ae60), danger (#e74c3c), dan neutral colors untuk konsistensi tema. |
| **Layout System** | Grid dan flexbox untuk responsive design. | Container dengan `max-width: 1200px` dan `margin: 0 auto`, grid cards dengan `auto-fit` dan `minmax()`, flexbox untuk alignment dan spacing. |
| **Form Styling** | Desain form yang modern dan user-friendly. | Input fields dengan `padding: 12px 15px`, border 2px dengan transition smooth pada focus, border-radius 8px untuk soft corners, dan focus state dengan `border-color: var(--accent)`. |
| **Button Design** | Tombol interaktif dengan hover effects. | Base class `.btn` dengan padding, border-radius, dan transition. Variant classes (`.btn-primary`, `.btn-success`, `.btn-danger`) dengan color schemes berbeda. Hover state dengan `transform: translateY(-2px)` dan box-shadow untuk depth effect. |
| **Table Styling** | Tabel responsif dengan striped rows. | Full-width table dengan `border-collapse`, header dengan background `var(--primary)` dan white text, hover effect pada rows dengan `background: var(--light)`, padding 15px untuk cell spacing. |
| **Modal Design** | Overlay modal dengan animasi. | Fixed position fullscreen overlay dengan `rgba(0,0,0,0.5)` backdrop, centered content dengan flexbox, modal-content dengan white background dan border-radius, keyframe animations untuk fade-in dan slide-up effects. |
| **Alert Animations** | Notifikasi dengan slide-down animation. | `@keyframes slideDown` dengan opacity dan transform, auto-hide dengan JavaScript timeout, color-coded backgrounds untuk success (green) dan error (red). |
| **Responsive Breakpoints** | Media queries untuk mobile optimization. | `@media (max-width: 768px)` dengan adjusted padding, single column grid, stacked filter controls, dan smaller font sizes untuk table. |

### 7. `api/config.php` (Konfigurasi Database & Utilities)

| Fungsi | Fungsi Utama | Keterangan Implementasi |
|:-------|:-------------|:------------------------|
| **Database Constants** | Definisi koneksi database. | `define()` untuk DB_HOST ('localhost'), DB_USER ('root'), DB_PASS (''), DB_NAME ('smk_mbg_sehat') yang mudah dikonfigurasi. |
| **getConnection()** | Membuat koneksi MySQLi baru. | `new mysqli()` dengan parameter dari constants, error handling dengan `connect_error`, set charset ke `utf8mb4` untuk support emoji dan karakter Unicode, return connection object. |
| **closeConnection($conn)** | Menutup koneksi database dengan aman. | Check null dengan `if($conn)`, panggil `$conn->close()` untuk free resources, best practice untuk mencegah memory leak. |
| **sanitizeInput($data)** | Sanitasi input untuk keamanan. | Triple-layer sanitization: (1) `trim()` untuk hapus whitespace, (2) `stripslashes()` untuk remove escape characters, (3) `htmlspecialchars()` untuk escape HTML entities dan prevent XSS. |

### 8. `api/create.php` (API Create - INSERT Data)

| Baris Kode | Fungsi Utama | Keterangan Implementasi |
|:-----------|:-------------|:------------------------|
| `header('Content-Type: application/json')` | **Set Response Type** | Memberitahu client bahwa response adalah JSON, penting untuk AJAX parsing yang benar. |
| `if ($_SERVER['REQUEST_METHOD'] !== 'POST')` | **Method Validation** | Security check untuk memastikan endpoint hanya menerima POST request, return error JSON jika method salah. |
| `sanitizeInput($_POST['namaLengkap'])` | **Input Sanitization** | Mengambil data POST dan membersihkan dengan fungsi helper dari config.php untuk setiap field input. |
| `if (empty($namaLengkap) || ...)` | **Required Field Validation** | Validasi server-side untuk memastikan semua field wajib diisi, mencegah data kosong masuk ke database. |
| `filter_var($email, FILTER_VALIDATE_EMAIL)` | **Email Format Validation** | Menggunakan built-in PHP filter yang powerful untuk memverifikasi format email yang valid sesuai RFC 5322. |
| `if ($nilaiRapor < 0 || $nilaiRapor > 100)` | **Range Validation** | Memastikan nilai rapor dalam rentang 0-100, validasi numerik untuk data integrity. |
| `$checkStmt->prepare("SELECT id FROM peserta WHERE email = ?")` | **Duplicate Check** | Prepared statement untuk cek email duplikat, mencegah multiple registration dengan email yang sama, return error jika sudah exist. |
| `$stmt->prepare("INSERT INTO peserta (...) VALUES (?, ?, ...)")` | **Prepared Statement INSERT** | Menggunakan parameterized query dengan bind_param untuk SQL injection prevention. Binding 8 parameters (sssssssd) sesuai tipe data. |
| `$stmt->bind_param("sssssssd", ...)` | **Parameter Binding** | Bind variables ke placeholder dengan type hints: 's' untuk string (7x) dan 'd' untuk double (nilai_rapor), secure data insertion. |
| `echo json_encode(['success' => true, ...])` | **JSON Response** | Return JSON object dengan status success/false dan message, include `insert_id` untuk reference data yang baru dibuat. |

### 9. `api/read.php` (API Read - SELECT Data)

| Baris Kode | Fungsi Utama | Keterangan Implementasi |
|:-----------|:-------------|:------------------------|
| `$sql = "SELECT id, nama_lengkap, ... FROM peserta ORDER BY tanggal_daftar DESC"` | **Query Construction** | SQL query untuk mengambil semua data dengan default sorting berdasarkan tanggal pendaftaran terbaru. Mengambil semua kolom yang diperlukan untuk display. |
| `$result = $conn->query($sql)` | **Execute Query** | Eksekusi query menggunakan MySQLi query method, return result object yang berisi dataset. |
| `while ($row = $result->fetch_assoc())` | **Data Iteration** | Loop through result set dengan fetch_assoc() yang return associative array, memudahkan akses data dengan key name. |
| `$data[] = ['id' => intval($row['id']), ...]` | **Data Transformation** | Build array of objects dengan type casting: `intval()` untuk integer ID, `floatval()` untuk nilai rapor, string lainnya as-is. Format data sesuai kebutuhan frontend. |
| `echo json_encode(['success' => true, 'data' => $data, 'total' => count($data)])` | **JSON Response** | Return complete dataset dalam format JSON dengan metadata: success status, array data, dan total count untuk informasi. |

### 10. `api/update.php` (API Update - UPDATE Data)

| Baris Kode | Fungsi Utama | Keterangan Implementasi |
|:-----------|:-------------|:------------------------|
| `$id = isset($_POST['id']) ? intval($_POST['id']) : 0` | **ID Validation** | Mengambil ID dari POST dan casting ke integer dengan `intval()`, default 0 jika tidak ada. Validasi `if($id <= 0)` untuk memastikan ID valid. |
| `$checkStmt->prepare("SELECT id FROM peserta WHERE email = ? AND id != ?")` | **Unique Email Check** | Prepared statement untuk cek email duplikat pada record lain (excluding current record dengan `id != ?`). Mencegah konflik email saat update. |
| `$stmt->prepare("UPDATE peserta SET nama_lengkap = ?, ... WHERE id = ?")` | **Prepared Statement UPDATE** | Parameterized query dengan 9 placeholders (8 untuk SET, 1 untuk WHERE). Bind 9 parameters dengan type string "sssssssdi" (8 strings + 1 double + 1 integer). |
| `if ($stmt->affected_rows > 0)` | **Check Affected Rows** | Validasi apakah ada row yang ter-update, `affected_rows > 0` berarti update berhasil, `=== 0` berarti tidak ada perubahan atau ID tidak ditemukan. |
| `echo json_encode(['success' => true, 'message' => 'Data berhasil diupdate'])` | **Success Response** | Return JSON dengan success true dan pesan konfirmasi untuk feedback ke user. |

### 11. `api/delete.php` (API Delete - DELETE Data)

| Baris Kode | Fungsi Utama | Keterangan Implementasi |
|:-----------|:-------------|:------------------------|
| `$id = isset($_POST['id']) ? intval($_POST['id']) : 0` | **ID Parameter** | Ambil ID dari POST request dengan type casting integer, validasi ID harus > 0 untuk keamanan. |
| `$stmt->prepare("DELETE FROM peserta WHERE id = ?")` | **Prepared Statement DELETE** | Parameterized DELETE query dengan single placeholder untuk ID, mencegah SQL injection pada operasi delete. |
| `$stmt->bind_param("i", $id)` | **Parameter Binding** | Bind integer ID ke placeholder dengan type hint 'i', secure deletion berdasarkan primary key. |
| `if ($stmt->affected_rows > 0)` | **Deletion Verification** | Check apakah ada row yang terhapus, `> 0` berarti delete berhasil, `=== 0` berarti ID tidak ditemukan di database. |
| `echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus'])` | **Response Feedback** | Return JSON response dengan status dan message untuk user confirmation. |

### 12. `database.sql` (Database Schema)

| Statement | Fungsi Utama | Keterangan Implementasi |
|:----------|:-------------|:------------------------|
| `CREATE DATABASE IF NOT EXISTS smk_mbg_sehat` | **Database Creation** | Buat database baru dengan nama `smk_mbg_sehat`, `IF NOT EXISTS` mencegah error jika database sudah ada. |
| `id INT(11) AUTO_INCREMENT PRIMARY KEY` | **Primary Key** | ID sebagai primary key dengan auto increment untuk unique identifier setiap record, tipe INT dengan length 11 digit. |
| `email VARCHAR(255) NOT NULL UNIQUE` | **Unique Constraint** | Email field dengan constraint UNIQUE untuk mencegah duplikasi, NOT NULL untuk mandatory field, length 255 karakter. |
| `jenis_kelamin ENUM('Laki-laki', 'Perempuan')` | **ENUM Type** | Restricted values untuk jenis kelamin, hanya bisa 'Laki-laki' atau 'Perempuan', efisien untuk data terbatas. |
| `nilai_rapor DECIMAL(5,2) NOT NULL` | **Decimal Precision** | Tipe DECIMAL dengan 5 digit total (termasuk 2 digit desimal), untuk nilai 0.00 sampai 999.99, cocok untuk nilai rapor dengan presisi. |
| `tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP` | **Auto Timestamp** | Field datetime yang otomatis diisi dengan waktu saat insert, menggunakan fungsi MySQL `CURRENT_TIMESTAMP()`. |
| `INDEX idx_email (email)` | **Index Creation** | Membuat index pada kolom email untuk mempercepat query pencarian dan validasi unique, meningkatkan performance. |
| `ENGINE=InnoDB DEFAULT CHARSET=utf8mb4` | **Storage Engine** | Menggunakan InnoDB untuk ACID compliance dan foreign key support, charset utf8mb4 untuk full Unicode support termasuk emoji. |

### 13. `README.md` (Dokumentasi Lengkap)

| Section | Fungsi Utama | Keterangan Implementasi |
|:--------|:-------------|:------------------------|
| **Deskripsi Project** | Overview fitur dan teknologi. | Penjelasan lengkap tentang sistem, fitur utama dengan checklist, dan stack teknologi yang digunakan (HTML5, CSS3, Vanilla JS, PHP 7.4+, MySQL 5.7+). |
| **Struktur File** | Tree diagram organisasi file. | ASCII tree yang menampilkan hierarki folder dan file, memudahkan developer memahami arsitektur project. |
| **Panduan Instalasi** | Step-by-step setup instructions. | 5 langkah lengkap: (1) Persiapan environment, (2) Setup database dengan SQL script, (3) Konfigurasi `config.php`, (4) Deploy ke web server, (5) Akses aplikasi di browser. |
| **Cara Penggunaan** | User manual untuk setiap fitur. | Tutorial detail untuk pendaftaran, melihat daftar, edit data, dan delete data dengan screenshot dan penjelasan setiap step. |
| **Troubleshooting** | Solusi untuk error umum. | FAQ dengan 4 error paling sering terjadi dan cara mengatasinya: database connection error, 404 API, data tidak muncul, form tidak submit. |
| **Pengembangan Lebih Lanjut** | Roadmap fitur future. | Checklist 9 fitur potensial untuk pengembangan: upload foto, export data, print kartu, login system, dashboard, email notifikasi, pagination, search advanced. |

---

## Alur Kerja Sistem (Workflow)

### A. Proses Create (Pendaftaran Baru)

```
User mengisi form → JavaScript validasi client-side → Jika valid, AJAX POST ke create.php
                                                      ↓
                                          create.php validasi server-side
                                                      ↓
                               Cek email duplikat di database dengan prepared statement
                                                      ↓
                          Jika unique, INSERT data ke tabel peserta dengan binding parameter
                                                      ↓
                                Return JSON response {success: true/false, message: "..."}
                                                      ↓
                    JavaScript terima response → Tampilkan alert → Reset form → Show link ke daftar peserta
```

### B. Proses Read (Tampil Daftar Peserta)

```
Page load → JavaScript call loadData() → AJAX GET request ke read.php
                                                      ↓
                                    read.php execute SELECT query dengan ORDER BY
                                                      ↓
                                    Fetch all rows dengan fetch_assoc() loop
                                                      ↓
                          Build array data dengan type casting (intval, floatval)
                                                      ↓
                                Return JSON {success: true, data: [...], total: n}
                                                      ↓
                    JavaScript terima data → Store ke currentData → Call sortAndRenderData()
                                                      ↓
                            Sort data berdasarkan pilihan user (6 opsi sorting)
                                                      ↓
                              renderTable() loop data → Generate HTML rows dengan escapeHtml()
                                                      ↓
                                      Update innerHTML tableBody → Display table
```

### C. Proses Update (Edit Data Peserta)

```
User klik icon edit → JavaScript call editPeserta(id) → Find data dari currentData array
                                                      ↓
                                    Pre-fill form modal dengan data existing
                                                      ↓
                                          Show modal dengan classList.add('show')
                                                      ↓
User edit data → Submit form → JavaScript validasi → AJAX POST ke update.php dengan FormData
                                                      ↓
                              update.php validasi semua input + cek email duplikat (exclude current ID)
                                                      ↓
                                    Execute UPDATE query dengan prepared statement
                                                      ↓
                              Check affected_rows → Return JSON response
                                                      ↓
                    JavaScript handle response → Show alert → Close modal → Reload data (call loadData())
```

### D. Proses Delete (Hapus Data Peserta)

```
User klik icon delete → JavaScript call deletePeserta(id, nama)
                                          ↓
                          Tampilkan confirm dialog dengan nama peserta
                                          ↓
                    User confirm → AJAX POST ke delete.php dengan FormData berisi ID
                                          ↓
                        delete.php execute DELETE query dengan prepared statement
                                          ↓
                          Check affected_rows → Return JSON response
                                          ↓
            JavaScript handle response → Show alert (green/red) → Reload data untuk refresh table
```

---

## Dokumentasi dan Hasil Demo Online
Seluruh file telah diunggah dan di-*hosting* secara *online* menggunakan platform **GreatSite**, memungkinkan demonstrasi fungsionalitas AJAX, PHP, dan MySQL secara *live*.

### Screenshot Halaman Utama
![Halaman Utama](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/awalpage_p9.jpg?raw=true)

### Screenshot Form Pendaftaran
![Form Pendaftaran](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/formulirpendaftaran_p9.png?raw=true)

### Screenshot Tabel Peserta
![Tabel Peserta](https://github.com/shzirley/tugas-pweb-a/blob/main/screenshotpweb/peserta_terdaftar_p9.png?raw=true)

### Link Web Demo
Untuk melihat hasil implementasi secara langsung:
[Klik Disini](https://shzirley.great-site.net/tugas9pweb/)

### Link Folder Proyek
Struktur file dalam direktori *hosting* dapat dilihat pada:
[folder9](https://www.google.com/search?q=pertemuan9/)


---
