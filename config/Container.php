<?php

namespace Config;

use Controllers\UserController;
use Controllers\GuildController;
use Repositories\StatsRepository;
use Repositories\UserRepository;
use Repositories\GuildRepository;
use Repositories\CharacterRepository;
use Services\CharacterService;
use Services\UserService;
use Services\GuildService;

class Container
{
    private static $pdo = null;

    private static function getPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = Database::connect();
        }

        return self::$pdo;
    }

    public static function getUserController(): UserController
    {
        $pdo = self::getPDO();

        $userRepository = new UserRepository($pdo);
        $guildRepository = new GuildRepository($pdo);
        $characterRepository = new CharacterRepository($pdo);
        $statsRepository = new StatsRepository($pdo);
        $characterService = new CharacterService($characterRepository, $statsRepository);

        $userService = new UserService(
            $userRepository,
            $guildRepository,
            $characterRepository,
            $characterService,
        );

        return new UserController($userRepository, $userService);
    }

    public static function getGuildController(): GuildController
    {
        $pdo = self::getPDO();

        $guildRepository = new GuildRepository($pdo);
        $statsRepository = new StatsRepository($pdo);
        $characterRepository = new CharacterRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $guildService = new GuildService($guildRepository, $statsRepository, $characterRepository);
        $characterService = new CharacterService($characterRepository, $statsRepository);

        $userService = new UserService(
            $userRepository,
            $guildRepository,
            $characterRepository,
            $characterService,
        );

        return new GuildController($guildService, $userService);
    }
}
