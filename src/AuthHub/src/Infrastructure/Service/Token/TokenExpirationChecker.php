<?php

namespace App\Infrastructure\Service\Token;

use App\Domain\IService\Token\TokenExpirationCheckerInterface;

class TokenExpirationChecker implements TokenExpirationCheckerInterface
{
    public const REFRESH_TIME = 1800;

    public function isTokenCloseToExpiration(array $payload): bool
    {
        $expireTime = $payload['exp'] - time();
        return $expireTime < static::REFRESH_TIME;
    }
}
