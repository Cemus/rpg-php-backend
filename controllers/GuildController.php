<?php
namespace Controllers;

use Models\Guild;

class GuildController
{
    private $guildModel;

    public function __construct(Guild $guildModel)
    {
        $this->guildModel = $guildModel;
    }
}