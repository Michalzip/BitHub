<?php

namespace App\Application\CQRS\Command\SignUp;

use App\Domain\Entity\User\Model\User;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\Exception\EmailAlreadyExistException;
use App\Application\CQRS\Command\SignUp\SignUpCommand;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use App\Domain\Entity\User\Repository\AuthRepositoryInterface;

final class SignUpHandler implements CommandHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }
    public function __invoke(SignUpCommand $command): User
    {
        $user = $this->authRepository->findUserByEmail($command->email);

        if (null !== $user) {
            throw new EmailAlreadyExistException();
        }

        $userData = new User(
            $command->firstName,
            $command->lastName,
            $command->email,
            HashedPassword::encode($command->hashedPassword->value)
        );


        $this->authRepository->saveUser($userData);

        return $userData;

    }
}
