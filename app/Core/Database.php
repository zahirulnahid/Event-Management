<?php

class Database
{
    private $host = "localhost";
    private $user = "root";  // Change this if needed
    private $pass = "";      // Change this if needed
    private $dbname = "event_management";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>
