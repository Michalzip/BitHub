<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use Exception;
use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionSendSuggestionPriceConsume extends Command
{
    private const ROUTING_KEY = 'suggestion_price_auction';
    protected static $defaultName = 'consume:send-suggestion-price';
    private $response;
    public function __construct(private AuctionUserRepositoryInterface $auctionUserRepository, private AuctionRepositoryInterface $auctionRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }

    public function handleSendSuggestionPriceConsume($req)
    {

        $data = json_decode($req->body, true);

        $userAuction  = $this->auctionUserRepository->findAuctionUser($data["userId"], $data["auctionId"]);
        $auction = $this->auctionRepository->findById($data['auctionId']);

        if($userAuction!=null && $auction->getEndedAt()>new \DateTime()) {
            if($data["bidAmount"] > $userAuction->getbidAmount() && $userAuction!=null) {
                try {
                    $userAuction->setBidAmount($data["bidAmount"]);
                    $this->auctionUserRepository->saveAuction($userAuction);

                    $auction->setCurrentPrice($data['bidAmount']);
                    $this->auctionRepository->saveAuction($auction);

                    $this->response = new ConsumerResponse("success", "Bid added successfully");

                } catch (Exception $e) {
                    $this->response = new ConsumerResponse("error", $e->getMessage());
                }
            } else {
                $this->response = new ConsumerResponse("error", "Cannot Add Price Lower Than Current Price");
            }
        } elseif($userAuction === null) {
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
        $this->rpcConsumer->consume(array($this,'handleSendSuggestionPriceConsume'), AuctionSendSuggestionPriceConsume::ROUTING_KEY);
        return Command::SUCCESS;
    }

}
