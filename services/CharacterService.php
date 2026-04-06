<?php

namespace Services;

use Models\Stats;
use Repositories\CharacterRepository;
use Repositories\StatsRepository;

class CharacterService
{
    public function __construct(private readonly CharacterRepository $characterRepository, private readonly StatsRepository $statsRepository)
    {

    }

    public function getCharacterWithStatsByGuildId(int $guildId): array
    {
        $characters = $this->characterRepository->findByGuildId($guildId);

        foreach ($characters as $character) {
            $character->stats = $this->statsRepository->findById($character->statsId);
        }

        return $characters;
    }

    public function getCharacterStat($characterId): ?Stats
    {
        $stats = $this->statsRepository->findById($characterId);
        return $stats;
    }
}