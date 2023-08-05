<?php

namespace App\Application\CQRS\Command\SignUp;

use App\Domain\ValueObject\Email;

use App\Domain\ValueObject\LastName;

use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use Shared\Domain\IBus\ICommand\CommandInterface;

final class SignUpCommand implements CommandInterface
{
    public function __construct(
        public  FirstName $firstName,
        public  LastName $lastName,
        public  Email $email,
        public  HashedPassword $hashedPassword
    ) {
    }
}
