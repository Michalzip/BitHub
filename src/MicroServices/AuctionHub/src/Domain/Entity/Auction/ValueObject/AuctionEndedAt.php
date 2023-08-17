<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class AuctionEndedAt
{
    #[ORM\Column(name: 'ended_at')]
    public readonly DateTime $value;

    public function __construct(DateTime $value)
    {

        $this->value = $value;

    }
}
