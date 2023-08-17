<?php

namespace UserService\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use UserService\Application\CQRS\Command\PriceSuggestion\PriceSuggestionCommand;
use UserService\Infrastructure\ApiPlatform\Output\ArrayOutput;

final readonly class PriceSuggestionProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ArrayOutput
    {
        $command = new PriceSuggestionCommand($data->auctionId, $data->bidAmount);

        $data =  $this->commandBus->dispatch($command);

        return ArrayOutput::fromArrayToObject($data);


    }
}
