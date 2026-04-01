<?php

namespace Models;

use Exceptions\GuildNameAlreadyExistsException;

class Guild
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $guildName): int
    {
        if ($this->guildExists($guildName)) {
            throw new GuildNameAlreadyExistsException();
        }


        $sql = "INSERT INTO guilds (name) VALUES (:guildName)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":guildName", $guildName);
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();

    }

    public function guildExists($guildName)
    {
        $sql = "SELECT COUNT(*) FROM guilds WHERE name = :guildName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":guildName", $guildName);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}