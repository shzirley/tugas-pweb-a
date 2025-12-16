<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

requireAdmin();

$user = getCurrentUser();
$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            $username = sanitize($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $nama_lengkap = sanitize($_POST['nama_lengkap']);
            $role = sanitize($_POST['role']);
            
            // Check if username already exists
            $check = $conn->query("SELECT * FROM user WHERE username = '$username'");
            if ($check->num_rows > 0) {
                $error = 'Username sudah digunakan!';
            } else {
                $stmt = $conn->prepare("INSERT INTO user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $password, $nama_lengkap, $role);
                
                if ($stmt->execute()) {
                    $success = 'Pengguna berhasil ditambahkan!';
                } else {
                    $error = 'Gagal menambahkan pengguna!';
                }
                $stmt->close();
            }
        } elseif ($_POST['action'] === 'edit') {
            $id = intval($_POST['id_user']);
            $username = sanitize($_POST['username']);
            $nama_lengkap = sanitize($_POST['nama_lengkap']);
            $role = sanitize($_POST['role']);
            
            // Check if username already exists for other users
            $check = $conn->query("SELECT * FROM user WHERE username = '$username' AND id_user != $id");
            if ($check->num_rows > 0) {
                $error = 'Username sudah digunakan!';
            } else {
                if (!empty($_POST['password'])) {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE user SET username=?, password=?, nama_lengkap=?, role=? WHERE id_user=?");
                    $stmt->bind_param("ssssi", $username, $password, $nama_lengkap, $role, $id);
                } else {
                    $stmt = $conn->prepare("UPDATE user SET username=?, nama_lengkap=?, role=? WHERE id_user=?");
                    $stmt->bind_param("sssi", $username, $nama_lengkap, $role, $id);
                }
                
                if ($stmt->execute()) {
                    $success = 'Data pengguna berhasil diupdate!';
                } else {
                    $error = 'Gagal mengupdate data pengguna!';
                }
                $stmt->close();
            }
        } elseif ($_POST['action'] === 'delete') {
            $id = intval($_POST['id_user']);
            
            // Prevent deleting current user
            if ($id == $user['id']) {
                $error = 'Tidak dapat menghapus akun yang sedang aktif!';
            } else {
                $stmt = $conn->prepare("DELETE FROM user WHERE id_user=?");
                $stmt->bind_param("i", $id);
                
                if ($stmt->execute()) {
                    $success = 'Pengguna berhasil dihapus!';
                } else {
                    $error = 'Gagal menghapus pengguna!';
                }
                $stmt->close();
            }
        }
    }
}

// Get all users
$users = $conn->query("SELECT * FROM user ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna - LaundryCrafty</title>
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
                <li>
                    <a href="pengguna.php" class="active">
                        <i class="fas fa-user-shield"></i>
                        Pengguna
                    </a>
                </li>
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
                <h1>Manajemen Pengguna</h1>
                <div class="header-actions">
                    <button onclick="openModal('addModal')" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pengguna
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
            
            <!-- Users Table -->
            <div class="card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users->num_rows > 0): ?>
                                <?php while ($row = $users->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo str_pad($row['id_user'], 3, '0', STR_PAD_LEFT); ?></strong></td>
                                        <td>
                                            <strong><?php echo $row['username']; ?></strong>
                                            <?php if ($row['id_user'] == $user['id']): ?>
                                                <span class="badge badge-info" style="margin-left: 0.5rem;">Anda</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['nama_lengkap']; ?></td>
                                        <td>
                                            <?php
                                            $badge_class = $row['role'] === 'admin' ? 'badge-danger' : 'badge-success';
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>">
                                                <?php echo ucfirst($row['role']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo formatDate($row['created_at']); ?></td>
                                        <td>
                                            <button onclick='editUser(<?php echo json_encode($row); ?>)' class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($row['id_user'] != $user['id']): ?>
                                                <button onclick="deleteUser(<?php echo $row['id_user']; ?>, '<?php echo addslashes($row['username']); ?>')" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        Tidak ada pengguna
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add User Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Pengguna Baru</h3>
                <span class="close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                </div>
                
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap *</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role *</label>
                    <select id="role" name="role" required>
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
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
    
    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Pengguna</h3>
                <span class="close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id_user" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_username">Username *</label>
                    <input type="text" id="edit_username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_password">Password Baru</label>
                    <input type="password" id="edit_password" name="password" autocomplete="new-password">
                    <small style="display: block; margin-top: 0.5rem; color: var(--text-muted);">
                        Kosongkan jika tidak ingin mengubah password
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="edit_nama_lengkap">Nama Lengkap *</label>
                    <input type="text" id="edit_nama_lengkap" name="nama_lengkap" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_role">Role *</label>
                    <select id="edit_role" name="role" required>
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
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
        <input type="hidden" name="id_user" id="delete_id">
    </form>
    
    <script src="js/main.js"></script>
    <script>
        function editUser(data) {
            document.getElementById('edit_id').value = data.id_user;
            document.getElementById('edit_username').value = data.username;
            document.getElementById('edit_nama_lengkap').value = data.nama_lengkap;
            document.getElementById('edit_role').value = data.role;
            document.getElementById('edit_password').value = '';
            openModal('editModal');
        }
        
        function deleteUser(id, username) {
            if (confirm('Apakah Anda yakin ingin menghapus pengguna "' + username + '"?')) {
                document.getElementById('delete_id').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
