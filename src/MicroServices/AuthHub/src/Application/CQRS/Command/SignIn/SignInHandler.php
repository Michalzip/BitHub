<?php

namespace App\Application\CQRS\Command\SignIn;

use App\Domain\Exception\UserNotFound;
use App\Domain\Exception\InvalidAuthCredentials;
use Shared\Infrastructure\Service\Redis\RedisClient;
use App\Application\CQRS\Command\SignIn\SignInCommand;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use App\Domain\Entity\User\Repository\AuthRepositoryInterface;

final class SignInHandler implements CommandHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository, private RedisClient $client)
    {
    }

    public function __invoke(SignInCommand $command): void
    {

        $user = $this->authRepository->findUserByEmail($command->email) ?? throw new UserNotFound();

        $validPassword = $user->verifyPassword($user->getPassword(), $command->hashedPassword);

        if(!$validPassword) {
            throw new InvalidAuthCredentials();
        }
    }
}
