<?php

namespace Models;

class Stats
{
    public int $id;
    public int $vit;
    public int $str;
    public int $spd;
    public int $psy;
    public int $lck;

    public function __construct(int $id, int $vit, int $str, int $spd, int $psy, int $lck)
    {
        $this->id = $id;
        $this->vit = $vit;
        $this->str = $str;
        $this->spd = $spd;
        $this->psy = $psy;
        $this->lck = $lck;
    }

}