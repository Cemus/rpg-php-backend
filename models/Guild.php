<?php

namespace Models;

class Guild
{
    public int $id;
    public string $name;
    public int $gold;

    /** @var Character[] */
    public array $characters = [];

    public function __construct(int $id, string $name, int $gold, array $characters = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->gold = $gold;
        $this->characters = $characters;
    }
}