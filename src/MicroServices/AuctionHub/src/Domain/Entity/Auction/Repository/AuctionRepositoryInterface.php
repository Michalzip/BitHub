<?php

namespace AuctionService\Domain\Entity\Auction\Repository;

use AuctionService\Domain\Entity\Auction\Model\Auction;

interface AuctionRepositoryInterface
{
    public function findAll(): array;
    public function findActiveAuctions(): array;
    public function findById(string $auctionId): ?Auction;
    public function getAuctionDetailsById(string $auctionId);
    public function saveAuction(Auction $auction): void;
}
