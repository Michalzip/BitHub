<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class AuctionCreatedAt
{
    #[ORM\Column(name: 'created_at')]
    public readonly DateTime $value;

    public function __construct(?DateTime $value = new DateTime())
    {
        $this->value = $value;
    }
}
