<?php
class Shelter {
    private $conn;
    private $table = 'shelter';

    // Shelter properties
    public $id;
    public $shelter_name;
    public $owner_name;
    public $contacts;
    public $shelter_email;
    public $address;
    public $state;
    public $city;
    public $profile_image;
    public $about;
    public $latitude;
    public $longitude;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get shelter profile details by shelterID
    public function getShelterProfileDetails($shelterID)
    {
        
        $query = "SELECT ShelterID, ShelterName, OwnerName, Contacts, ShelterEmail, Address, City, State, About FROM shelter WHERE ShelterID = :shelterID";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shelterID', $shelterID);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get shelter profile picture by shelterID
    public function getShelterProfilePicture($shelterID)
    {
        $query = "SELECT ProfileImage FROM shelter WHERE ShelterID = :shelterID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':shelterID', $shelterID);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    
}
?>
