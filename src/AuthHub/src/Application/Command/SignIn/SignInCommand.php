<?php

namespace App\Application\Command\SignIn;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

class SignInCommand
{
    public readonly Email $email;

    public readonly HashedPassword $hashedPassword;

    public function __construct(string $email, string $password)
    {
        $this->email = Email::fromString($email);

        $this->hashedPassword = HashedPassword::fromString($password);
    }
    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getHashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

}
