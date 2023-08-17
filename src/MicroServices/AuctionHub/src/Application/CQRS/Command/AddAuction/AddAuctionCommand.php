<?php

namespace AuctionService\Application\CQRS\Command\AddAuction;

use AuctionService\Domain\Entity\Auction\ValueObject\AuctionEndedAt;
use Shared\Domain\IBus\ICommand\CommandInterface;
use AuctionService\Domain\Entity\Auction\ValueObject\Seller;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionTitle;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionStartPrice;

final class AddAuctionCommand implements CommandInterface
{
    public function __construct(
        public  AuctionTitle $title,
        public AuctionStartPrice $startPrice,
        public Seller $seller,
        public AuctionEndedAt $endedAt
    ) {
    }
}
