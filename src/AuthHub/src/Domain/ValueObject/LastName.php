<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;

class LastName
{

    public function __construct(private readonly string $lastName)
    {
    }
    public static function fromString(string $lastName): self
    {
        Assertion::minLength($lastName, 6, 'Min 6 characters of last name');

        return new self($lastName);

    }

    public function toString(): string
    {
        return $this->lastName;
    }
}
