<?php

namespace Shared\Domain\IService;

interface TokenExpirationCheckerInterface
{
    public function isTokenCloseToExpiration(array $payload): bool;
}
