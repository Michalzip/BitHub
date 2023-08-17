<?php

namespace UserService\Application\CQRS\Command\PriceSuggestion;

use Shared\Domain\IBus\ICommand\CommandInterface;

final class PriceSuggestionCommand implements CommandInterface
{
    public readonly string $auctionId;
    public readonly float  $bidAmount;
    public function __construct(string $auctionId, float $bidAmount)
    {
        $this->auctionId=$auctionId;
        $this->bidAmount=$bidAmount;
    }
}
