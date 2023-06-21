<?php

namespace App\Application\Command\SignUp;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\LastName;
use Domain\ValueObject\Credentials;

class SignUpCommand
{
    public Credentials $credentials;

    public function __construct(string $firstName, string $lastName, string $email, string $plainPassword)
    {
        $this->credentials = new Credentials(FirstName::fromString($firstName), LastName::fromString($lastName), Email::fromString($email), HashedPassword::encode($plainPassword));
    }
}
