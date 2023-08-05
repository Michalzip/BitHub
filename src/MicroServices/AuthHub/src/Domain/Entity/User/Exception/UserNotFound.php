<?php

namespace App\Domain\Exception;

use Shared\Domain\Exception\NotFoundException;

final class UserNotFound extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('User Not Found');
    }
}
