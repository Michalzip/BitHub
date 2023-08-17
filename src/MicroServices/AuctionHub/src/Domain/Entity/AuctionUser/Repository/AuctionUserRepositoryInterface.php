<?php

namespace AuctionService\Domain\Entity\AuctionUser\Repository;

use AuctionService\Domain\Entity\AuctionUser\Model\AuctionUser;

interface AuctionUserRepositoryInterface
{
    public function getAuctionUsersWithSameAuctionId($auctionId): ?array;
    public function saveAuction(AuctionUser $auctionUser): void;
    public function updateBidAmount(AuctionUser $auctionUser, float $newBidAmount): void;
    public function getUserBidByAuctionId(string $auctionId): array;
    public function findAuctionsByUserId($userId): ?array;
    public function findAuctionUser(string $userId, string $auctionId): ?AuctionUser;
}
