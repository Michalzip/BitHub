<?php

namespace AuctionService\Application\CQRS\Command\AddAuction;

use AuctionService\Domain\Entity\Auction\Model\Auction;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use AuctionService\Application\CQRS\Command\AddAuction\AddAuctionCommand;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;

final class AddAuctionHandler implements CommandHandlerInterface
{
    public function __construct(private readonly AuctionRepositoryInterface $auctionRepository)
    {
    }

    public function __invoke(AddAuctionCommand $command): void
    {
        $auction = new Auction(
            $command->title,
            $command->startPrice,
            $command->seller,
            $command->endedAt,
        );

        $this->auctionRepository->saveAuction($auction);
    }
}
