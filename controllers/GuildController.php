<?php
namespace Controllers;

use Models\User;

class GuildController
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }
}