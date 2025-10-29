<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smk_mbg_sehat');

// Create connection
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die(json_encode([
            'success' => false,
            'message' => 'Koneksi database gagal: ' . $conn->connect_error
        ]));
    }
    
    // Set charset to utf8mb4
    $conn->set_charset('utf8mb4');
    
    return $conn;
}

// Close connection
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}

// Sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>