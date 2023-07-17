<?php

namespace App\Infrastructure\Service\Auth;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class Auth implements UserInterface, PasswordHasherAwareInterface, PasswordAuthenticatedUserInterface, \Stringable
{
    private function __construct(private readonly string $uuid, private readonly Email $email, private readonly HashedPassword $hashedPassword)
    {
    }

    public static function create(string $uuid, Email $email, HashedPassword $hashedPassword): self
    {
        return new self($uuid, $email, $hashedPassword);
    }
    public function getUserIdentifier(): string
    {
        return $this->email->toString();
    }
    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt(): ?string
    {
        return null;
    }


    public function eraseCredentials(): void
    {
        // noop
    }
    public function getPassword(): string
    {
        return $this->hashedPassword->toString();
    }

    public function getPasswordHasherName(): string
    {
        return 'hasher';
    }

    public function __toString(): string
    {
        return $this->email->toString();
    }
}
