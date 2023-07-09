<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new User($db);

    // User details query
    $result = $user->read();
    $num = $result->rowCount();

    if ($num > 0) {
        $users_arr = array();
        $users_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_item = array(
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'contacts' => $contacts,
                'profile_picture' => $profile_picture,
                'about' => $about
            );

            array_push($users_arr['data'], $user_item);
        }

        echo json_encode($users_arr);
    } else {
        echo json_encode(
            array('message' => 'No Users Found')
        );
    }
?>
