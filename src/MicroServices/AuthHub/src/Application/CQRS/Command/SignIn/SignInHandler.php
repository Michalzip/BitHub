<?php

namespace App\Application\CQRS\Command\SignIn;

use App\Domain\Exception\UserNotFound;
use App\Domain\Exception\InvalidAuthCredentials;
use App\Domain\Repository\AuthRepositoryInterface;
use App\Application\CQRS\Command\SignIn\SignInCommand;
use App\Shared\Application\Command\CommandHandlerInterface;

class SignInHandler implements CommandHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function __invoke(SignInCommand $command): void
    {
        $user = $this->authRepository->findUserByEmail($command->email) ?? throw new UserNotFound("User not found");

        $validPassword = $user->verifyPassword($user->getPassword(), $command->hashedPassword);

        if(!$validPassword) {
            throw new InvalidAuthCredentials("invalid credentials");
        }
    }
}
