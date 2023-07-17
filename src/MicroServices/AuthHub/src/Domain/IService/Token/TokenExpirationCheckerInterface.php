<?php

namespace App\Domain\IService\Token;

interface TokenExpirationCheckerInterface
{
    public function isTokenCloseToExpiration(array $payload): bool;
}
