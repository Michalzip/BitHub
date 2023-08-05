<?php

namespace Shared\Infrastructure\Service\Token;

use Shared\Domain\IService\TokenExpirationCheckerInterface;

class TokenExpirationChecker implements TokenExpirationCheckerInterface
{
    public const REFRESH_TIME = 1600;

    public function __construct()
    {
    }

    public function isTokenCloseToExpiration(array $payload): bool
    {
        $expireTime = $payload['exp'] - time();
        return $expireTime < static::REFRESH_TIME;
    }
}
