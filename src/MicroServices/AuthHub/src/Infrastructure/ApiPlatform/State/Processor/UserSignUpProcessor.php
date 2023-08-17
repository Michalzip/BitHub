<?php

namespace App\Infrastructure\ApiPlatform\State\Processor;

use App\Domain\ValueObject\Email;
use ApiPlatform\Metadata\Operation;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\FirstName;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\ValueObject\HashedPassword;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use App\Application\CQRS\Command\SignUp\SignUpCommand;

final readonly class UserSignUpProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new SignUpCommand(new FirstName($data->firstName), new LastName($data->lastName), new Email($data->email), new HashedPassword($data->password));


        $this->commandBus->dispatch($command);

    }
}
