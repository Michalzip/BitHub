<?php

namespace App\Application\CQRS\Query\Auth\GetToken;

use App\Domain\ValueObject\Email;
use Shared\Application\Query\QueryInterface;

class GetTokenQuery implements QueryInterface
{
    public Email $email;

    public function __construct(string $email)
    {
        $this->email = Email::fromString($email);
    }
}
