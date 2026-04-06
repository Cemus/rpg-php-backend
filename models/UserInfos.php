<?php

namespace Models;

class UserInfos
{
    public User $user;
    public ?Guild $guild = null;


    public function __construct(User $user, ?Guild $guild = null)
    {
        $this->user = $user;
        $this->guild = $guild;
    }
}