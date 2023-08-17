<?php

namespace AuctionService\Domain\Entity\Auction\ValueObject;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Shared\Infrastructure\Service\Auth\Auth;

#[ORM\Embeddable]
final class Seller
{
    #[ORM\Column(name: 'seller')]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }
}
