<?php

namespace Shared\Application\TokenListener;

use Shared\Infrastructure\Service\Auth\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Shared\Infrastructure\Service\Redis\RedisClient;
use Symfony\Component\Security\Core\User\UserInterface;
use Shared\Domain\IService\AuthenticationProviderInterace;
use Shared\Domain\IService\TokenExpirationCheckerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;

class TokenExpirationListener
{
    private ?array $payload = null;
    private ?UserInterface $user = null;

    public function __construct(
        private readonly TokenExpirationCheckerInterface $tokenExpirationChecker,
        private readonly AuthenticationProviderInterace $authenticationProvider,
        private readonly RedisClient $client
    ) {
    }

    public function onAuthenticatedAccess(JWTAuthenticatedEvent $event)
    {
        //?data from token in header
        $this->payload = $event->getPayload();
        //?data from provider
        /** @var Auth $user */
        $user = $this->user = $event->getToken()->getUser();

        if ($this->payload != null && $this->user != null) {

            if ($this->tokenExpirationChecker->isTokenCloseToExpiration($this->payload)) {


                $newToken =  $this->authenticationProvider->generateToken($user->getId(), $user->getEmail(), $user->getFirstName(), $user->getLastName());

                $this->client->set('token', $newToken);

            }
        }
    }

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {

        $token = $this->client->get('token');

        $response = new JsonResponse("Token not found, please try: $token");

        if($token == null) {
            $response = new JsonResponse("Please sign in again");
        }

        $event->setResponse($response);

    }

    public function onTokenExpires(JWTExpiredEvent $event)
    {
        $event->setResponse(new JsonResponse('your token have been expired, please sign in again'));
    }
}
