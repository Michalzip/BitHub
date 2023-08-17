<?php

namespace UserService\Application\CQRS\Query\AuctionBidsCollection;

use Shared\Domain\IBus\IQuery\QueryInterface;

final class AuctionBidsCollectionQuery implements QueryInterface
{
    public readonly string $auctionId;

    public function __construct(string $auctionId)
    {
        $this->auctionId=$auctionId;

    }
}
