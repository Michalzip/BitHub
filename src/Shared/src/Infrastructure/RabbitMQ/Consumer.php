<?php

namespace Shared\Infrastructure\RabbitMQ;

use Shared\Infrastructure\RabbitMQ\RabbitMqConnection;

class Consumer
{
    private $channel;

    public function __construct(private RabbitMqConnection $rabbitMqConnection)
    {
        $this->channel = $rabbitMqConnection->getChannel();
    }

    public function consume($callback, $routingKey): void
    {
        $this->channel->queue_declare($routingKey, false, false, false, false);

        $this->channel->basic_qos(0, 1, 0);

        $this->channel->basic_consume($routingKey, '', false, false, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

        $this->rabbitMqConnection->closeConnection();
    }
}
