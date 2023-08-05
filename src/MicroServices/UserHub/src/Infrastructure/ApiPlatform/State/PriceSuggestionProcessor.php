<?php

namespace UserService\Infrastructure\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use UserService\Application\CQRS\Command\PriceSuggestion\PriceSuggestionCommand;

final readonly class PriceSuggestionProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new PriceSuggestionCommand(10);

        $this->commandBus->dispatch($command);
    }
}
