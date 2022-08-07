<?php
    Class DbConnect {
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $database = "exads";

        protected function connect() {
            try {
                $database_string = "mysql:host=".$this->host.";dbname=".$this->database;
                $pdo = new PDO($database_string, $this->user, $this->password);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
           
        }
    }