<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Shelter.php';


// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

if (isset($_GET['shelterID'])) {
    $shelterID = $_GET['shelterID'];

    // Fetch shelter profile details from the database using the $shelterID
    $shelter = new Shelter($conn);
    $shelterDetails = $shelter->getShelterProfileDetails($shelterID);


    if ($shelterDetails) {
        $response = array(
            'ShelterID' => $shelterDetails['ShelterID'],
            'ShelterName' => $shelterDetails['ShelterName'],
            'OwnerName' => $shelterDetails['OwnerName'],
            'Contacts' => $shelterDetails['Contacts'],
            'ShelterEmail' => $shelterDetails['ShelterEmail'],
            'Address' => $shelterDetails['Address'],
            'City' => $shelterDetails['City'],
            'State' => $shelterDetails['State'],
            'About' => $shelterDetails['About']
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('message' => 'Shelter not found.'));
    }


    // Return the shelter profile details as JSON response
    //echo json_encode($shelterDetails);
} else {
    // Return an error message if shelterID is not provided
    echo json_encode(array('message' => 'Shelter ID not specified.'));
}
?>
