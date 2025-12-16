<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id = intval($_POST['id']);
    $nis = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $foto_lama = isset($_POST['foto_lama']) ? $_POST['foto_lama'] : '';
    
    // Cek apakah NIS sudah digunakan oleh siswa lain
    $check_query = "SELECT id FROM siswa WHERE nis = '$nis' AND id != $id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        header("Location: form_ubah.php?id=$id&error=" . urlencode("NIS sudah digunakan oleh siswa lain!"));
        exit();
    }
    
    // Proses upload foto baru (jika ada)
    $foto_name = $foto_lama;
    $upload_success = false;
    
    // Debug: Cek apakah ada file yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = strtolower($_FILES['foto']['type']);
        $file_size = $_FILES['foto']['size'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validasi tipe dan ukuran file
        if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
            // Buat folder images jika belum ada
            if (!file_exists('images')) {
                mkdir('images', 0777, true);
            }
            
            // Generate nama file unik
            $foto_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $foto_name = 'siswa_' . time() . '_' . uniqid() . '.' . $foto_ext;
            $foto_path = 'images/' . $foto_name;
            
            // Upload file
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
                $upload_success = true;
                
                // Hapus foto lama jika ada dan berbeda
                if (!empty($foto_lama) && $foto_lama != $foto_name && file_exists('images/' . $foto_lama)) {
                    @unlink('images/' . $foto_lama);
                }
            } else {
                // Jika upload gagal, tetap gunakan foto lama
                $foto_name = $foto_lama;
            }
        } else {
            // Jika validasi gagal, tetap gunakan foto lama
            $foto_name = $foto_lama;
        }
    } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
        // Tidak ada file yang diupload, gunakan foto lama
        $foto_name = $foto_lama;
    }
    
    // Update data ke database
    if (empty($foto_name)) {
        $query = "UPDATE siswa SET 
                  nis = '$nis',
                  nama = '$nama',
                  jenis_kelamin = '$jenis_kelamin',
                  telepon = '$telepon',
                  alamat = '$alamat',
                  foto = NULL
                  WHERE id = $id";
    } else {
        $query = "UPDATE siswa SET 
                  nis = '$nis',
                  nama = '$nama',
                  jenis_kelamin = '$jenis_kelamin',
                  telepon = '$telepon',
                  alamat = '$alamat',
                  foto = '$foto_name'
                  WHERE id = $id";
    }
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php?success=edit");
    } else {
        // Hapus foto baru jika update database gagal
        if ($upload_success && !empty($foto_name) && $foto_name != $foto_lama && file_exists('images/' . $foto_name)) {
            @unlink('images/' . $foto_name);
        }
        header("Location: form_ubah.php?id=$id&error=" . urlencode("Gagal mengubah data: " . mysqli_error($conn)));
    }
} else {
    header("Location: index.php");
}

mysqli_close($conn);
exit();
?>