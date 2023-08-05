<?php

namespace UserService\Application\EventSubscriber;

use Shared\Infrastructure\Service\Auth\Auth;
use UserService\Domain\Entity\User\Model\User;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserService\Domain\Entity\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserExistenceSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly TokenStorageInterface $user, private UserRepositoryInterface $userRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function UserInitializer()
    {
        /** @var Auth $authUser */
        $authUser =  $this->user->getToken()->getUser();

        $findedUser = $this->userRepository->findUserByEmail($authUser->getEmail());

        if($findedUser==null) {

            $this->userRepository->saveUser(User::toModel($authUser));
        }
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $jwtToken=$request->headers->get('Authorization');

        if($jwtToken!=null) {
            $this->UserInitializer();
        }
    }
}
