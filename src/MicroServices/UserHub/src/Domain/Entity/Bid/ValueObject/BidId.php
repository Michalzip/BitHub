<?php

namespace UserService\Domain\Entity\Bid\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\AggregateRootId;

#[ORM\Embeddable]
class BidId implements \Stringable
{
    use AggregateRootId;
}
