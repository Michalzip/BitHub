<?php

namespace Domain\ValueObject;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\LastName;

class Credentials
{
    public function __construct(public FirstName $firstName, public LastName $lastName, public Email $email, public HashedPassword $password)
    {
    }
}
