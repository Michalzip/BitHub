<?php

namespace Shared\Infrastructure\Service\Auth;

use Exception;
use Shared\Infrastructure\Service\Auth\Auth;
use Shared\Infrastructure\Service\Redis\RedisClient;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class AuthProvider implements UserProviderInterface
{
    public function __construct(
        private readonly RedisClient $client
    ) {
    }

    //another option I considered was to make a separate UserInterface class for each microservice, send by rabbitmq data like email ... to put the data into their databases immediately.
    //immediately inserting the email into the other databases would allow me to avoid the result: "invalid credentials" if I put the token into the header
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        try {

            $data = $this->client->get($identifier);

            return Auth::create($data['id'], $data['email'], $data['firstName'], $data['lastName']);

        } catch (Exception) {
            throw new UserNotFoundException();
        }

    }



    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return Auth::class === $class;
    }
}
