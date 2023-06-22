<?php

namespace App\Application\Command\SignUp;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\LastName;

class SignUpCommand
{
    public readonly FirstName $firstName;
    public readonly LastName $lastName;
    public readonly Email $email;
    public readonly HashedPassword $hashedPassword;

    public function __construct(string $firstName, string $lastName, string $email, string $plainPassword)
    {
        $this->firstName = FirstName::fromString($firstName);
        $this->lastName = LastName::fromString($lastName);
        $this->email  = Email::fromString($email);
        $this->hashedPassword = HashedPassword::encode($plainPassword);
    }
}
