<?php

namespace App\Application\CQRS\Command\SignUp;

use App\Application\CQRS\Command\SignUp\SignUpCommand;
use App\Domain\Entity\User;
use App\Domain\Exception\EmailAlreadyExistException;
use App\Domain\Repository\AuthRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class SignUpHandler implements CommandHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }
    public function __invoke(SignUpCommand $command): void
    {
        $user = $this->authRepository->findUserByEmail($command->email);

        if (null !== $user) {
            throw new EmailAlreadyExistException("email already exists");
        }

        $userData = new User();
        $userData->setFirstName($command->firstName);
        $userData->setLastName($command->lastName);
        $userData->setEmail($command->email);
        $userData->setHashedPassword($command->hashedPassword);

        $this->authRepository->saveUser($userData);

    }
}
