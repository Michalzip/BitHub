<?php

namespace App\Application\Command\SignIn;

use Domain\Exception\UserNotFound;
use App\Application\Command\SignIn\SignInCommand;
use App\Domain\Exception\InvalidAuthCredentials;
use App\Domain\Repository\AuthRepositoryInterface;

class SignInHandler
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function handle(SignInCommand $request)
    {

        $user = $this->authRepository->findUserByEmail($request->getEmail()) ?? throw new UserNotFound("User not found");

        $validResult = $user->verifyPassword($user->getPassword(), $request->getHashedPassword());

        if(!$validResult) {
            throw new InvalidAuthCredentials("invalid credentials");
        }

        //TODO: gerenate jwt token
    }
}
