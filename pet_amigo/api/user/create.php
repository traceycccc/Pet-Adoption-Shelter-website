<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new User($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));


    try {
        
        $user->email = $data->email;
        $user->username = $data->username;
        $user->name = $data->name;
        $user->password = $data->password;
        
        if (empty($user->email) || empty($user->username) || empty($user->name) || empty($user->password)) {
            throw new Exception();
        }
        
        // Attempt login
        if ($user->create()) {
            // Start session
            session_start();
            $_SESSION['ID'] = $user->id;
    
            // Create response array
            $response = array(
                'message' => 'User is Created'
            );
    
            // Return response as JSON
            echo json_encode($response);
        } else{
            throw new Exception();
        }
    } catch (Exception $e) {
        // Check if the email already exists
        if ($user->emailExists($user->email)) {
            echo json_encode(
                array('message' => 'The email used to register already exists! Try another email!')
            );
            exit;
        }else{
            echo json_encode(
                array('message' => 'User Not Created')
            );
        }
        
        
        
        
    }
?>
