<?php

namespace UserService\Domain\Entity\User\Repository;

use UserService\Domain\Entity\User\Model\User;

interface UserRepositoryInterface
{
    public function saveUser(User $user): void;
    public function findUserByEmail(string $email): ?User;
}
