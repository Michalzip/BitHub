<?php

namespace App\Application\Command\SignUp;

use App\Application\Command\SignUp\SignUpCommand;
use App\Domain\Entity\User;
use App\Domain\Exception\EmailAlreadyExistException;
use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class SignUpHandler
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function SignUp(SignUpCommand $command)
    {

        $userData = User::create($command->credentials);

        $validData = $this->authRepository->findUserByEmail($userData->getEmail());

        if (null !== $validData) {
            throw new EmailAlreadyExistException("email already exists", Response::HTTP_CONFLICT);
        }

        $this->authRepository->saveUser($userData);

    }
}
