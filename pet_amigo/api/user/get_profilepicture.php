<?php
    // Allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');


    require_once('../../config/Database.php');
    require_once('../../models/User.php');

    // Check if the user ID is provided as a query parameter
    if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'User ID is missing'));
    exit();
    }

    try {
        $database = new Database();
        $db = $database->connect();

        $user = new User($db);

        // Set the user ID
        $user->id = $_GET['id'];

        // Get the profile picture
        $profilePicture = $user->getProfilePicture();

        if ($profilePicture) {
            // Set the appropriate headers
            header('Content-Type: image/jpeg');
            header('Content-Length: ' . strlen($profilePicture));

            // Output the profile picture
            echo $profilePicture;
        } else {
            http_response_code(404); // Not Found
            echo json_encode(array('message' => 'Profile picture not found'));
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Unable to get profile picture', 'error' => $e->getMessage()));
    }
?>
