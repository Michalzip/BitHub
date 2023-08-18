<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;

class AuctionCollectionConsume extends Command
{
    private const ROUTING_KEY = 'auction_collection_queue';

    protected static $defaultName = 'consume:auction-collection';

    public function __construct(private AuctionRepositoryInterface $auctionRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }

    public function handleAuctionCollectionConsume($req)
    {

        $auctions  = $this->auctionRepository->findAll();

        $response = new ConsumerResponse("info", "not found any auctions");

        if($auctions != null) {
            $response = new ConsumerResponse("success", $auctions);
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
        $this->rpcConsumer->consume(array($this,'handleAuctionCollectionConsume'), AuctionCollectionConsume::ROUTING_KEY);

        return Command::SUCCESS;

    }

}
