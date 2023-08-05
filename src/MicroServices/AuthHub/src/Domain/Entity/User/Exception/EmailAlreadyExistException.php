<?php

namespace App\Domain\Exception;

class EmailAlreadyExistException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Email Already Exist');
    }
}
