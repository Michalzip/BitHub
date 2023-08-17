<?php

namespace UserService\Application\CQRS\Command\JoinAuction;

use Exception;
use Shared\Infrastructure\Service\Auth\Auth;
use UserService\Domain\Entity\Bid\Model\Bid;
use UserService\Domain\Entity\User\Model\User;
use Shared\Domain\IBus\ICommand\CommandHandlerInterface;
use UserService\Domain\Entity\Bid\ValueObject\BidAmount;
use UserService\Infrastructure\RabbitMq\Rpc\Client\AuctionClient;
use UserService\Domain\Entity\Bid\ValueObject\BidAuctionId;
use UserService\Domain\Entity\Bid\Repository\BidRepositoryInterface;
use UserService\Application\CQRS\Command\JoinAuction\JoinAuctionCommand;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class JoinAuctionHandler implements CommandHandlerInterface
{
    private const ROUTING_KEY = 'auction_join_queue';
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly AuctionClient $auctionClient,
        private readonly BidRepositoryInterface $bidRepository
    ) {

    }
    public function __invoke(JoinAuctionCommand $command): array
    {
        /** @var Auth $authUser */
        $authUser =  $this->tokenStorage->getToken()->getUser();

        $response = $this->auctionClient->performRpcCall([
            "userId"=>$authUser->getId(),
            "bidAmount"=>$command->bidAmount,
            "auctionId"=>$command->auctionId
        ], JoinAuctionHandler::ROUTING_KEY);



        $unserializableResponse = json_decode($response, true);


        if($unserializableResponse['status']=="success") {

            $newBid = new Bid(
                User::fromAuth($authUser),
                new BidAuctionId($command->auctionId),
                new BidAmount($command->bidAmount)
            );

            $this->bidRepository->saveBid($newBid);
        }

        return $unserializableResponse;
    }
}
