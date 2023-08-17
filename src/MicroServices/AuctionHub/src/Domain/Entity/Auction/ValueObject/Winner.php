<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class Winner
{
    #[ORM\Column(name: 'winner', nullable: true)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::notNull($value);

        $this->value = $value;
    }
}
