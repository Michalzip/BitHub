<?php

namespace AuctionService\Domain\Entity\Auction\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use AuctionService\Domain\Entity\Auction\ValueObject\Seller;
use AuctionService\Domain\Entity\Auction\ValueObject\Winner;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionId;
use AuctionService\Domain\Entity\AuctionUser\Model\AuctionUser;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionTitle;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionActive;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionEndedAt;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionCreatedAt;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionStartPrice;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionCurrentPrice;

#[ORM\Entity]
class Auction
{
    #[ORM\Embedded(columnPrefix: false)]
    private AuctionId $id;

    #[OneToMany(targetEntity: AuctionUser::class, mappedBy: 'auction')]
    private $users;

    #[ORM\Embedded(columnPrefix: false)]
    private AuctionCurrentPrice $currentPrice;

    #[ORM\Embedded(columnPrefix: false)]
    private Winner $winner;

    #[ORM\Embedded(columnPrefix: false)]
    private AuctionActive $auctionActive;

    #[ORM\Embedded(columnPrefix: false)]
    private AuctionCreatedAt $createdAt;




    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private AuctionTitle $auctionTitle,
        #[ORM\Embedded(columnPrefix: false)]
        private AuctionStartPrice $startPrice,
        #[ORM\Embedded(columnPrefix: false)]
        private Seller $seller,
        #[ORM\Embedded(columnPrefix: false)]
        private AuctionEndedAt $endedAt
    ) {
        $this->users = new ArrayCollection();
        $this->currentPrice = new AuctionCurrentPrice($this->startPrice->value);
        $this->auctionActive = new AuctionActive();
        $this->createdAt = new AuctionCreatedAt();

    }

    public function setIsActive(bool $activeStatus): self
    {
        $this->auctionActive = new AuctionActive($activeStatus);

        return $this;
    }

    public function setWinner(string $winnerId): self
    {
        $this->winner = new Winner($winnerId);

        return $this;
    }


    public function setCurrentPrice(float $value): self
    {
        $this->currentPrice = new AuctionCurrentPrice($value);

        return $this;

    }

    public function ActiveStatus(): bool
    {
        return $this->auctionActive->value;

    }

    public function getId(): string
    {
        return  $this->id->value;

    }

    public function getWinner(): string
    {
        return $this->winner->value;
    }
    public function getEndedAt(): DateTime
    {
        return $this->endedAt->value;

    }
    public function getCurrentAuctionPrice(): float
    {
        return $this->currentPrice->value;
    }

}
