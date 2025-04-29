<?php

namespace Service;

use mysqli;

class Database
{
    private $host = "sql5.freesqldatabase.com";
    private $username = "sql5775922";
    private $password = "5RjFzXncPn";
    private $database = "sql5775922";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("❌ Database connection failed: " . $this->conn->connect_error);
        }
    }
}
