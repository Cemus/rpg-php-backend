<?php

namespace Services;

use Repositories\CharacterRepository;
use Repositories\GuildRepository;
use Repositories\StatsRepository;

class GuildService
{
    private GuildRepository $guildRepository;
    private StatsRepository $statsRepository;
    private CharacterRepository $characterRepository;

    public function __construct(GuildRepository $guildRepository, StatsRepository $statsRepository, CharacterRepository $characterRepository)
    {
        $this->guildRepository = $guildRepository;
        $this->statsRepository = $statsRepository;
        $this->characterRepository = $characterRepository;
    }

    public function createGuildWithCharacter(string $guildName): int
    {
        $this->guildRepository->getPDO()->beginTransaction();

        try {
            $guildId = $this->guildRepository->create($guildName);

            $statId = $this->statsRepository->create(10, 10, 10, 10, 10);
            $this->characterRepository->create(guildId: $guildId, statId: $statId);

            $this->guildRepository->getPDO()->commit();

            return $guildId;
        } catch (\Exception $e) {
            $this->guildRepository->getPDO()->rollBack();
            throw $e;
        }
    }
}