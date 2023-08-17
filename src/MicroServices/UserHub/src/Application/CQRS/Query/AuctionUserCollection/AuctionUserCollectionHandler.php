<?php

namespace UserService\Application\CQRS\Query\AuctionUserCollection;

use Shared\Infrastructure\Service\Auth\Auth;
use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Application\CQRS\Query\AuctionCollection\AuctionCollectionQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserService\Application\CQRS\Query\AuctionUserCollection\AuctionUserCollectionQuery;

final class AuctionUserCollectionHandler implements QueryHandlerInterface
{
    private const ROUTING_KEY = 'auction_user_collection_queue';
    public function __construct(
        private readonly AuctionClient $auctionClient,
        private readonly TokenStorageInterface $tokenStorage,
    ) {
    }

    public function __invoke(AuctionUserCollectionQuery $command): array
    {

        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();

        $data =  $this->auctionClient->performRpcCall(["userId"=>$authUser->getId()], AuctionUserCollectionHandler::ROUTING_KEY);

        return json_decode($data, true);
    }
}
