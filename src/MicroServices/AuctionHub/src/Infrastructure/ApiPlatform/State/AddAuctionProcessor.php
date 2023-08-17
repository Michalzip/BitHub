<?php

namespace AuctionService\Infrastructure\ApiPlatform\State;

use DateTime;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Shared\Infrastructure\Service\Auth\Auth;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use AuctionService\Domain\Entity\Auction\ValueObject\Seller;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionTitle;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionEndedAt;
use AuctionService\Domain\Entity\Auction\ValueObject\AuctionStartPrice;
use AuctionService\Application\CQRS\Command\AddAuction\AddAuctionCommand;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class AddAuctionProcessor implements ProcessorInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus, private TokenStorageInterface $tokenStorage)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();


        $command  =  new AddAuctionCommand(
            new AuctionTitle($data->title),
            new AuctionStartPrice($data->startPrice),
            new Seller($authUser->getEmail()),
            new AuctionEndedAt(new DateTime($data->endedAt)),
        );

        $this->commandBus->dispatch($command);
    }
}
