<?php

namespace App\Infrastructure\Service\Auth;

use Exception;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\Auth\Auth;
use App\Infrastructure\Repository\AuthRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class AuthProvider implements UserProviderInterface
{
    public function __construct(private readonly AuthRepository $userReadModelRepository)
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {
            [$id, $email, $hashedPassword] = $this->userReadModelRepository->getCredentialsByEmail(
                Email::fromString($identifier)
            );

            return Auth::create($id, $email, $hashedPassword);

        } catch (Exception) {
            throw new UserNotFoundException();
        }

    }

    public function loadUserByUsername(string $email): UserInterface
    {
        [$uuid, $email, $hashedPassword] = $this->userReadModelRepository->getCredentialsByEmail(
            Email::fromString($email)
        );

        return Auth::create($uuid, $email, $hashedPassword);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByUsername($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return Auth::class === $class;
    }
}
