<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class FirstName
{
    #[ORM\Column(name: "first_name")]
    public readonly string $value;
    public function __construct(string $value)
    {
        Assertion::minLength($value, 3, 'Min 3 characters of first name');

        $this->value = $value;

    }

}
