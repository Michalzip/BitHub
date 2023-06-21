<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;

class Email
{
    private function __construct(private readonly string $email)
    {
    }

    public static function fromString(string $email): self
    {
        Assertion::email($email, 'Not a valid email');

        return new self($email);
    }

    public function toString(): string
    {
        return $this->email;
    }
}
