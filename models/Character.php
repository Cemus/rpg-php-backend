<?php

namespace Models;

class Character
{
    public int $id;
    public string $name;
    public int $hp;
    public int $level;
    public int $xp;
    public int $statsId;
    public ?Stats $stats = null;

    public function __construct(int $id, string $name, int $hp, int $level, int $xp, int $statsId, ?Stats $stats = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->hp = $hp;
        $this->level = $level;
        $this->xp = $xp;
        $this->statsId = $statsId;
        $this->stats = $stats;
    }
}