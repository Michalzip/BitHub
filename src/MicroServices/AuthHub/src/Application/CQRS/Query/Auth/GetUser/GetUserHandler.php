<?php

namespace App\Application\CQRS\Query\Auth\GetUser;

use App\Domain\Entity\User\Model\User;
use App\Domain\Exception\UserNotFound;
use App\Application\CQRS\Query\Auth\GetUser\GetUser;
use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use App\Domain\Entity\User\Repository\AuthRepositoryInterface;

final class GetUserHandler implements QueryHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }
    public function __invoke(GetUser $query): User
    {

        return $this->authRepository->findUserByEmail($query->email) ?? throw new UserNotFound();

    }
}
