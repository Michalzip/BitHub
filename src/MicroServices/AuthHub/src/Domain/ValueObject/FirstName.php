<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;

class FirstName
{

    public function __construct(private readonly string $firstName)
    {
    }
    public static function fromString(string $firstName): self
    {
        Assertion::minLength($firstName, 3, 'Min 3 characters of first name');

        return new self($firstName);

    }

    public function toString(): string
    {
        return $this->firstName;
    }
}
