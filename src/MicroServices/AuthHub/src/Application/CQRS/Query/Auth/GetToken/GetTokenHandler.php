<?php

namespace App\Application\CQRS\Query\Auth\GetToken;

use Shared\Domain\IBus\IQuery\QueryHandlerInterface;
use Shared\Domain\IService\AuthenticationProviderInterace;
use App\Application\CQRS\Query\Auth\GetToken\GetTokenQuery;
use App\Domain\Entity\User\Repository\AuthRepositoryInterface;

final class GetTokenHandler implements QueryHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository, private AuthenticationProviderInterace $authenticationProvider)
    {
    }
    public function __invoke(GetTokenQuery $query): string
    {
        [$id,$email,$firstName,$lastName] = $this->authRepository->getCredentialsByEmail($query->email);

        return $this->authenticationProvider->generateToken($id, $email, $firstName, $lastName);
    }
}
