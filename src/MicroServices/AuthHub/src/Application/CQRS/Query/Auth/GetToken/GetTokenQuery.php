<?php

namespace App\Application\CQRS\Query\Auth\GetToken;

use App\Domain\ValueObject\Email;
use Shared\Domain\IBus\IQuery\QueryInterface;

final class GetTokenQuery implements QueryInterface
{
    public function __construct(public Email $email)
    {

    }
}
