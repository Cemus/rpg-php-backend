<?php

namespace Repositories;

use Exceptions\GuildNameAlreadyExistsException;
use Models\Guild;

class GuildRepository extends Repository
{
    public function create(string $guildName): int
    {
        if ($this->guildExists($guildName)) {
            throw new GuildNameAlreadyExistsException();
        }

        $sql = "INSERT INTO guilds (name,gold) VALUES (:guildName,:gold)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':guildName' => $guildName,
            ':gold' => 1000
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function guildExists(string $guildName): bool
    {
        $sql = "SELECT COUNT(*) FROM guilds WHERE name = :guildName";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([":guildName" => $guildName]);

        return $stmt->fetchColumn() > 0;
    }

    public function findById(int $guildId): ?Guild
    {
        $sql = "SELECT id_guilds, name, gold from guilds where id_guilds = :guildId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":guildId" => $guildId]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Guild($data['id_guilds'], $data['name'], $data['gold']);
    }



}