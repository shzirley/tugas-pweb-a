<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser();

// Get statistics
$stats = [];

// Total pelanggan
$result = $conn->query("SELECT COUNT(*) as total FROM pelanggan");
$stats['total_pelanggan'] = $result->fetch_assoc()['total'];

// Transaksi hari ini
$today = date('Y-m-d');
$result = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE tanggal_masuk = '$today'");
$stats['transaksi_hari_ini'] = $result->fetch_assoc()['total'];

// Transaksi proses
$result = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status = 'Proses'");
$stats['transaksi_proses'] = $result->fetch_assoc()['total'];

// Pendapatan bulan ini
$month = date('Y-m');
$result = $conn->query("SELECT SUM(total_harga) as total FROM transaksi WHERE DATE_FORMAT(tanggal_masuk, '%Y-%m') = '$month' AND status != 'Proses'");
$stats['pendapatan_bulan'] = $result->fetch_assoc()['total'] ?? 0;

// Get recent transactions
$recent_transactions = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, l.nama_layanan, u.nama_lengkap as kasir
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN layanan l ON t.id_layanan = l.id_layanan
    JOIN user u ON t.id_user = u.id_user
    ORDER BY t.created_at DESC
    LIMIT 10
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LaundryCrafty</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h2>LaundryCrafty</h2>
                <p>Management System</p>
            </div>
            
            <ul class="nav-menu">
                <li>
                    <a href="dashboard.php" class="active">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="pelanggan.php">
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="transaksi.php">
                        <i class="fas fa-receipt"></i>
                        Transaksi
                    </a>
                </li>
                <li>
                    <a href="layanan.php">
                        <i class="fas fa-tags"></i>
                        Layanan
                    </a>
                </li>
                <li>
                    <a href="laporan.php">
                        <i class="fas fa-chart-line"></i>
                        Laporan
                    </a>
                </li>
                <?php if (isAdmin()): ?>
                <li>
                    <a href="pengguna.php">
                        <i class="fas fa-user-shield"></i>
                        Pengguna
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
            
            <div class="user-info">
                <p>Logged in as:</p>
                <strong><?php echo $user['nama']; ?></strong>
                <p style="margin-top: 0.5rem; font-family: 'Space Mono', monospace; text-transform: uppercase; font-size: 0.75rem;">
                    <?php echo $user['role']; ?>
                </p>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div>
                    <h1>Dashboard</h1>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">
                        Selamat datang di LaundryCrafty, <?php echo $user['nama']; ?>!
                    </p>
                </div>
                <div class="header-actions">
                    <a href="transaksi.php?action=add" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </a>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Pelanggan</h3>
                    <div class="stat-value"><?php echo $stats['total_pelanggan']; ?></div>
                    <div class="stat-label">Pelanggan Terdaftar</div>
                    <i class="fas fa-users"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Transaksi Hari Ini</h3>
                    <div class="stat-value"><?php echo $stats['transaksi_hari_ini']; ?></div>
                    <div class="stat-label">Transaksi Masuk</div>
                    <i class="fas fa-calendar-day"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Sedang Diproses</h3>
                    <div class="stat-value"><?php echo $stats['transaksi_proses']; ?></div>
                    <div class="stat-label">Cucian Aktif</div>
                    <i class="fas fa-spinner"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Pendapatan Bulan Ini</h3>
                    <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatRupiah($stats['pendapatan_bulan']); ?></div>
                    <div class="stat-label">Total Pemasukan</div>
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <h2>Transaksi Terbaru</h2>
                    <a href="transaksi.php" class="btn btn-secondary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat</th>
                                <th>Total</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_transactions->num_rows > 0): ?>
                                <?php while ($row = $recent_transactions->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($row['id_transaksi'], 5, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td><?php echo $row['nama_pelanggan']; ?></td>
                                        <td><?php echo $row['nama_layanan']; ?></td>
                                        <td><?php echo $row['berat']; ?> kg</td>
                                        <td><strong><?php echo formatRupiah($row['total_harga']); ?></strong></td>
                                        <td><?php echo formatDate($row['tanggal_masuk']); ?></td>
                                        <td>
                                            <?php
                                            $badge_class = 'badge-warning';
                                            if ($row['status'] === 'Selesai') $badge_class = 'badge-success';
                                            if ($row['status'] === 'Sudah Diambil') $badge_class = 'badge-info';
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <?php echo $row['status']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row['kasir']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="js/main.js"></script>
</body>
</html>
