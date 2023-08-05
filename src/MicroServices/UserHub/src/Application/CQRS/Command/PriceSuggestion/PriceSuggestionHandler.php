<?php

namespace UserService\Application\CQRS\Command\PriceSuggestion;

use Shared\Infrastructure\Service\Auth\Auth;
use UserService\Domain\Entity\Bid\Model\Bid;
use UserService\Domain\Entity\Bid\ValueObject\BidAmount;
use UserService\Domain\Entity\User\Model\User;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use UserService\Domain\Entity\Bid\Repository\BidRepositoryInterface;
use UserService\Application\CQRS\Command\PriceSuggestion\PriceSuggestionCommand;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class PriceSuggestionHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BidRepositoryInterface $bidRepository
    ) {

    }
    public function __invoke(PriceSuggestionCommand $command): void
    {
        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();


        $newBid = new Bid(
            User::toModel($authUser),
            new BidAmount(20)
        );

        $this->bidRepository->saveBid($newBid);

    }
}
