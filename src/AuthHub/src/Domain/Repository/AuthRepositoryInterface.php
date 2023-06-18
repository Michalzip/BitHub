<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Application\Command\SignUp\SignUpCommand;


interface AuthRepositoryInterface
{
    public function createUser(SignUpCommand $command): ?User;
    public function saveUser(User $user) : void;

    public function checkUserExistByEmail(string $email): ?User;
}
