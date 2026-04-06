<?php

namespace Exceptions;

class UserNotFoundException extends \Exception
{
    protected $message = "User not found";
    protected $code = 404;
}