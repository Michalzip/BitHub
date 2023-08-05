<?php

namespace Shared\Infrastructure\Service\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Shared\Domain\IService\AuthenticationProviderInterace;

class AuthenticationProvider implements AuthenticationProviderInterace
{
    public function __construct(private readonly JWTTokenManagerInterface $JWTManager)
    {
    }

    public function generateToken(string $uuid, string $email, $firstName, $lastName): string
    {
        $auth = Auth::create($uuid, $email, $firstName, $lastName);

        return $this->JWTManager->create($auth);
    }
}
