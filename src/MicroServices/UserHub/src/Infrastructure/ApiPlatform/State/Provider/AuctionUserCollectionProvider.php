<?php

namespace UserService\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Shared\Domain\IBus\IQuery\QueryBusInterface;
use UserService\Application\CQRS\Query\AuctionUserCollection\AuctionUserCollectionQuery;

final readonly class AuctionUserCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $response = $this->queryBus->ask(new AuctionUserCollectionQuery());
        return $response;
    }
}
