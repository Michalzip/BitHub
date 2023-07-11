<?php

namespace App\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Infrastructure\Bus\Query\QueryBus;
use App\Application\Cqrs\Command\SignIn\SignInCommand;
use App\Shared\Application\Command\CommandBusInterface;
use App\Application\Cqrs\Query\Auth\GetToken\GetTokenQuery;
use App\Infrastructure\ApiPlatform\Output\JWT;

final readonly class UserSignInProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBus $queryBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JWT
    {

        $command = new SignInCommand($data->email, $data->password);

        $this->commandBus->dispatch($command);

        $jwtToken = $this->queryBus->ask(new GetTokenQuery($data->email));

        return JWT::formJwtTokenString($jwtToken);

    }
}
