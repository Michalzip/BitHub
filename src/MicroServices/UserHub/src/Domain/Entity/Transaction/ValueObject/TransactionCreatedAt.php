<?php

namespace UserService\Domain\Entity\Transaction\ValueObject;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class TransactionCreatedAt
{
    #[ORM\Column(name: 'created_at')]
    public readonly DateTime $value;

    public function __construct(?DateTime $value = new DateTime())
    {
        $this->value = $value;
    }
}
