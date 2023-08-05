<?php

namespace UserService\Domain\Entity\Bid\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class BidAmount
{
    #[ORM\Column(name: 'amount')]
    public readonly float $value;

    public function __construct(float $value)
    {
        Assert::greaterThanEq($value, 5);

        $this->value = $value;
    }
}
