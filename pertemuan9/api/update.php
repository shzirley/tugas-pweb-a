<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
    exit;
}

// Get and sanitize input
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$namaLengkap = isset($_POST['namaLengkap']) ? sanitizeInput($_POST['namaLengkap']) : '';
$email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
$tanggalLahir = isset($_POST['tanggalLahir']) ? sanitizeInput($_POST['tanggalLahir']) : '';
$jenisKelamin = isset($_POST['jenisKelamin']) ? sanitizeInput($_POST['jenisKelamin']) : '';
$agama = isset($_POST['agama']) ? sanitizeInput($_POST['agama']) : '';
$alamat = isset($_POST['alamat']) ? sanitizeInput($_POST['alamat']) : '';
$jurusan = isset($_POST['jurusan']) ? sanitizeInput($_POST['jurusan']) : '';
$nilaiRapor = isset($_POST['nilaiRapor']) ? floatval($_POST['nilaiRapor']) : 0;

// Validation
if ($id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID tidak valid'
    ]);
    exit;
}

if (empty($namaLengkap) || empty($email) || empty($tanggalLahir) || 
    empty($jenisKelamin) || empty($agama) || empty($alamat) || 
    empty($jurusan) || $nilaiRapor <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Semua field harus diisi dengan benar'
    ]);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Format email tidak valid'
    ]);
    exit;
}

// Validate nilai rapor
if ($nilaiRapor < 0 || $nilaiRapor > 100) {
    echo json_encode([
        'success' => false,
        'message' => 'Nilai rapor harus antara 0.00 - 100.00'
    ]);
    exit;
}

try {
    $conn = getConnection();
    
    // Check if email already exists for other records
    $checkStmt = $conn->prepare("SELECT id FROM peserta WHERE email = ? AND id != ?");
    $checkStmt->bind_param("si", $email, $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Email sudah digunakan oleh peserta lain'
        ]);
        $checkStmt->close();
        closeConnection($conn);
        exit;
    }
    $checkStmt->close();
    
    // Prepare update statement
    $stmt = $conn->prepare("UPDATE peserta SET nama_lengkap = ?, email = ?, tanggal_lahir = ?, jenis_kelamin = ?, agama = ?, alamat = ?, jurusan = ?, nilai_rapor = ? WHERE id = ?");
    
    $stmt->bind_param("sssssssdi", $namaLengkap, $email, $tanggalLahir, $jenisKelamin, $agama, $alamat, $jurusan, $nilaiRapor, $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak ada perubahan data atau data tidak ditemukan'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengupdate data: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
    closeConnection($conn);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>