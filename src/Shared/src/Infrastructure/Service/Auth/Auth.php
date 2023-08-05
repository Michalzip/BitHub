<?php

namespace Shared\Infrastructure\Service\Auth;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;

class Auth implements UserInterface, PasswordHasherAwareInterface, \Stringable
{
    private function __construct(private  readonly string $uuid, private readonly string $email, private readonly string $firstName, private readonly string $lastName)
    {
    }

    public static function create(string $uuid, string $email, string $firstName, string $lastName): self
    {
        return new self($uuid, $email, $firstName, $lastName);
    }

    public static function toModel(){}

    public function getId(): ?string
    {
        return $this->uuid;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
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

    public function getPasswordHasherName(): string
    {
        return 'hasher';
    }
    public function __toString(): string
    {
        return $this->email;
    }
}
