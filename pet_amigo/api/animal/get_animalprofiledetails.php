<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Animal.php';


// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

if (isset($_GET['animalID'])) {
    $animalID = $_GET['animalID'];

    // Fetch animal profile details from the database using the $animalID
    $animal = new Animal($conn);
    $animalDetails = $animal->getAnimalProfileDetails($animalID);

    
    if ($animalDetails) {
        $response = array(
            'AnimalID' => $animalDetails['AnimalID'],
            'ShelterID' => $animalDetails['ShelterID'],
            'ShelterName' => $animalDetails['ShelterName'],
            'Status' => $animalDetails['Status'],
            'AnimalName' => $animalDetails['AnimalName'],
            'Gender' => $animalDetails['Gender'],
            'Age' => $animalDetails['Age'],
            'IsVaccinated' => $animalDetails['IsVaccinated'],
            'IsSpayed' => $animalDetails['IsSpayed'],
            'About' => $animalDetails['About']
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('message' => 'Animal not found.'));
    }


   
} else {
    // Return an error message if animalID is not provided
    echo json_encode(array('message' => 'Animal ID not specified.'));
}
?>
