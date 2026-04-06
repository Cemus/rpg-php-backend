<?php
namespace Exceptions;

class InvalidPasswordException extends \Exception
{
    protected $message = "Password is incorrect";
    protected $code = 401;
}