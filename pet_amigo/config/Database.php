<?php
    class Database{
        //DB Params
        // private means can only use in this class, the Database class
        private $host = 'localhost';
        private $db_name = 'pet_amigo';
        private $username = 'root';  //database username
        private $db_password = 'nb6kNiJsymQASSx4';  //user's password, which is root's password, secured
        private $conn;  //property, to represent the connection

        // DB connect
        public function connect(){
            // set connection property to null
            $this->conn = null;
            
            //using PDO to connect the database
            try{
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->db_password);
                

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;
        }
    }