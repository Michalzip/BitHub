<?php

namespace UserService\Domain\Entity\Transaction\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class TransactionState
{
    #[ORM\Column(name: 'transaction_state')]
    public readonly string $value;

    public const
    ACTIVE = 'active',
    PENDING = 'pending',
    REJECTED = 'rejected';

    public function __construct(?string $value = self::PENDING)
    {

        $this->value = $value;

    }

}
