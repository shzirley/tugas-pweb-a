<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if logged in (for web) or valid API key (for external apps)
// For now, we'll allow access if session exists
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get all customers or specific customer
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM pelanggan WHERE id_pelanggan = $id");
            if ($result->num_rows > 0) {
                echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Customer not found']);
            }
        } else {
            $result = $conn->query("SELECT * FROM pelanggan ORDER BY created_at DESC");
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            echo json_encode(['success' => true, 'data' => $customers]);
        }
        break;
        
    case 'POST':
        // Create new customer
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['nama']) || !isset($data['no_hp'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Required fields missing']);
            exit();
        }
        
        $nama = $conn->real_escape_string($data['nama']);
        $alamat = isset($data['alamat']) ? $conn->real_escape_string($data['alamat']) : '';
        $no_hp = $conn->real_escape_string($data['no_hp']);
        $email = isset($data['email']) ? $conn->real_escape_string($data['email']) : '';
        
        $sql = "INSERT INTO pelanggan (nama, alamat, no_hp, email) VALUES ('$nama', '$alamat', '$no_hp', '$email')";
        
        if ($conn->query($sql)) {
            echo json_encode([
                'success' => true,
                'message' => 'Customer created successfully',
                'id' => $conn->insert_id
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to create customer']);
        }
        break;
        
    case 'PUT':
        // Update customer
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Customer ID required']);
            exit();
        }
        
        $id = intval($data['id']);
        $updates = [];
        
        if (isset($data['nama'])) $updates[] = "nama = '" . $conn->real_escape_string($data['nama']) . "'";
        if (isset($data['alamat'])) $updates[] = "alamat = '" . $conn->real_escape_string($data['alamat']) . "'";
        if (isset($data['no_hp'])) $updates[] = "no_hp = '" . $conn->real_escape_string($data['no_hp']) . "'";
        if (isset($data['email'])) $updates[] = "email = '" . $conn->real_escape_string($data['email']) . "'";
        
        if (empty($updates)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No fields to update']);
            exit();
        }
        
        $sql = "UPDATE pelanggan SET " . implode(', ', $updates) . " WHERE id_pelanggan = $id";
        
        if ($conn->query($sql)) {
            echo json_encode(['success' => true, 'message' => 'Customer updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to update customer']);
        }
        break;
        
    case 'DELETE':
        // Delete customer
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            if ($conn->query("DELETE FROM pelanggan WHERE id_pelanggan = $id")) {
                echo json_encode(['success' => true, 'message' => 'Customer deleted successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Failed to delete customer']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Customer ID required']);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        break;
}
?>
