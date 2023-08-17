<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class AuctionStartPrice
{
    #[ORM\Column(name: 'start_price')]
    public readonly float $value;

    public function __construct(float $value)
    {
        Assert::greaterThan($value, 0);

        $this->value = $value;
    }
}
