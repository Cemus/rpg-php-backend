<?php
namespace Exceptions;

class GuildNameAlreadyExistsException extends \Exception
{
    protected $message = "This guild name is already taken";
    protected $code = 409;
}