<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Animal.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  // Get the animal ID and status from the request parameters
  $animalID = $_GET['animalID'];
  $status = $_GET['status'];

  // Update the animal status in the database
  $animal = new Animal($conn);
  $result = $animal->updateAnimalStatus($animalID, $status);

  if ($result) {
    echo json_encode(array('message' => 'Animal status updated successfully.'));
  } else {
    echo json_encode(array('message' => 'Failed to update animal status.'));
  }
} else {
  // Return an error message if the request method is not PUT
  echo json_encode(array('message' => 'Invalid request method.'));
}
?>
