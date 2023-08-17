<?php

namespace UserService\Application\CQRS\Query\AuctionWinner;

use Shared\Domain\IBus\IQuery\QueryInterface;

class AuctionWinnerQuery implements QueryInterface
{
    public readonly string $auctionId;
    public function __construct(string $auctionId)
    {
        $this->auctionId=$auctionId;

    }
}
