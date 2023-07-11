<?php

namespace App\Infrastructure\ApiPlatform\Output;

final class JWT
{
    private function __construct(
        public readonly string $token,
    ) {
    }

    public static function formJwtTokenString(string $authToken): JWT
    {
        return new self((string) $authToken);
    }
}
