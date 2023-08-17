<?php

namespace UserService\Infrastructure\RabbitMq\Rpc\Client;

use Shared\Infrastructure\RPC\RpcClient;

class AuctionClient
{
    public function __construct(private readonly RpcClient $rpcClient)
    {
    }

    public function performRpcCall($message, $routingKey): mixed
    {
        $serializableMessage = json_encode($message);

        return  $this->rpcClient->call($serializableMessage, $routingKey);

    }
}
