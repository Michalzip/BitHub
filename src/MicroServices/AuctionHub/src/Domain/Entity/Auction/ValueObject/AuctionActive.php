<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class AuctionActive
{
    #[ORM\Column(name: 'auction_active')]
    public readonly bool $value;

    public function __construct(?bool $value = true)
    {
        Assert::boolean($value);

        $this->value = $value;
    }
}
