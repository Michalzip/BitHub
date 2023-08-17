<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\AuctionUser\Model\AuctionUser;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionJoinConsume extends Command
{
    private const ROUTING_KEY = 'auction_join_queue';
    protected static $defaultName = 'consume:auction-join';
    private $response;
    public function __construct(private AuctionUserRepositoryInterface $auctionUserRepository, private AuctionRepositoryInterface $auctionRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }

    public function handleAuctionJoinConsume($req)
    {

        $result = json_decode($req->body, true);

        $auction = $this->auctionRepository->findById($result['auctionId']);

        if($auction!=null && $auction->getEndedAt()>new \DateTime()) {

            $userAlreadyJoinded= $this->auctionUserRepository->findAuctionUser($result["userId"], $result["auctionId"]);

            if($userAlreadyJoinded===null) {
                if($result["bidAmount"] > $auction->getCurrentAuctionPrice() && $auction!=null) {
                    try {

                        $newAuctionUser = new AuctionUser($result["userId"], $auction, $result["bidAmount"]);
                        $this->auctionUserRepository->saveAuction($newAuctionUser);

                        $auction->setCurrentPrice($result['bidAmount']);
                        $this->auctionRepository->saveAuction($auction);

                        $this->response = new ConsumerResponse("success", "Auction user added successfully.");
                    } catch (Exception $e) {
                        $this->response = new ConsumerResponse("error", $e->getMessage());
                    }

                } else {
                    $this->response = new ConsumerResponse("error", "Cannot Add Price Lower Than Current Price");
                }

            } else {
                $this->response = new ConsumerResponse("error", "User Already Joined To The Action");
            }

        } elseif ($auction == null) {
            $this->response = new ConsumerResponse("error", "Cannot Find Auction");
        } else {
            $this->response = new ConsumerResponse("error", "Auction Is Not Active");
        }


        $msg = new AMQPMessage(
            json_encode($this->response->toArray()),
            ['correlation_id' => $req->get('correlation_id')]
        );

        $req->getChannel()->basic_publish(
            $msg,
            '',
            $req->get('reply_to')
        );
        $req->ack();
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->rpcConsumer->consume(array($this,'handleAuctionJoinConsume'), AuctionJoinConsume::ROUTING_KEY);

        return Command::SUCCESS;

    }

}
