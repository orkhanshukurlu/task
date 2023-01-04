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

    public function createPayment($userId, $price, $image, $status = 2)
    {
        $query = $this->conn->prepare("
            INSERT INTO payments (user_id, price, image, status) 
            VALUES (:user_id, :price, :image, :status)
        ");

        $query->bindParam(':user_id', $userId);
        $query->bindParam(':price',   $price);
        $query->bindParam(':image',   $image);
        $query->bindParam(':status',  $status);
        $query->execute();
        return $this->conn->lastInsertId();
    }

    public function editPayment($id, $status)
    {
        $query = $this->conn->prepare("UPDATE payments SET status = :status WHERE id = :id");
        $query->bindParam(':status', $status);
        $query->bindParam(':id',     $id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPayments()
    {
        if (user()->role == 2) {
            $query = $this->conn->prepare("
                SELECT p.id, u.username, p.image, p.status
                FROM payments p 
                LEFT JOIN users u ON p.user_id = u.id
                ORDER BY p.id DESC
            ");
        } else {
            $query = $this->conn->prepare("
                SELECT p.id, u.username, p.image, p.status
                FROM payments p 
                LEFT JOIN users u ON p.user_id = u.id
                WHERE u.id = :id
                ORDER BY p.id DESC
            ");

            $query->bindParam(':id', user()->id);
        }

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}