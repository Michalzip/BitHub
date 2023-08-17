<?php

namespace AuctionService\Infrastructure\RabbitMq\Rpc\Consumer;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RPC\RpcConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AuctionHub\Infrastructure\RabbitMq\Rpc\Response\ConsumerResponse;
use AuctionService\Domain\Entity\Auction\Repository\AuctionRepositoryInterface;
use AuctionService\Domain\Entity\AuctionUser\Repository\AuctionUserRepositoryInterface;

class AuctionGetSuggestionPriceConsume extends Command
{
    private const ROUTING_KEY = 'get_suggestion_price_auction';

    protected static $defaultName = 'consume:get-suggestion-price';

    private $response;
    public function __construct(private AuctionUserRepositoryInterface $auctionUserRepository, private AuctionRepositoryInterface $auctionRepository, private RpcConsumer $rpcConsumer)
    {
        parent::__construct();
    }

    public function handleAuctionGetSuggestionPriceConsume($req)
    {

        $data = json_decode($req->body, true);

        $usersBid  = $this->auctionUserRepository->getUserBidByAuctionId($data["auctionId"]);

        if($usersBid!=null) {

            $this->response = new ConsumerResponse("success", $usersBid);

        } else {
            $this->response = new ConsumerResponse("error", "No User Has Bid On This Auction");
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
        $this->rpcConsumer->consume(array($this,'handleAuctionGetSuggestionPriceConsume'), AuctionGetSuggestionPriceConsume::ROUTING_KEY);

        return Command::SUCCESS;
    }
}
