<?php
header('Content-Type: application/json');
require_once 'config.php';

try {
    $conn = getConnection();
    
    // Get all data
    $sql = "SELECT id, nama_lengkap, email, tanggal_lahir, jenis_kelamin, agama, alamat, jurusan, nilai_rapor, tanggal_daftar FROM peserta ORDER BY tanggal_daftar DESC";
    
    $result = $conn->query($sql);
    
    if ($result) {
        $data = [];
        
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'id' => intval($row['id']),
                'nama_lengkap' => $row['nama_lengkap'],
                'email' => $row['email'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'agama' => $row['agama'],
                'alamat' => $row['alamat'],
                'jurusan' => $row['jurusan'],
                'nilai_rapor' => floatval($row['nilai_rapor']),
                'tanggal_daftar' => $row['tanggal_daftar']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data,
            'total' => count($data)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal mengambil data: ' . $conn->error
        ]);
    }
    
    closeConnection($conn);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>