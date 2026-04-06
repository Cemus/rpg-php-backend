<?php
namespace Controllers;

use Config\Request;
use Services\GuildService;
use Services\UserService;

class GuildController
{

    public function __construct(private readonly GuildService $guildService, private readonly UserService $userService)
    {
    }

    public function createGuild(Request $request): bool
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $guildName = $input['guildName'] ?? '';

            if (!$guildName) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Guild name required']);
                throw new \Exception('Guild name required');
            }

            $userId = $request->user->sub;
            $userHasGuild = $this->userService->hasGuild($userId);

            if ($userHasGuild) {
                throw new \Exception("User already has a guild");
            }

            $guildId = $this->guildService->createGuildWithCharacter($guildName);
            $this->userService->associateGuild($userId, $guildId);

            echo json_encode([
                'status' => 'success',
                'guildId' => $guildId,
            ]);

            return true;

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            return false;
        }
    }
}