<?php

namespace UserService\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Shared\Domain\IBus\IQuery\QueryBusInterface;
use UserService\Application\CQRS\Query\AuctionBidsCollection\AuctionBidsCollectionQuery;

final readonly class AuctionBidsCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $auctionId = $uriVariables['auctionId'];

        $response =  $this->queryBus->ask(new AuctionBidsCollectionQuery($auctionId));
        return $response;
    }
}
