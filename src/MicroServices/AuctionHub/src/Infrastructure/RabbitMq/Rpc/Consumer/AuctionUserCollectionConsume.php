<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionUserCollectionConsume extends Command
{
    private const ROUTING_KEY = 'auction_user_collection_queue';
    protected static $defaultName = 'consume:auction-collection-user';

    public function __construct(private AuctionUserRepositoryInterface $auctionUserRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }


    public function handleAuctionWinnerStatus($req)
    {

        $data = json_decode($req->body, true);

        $auctionUser  = $this->auctionUserRepository->findAuctionsByUserId($data['userId']);


        $response = new ConsumerResponse("info", "not found the auction to which you belong");


        if($auctionUser != null) {

            $response = new ConsumerResponse("succes", $auctionUser);

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
        $this->rpcConsumer->consume(array($this,'handleAuctionWinnerStatus'), AuctionUserCollectionConsume::ROUTING_KEY);

        return Command::SUCCESS;

    }
}
