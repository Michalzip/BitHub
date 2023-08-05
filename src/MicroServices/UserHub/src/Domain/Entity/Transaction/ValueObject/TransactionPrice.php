<?php

namespace UserService\Domain\Entity\Transaction\ValueObject;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class TransactionPrice
{
    #[ORM\Column(name: 'price', type: 'integer', options: ['unsigned' => true])]
    public readonly int $value;

    public function __construct(int $value)
    {
        Assert::greaterThanEq($value, 0);

        $this->value = $value;
    }
}
