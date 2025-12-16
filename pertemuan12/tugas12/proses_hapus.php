<?php
require_once 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Ambil data foto untuk dihapus
    $query = "SELECT foto FROM siswa WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $foto = $data['foto'];
        
        // Hapus data dari database
        $delete_query = "DELETE FROM siswa WHERE id = $id";
        
        if (mysqli_query($conn, $delete_query)) {
            // Hapus file foto jika ada
            if (!empty($foto) && file_exists('images/' . $foto)) {
                unlink('images/' . $foto);
            }
            header("Location: index.php?success=delete");
        } else {
            header("Location: index.php?error=" . urlencode("Gagal menghapus data: " . mysqli_error($conn)));
        }
    } else {
        header("Location: index.php?error=" . urlencode("Data tidak ditemukan"));
    }
} else {
    header("Location: index.php");
}

mysqli_close($conn);
exit();
?>
