<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Animal.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

// Fetch animals with status 'available' from the database
$animal = new Animal($conn);
$animals = $animal->getAvailableAnimals();

// Return the animals as JSON response
echo json_encode($animals);
?>
