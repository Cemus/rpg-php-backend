<?php

namespace Repositories;
use Exceptions\InvalidPasswordException;
use Exceptions\UserAlreadyExistsException;
use Exceptions\UserNotFoundException;
use Models\User;
class UserRepository extends Repository
{
    public function create(string $username, string $password): int
    {
        if ($this->userExists($username)) {
            throw new UserAlreadyExistsException();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username,password,created_at, updated_at) VALUES (:username,:password,NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([":username" => $username, ":password" => $hashedPassword]);

        return (int) $this->pdo->lastInsertId();
    }

    public function userExists(string $username): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([":username" => $username]);

        return $stmt->fetchColumn() > 0;
    }

    public function verify(string $username, string $password): int
    {
        $sql = "SELECT id_users, password FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":username" => $username]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            throw new UserNotFoundException();
        }

        if (!password_verify($password, $row['password'])) {
            throw new InvalidPasswordException();
        }

        return (int) $row['id_users'];
    }

    public function findById(int $id): ?User
    {
        $sql = "SELECT id_users, username, id_guilds from users WHERE id_users = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new User(
            $data['id_users'],
            $data['username'],
            $data['id_guilds'],
        );
    }

    public function updateGuildId(int $userId, int $guildId): bool
    {
        $sql = 'UPDATE users 
                SET id_guilds = :guildId, updated_at = NOW()
                WHERE id_users = :userId';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userId' => $userId, ':guildId' => $guildId]);

        return true;
    }

    public function hasGuild(int $userId): bool
    {
        $sql = 'SELECT id_guilds from users WHERE id_users = :userId AND id_guilds IS NOT NULL';
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([":userId" => $userId]);

        return $stmt->fetchColumn() > 0;
    }
}