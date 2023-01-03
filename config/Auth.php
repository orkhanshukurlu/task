<?php

class Auth
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->call();
    }

    public function login($email, $password)
    {
        if (! $userData = $this->findUserByUserAndPass($email, $password)) {
            return false;
        }

        Session::put('user', $userData);
        return true;
    }

    public function logout()
    {
        Session::forget('user');
    }

    public function register($username, $email, $password, $role = 1)
    {
        $userId   = $this->createUser($username, $email, $password, $role);
        $userData = $this->findUserById($userId);
        Session::put('user', $userData);
    }

    private function createUser($username, $email, $password, $role)
    {
        $query = $this->db->prepare("
            INSERT INTO users (username, email, password, role) 
            VALUES (:username, :email, :password, :role)
        ");

        $password = md5(sha1($password));

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

    private function findUserByUserAndPass($email, $password)
    {
        $query = $this->db->prepare("
            SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1
        ");

        $password = md5(sha1($password));

        $query->bindParam(':email',    $email);
        $query->bindParam(':password', $password);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}