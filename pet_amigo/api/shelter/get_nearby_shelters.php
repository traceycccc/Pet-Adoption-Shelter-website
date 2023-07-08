<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Shelter.php';

// Create a new Database instance and establish the connection
$database = new Database();
$conn = $database->connect();

// Get latitude and longitude from the request parameters
$latitude = $_GET['lat'];
$longitude = $_GET['long'];

// Prepare the SQL query to fetch nearby shelters based on latitude and longitude
$query = "SELECT ShelterID, ShelterName, Address, State, City, (ACOS(SIN(RADIANS(latitude))*SIN(RADIANS(:latitude))+COS(RADIANS(latitude))*COS(RADIANS(:latitude))*COS(RADIANS(longitude)-RADIANS(:longitude)))) * 6371 AS Distance FROM shelter ORDER BY Distance ASC";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bindParam(':latitude', $latitude);
$stmt->bindParam(':longitude', $longitude);
$stmt->execute();

// Fetch the shelter results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the results as JSON
echo json_encode($results);
?>
