<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser();

// Get date range from query params
$start_date = isset($_GET['start_date']) ? sanitize($_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? sanitize($_GET['end_date']) : date('Y-m-d');
$periode = isset($_GET['periode']) ? sanitize($_GET['periode']) : 'custom';

// Set date range based on period
if ($periode === 'today') {
    $start_date = $end_date = date('Y-m-d');
} elseif ($periode === 'week') {
    $start_date = date('Y-m-d', strtotime('monday this week'));
    $end_date = date('Y-m-d', strtotime('sunday this week'));
} elseif ($periode === 'month') {
    $start_date = date('Y-m-01');
    $end_date = date('Y-m-t');
} elseif ($periode === 'year') {
    $start_date = date('Y-01-01');
    $end_date = date('Y-12-31');
}

// Get statistics
$stats = [];

// Total transaksi
$result = $conn->query("
    SELECT COUNT(*) as total 
    FROM transaksi 
    WHERE tanggal_masuk BETWEEN '$start_date' AND '$end_date'
");
$stats['total_transaksi'] = $result->fetch_assoc()['total'];

// Total pendapatan
$result = $conn->query("
    SELECT SUM(total_harga) as total 
    FROM transaksi 
    WHERE tanggal_masuk BETWEEN '$start_date' AND '$end_date' 
    AND status != 'Proses'
");
$stats['total_pendapatan'] = $result->fetch_assoc()['total'] ?? 0;

// Total berat
$result = $conn->query("
    SELECT SUM(berat) as total 
    FROM transaksi 
    WHERE tanggal_masuk BETWEEN '$start_date' AND '$end_date'
");
$stats['total_berat'] = $result->fetch_assoc()['total'] ?? 0;

// Rata-rata transaksi
$stats['rata_transaksi'] = $stats['total_transaksi'] > 0 ? $stats['total_pendapatan'] / $stats['total_transaksi'] : 0;

// Get transactions in period
$transactions = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, l.nama_layanan, u.nama_lengkap as kasir
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN layanan l ON t.id_layanan = l.id_layanan
    JOIN user u ON t.id_user = u.id_user
    WHERE t.tanggal_masuk BETWEEN '$start_date' AND '$end_date'
    ORDER BY t.tanggal_masuk DESC
");

// Get revenue by service
$revenue_by_service = $conn->query("
    SELECT l.nama_layanan, COUNT(*) as jumlah, SUM(t.total_harga) as total
    FROM transaksi t
    JOIN layanan l ON t.id_layanan = l.id_layanan
    WHERE t.tanggal_masuk BETWEEN '$start_date' AND '$end_date'
    AND t.status != 'Proses'
    GROUP BY l.id_layanan
    ORDER BY total DESC
");

// Get daily revenue for chart
$daily_revenue = $conn->query("
    SELECT DATE(tanggal_masuk) as tanggal, SUM(total_harga) as total
    FROM transaksi
    WHERE tanggal_masuk BETWEEN '$start_date' AND '$end_date'
    AND status != 'Proses'
    GROUP BY DATE(tanggal_masuk)
    ORDER BY tanggal ASC
");

$chart_labels = [];
$chart_data = [];
while ($row = $daily_revenue->fetch_assoc()) {
    $chart_labels[] = date('d M', strtotime($row['tanggal']));
    $chart_data[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - LaundryCrafty</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="dashboard.php">
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
                    <a href="laporan.php" class="active">
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
                <h1>Laporan Keuangan</h1>
                <div class="header-actions">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                </div>
            </div>
            
            <!-- Filter -->
            <div class="card">
                <form method="GET" action="">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Periode</label>
                            <select name="periode" onchange="toggleCustomDate(this.value)">
                                <option value="today" <?php echo $periode === 'today' ? 'selected' : ''; ?>>Hari Ini</option>
                                <option value="week" <?php echo $periode === 'week' ? 'selected' : ''; ?>>Minggu Ini</option>
                                <option value="month" <?php echo $periode === 'month' ? 'selected' : ''; ?>>Bulan Ini</option>
                                <option value="year" <?php echo $periode === 'year' ? 'selected' : ''; ?>>Tahun Ini</option>
                                <option value="custom" <?php echo $periode === 'custom' ? 'selected' : ''; ?>>Custom</option>
                            </select>
                        </div>
                        
                        <div class="form-group" id="start_date_group" style="margin-bottom: 0; <?php echo $periode !== 'custom' ? 'display: none;' : ''; ?>">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" value="<?php echo $start_date; ?>">
                        </div>
                        
                        <div class="form-group" id="end_date_group" style="margin-bottom: 0; <?php echo $periode !== 'custom' ? 'display: none;' : ''; ?>">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="end_date" value="<?php echo $end_date; ?>">
                        </div>
                        
                        <div style="display: flex; align-items: end;">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-filter"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </form>
                
                <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 12px;">
                    <strong>Periode: <?php echo formatDate($start_date); ?> - <?php echo formatDate($end_date); ?></strong>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Transaksi</h3>
                    <div class="stat-value"><?php echo $stats['total_transaksi']; ?></div>
                    <div class="stat-label">Transaksi dalam periode</div>
                    <i class="fas fa-receipt"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Total Pendapatan</h3>
                    <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatRupiah($stats['total_pendapatan']); ?></div>
                    <div class="stat-label">Pendapatan selesai</div>
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Total Berat</h3>
                    <div class="stat-value"><?php echo number_format($stats['total_berat'], 1); ?> kg</div>
                    <div class="stat-label">Cucian diproses</div>
                    <i class="fas fa-weight"></i>
                </div>
                
                <div class="stat-card">
                    <h3>Rata-rata Transaksi</h3>
                    <div class="stat-value" style="font-size: 1.75rem;"><?php echo formatRupiah($stats['rata_transaksi']); ?></div>
                    <div class="stat-label">Per transaksi</div>
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="card">
                <div class="card-header">
                    <h2>Grafik Pendapatan Harian</h2>
                </div>
                <canvas id="revenueChart" style="max-height: 400px;"></canvas>
            </div>
            
            <!-- Revenue by Service -->
            <div class="card">
                <div class="card-header">
                    <h2>Pendapatan per Layanan</h2>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total Pendapatan</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($revenue_by_service->num_rows > 0): ?>
                                <?php while ($row = $revenue_by_service->fetch_assoc()): ?>
                                    <?php $percentage = $stats['total_pendapatan'] > 0 ? ($row['total'] / $stats['total_pendapatan']) * 100 : 0; ?>
                                    <tr>
                                        <td><strong><?php echo $row['nama_layanan']; ?></strong></td>
                                        <td><?php echo $row['jumlah']; ?> transaksi</td>
                                        <td><strong><?php echo formatRupiah($row['total']); ?></strong></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 1rem;">
                                                <div style="flex: 1; background: var(--border); height: 8px; border-radius: 4px; overflow: hidden;">
                                                    <div style="width: <?php echo $percentage; ?>%; height: 100%; background: var(--gradient-1);"></div>
                                                </div>
                                                <span style="font-weight: 600; min-width: 50px;"><?php echo number_format($percentage, 1); ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                        Tidak ada data pendapatan dalam periode ini
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Transaction Details -->
            <div class="card">
                <div class="card-header">
                    <h2>Detail Transaksi</h2>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transactions->num_rows > 0): ?>
                                <?php while ($row = $transactions->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($row['id_transaksi'], 5, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td><?php echo formatDate($row['tanggal_masuk']); ?></td>
                                        <td><?php echo $row['nama_pelanggan']; ?></td>
                                        <td><?php echo $row['nama_layanan']; ?></td>
                                        <td><?php echo $row['berat']; ?> kg</td>
                                        <td><strong><?php echo formatRupiah($row['total_harga']); ?></strong></td>
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
                                        Tidak ada transaksi dalam periode ini
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
    <script>
        function toggleCustomDate(value) {
            const startDateGroup = document.getElementById('start_date_group');
            const endDateGroup = document.getElementById('end_date_group');
            
            if (value === 'custom') {
                startDateGroup.style.display = 'block';
                endDateGroup.style.display = 'block';
            } else {
                startDateGroup.style.display = 'none';
                endDateGroup.style.display = 'none';
            }
        }
        
        // Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chart_labels); ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?php echo json_encode($chart_data); ?>,
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Sora',
                                size: 12,
                                weight: '600'
                            },
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 12,
                        titleFont: {
                            family: 'Sora',
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            family: 'Sora',
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: {
                                family: 'Sora',
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Sora',
                                size: 11
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
