<?php

namespace UserService\Application\CQRS\Query\AuctionBidsCollection;

use Shared\Infrastructure\Service\Auth\Auth;
use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Application\CQRS\Query\AuctionBidsCollection\AuctionBidsCollectionQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuctionBidsCollectionHandler implements QueryHandlerInterface
{
    private const ROUTING_KEY = 'get_suggestion_price_auction';
    public function __construct(
        private readonly AuctionClient $auctionClient,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public function __invoke(AuctionBidsCollectionQuery $command)
    {
        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();

        $data =  $this->auctionClient->performRpcCall(['auctionId'=>$command->auctionId,"userId"=>$authUser->getId()], AuctionBidsCollectionHandler::ROUTING_KEY);

        return json_decode($data, true);
    }
}
