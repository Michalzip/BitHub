<?php

namespace App\Domain\ValueObject;

class HashedPassword implements \Stringable
{

    private function __construct(private readonly string $hashedPassword)
    {
    }
    
    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
