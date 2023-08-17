<?php

namespace UserService\Application\CQRS\Query\AuctionWinner;

use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Application\CQRS\Query\AuctionWinner\AuctionWinnerQuery;

class AuctionWinnerHandler implements QueryHandlerInterface
{
    private const ROUTING_KEY = 'get_auction_status_queue';
    public function __construct(
        private readonly AuctionClient $auctionClient,
    ) {
    }

    public function __invoke(AuctionWinnerQuery $command)
    {
        $data =  $this->auctionClient->performRpcCall(['auctionId'=>$command->auctionId], AuctionWinnerHandler::ROUTING_KEY);

        return json_decode($data, true);
    }
}
