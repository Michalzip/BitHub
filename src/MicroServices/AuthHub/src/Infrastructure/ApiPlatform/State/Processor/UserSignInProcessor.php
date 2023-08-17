<?php

namespace App\Infrastructure\ApiPlatform\State\Processor;

use App\Domain\ValueObject\Email;
use ApiPlatform\Metadata\Operation;
use App\Domain\Entity\User\Model\User;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\ValueObject\HashedPassword;
use App\Infrastructure\ApiPlatform\Output\JWT;
use Shared\Domain\IBus\IQuery\QueryBusInterface;
use App\Application\CQRS\Query\Auth\GetUser\GetUser;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use Shared\Infrastructure\Service\Redis\RedisClient;
use App\Application\CQRS\Command\SignIn\SignInCommand;
use App\Application\CQRS\Query\Auth\GetToken\GetTokenQuery;

final readonly class UserSignInProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly RedisClient $redisClient
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JWT
    {

        //check valid data
        $this->commandBus->dispatch(new SignInCommand(new Email($data->email), new HashedPassword($data->password)));

        $jwtTokenString = $this->queryBus->ask(new GetTokenQuery(new Email($data->email)));

        /** @var User $user */
        $user = $this->queryBus->ask(new GetUser(new Email($data->email)));


        $userPersitenceData = [
            'id'=>$user->getId()->value,
            'email'=>$user->getEmail()->value,
            'firstName'=>$user->getFirstName()->value,
            'lastName'=>$user->getLastName()->value,
        ];

        $this->redisClient->set($user->getEmail()->value, $userPersitenceData);

        $this->redisClient->set("token", $jwtTokenString);


        return  JWT::formJwtTokenString($jwtTokenString);

    }
}
