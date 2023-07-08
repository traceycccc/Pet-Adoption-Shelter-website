<?php
    class User {
        private $conn;
        private $table = 'users';

        // User properties
        public $id;
        public $email;
        public $username;
        public $name;
        public $password;
        public $contacts;
        public $profile_picture;
        public $about;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Create user
        public function create() {
            // Query
            $query = 'INSERT INTO ' . $this->table . '
                    SET
                        email = :email,
                        username = :username,
                        name = :name,
                        password = :password';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // Bind data
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':password', $this->password);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }


        // Check if email exists in the database
        public function emailExists($email) {
            // Query
            $query = 'SELECT id FROM ' . $this->table . ' WHERE email = :email';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $email = htmlspecialchars(strip_tags($email));

            // Bind data
            $stmt->bindParam(':email', $email);

            // Execute query
            $stmt->execute();

            // Check if email exists
            if ($stmt->rowCount() > 0) {
                return true;
            }

            return false;
        }
        // Read user details
        public function read() {
            // Query
            $query = 'SELECT 
                        username, 
                        name, 
                        email, 
                        contacts, 
                        profile_picture, 
                        about 
                    FROM 
                        ' . $this->table;

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
        
        

        public function login() {
            // Query to check if the user exists with the given email and password
            $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        
            // Prepare the query
            $stmt = $this->conn->prepare($query);
        
            // Bind the parameters
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
        
            // Execute the query
            $stmt->execute();
        
            // Check if a user was found
            if ($stmt->rowCount() > 0) {
                // Fetch the user record
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                // Set the user properties
                $this->id = $row['id'];
                // Set other relevant user properties
        
                return true; // Login successful
            }
        
            return false; // Login failed
        }
        


        // Get the profile picture for the user
        public function getProfilePicture()
        {
            $query = 'SELECT profile_picture FROM users WHERE id = ?';

            $stmt = $this->conn->prepare($query);

            // Bind the user ID parameter
            $stmt->bindParam(1, $this->id);

            // Execute the query
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['profile_picture'];
            }

            return null;
        }

        // Get the profile details for the user
        public function getProfileDetails()
        {
            $query = 'SELECT username, name, email, contacts, about FROM users WHERE id = ?';

            $stmt = $this->conn->prepare($query);

            // Bind the user ID parameter
            $stmt->bindParam(1, $this->id);

            // Execute the query
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
            }

            return null;
        }

       
    }
?>
