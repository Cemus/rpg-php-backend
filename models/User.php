<?php

namespace Models;
use Exceptions\UserAlreadyExistsException;
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $username, string $password): int
    {
        if ($this->userExists($username)) {
            throw new UserAlreadyExistsException();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username,password) VALUES (:username,:password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();

    }

    public function userExists($username)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}