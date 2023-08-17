<?php

namespace UserService\Domain\Entity\Bid\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class BidAuctionId
{
    #[ORM\Column(name: 'bid_auction_id')]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value);

        $this->value = $value;
    }
}
