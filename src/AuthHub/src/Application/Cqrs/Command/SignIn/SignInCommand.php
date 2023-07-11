<?php

namespace App\Application\CQRS\Command\SignIn;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use App\Shared\Application\Command\CommandInterface;

class SignInCommand implements CommandInterface
{
    public readonly Email $email;

    public readonly HashedPassword $hashedPassword;

    public function __construct(string $email, string $password)
    {
        $this->email = Email::fromString($email);

        $this->hashedPassword = HashedPassword::fromString($password);
    }

}
