<?php

namespace UserService\Domain\Entity\Bid\ValueObject;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class BidCreatedAt
{
    #[ORM\Column(name: 'created_at')]
    public readonly DateTime $value;

    public function __construct(?DateTime $value = new DateTime())
    {
        $this->value = $value;
    }
}
