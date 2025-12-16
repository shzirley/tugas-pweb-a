<?php
require_once 'koneksi.php';

// Ambil semua data siswa
$query = "SELECT * FROM siswa ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - CRUD</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 40px;
            animation: fadeIn 0.5s ease-out;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .header p {
            color: #718096;
            font-size: 14px;
        }

        .action-bar {
            margin-bottom: 30px;
            animation: slideIn 0.4s ease-out;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
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

        .btn-success {
            background: #10b981;
            color: white;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 13px;
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: slideIn 0.4s ease-out;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            padding: 16px 24px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        td {
            padding: 20px 24px;
            font-size: 14px;
            color: #374151;
        }

        .photo-cell img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nis-cell {
            font-weight: 600;
            color: #1f2937;
        }

        .name-cell {
            font-weight: 500;
            color: #111827;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .icon {
            width: 16px;
            height: 16px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #9ca3af;
            font-size: 14px;
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideIn 0.4s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
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
            .header h1 {
                font-size: 28px;
            }

            th, td {
                padding: 12px 16px;
                font-size: 13px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Data Siswa</h1>
            <p>Kelola data siswa dengan mudah</p>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    if ($_GET['success'] == 'add') echo "✓ Data siswa berhasil ditambahkan!";
                    elseif ($_GET['success'] == 'edit') echo "✓ Data siswa berhasil diperbarui!";
                    elseif ($_GET['success'] == 'delete') echo "✓ Data siswa berhasil dihapus!";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                ✕ <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Action Bar -->
        <div class="action-bar">
            <a href="form_simpan.php" class="btn btn-primary">
                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Siswa
            </a>
        </div>

        <!-- Table Card -->
        <div class="card">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="photo-cell">
                                        <?php 
                                        // Cek apakah ada foto dan file exists
                                        if (!empty($row['foto']) && file_exists('images/' . $row['foto'])) {
                                            // Tambahkan timestamp untuk prevent caching
                                            $foto_path = 'images/' . $row['foto'] . '?t=' . time();
                                        } else {
                                            // Gunakan initial nama sebagai avatar default
                                            $initials = strtoupper(substr($row['nama'], 0, 2));
                                            $foto_path = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"%3E%3Crect fill="%234A5568" width="60" height="60" rx="12"/%3E%3Ctext x="30" y="30" font-size="20" text-anchor="middle" dy=".3em" fill="white" font-family="Arial"%3E' . $initials . '%3C/text%3E%3C/svg%3E';
                                        }
                                        ?>
                                        <img src="<?php echo $foto_path; ?>" alt="<?php echo htmlspecialchars($row['nama']); ?>" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22%3E%3Crect fill=%22%234A5568%22 width=%2260%22 height=%2260%22 rx=%2212%22/%3E%3Ctext x=%2230%22 y=%2230%22 font-size=%2220%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22white%22 font-family=%22Arial%22%3E<?php echo strtoupper(substr($row['nama'], 0, 2)); ?>%3C/text%3E%3C/svg%3E'">
                                    </td>
                                    <td class="nis-cell"><?php echo htmlspecialchars($row['nis']); ?></td>
                                    <td class="name-cell"><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telepon']); ?></td>
                                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="form_ubah.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Ubah
                                            </a>
                                            <a href="proses_hapus.php?id=<?php echo $row['id']; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3>Belum ada data siswa</h3>
                    <p>Klik tombol "Tambah Siswa" untuk menambahkan data</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>