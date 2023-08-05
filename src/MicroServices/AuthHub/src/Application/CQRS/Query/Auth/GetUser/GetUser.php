<?php

namespace App\Application\CQRS\Query\Auth\GetUser;


use App\Domain\ValueObject\Email;
use Shared\Domain\IBus\IQuery\QueryInterface;

final class GetUser implements QueryInterface
{
    public function __construct(public Email $email)
    {

    }
}
