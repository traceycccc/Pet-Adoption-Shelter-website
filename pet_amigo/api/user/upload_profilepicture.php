<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in'));
    exit();
}

// Check if a file was uploaded
if (!isset($_FILES['profilePicture'])) {
    echo json_encode(array('success' => false, 'message' => 'No file uploaded'));
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['ID'];

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

// Get the file details
$file_name = $_FILES['profilePicture']['name'];
$file_tmp = $_FILES['profilePicture']['tmp_name'];
$file_size = $_FILES['profilePicture']['size'];
$file_error = $_FILES['profilePicture']['error'];

// Read the file contents
$file_data = file_get_contents($file_tmp);

// Create a new User instance
$user = new User($conn);
$user->id = $user_id;

// Update the user's profile picture in the database
if ($user->updateProfilePicture($file_name, $file_data)) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'message' => 'Failed to upload profile picture'));
}
?>
