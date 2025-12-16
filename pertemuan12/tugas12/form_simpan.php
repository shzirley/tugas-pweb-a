<?php
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .header p {
            color: #718096;
            font-size: 14px;
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 40px;
            animation: slideIn 0.4s ease-out;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .radio-group {
            display: flex;
            gap: 24px;
            margin-top: 8px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .radio-item label {
            margin: 0;
            font-weight: 400;
            cursor: pointer;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .file-input-label:hover {
            background: #e5e7eb;
        }

        .file-input-label svg {
            width: 18px;
            height: 18px;
        }

        input[type="file"] {
            display: none;
        }

        .file-info {
            margin-top: 8px;
            font-size: 12px;
            color: #6b7280;
        }

        .preview-image {
            margin-top: 16px;
            max-width: 150px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .icon {
            width: 18px;
            height: 18px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .card {
                padding: 24px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Tambah Data Siswa</h1>
            <p>Isi formulir di bawah untuk menambahkan data siswa baru</p>
        </div>

        <!-- Form Card -->
        <div class="card">
            <form action="proses_simpan.php" method="POST" enctype="multipart/form-data">
                <!-- NIS -->
                <div class="form-group">
                    <label for="nis">NIS <span class="required">*</span></label>
                    <input type="text" id="nis" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                </div>

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label>Jenis Kelamin <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="laki" name="jenis_kelamin" value="Laki-laki" checked>
                            <label for="laki">Laki-laki</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan">
                            <label for="perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>

                <!-- Telepon -->
                <div class="form-group">
                    <label for="telepon">Nomor Telepon <span class="required">*</span></label>
                    <input type="tel" id="telepon" name="telepon" class="form-control" placeholder="Contoh: 081234567890" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat Lengkap <span class="required">*</span></label>
                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap" required></textarea>
                </div>

                <!-- Foto -->
                <div class="form-group">
                    <label>Foto Siswa</label>
                    <div class="file-input-wrapper">
                        <label for="foto" class="file-input-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Pilih Foto
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                        <div class="file-info">JPG, PNG, atau GIF (Max 2MB)</div>
                    </div>
                    <img id="preview" class="preview-image" style="display: none;">
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <a href="index.php" class="btn btn-secondary">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
