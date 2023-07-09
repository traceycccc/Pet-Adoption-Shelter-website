<?php
// login.php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include database and user model
include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate user object
$user = new User($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

try {
    // Set user email and password from request data
    $user->email = $data->email;
    $user->password = $data->password;

    if (empty($user->email) || empty($user->password)) {
        throw new Exception();
    }

    // Attempt login
    if ($user->login()) {
        // Start session
        session_start();
        $_SESSION['ID'] = $user->id;

        // Create response array
        $response = array(
            'message' => 'Login Successful',
            'id' => $user->id
        );

        // Return response as JSON
        echo json_encode($response);
    } else {
        throw new Exception();
    }
} catch (Exception $e) {
    // Handle exceptions
    $response = array(
        'message' => 'Login Failed'
    );

    // Return response as JSON
    echo json_encode($response);
}

?>
