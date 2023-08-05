<?php

namespace UserService\Domain\Entity\Transaction\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\AggregateRootId;

#[ORM\Embeddable]
class TransactionId implements \Stringable
{
    use AggregateRootId;
}

