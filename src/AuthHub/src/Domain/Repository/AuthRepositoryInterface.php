<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Application\Command\SignUp\SignUpCommand;

interface AuthRepositoryInterface
{
    public function saveUser(User $user): void;
    public function findUserByEmail(Email $email): ?User;
}
