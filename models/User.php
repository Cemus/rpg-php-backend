<?php

namespace Models;

class User
{
    public int $id;
    public string $username;
    public int|null $guildId = null;

    public function __construct(int $id, string $username, int|null $guildId = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->guildId = $guildId;
    }
}