<?php

namespace UserService\Domain\Entity\Transaction\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

use UserService\Domain\Entity\User\Model\User;
use UserService\Domain\Entity\Transaction\ValueObject\TransactionCreatedAt;
use UserService\Domain\Entity\Transaction\ValueObject\TransactionId;
use UserService\Domain\Entity\Transaction\ValueObject\TransactionPrice;
use UserService\Domain\Entity\Transaction\ValueObject\TransactionState;

#[ORM\Entity]
class Transaction
{
    #[ORM\Embedded(columnPrefix: false)]
    private TransactionId $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
        private User $user,
        #[ORM\Embedded(columnPrefix: false)]
        private TransactionState $state,
        #[ORM\Embedded(columnPrefix: false)]
        private TransactionPrice $price,
        #[ORM\Embedded(columnPrefix: false)]
        private TransactionCreatedAt $createdAt
    ) {
    }

}
