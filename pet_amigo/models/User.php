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
            // Query to check if the user exists with the given email
            $query = "SELECT * FROM users WHERE email = :email";
        
            // Prepare the query
            $stmt = $this->conn->prepare($query);
        
            // Bind the email parameter
            $stmt->bindParam(':email', $this->email);
        
            // Execute the query
            $stmt->execute();
        
            // Check if a user was found
            if ($stmt->rowCount() > 0) {
                // Fetch the user record
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                // Verify the entered password with the hashed password
                if (password_verify($this->password, $row['password'])) {
                    // Set the user properties
                    $this->id = $row['id'];
                    // Set other relevant user properties
        
                    return true; // Login successful
                }
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
        

        public function getProfileDetails() {
            $query = 'SELECT username, name, email, contacts, about FROM users WHERE id = :id';
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
    
            //return $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row;
                }
    
                return null;
        }

        // Update the user's profile details
        // Update user profile details
        public function updateProfileDetails() {
            // Query
            $query = 'UPDATE ' . $this->table . '
                    SET
                        username = :username,
                        name = :name,
                        email = :email,
                        contacts = :contacts,
                        about = :about
                    WHERE
                        id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->contacts = htmlspecialchars(strip_tags($this->contacts));
            $this->about = htmlspecialchars(strip_tags($this->about));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':contacts', $this->contacts);
            $stmt->bindParam(':about', $this->about);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update the user's profile picture in the database
        public function updateProfilePicture($file_name, $file_data) {
            // Query
            $query = 'UPDATE ' . $this->table . ' SET profile_picture = :profile_picture WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $file_name = htmlspecialchars(strip_tags($file_name));

            // Bind data
            $stmt->bindParam(':profile_picture', $file_data, PDO::PARAM_LOB);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }


        // Method to reset the user's password
        public function resetPassword($email, $password) {
            // Check if the user with the given email exists
            $query = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
            // User not found
            return false;
            }

            // Update the user's password
            $query = 'UPDATE users SET password = :password WHERE email = :email';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
            // Password updated successfully
            return true;
            } else {
            // Password update failed
            return false;
            }
        }
        

       
    }
?>
