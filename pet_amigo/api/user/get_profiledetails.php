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

    // Get the user details
    $userDetails = $user->getProfileDetails();

    if ($userDetails) {
        echo json_encode($userDetails);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(array('message' => 'User details not found'));
    }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('message' => 'Unable to get user details', 'error' => $e->getMessage()));
    }
?>
