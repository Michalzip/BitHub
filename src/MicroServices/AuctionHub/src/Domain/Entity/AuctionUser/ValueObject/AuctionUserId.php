<?php

namespace AuctionService\Domain\Entity\AuctionUser\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Shared\Domain\ValueObject\AggregateRootId;

#[ORM\Embeddable]
class AuctionUserId implements \Stringable
{
    use AggregateRootId;
}
