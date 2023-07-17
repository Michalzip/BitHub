<?php

namespace App\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Shared\Infrastructure\Bus\Query\QueryBus;
use App\Application\CQRS\Command\SignIn\SignInCommand;
use Shared\Application\Command\CommandBusInterface;
use App\Application\CQRS\Query\Auth\GetToken\GetTokenQuery;
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
