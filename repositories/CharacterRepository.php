<?php

namespace Repositories;

use Models\Character;

class CharacterRepository extends Repository
{
    public function create(int|null $guildId = null, int $statId): int
    {
        $sql = "INSERT INTO characters (name,hp,level,xp,id_stats,id_guilds) VALUES (:name,:hp,:level,:xp,:id_stats,:id_guilds)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => 'Michel',
            ':hp' => 100,
            ':level' => 1,
            ':xp' => 0,
            ':id_stats' => $statId,
            ':id_guilds' => $guildId
        ]);
        return (int) $this->pdo->lastInsertId();

    }

    public function findByGuildId($guildId): array
    {
        $sql = "SELECT * FROM characters WHERE id_guilds = :guildId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":guildId" => $guildId]);

        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        error_log(print_r($data, true));
        $characters = [];

        foreach ($data as $row) {
            $characters[] = new Character(
                $row['id_characters'],
                $row['name'],
                $row['hp'],
                $row['level'],
                $row['xp'],
                $row['id_stats'],
                null,
            );
        }

        return $characters;
    }
}