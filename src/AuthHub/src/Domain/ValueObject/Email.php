<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;
use JsonSerializable;

class Email implements JsonSerializable, \Stringable
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

    public function __toString(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
