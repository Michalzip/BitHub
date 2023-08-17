<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionService\Domain\Entity\Auction\Model\Auction;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;

class AuctionWinnerConsume extends Command
{
    private const ROUTING_KEY = 'get_auction_status_queue';
    protected static $defaultName = 'consume:auction-winner';

    public function __construct(private AuctionRepositoryInterface $auctionRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }


    public function handleAuctionWinnerStatus($req)
    {

        $data = json_decode($req->body, true);

        $auction  = $this->auctionRepository->getAuctionDetailsById($data['auctionId']);


        $response = new ConsumerResponse("error", "not found the auction");


        if($auction!=null) {

            $response = new ConsumerResponse("pending", "the auction has no winner so far");

            if($auction['winner.value']!=null) {

                $response = new ConsumerResponse("success", $auction);
            }

        }


        $msg = new AMQPMessage(
            json_encode($response->toArray()),
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
        $this->rpcConsumer->consume(array($this,'handleAuctionWinnerStatus'), AuctionWinnerConsume::ROUTING_KEY);

        return Command::SUCCESS;

    }
}
