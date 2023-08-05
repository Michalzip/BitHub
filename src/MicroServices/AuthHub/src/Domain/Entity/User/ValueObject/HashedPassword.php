<?php

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use RuntimeException;

#[ORM\Embeddable]
final class HashedPassword
{
    #[ORM\Column(name: "hashed_password")]
    public readonly string $value;
    public const COST = 12;
    public function __construct(string $value)
    {
        Assertion::minLength($value, 6, 'Min 6 characters password');

        $this->value = $value;
    }

    public static function encode(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }


    public static function verifyPassword(string $hashedPassword, string $plainPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
    private static function hash(string $plainPassword): string
    {

        $hashedPassword = \password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (\is_bool($hashedPassword)) {
            throw new RuntimeException('Server error hashing password');
        }

        return (string) $hashedPassword;
    }


}
