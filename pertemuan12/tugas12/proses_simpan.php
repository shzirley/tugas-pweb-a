<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // Cek apakah NIS sudah ada
    $check_query = "SELECT id FROM siswa WHERE nis = '$nis'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: form_simpan.php?error=" . urlencode("NIS sudah terdaftar!"));
        exit();
    }
    
    // Proses upload foto
    $foto_name = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (in_array($_FILES['foto']['type'], $allowed_types) && $_FILES['foto']['size'] <= $max_size) {
            $foto_ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto_name = 'siswa_' . time() . '_' . uniqid() . '.' . $foto_ext;
            $foto_path = 'images/' . $foto_name;
            
            // Buat folder images jika belum ada
            if (!file_exists('images')) {
                mkdir('images', 0777, true);
            }
            
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
                $foto_name = null;
            }
        }
    }
    
    // Insert data ke database
    $query = "INSERT INTO siswa (nis, nama, jenis_kelamin, telepon, alamat, foto) 
              VALUES ('$nis', '$nama', '$jenis_kelamin', '$telepon', '$alamat', " . 
              ($foto_name ? "'$foto_name'" : "NULL") . ")";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=add");
    } else {
        // Hapus foto jika insert gagal
        if ($foto_name && file_exists('images/' . $foto_name)) {
            unlink('images/' . $foto_name);
        }
        header("Location: form_simpan.php?error=" . urlencode("Gagal menyimpan data: " . mysqli_error($conn)));
    }
} else {
    header("Location: index.php");
}

mysqli_close($conn);
exit();
?>
