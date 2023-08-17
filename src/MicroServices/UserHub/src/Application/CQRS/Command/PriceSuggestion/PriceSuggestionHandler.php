<?php

namespace UserService\Application\CQRS\Command\PriceSuggestion;

use Shared\Infrastructure\Service\Auth\Auth;
use UserService\Domain\Entity\Bid\Model\Bid;
use UserService\Domain\Entity\User\Model\User;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use UserService\Domain\Entity\Bid\ValueObject\BidAmount;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Domain\Entity\Bid\ValueObject\BidAuctionId;
use UserService\Domain\Entity\Bid\Repository\BidRepositoryInterface;
use UserService\Application\CQRS\Command\PriceSuggestion\PriceSuggestionCommand;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class PriceSuggestionHandler implements CommandHandlerInterface
{
    private const ROUTING_KEY = 'suggestion_price_auction';
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BidRepositoryInterface $bidRepository,
        private readonly AuctionClient $auctionClient,
    ) {

    }

    public function __invoke(PriceSuggestionCommand $command): array
    {
        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();


        $response =  $this->auctionClient->performRpcCall(["userId"=>$authUser->getId(),"auctionId"=>$command->auctionId,"bidAmount"=>$command->bidAmount], PriceSuggestionHandler::ROUTING_KEY);

        $unserializableResponse = json_decode($response, true);

        if($unserializableResponse['status']=="success") {

            $newBid = new Bid(
                User::fromAuth($authUser),
                new BidAuctionId($command->auctionId),
                new BidAmount($command->bidAmount)
            );
            $this->bidRepository->saveBid($newBid);

            $this->bidRepository->updatePiercedStatus($command->auctionId);

        }

        return $unserializableResponse;
    }
}
