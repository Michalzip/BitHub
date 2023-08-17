<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;
use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\AggregateRootId;

#[ORM\Embeddable]
class AuctionId implements \Stringable
{
    use AggregateRootId;
}
