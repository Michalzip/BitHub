<?php

namespace App\Infrastructure\ApiPlatform\State\Processor;

use Shared\Application\Test;

use ApiPlatform\Metadata\Operation;

use ApiPlatform\State\ProcessorInterface;
use Shared\Application\Command\CommandBusInterface;
use App\Application\CQRS\Command\SignUp\SignUpCommand;

final readonly class UserSignUpProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new SignUpCommand($data->firstName, $data->lastName, $data->email, $data->password);

        $this->commandBus->dispatch($command);
    }
}
