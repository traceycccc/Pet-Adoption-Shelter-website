<?php
class Animal {
    private $conn;
    private $table = 'animal';

    // Animal properties
    public $ID;
    public $ShelterID;
    public $Status;
    public $AnimalName;
    public $Gender;
    public $Age;
    public $IsVaccinated;
    public $IsSpayed;
    public $About;
    public $ProfileImage;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAnimalProfileDetails($animalID)
    {
        
        $query = "SELECT a.AnimalID, a.ShelterID, s.ShelterName, a.Status, a.AnimalName, a.Gender, a.Age, a.IsVaccinated, a.IsSpayed, a.About 
            FROM animal a
            JOIN shelter s ON a.ShelterID = s.ShelterID
            WHERE a.AnimalID = :animalID";


        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':animalID', $animalID);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get shelter profile picture by shelterID
    public function getAnimalProfilePicture($animalID)
    {
        $query = "SELECT ProfileImage FROM animal WHERE AnimalID = :animalID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':animalID', $animalID);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function updateAnimalStatus($animalID, $status)
    {
        $query = "UPDATE animal SET Status = :status WHERE AnimalID = :animalID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':animalID', $animalID);

        return $stmt->execute();
    }

}

?>
