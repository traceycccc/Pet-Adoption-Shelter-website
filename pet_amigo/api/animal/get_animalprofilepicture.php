<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: image/jpeg');

include_once '../../config/Database.php';
include_once '../../models/Animal.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

if (isset($_GET['animalID'])) {
    $animalID = $_GET['animalID'];

    // Fetch shelter profile picture from the database using the $shelterID
    $animal = new Animal($conn);
    $animalPicture = $animal->getAnimalProfilePicture($animalID);

    // Return the shelter profile picture
    echo $animalPicture;
} else {
    // Return a placeholder image if shelterID is not provided
    // Replace 'path_to_placeholder_image.jpg' with the actual path to your placeholder image
    $placeholderImage = file_get_contents('path_to_placeholder_image.jpg');
    echo $placeholderImage;
}
?>
