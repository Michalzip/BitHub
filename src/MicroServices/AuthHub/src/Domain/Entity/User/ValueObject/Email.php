<?php

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;

#[ORM\Embeddable]
final class Email
{
    #[ORM\Column(name: 'email', length: 25)]
    public readonly string $value;
    public function __construct(string $value)
    {
        Assertion::email($value, 'Not a valid email');
        $this->value = $value;

    }

}
