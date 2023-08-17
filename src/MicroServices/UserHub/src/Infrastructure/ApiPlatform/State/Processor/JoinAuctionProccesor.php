<?php

namespace UserService\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use UserService\Application\CQRS\Command\JoinAuction\JoinAuctionCommand;
use UserService\Infrastructure\ApiPlatform\Output\ArrayOutput;

final readonly class JoinAuctionProccesor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ArrayOutput
    {
        $command = new JoinAuctionCommand($data->auctionId, $data->bidAmount);

        $response =  $this->commandBus->dispatch($command);

        return ArrayOutput::fromArrayToObject($response);
    }


}
