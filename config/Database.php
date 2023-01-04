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

    public function createCompany($name)
    {
        $query = $this->conn->prepare("INSERT INTO companies (name) VALUES (:name)");
        $query->bindParam(':name', $name);
        $query->execute();
        return $this->conn->lastInsertId();
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

    public function editUser($id, $username, $email, $password = null, $phone = null)
    {
        if (is_null($password)) {
            $query = $this->conn->prepare("
                UPDATE users 
                SET username = :username, email = :email, phone = :phone
                WHERE id = :id
            ");

            $query->bindParam(':username', $username);
            $query->bindParam(':email',    $email);
            $query->bindParam(':phone',    $phone);
            $query->bindParam(':id',       $id);
        } else {
            $query = $this->conn->prepare("
                UPDATE users 
                SET username = :username, email = :email, password = :password, phone = :phone
                WHERE id = :id
            ");

            $password = md5(sha1($password));

            $query->bindParam(':username', $username);
            $query->bindParam(':email',    $email);
            $query->bindParam(':password', $password);
            $query->bindParam(':phone',    $phone);
            $query->bindParam(':id',       $id);
        }

        $query->execute();
        $user = $this->findUserById($id);
        Session::forget('user');
        Session::put('user', $user);
        return $user;
    }

    public function findUserById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
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

    public function getUsers()
    {
        $query = $this->conn->prepare("
            SELECT u.id, u.username, u.phone, sum(p.price) price
            FROM users u
            LEFT JOIN payments p ON p.user_id = u.id
            WHERE p.status = 1
        ");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserPayment()
    {
        $query = $this->conn->prepare("
            SELECT sum(p.price) price
            FROM users u
            LEFT JOIN payments p ON p.user_id = u.id
            WHERE u.id = :id AND p.status = 1
        ");

        $query->bindParam(':id', user()->id);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}