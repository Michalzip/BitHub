<?php

namespace App\Application\CQRS\Command\SignIn;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;
use Shared\Domain\IBus\ICommand\CommandInterface;

class SignInCommand implements CommandInterface
{
    public function __construct(
        public  Email $email,
        public  HashedPassword $hashedPassword
    ) {
    }

}
