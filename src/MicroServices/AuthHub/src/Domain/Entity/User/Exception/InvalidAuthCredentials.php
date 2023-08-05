<?php

namespace App\Domain\Exception;

final class InvalidAuthCredentials extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid Credentials');
    }
}
