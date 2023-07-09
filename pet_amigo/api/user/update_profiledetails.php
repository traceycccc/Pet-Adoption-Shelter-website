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
    if (
        isset($data->username) &&
        isset($data->name) &&
        isset($data->email) &&
        isset($data->contacts) &&
        isset($data->about)
    ) {
        // Create a new User instance
        $user = new User($conn);
        
        // Get the user ID from the session
        if (isset($_SESSION['ID'])) {
            $user->id = $_SESSION['ID'];

            // Assign the updated values
            $user->username = $data->username;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->contacts = $data->contacts;
            $user->about = $data->about;

            // Update the user's profile details
            if ($user->updateProfileDetails()) {
                // Profile details updated successfully
                echo json_encode(array('success' => true));
            } else {
                // Failed to update profile details
                echo json_encode(array('success' => false));
            }
        } else {
            // User ID not found in session
            echo json_encode(array('success' => false, 'message' => 'User ID not found in session'));
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
