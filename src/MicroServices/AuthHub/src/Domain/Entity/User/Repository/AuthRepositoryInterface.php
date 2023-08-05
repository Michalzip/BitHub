<?php

namespace App\Domain\Entity\User\Repository;

use App\Domain\ValueObject\Email;
use App\Domain\Entity\User\Model\User;

interface AuthRepositoryInterface
{
    public function saveUser(User $user): void;
    public function getCredentialsByEmail(Email $email): array;
    public function findUserByEmail(Email $email): ?User;
}
