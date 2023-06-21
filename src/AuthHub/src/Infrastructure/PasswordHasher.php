<?php

namespace App\Infrastructure;

class PasswordHasher
{

    private string $hasher = HashedPassword::class;

    public function hash(string $plainPassword): string
    {
        return $this->hasher::encode($plainPassword)->toString();
    }

    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $this->hasher::fromHash($hashedPassword)->match($plainPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }
}
