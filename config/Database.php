<?php

class Database
{
    private $host = 'localhost';
    private $name = 'task';
    private $user = 'root';
    private $pass = '';

    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->name", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function call()
    {
        return $this->conn;
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}