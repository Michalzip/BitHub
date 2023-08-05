<?php

namespace UserService\Application\CQRS\Command\PriceSuggestion;

use Shared\Domain\IBus\ICommand\CommandInterface;

final class PriceSuggestionCommand implements CommandInterface
{
    public readonly int $price;
    public function __construct(int $price)
    {
        $this->price=$price;
    }
}
