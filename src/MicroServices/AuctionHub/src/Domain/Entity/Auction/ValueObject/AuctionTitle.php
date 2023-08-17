<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class AuctionTitle
{
    #[ORM\Column(name: 'title', unique: true)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }
}
