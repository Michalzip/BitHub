<?php

namespace App\Domain\IService\Auth;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\HashedPassword;

interface AuthenticationProviderInterace
{
    public function generateToken(string $uuid, Email $email, HashedPassword $hashedPassword): string;
}
