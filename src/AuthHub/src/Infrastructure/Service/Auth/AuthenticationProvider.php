<?php

namespace App\Infrastructure\Service\Auth;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\IService\Auth\AuthenticationProviderInterace;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthenticationProvider implements AuthenticationProviderInterace
{
    public function __construct(private readonly JWTTokenManagerInterface $JWTManager)
    {
    }

    public function generateToken(string $uuid, Email $email, HashedPassword $hashedPassword): string
    {
        $auth = Auth::create($uuid, $email, $hashedPassword);

        return $this->JWTManager->create($auth);
    }
}
