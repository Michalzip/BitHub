<?php

namespace App\Application\CQRS\Query\Auth\GetToken;

use App\Domain\Repository\AuthRepositoryInterface;
use Shared\Application\Query\QueryHandlerInterface;
use App\Application\CQRS\Query\Auth\GetToken\GetTokenQuery;
use App\Domain\IService\Auth\AuthenticationProviderInterace;

class GetTokenHandler implements QueryHandlerInterface
{
    public function __construct(private AuthRepositoryInterface $authRepository, private AuthenticationProviderInterace $authenticationProvider)
    {
    }
    public function __invoke(GetTokenQuery $query): string
    {
        [$id,$email,$hashedPassword] = $this->authRepository->getCredentialsByEmail($query->email);

        return $this->authenticationProvider->generateToken($id, $email, $hashedPassword);
    }
}
