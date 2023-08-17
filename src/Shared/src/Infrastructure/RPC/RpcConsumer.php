<?php

namespace Shared\Infrastructure\RPC;

use Shared\Infrastructure\RabbitMQ\RabbitMqConnection;

class RpcConsumer
{
    public $channel;
    public function __construct(private RabbitMqConnection $rabbitMqConnection)
    {
        $this->channel = $rabbitMqConnection->getChannel();
    }

    public function consume($callback, string $queue)
    {

        $this->channel->queue_declare($queue, false, false, false, false);

        $this->channel->basic_consume($queue, '', false, false, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->rabbitMqConnection->closeConnection();
    }
}
