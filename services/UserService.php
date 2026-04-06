<?php

namespace Services;

use Models\UserInfos;
use Repositories\UserRepository;
use Repositories\GuildRepository;
use Repositories\CharacterRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly GuildRepository $guildRepository,
        private readonly CharacterRepository $characterRepository,
        private readonly CharacterService $characterService
    ) {
    }

    public function getUserInfos(int $userId): UserInfos
    {
        $user = $this->userRepository->findById($userId);
        $guildId = $user->guildId;

        if ($guildId) {
            $guild = $this->guildRepository->findById($user->guildId);
            $characters = $this->characterService->getCharacterWithStatsByGuildId($guild->id);
            $guild->characters = $characters;
            return new UserInfos($user, $guild);

        }

        return new UserInfos($user);

    }

    public function associateGuild(int $userId, int $guildId): bool
    {
        $result = $this->userRepository->updateGuildId($userId, $guildId);
        return $result;
    }

    public function hasGuild(int $userId): bool
    {
        return $this->userRepository->hasGuild($userId);
    }


}