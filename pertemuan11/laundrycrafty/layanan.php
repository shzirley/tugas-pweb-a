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
            $nama_layanan = sanitize($_POST['nama_layanan']);
            $harga_per_kg = floatval($_POST['harga_per_kg']);
            $durasi_hari = intval($_POST['durasi_hari']);
            $deskripsi = sanitize($_POST['deskripsi']);
            
            $stmt = $conn->prepare("INSERT INTO layanan (nama_layanan, harga_per_kg, durasi_hari, deskripsi) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdis", $nama_layanan, $harga_per_kg, $durasi_hari, $deskripsi);
            
            if ($stmt->execute()) {
                $success = 'Layanan berhasil ditambahkan!';
            } else {
                $error = 'Gagal menambahkan layanan!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'edit') {
            $id = intval($_POST['id_layanan']);
            $nama_layanan = sanitize($_POST['nama_layanan']);
            $harga_per_kg = floatval($_POST['harga_per_kg']);
            $durasi_hari = intval($_POST['durasi_hari']);
            $deskripsi = sanitize($_POST['deskripsi']);
            
            $stmt = $conn->prepare("UPDATE layanan SET nama_layanan=?, harga_per_kg=?, durasi_hari=?, deskripsi=? WHERE id_layanan=?");
            $stmt->bind_param("sdisi", $nama_layanan, $harga_per_kg, $durasi_hari, $deskripsi, $id);
            
            if ($stmt->execute()) {
                $success = 'Data layanan berhasil diupdate!';
            } else {
                $error = 'Gagal mengupdate data layanan!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'delete') {
            $id = intval($_POST['id_layanan']);
            
            $stmt = $conn->prepare("DELETE FROM layanan WHERE id_layanan=?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $success = 'Layanan berhasil dihapus!';
            } else {
                $error = 'Gagal menghapus layanan! (Mungkin masih ada transaksi terkait)';
            }
            $stmt->close();
        }
    }
}

// Get all services
$services = $conn->query("SELECT * FROM layanan ORDER BY nama_layanan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - LaundryCrafty</title>
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
                    <a href="transaksi.php">
                        <i class="fas fa-receipt"></i>
                        Transaksi
                    </a>
                </li>
                <li>
                    <a href="layanan.php" class="active">
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
                <h1>Paket Layanan</h1>
                <div class="header-actions">
                    <?php if (isAdmin()): ?>
                    <button onclick="openModal('addModal')" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Layanan
                    </button>
                    <?php endif; ?>
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
            
            <!-- Services Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                <?php if ($services->num_rows > 0): ?>
                    <?php while ($row = $services->fetch_assoc()): ?>
                        <div class="card" style="position: relative; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--gradient-1);"></div>
                            
                            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--dark);">
                                <i class="fas fa-tag" style="color: var(--primary); margin-right: 0.5rem;"></i>
                                <?php echo $row['nama_layanan']; ?>
                            </h3>
                            
                            <div style="margin-bottom: 1.5rem;">
                                <p style="color: var(--text-muted); margin-bottom: 0.5rem;">
                                    <?php echo $row['deskripsi'] ?: 'Tidak ada deskripsi'; ?>
                                </p>
                            </div>
                            
                            <div style="padding: 1rem; background: var(--light); border-radius: 12px; margin-bottom: 1rem;">
                                <div style="font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">
                                    <?php echo formatRupiah($row['harga_per_kg']); ?>
                                </div>
                                <div style="color: var(--text-muted); font-size: 0.875rem;">
                                    per kilogram
                                </div>
                            </div>
                            
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding: 0.75rem; background: rgba(99, 102, 241, 0.1); border-radius: 8px;">
                                <i class="fas fa-clock" style="color: var(--primary);"></i>
                                <span style="font-weight: 600; color: var(--dark);">
                                    Estimasi <?php echo $row['durasi_hari']; ?> hari
                                </span>
                            </div>
                            
                            <?php if (isAdmin()): ?>
                            <div style="display: flex; gap: 0.5rem;">
                                <button onclick='editService(<?php echo json_encode($row); ?>)' class="btn btn-warning btn-sm" style="flex: 1;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="deleteService(<?php echo $row['id_layanan']; ?>, '<?php echo addslashes($row['nama_layanan']); ?>')" class="btn btn-danger btn-sm" style="flex: 1;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <i class="fas fa-tags" style="font-size: 4rem; opacity: 0.3; color: var(--text-muted); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-muted); font-size: 1.125rem;">Belum ada layanan tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <!-- Add Service Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Layanan Baru</h3>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="nama_layanan">Nama Layanan *</label>
                    <input type="text" id="nama_layanan" name="nama_layanan" placeholder="Contoh: Cuci Setrika" required>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="harga_per_kg">Harga per Kg *</label>
                        <input type="number" id="harga_per_kg" name="harga_per_kg" step="100" min="0" placeholder="5000" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="durasi_hari">Durasi (Hari) *</label>
                        <input type="number" id="durasi_hari" name="durasi_hari" min="1" placeholder="3" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi layanan..."></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" onclick="closeModal('addModal')" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Service Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Layanan</h3>
                <span class="close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_layanan" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_nama_layanan">Nama Layanan *</label>
                    <input type="text" id="edit_nama_layanan" name="nama_layanan" required>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="edit_harga_per_kg">Harga per Kg *</label>
                        <input type="number" id="edit_harga_per_kg" name="harga_per_kg" step="100" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_durasi_hari">Durasi (Hari) *</label>
                        <input type="number" id="edit_durasi_hari" name="durasi_hari" min="1" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi"></textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <button type="button" onclick="closeModal('editModal')" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Form -->
    <form id="deleteForm" method="POST" action="" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id_layanan" id="delete_id">
    </form>
    
    <script src="js/main.js"></script>
    <script>
        function editService(data) {
            document.getElementById('edit_id').value = data.id_layanan;
            document.getElementById('edit_nama_layanan').value = data.nama_layanan;
            document.getElementById('edit_harga_per_kg').value = data.harga_per_kg;
            document.getElementById('edit_durasi_hari').value = data.durasi_hari;
            document.getElementById('edit_deskripsi').value = data.deskripsi || '';
            openModal('editModal');
        }
        
        function deleteService(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus layanan "' + nama + '"?\n\nPeringatan: Ini akan mempengaruhi transaksi terkait!')) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
