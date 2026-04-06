<?php

namespace Repositories;

use Models\Stats;
class StatsRepository extends Repository
{
    public function create(int|null $vit = null, int|null $str = null, int|null $spd = null, int|null $psy = null, int|null $lck = null): int
    {
        $sql = "INSERT INTO stats (vit,str,spd,psy,lck) VALUES (:vit,:str,:spd,:psy,:lck)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':vit' => $vit,
            ':str' => $str,
            ':spd' => $spd,
            ':psy' => $psy,
            ":lck" => $lck
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findById(int $statsId): ?Stats
    {
        $sql = "SELECT * from stats where id_stats = :statsId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':statsId' => $statsId]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Stats($data['id_stats'], $data['vit'], $data['str'], $data['spd'], $data['psy'], $data['lck'], );
    }
}