<?php
namespace Exceptions;

class UserAlreadyExistsException extends \Exception
{
    protected $message = "User already exists";
    protected $code = 409;
}