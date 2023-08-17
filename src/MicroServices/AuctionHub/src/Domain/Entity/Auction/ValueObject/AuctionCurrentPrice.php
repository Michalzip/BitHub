<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class AuctionCurrentPrice
{
    #[ORM\Column(name: 'current_price')]
    public readonly float $value;

    public function __construct(float $value)
    {
        Assert::greaterThanEq($value, 0);

        $this->value = $value;
    }
}
