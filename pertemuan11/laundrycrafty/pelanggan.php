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
            $nama = sanitize($_POST['nama']);
            $alamat = sanitize($_POST['alamat']);
            $no_hp = sanitize($_POST['no_hp']);
            $email = sanitize($_POST['email']);
            
            $stmt = $conn->prepare("INSERT INTO pelanggan (nama, alamat, no_hp, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $alamat, $no_hp, $email);
            
            if ($stmt->execute()) {
                $success = 'Pelanggan berhasil ditambahkan!';
            } else {
                $error = 'Gagal menambahkan pelanggan!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'edit') {
            $id = intval($_POST['id_pelanggan']);
            $nama = sanitize($_POST['nama']);
            $alamat = sanitize($_POST['alamat']);
            $no_hp = sanitize($_POST['no_hp']);
            $email = sanitize($_POST['email']);
            
            $stmt = $conn->prepare("UPDATE pelanggan SET nama=?, alamat=?, no_hp=?, email=? WHERE id_pelanggan=?");
            $stmt->bind_param("ssssi", $nama, $alamat, $no_hp, $email, $id);
            
            if ($stmt->execute()) {
                $success = 'Data pelanggan berhasil diupdate!';
            } else {
                $error = 'Gagal mengupdate data pelanggan!';
            }
            $stmt->close();
        } elseif ($_POST['action'] === 'delete') {
            $id = intval($_POST['id_pelanggan']);
            
            $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id_pelanggan=?");
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $success = 'Pelanggan berhasil dihapus!';
            } else {
                $error = 'Gagal menghapus pelanggan! (Mungkin masih ada transaksi terkait)';
            }
            $stmt->close();
        }
    }
}

// Search functionality
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$where_clause = '';
if (!empty($search)) {
    $search_term = "%$search%";
    $where_clause = "WHERE nama LIKE '$search_term' OR no_hp LIKE '$search_term' OR email LIKE '$search_term'";
}

// Get all customers
$customers = $conn->query("SELECT * FROM pelanggan $where_clause ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan - LaundryCrafty</title>
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
                    <a href="pelanggan.php" class="active">
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
                <h1>Data Pelanggan</h1>
                <div class="header-actions">
                    <button onclick="openModal('addModal')" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pelanggan
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
            
            <!-- Search Bar -->
            <div class="card">
                <form method="GET" action="" style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <input type="text" name="search" placeholder="Cari pelanggan (nama, no HP, email)..." value="<?php echo $search; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="pelanggan.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Customers Table -->
            <div class="card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($customers->num_rows > 0): ?>
                                <?php while ($row = $customers->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($row['id_pelanggan'], 4, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['alamat']; ?></td>
                                        <td><?php echo $row['no_hp']; ?></td>
                                        <td><?php echo $row['email'] ?: '-'; ?></td>
                                        <td><?php echo formatDate($row['created_at']); ?></td>
                                        <td>
                                            <button onclick='editCustomer(<?php echo json_encode($row); ?>)' class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteCustomer(<?php echo $row['id_pelanggan']; ?>, '<?php echo addslashes($row['nama']); ?>')" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        <i class="fas fa-users" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                                        <?php echo empty($search) ? 'Belum ada pelanggan terdaftar' : 'Tidak ada pelanggan yang sesuai pencarian'; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add Customer Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Pelanggan Baru</h3>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="no_hp">No. HP *</label>
                    <input type="tel" id="no_hp" name="no_hp" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
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
    
    <!-- Edit Customer Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Data Pelanggan</h3>
                <span class="close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_pelanggan" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_nama">Nama Lengkap *</label>
                    <input type="text" id="edit_nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_alamat">Alamat</label>
                    <textarea id="edit_alamat" name="alamat"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_no_hp">No. HP *</label>
                    <input type="tel" id="edit_no_hp" name="no_hp" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="email" id="edit_email" name="email">
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
        <input type="hidden" name="id_pelanggan" id="delete_id">
    </form>
    
    <script src="js/main.js"></script>
    <script>
        function editCustomer(data) {
            document.getElementById('edit_id').value = data.id_pelanggan;
            document.getElementById('edit_nama').value = data.nama;
            document.getElementById('edit_alamat').value = data.alamat;
            document.getElementById('edit_no_hp').value = data.no_hp;
            document.getElementById('edit_email').value = data.email || '';
            openModal('editModal');
        }
        
        function deleteCustomer(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus pelanggan "' + nama + '"?\n\nPeringatan: Semua transaksi terkait pelanggan ini juga akan terhapus!')) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
