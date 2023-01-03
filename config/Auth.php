<?php

class Auth
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->call();
    }

    public function login($username, $password)
    {
    }

    public function register($username, $email, $password, $role = 1)
    {
        $userId   = $this->createUser($username, $email, $password, $role);
        $userData = $this->findUserById($userId);
        Session::put('user', $userData);
        return $userData;
    }

    private function createUser($username, $email, $password, $role)
    {
        $query = $this->db->prepare("
            INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)
        ");

        $password = md5($password);

        $query->bindParam(':username', $username);
        $query->bindParam(':email',    $email);
        $query->bindParam(':password', $password);
        $query->bindParam(':role',     $role);
        $query->execute();
        return $this->db->lastInsertId();
    }

    private function findUserById($userId)
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $query->bindParam(':id', $userId);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}