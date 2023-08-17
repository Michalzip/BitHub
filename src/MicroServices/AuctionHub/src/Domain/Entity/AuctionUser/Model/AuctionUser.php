<?php

namespace AuctionService\Domain\Entity\AuctionUser\Model;

use Doctrine\ORM\Mapping as ORM;
use AuctionService\Domain\Entity\Auction\Model\Auction;
use AuctionService\Domain\Entity\AuctionUser\ValueObject\AuctionUserId;

#[ORM\Entity]
class AuctionUser
{
    #[ORM\Embedded(columnPrefix: false)]
    private AuctionUserId $id;

    public function __construct(
        #[ORM\Column(name: "user_id", type: "guid", unique: false)]
        private string $userId,
        #[ORM\ManyToOne(targetEntity: Auction::class, inversedBy: 'users')]
        private Auction $auction,
        #[ORM\Column(name: 'bid_amount')]
        private float $bidAmount,
    ) {
    }


    public function getbidAmount(): float
    {
        return $this->bidAmount;
    }

    public function getAuctionId(): string
    {
        return $this->auction->getId();
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setBidAmount(float $bidAmount): void
    {
        $this->bidAmount = $bidAmount;
    }
}
