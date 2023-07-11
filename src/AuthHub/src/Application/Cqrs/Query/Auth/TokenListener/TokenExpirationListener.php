<?php

namespace App\Application\Cqrs\Query\Auth\TokenListener;

use App\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Domain\IService\Auth\AuthenticationProviderInterace;
use App\Domain\IService\Token\TokenExpirationCheckerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;

class TokenExpirationListener
{
    private ?array $payload = null;
    private ?UserInterface $user = null;

    public function __construct(
        private TokenExpirationCheckerInterface $tokenExpirationChecker,
        private AuthenticationProviderInterace $authenticationProvider,
        private AuthRepositoryInterface $authRepository,
    ) {
    }
    public function onAuthenticatedAccess(JWTAuthenticatedEvent $event)
    {
        //?data form header
        $this->payload = $event->getPayload();
        $this->user = $event->getToken()->getUser();

    }

    //check for each requqest that token is close to expires
    public function onAuthenticatedResponse(ResponseEvent $event)
    {

        if ($this->payload != null && $this->user != null) {

            if ($this->tokenExpirationChecker->isTokenCloseToExpiration($this->payload)) {

                $currentUser = $this->authRepository->findUserByEmail($this->user->getUserIdentifier());

                $jwtToken = $this->authenticationProvider->generateToken(
                    $currentUser->getId(),
                    $currentUser->getEmail(),
                    $currentUser->getPassword()
                );

                $jsonResponse = $event->getResponse()->getContent();

                $data = json_decode($jsonResponse);

                $event->setResponse(new JsonResponse([
                    'token_message' => "token is close to expire, new token: $jwtToken",
                    'response_message' => $data
                ]));
            }
        }
    }

    public function onTokenExpires(JWTExpiredEvent $event)
    {
        $event->setResponse(new JsonResponse('your session has expired, please sign in again'));
    }
}
