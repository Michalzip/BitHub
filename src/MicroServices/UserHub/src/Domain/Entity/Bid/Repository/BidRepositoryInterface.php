<?php

namespace UserService\Domain\Entity\Bid\Repository;

use UserService\Domain\Entity\Bid\Model\Bid;

interface BidRepositoryInterface
{
    public function saveBid(Bid $user): void;
}
