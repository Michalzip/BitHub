<?php

namespace UserService\Domain\Entity\Bid\Repository;

use UserService\Domain\Entity\Bid\Model\Bid;

interface BidRepositoryInterface
{
    public function saveBid(Bid $user): void;

    public function findBid($userId, $auctionId): ?Bid;

    public function updatePiercedStatus($auctionId);
}
