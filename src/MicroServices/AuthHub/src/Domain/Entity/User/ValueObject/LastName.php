<?php

namespace App\Domain\ValueObject;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class LastName
{
    #[ORM\Column(name: "last_name")]

    public readonly string $value;
    public function __construct(string $value)
    {
        Assertion::minLength($value, 6, 'Min 6 characters of last name');
        $this->value = $value;
    }

}
