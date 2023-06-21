<?php

namespace App\Domain\Repository;

use App\Application\Command\SignUp\SignUpCommand;
use App\Domain\Entity\User;

interface AuthRepositoryInterface
{
    public function saveUser(User $user): void;
    public function findUserByEmail(string $email): ?User;
}
