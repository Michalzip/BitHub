<?php

namespace UserService\Domain\Entity\Bid\Model;

use Doctrine\ORM\Mapping as ORM;
use UserService\Domain\Entity\User\Model\User;
use UserService\Domain\Entity\Bid\ValueObject\BidId;
use UserService\Domain\Entity\Bid\ValueObject\BidAmount;
use UserService\Domain\Entity\Bid\ValueObject\BidPierced;
use UserService\Domain\Entity\Bid\ValueObject\BidAuctionId;
use UserService\Domain\Entity\Bid\ValueObject\BidCreatedAt;

#[ORM\Entity]
class Bid
{
    #[ORM\Embedded(columnPrefix: false)]
    private BidId $id;

    #[ORM\Embedded(columnPrefix: false)]
    private BidPierced $pierced;

    #[ORM\Embedded(columnPrefix: false)]
    private BidCreatedAt $createdAt;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bids')]
        private User $user,
        #[ORM\Embedded(columnPrefix: false)]
        private BidAuctionId $bidAuctionId,
        #[ORM\Embedded(columnPrefix: false)]
        private BidAmount $amount,
    ) {
        $this->pierced = new BidPierced();
        $this->createdAt = new BidCreatedAt();
    }


}
