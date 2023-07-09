<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request data
    $data = json_decode(file_get_contents('php://input'));

    // Check if the required fields are present
    if (isset($data->email) && isset($data->password)) {
        // Create a new User instance
        $user = new User($conn);

        // Hash the new password
        $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);

        // Reset the user's password
        if ($user->resetPassword($data->email, $hashedPassword)) {
            // Password reset successful
            echo json_encode(array('success' => true));
        } else {
            // Password reset failed
            echo json_encode(array('success' => false, 'message' => 'Password reset failed'));
        }
    } else {
        // Required fields are missing
        echo json_encode(array('success' => false, 'message' => 'Missing required fields'));
    }
} else {
    // Invalid request method
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
}
?>
