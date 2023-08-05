<?php

namespace UserService\Domain\Entity\Bid\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class BidPierced
{
    #[ORM\Column(name: 'pierced')]
    public readonly bool $value;

    public function __construct(?bool $value = false)
    {
        Assert::boolean($value);

        $this->value = $value;
    }
}
