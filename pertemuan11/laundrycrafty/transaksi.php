<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

requireLogin();

$user = getCurrentUser();
$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $id_pelanggan = intval($_POST['id_pelanggan']);
            $id_layanan = intval($_POST['id_layanan']);
            $tanggal_masuk = sanitize($_POST['tanggal_masuk']);
            $berat = floatval($_POST['berat']);
            $catatan = sanitize($_POST['catatan']);
            
            // Get service info
            $layanan = $conn->query("SELECT * FROM layanan WHERE id_layanan = $id_layanan")->fetch_assoc();
            $total_harga = $berat * $layanan['harga_per_kg'];
            
            // Calculate tanggal_selesai
            $tanggal_selesai = date('Y-m-d', strtotime($tanggal_masuk . ' + ' . $layanan['durasi_hari'] . ' days'));
            
            $stmt = $conn->prepare("INSERT INTO transaksi (id_pelanggan, id_layanan, id_user, tanggal_masuk, tanggal_selesai, berat, total_harga, catatan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Proses')");
            $stmt->bind_param("iiissdds", $id_pelanggan, $id_layanan, $user['id'], $tanggal_masuk, $tanggal_selesai, $berat, $total_harga, $catatan);
            
            if ($stmt->execute()) {
                $success = 'Transaksi berhasil ditambahkan!';
            } else {
                $error = 'Gagal menambahkan transaksi!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'update_status') {
            $id = intval($_POST['id_transaksi']);
            $status = sanitize($_POST['status']);
            
            $stmt = $conn->prepare("UPDATE transaksi SET status=? WHERE id_transaksi=?");
            $stmt->bind_param("si", $status, $id);
            
            if ($stmt->execute()) {
                $success = 'Status transaksi berhasil diupdate!';
            } else {
                $error = 'Gagal mengupdate status transaksi!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'delete') {
            $id = intval($_POST['id_transaksi']);
            
            $stmt = $conn->prepare("DELETE FROM transaksi WHERE id_transaksi=?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $success = 'Transaksi berhasil dihapus!';
            } else {
                $error = 'Gagal menghapus transaksi!';
            }
            $stmt->close();
        }
    }
}

// Search and filter
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$filter_status = isset($_GET['status']) ? sanitize($_GET['status']) : '';

$where_clause = 'WHERE 1=1';
if (!empty($search)) {
    $where_clause .= " AND (p.nama LIKE '%$search%' OR t.id_transaksi LIKE '%$search%')";
}
if (!empty($filter_status)) {
    $where_clause .= " AND t.status = '$filter_status'";
}

// Get all transactions
$transactions = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, p.no_hp, l.nama_layanan, u.nama_lengkap as kasir
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN layanan l ON t.id_layanan = l.id_layanan
    JOIN user u ON t.id_user = u.id_user
    $where_clause
    ORDER BY t.created_at DESC
");

// Get customers and services for dropdown
$customers = $conn->query("SELECT * FROM pelanggan ORDER BY nama ASC");
$services = $conn->query("SELECT * FROM layanan ORDER BY nama_layanan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - LaundryCrafty</title>
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
                    <a href="transaksi.php" class="active">
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
                <h1>Data Transaksi</h1>
                <div class="header-actions">
                    <button onclick="openModal('addModal')" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </button>
                </div>
            </div>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <!-- Search and Filter -->
            <div class="card">
                <form method="GET" action="" style="display: grid; grid-template-columns: 1fr auto auto auto; gap: 1rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <input type="text" name="search" placeholder="Cari transaksi (ID, nama pelanggan)..." value="<?php echo $search; ?>">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <select name="status">
                            <option value="">Semua Status</option>
                            <option value="Proses" <?php echo $filter_status === 'Proses' ? 'selected' : ''; ?>>Proses</option>
                            <option value="Selesai" <?php echo $filter_status === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Sudah Diambil" <?php echo $filter_status === 'Sudah Diambil' ? 'selected' : ''; ?>>Sudah Diambil</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <?php if (!empty($search) || !empty($filter_status)): ?>
                        <a href="transaksi.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Transactions Table -->
            <div class="card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat</th>
                                <th>Total Harga</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transactions->num_rows > 0): ?>
                                <?php while ($row = $transactions->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($row['id_transaksi'], 5, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td>
                                            <strong><?php echo $row['nama_pelanggan']; ?></strong><br>
                                            <small style="color: var(--text-muted);"><?php echo $row['no_hp']; ?></small>
                                        </td>
                                        <td><?php echo $row['nama_layanan']; ?></td>
                                        <td><?php echo $row['berat']; ?> kg</td>
                                        <td><strong><?php echo formatRupiah($row['total_harga']); ?></strong></td>
                                        <td><?php echo formatDate($row['tanggal_masuk']); ?></td>
                                        <td><?php echo formatDate($row['tanggal_selesai']); ?></td>
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
                                        <td style="white-space: nowrap;">
                                            <?php if ($row['status'] !== 'Sudah Diambil'): ?>
                                                <button onclick="updateStatus(<?php echo $row['id_transaksi']; ?>, '<?php echo $row['status']; ?>')" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="viewDetail(<?php echo json_encode($row); ?>)" class="btn btn-warning btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="deleteTransaction(<?php echo $row['id_transaksi']; ?>)" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        <i class="fas fa-receipt" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                                        <?php echo empty($search) && empty($filter_status) ? 'Belum ada transaksi' : 'Tidak ada transaksi yang sesuai pencarian'; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add Transaction Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Transaksi Baru</h3>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="id_pelanggan">Pelanggan *</label>
                    <select id="id_pelanggan" name="id_pelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        <?php 
                        $customers->data_seek(0);
                        while ($customer = $customers->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $customer['id_pelanggan']; ?>">
                                <?php echo $customer['nama']; ?> - <?php echo $customer['no_hp']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small style="display: block; margin-top: 0.5rem; color: var(--text-muted);">
                        Pelanggan belum terdaftar? <a href="pelanggan.php" style="color: var(--primary);">Tambah pelanggan baru</a>
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="id_layanan">Layanan *</label>
                    <select id="id_layanan" name="id_layanan" required onchange="calculatePrice()">
                        <option value="">Pilih Layanan</option>
                        <?php 
                        $services->data_seek(0);
                        while ($service = $services->fetch_assoc()): 
                        ?>
                            <option value="<?php echo $service['id_layanan']; ?>" data-harga="<?php echo $service['harga_per_kg']; ?>" data-durasi="<?php echo $service['durasi_hari']; ?>">
                                <?php echo $service['nama_layanan']; ?> - <?php echo formatRupiah($service['harga_per_kg']); ?>/kg
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk *</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo date('Y-m-d'); ?>" required onchange="calculateDate()">
                    </div>
                    
                    <div class="form-group">
                        <label for="berat">Berat (kg) *</label>
                        <input type="number" id="berat" name="berat" step="0.1" min="0.1" required onkeyup="calculatePrice()">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Estimasi Selesai</label>
                    <input type="text" id="estimasi_selesai" readonly style="background: var(--light); cursor: not-allowed;">
                </div>
                
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" id="total_harga_display" readonly style="background: var(--light); cursor: not-allowed; font-weight: 700; font-size: 1.25rem;">
                </div>
                
                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" placeholder="Catatan tambahan (opsional)..."></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                    <button type="button" onclick="closeModal('addModal')" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Transaksi</h3>
                <span class="close" onclick="closeModal('detailModal')">&times;</span>
            </div>
            <div id="detail-content" style="line-height: 2;"></div>
        </div>
    </div>
    
    <!-- Update Status Form -->
    <form id="statusForm" method="POST" action="" style="display: none;">
        <input type="hidden" name="action" value="update_status">
        <input type="hidden" name="id_transaksi" id="status_id">
        <input type="hidden" name="status" id="status_value">
    </form>
    
    <!-- Delete Form -->
    <form id="deleteForm" method="POST" action="" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id_transaksi" id="delete_id">
    </form>
    
    <script src="js/main.js"></script>
    <script>
        function calculatePrice() {
            const layananSelect = document.getElementById('id_layanan');
            const beratInput = document.getElementById('berat');
            const totalDisplay = document.getElementById('total_harga_display');
            
            const selectedOption = layananSelect.options[layananSelect.selectedIndex];
            const harga = parseFloat(selectedOption.dataset.harga) || 0;
            const berat = parseFloat(beratInput.value) || 0;
            
            const total = harga * berat;
            totalDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
            
            calculateDate();
        }
        
        function calculateDate() {
            const layananSelect = document.getElementById('id_layanan');
            const tanggalMasuk = document.getElementById('tanggal_masuk');
            const estimasiSelesai = document.getElementById('estimasi_selesai');
            
            const selectedOption = layananSelect.options[layananSelect.selectedIndex];
            const durasi = parseInt(selectedOption.dataset.durasi) || 0;
            
            if (tanggalMasuk.value && durasi > 0) {
                const masuk = new Date(tanggalMasuk.value);
                masuk.setDate(masuk.getDate() + durasi);
                
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                estimasiSelesai.value = masuk.toLocaleDateString('id-ID', options);
            }
        }
        
        function updateStatus(id, currentStatus) {
            let newStatus = '';
            let message = '';
            
            if (currentStatus === 'Proses') {
                newStatus = 'Selesai';
                message = 'Tandai transaksi ini sebagai Selesai?';
            } else if (currentStatus === 'Selesai') {
                newStatus = 'Sudah Diambil';
                message = 'Tandai transaksi ini sebagai Sudah Diambil?';
            }
            
            if (confirm(message)) {
                document.getElementById('status_id').value = id;
                document.getElementById('status_value').value = newStatus;
                document.getElementById('statusForm').submit();
            }
        }
        
        function viewDetail(data) {
            const content = `
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">ID Transaksi</td>
                        <td style="padding: 0.75rem;">#${String(data.id_transaksi).padStart(5, '0')}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Pelanggan</td>
                        <td style="padding: 0.75rem;">${data.nama_pelanggan}<br><small>${data.no_hp}</small></td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Layanan</td>
                        <td style="padding: 0.75rem;">${data.nama_layanan}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Berat</td>
                        <td style="padding: 0.75rem;">${data.berat} kg</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Total Harga</td>
                        <td style="padding: 0.75rem; font-size: 1.25rem; font-weight: 700;">Rp ${parseFloat(data.total_harga).toLocaleString('id-ID')}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Tanggal Masuk</td>
                        <td style="padding: 0.75rem;">${new Date(data.tanggal_masuk).toLocaleDateString('id-ID', {year: 'numeric', month: 'long', day: 'numeric'})}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Tanggal Selesai</td>
                        <td style="padding: 0.75rem;">${new Date(data.tanggal_selesai).toLocaleDateString('id-ID', {year: 'numeric', month: 'long', day: 'numeric'})}</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Status</td>
                        <td style="padding: 0.75rem;"><span class="badge badge-${data.status === 'Proses' ? 'warning' : data.status === 'Selesai' ? 'success' : 'info'}">${data.status}</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 0.75rem; font-weight: 600;">Kasir</td>
                        <td style="padding: 0.75rem;">${data.kasir}</td>
                    </tr>
                    ${data.catatan ? `<tr><td style="padding: 0.75rem; font-weight: 600;">Catatan</td><td style="padding: 0.75rem;">${data.catatan}</td></tr>` : ''}
                </table>
            `;
            document.getElementById('detail-content').innerHTML = content;
            openModal('detailModal');
        }
        
        function deleteTransaction(id) {
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
