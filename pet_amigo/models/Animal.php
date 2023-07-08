<?php
class Animal {
    private $conn;
    private $table = 'animal';

    // Animal properties
    public $id;
    public $shelter_id;
    public $status;
    public $animal_name;
    public $gender;
    public $age;
    public $is_vaccinated;
    public $is_spayed;
    public $about;
    public $profile_image;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get available animals
    public function getAvailableAnimals() {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'available'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
