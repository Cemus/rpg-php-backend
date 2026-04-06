<?php

namespace Repositories;

abstract class Repository
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }
}