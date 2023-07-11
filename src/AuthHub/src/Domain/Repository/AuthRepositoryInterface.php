<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;

interface AuthRepositoryInterface
{
    public function saveUser(User $user): void;
    public function getCredentialsByEmail(Email $email): array;
    public function findUserByEmail(string $email): ?User;
}
