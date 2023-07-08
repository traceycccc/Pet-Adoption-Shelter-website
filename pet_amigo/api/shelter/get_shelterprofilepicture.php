<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: image/jpeg');

include_once '../../config/Database.php';
include_once '../../models/Shelter.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

if (isset($_GET['shelterID'])) {
    $shelterID = $_GET['shelterID'];

    // Fetch shelter profile picture from the database using the $shelterID
    $shelter = new Shelter($conn);
    $shelterPicture = $shelter->getShelterProfilePicture($shelterID);

    // Return the shelter profile picture
    echo $shelterPicture;
} else {
    // Return a placeholder image if shelterID is not provided
    // Replace 'path_to_placeholder_image.jpg' with the actual path to your placeholder image
    $placeholderImage = file_get_contents('path_to_placeholder_image.jpg');
    echo $placeholderImage;
}
?>
