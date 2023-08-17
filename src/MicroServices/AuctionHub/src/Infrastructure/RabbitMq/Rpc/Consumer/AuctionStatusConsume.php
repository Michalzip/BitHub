<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use Shared\Infrastructure\RabbitMQ\Consumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionService\Domain\Entity\Auction\Model\Auction;
use AuctionService\Domain\Entity\AuctionUser\Model\AuctionUser;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionStatusConsume extends Command
{
    private const ROUTING_KEY = 'check_auction_status_queue';
    protected static $defaultName = 'consume:auction-status';

    public function __construct(private AuctionRepositoryInterface $auctionRepository, private AuctionUserRepositoryInterface $auctionUserRepository, private Consumer $consumer)
    {

        parent::__construct();
    }

    public function findEndedAuctions($msg)
    {

        $auctions = $this->auctionRepository->findActiveAuctions();

        if($auctions==null) {

            $msg->ack();
        }

        foreach ($auctions as $auction) {

            /** @var Auction|null $modelAuction */
            $modelAuction = $auction;

            $modelAuction->setIsActive(false);

            try {

                $this->auctionRepository->saveAuction($auction);

                $this->setWinner($modelAuction->getId());

            } catch(\Exception $e) {

                var_dump($e->getMessage());
            }
        }


        $msg->ack();

    }

    public function setWinner(string $auctionId): void
    {

        $highestBidAmount = 0;
        $highestBidUser = null;

        $auctionUsers = $this->auctionUserRepository->getAuctionUsersWithSameAuctionId($auctionId);

        foreach ($auctionUsers as $auctionUser) {

            /** @var AuctionUser|null $auctionUserModel */
            $auctionUserModel = $auctionUser;

            $bidAmount  = $auctionUserModel->getbidAmount();

            if ($bidAmount > $highestBidAmount) {
                $highestBidAmount = $bidAmount;
                $highestBidUser = $auctionUserModel->getUserId();
            }
        }

        /** @var Auction|null $auction */
        $auction = $this->auctionRepository->findById($auctionId);

        $auction->setWinner($highestBidUser);

        $this->auctionRepository->saveAuction($auction);

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->consumer->consume([$this, 'findEndedAuctions'], AuctionStatusConsume::ROUTING_KEY);

    }
}
