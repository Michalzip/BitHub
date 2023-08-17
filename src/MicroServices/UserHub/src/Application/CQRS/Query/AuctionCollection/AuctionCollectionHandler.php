<?php

namespace UserService\Application\CQRS\Query\AuctionCollection;

use Shared\Infrastructure\RPC\RpcClient;
use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Infrastructure\Rpc\Client\AuctionCollectionClient;
use UserService\Application\CQRS\Query\AuctionCollection\AuctionCollectionQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuctionCollectionHandler implements QueryHandlerInterface
{
    private const ROUTING_KEY = 'auction_collection_queue';
    public function __construct(
        private readonly AuctionClient $auctionClient,
    ) {
    }

    public function __invoke(AuctionCollectionQuery $command): array
    {
        $data =  $this->auctionClient->performRpcCall("", AuctionCollectionHandler::ROUTING_KEY);

        return json_decode($data,true);
    }
}
