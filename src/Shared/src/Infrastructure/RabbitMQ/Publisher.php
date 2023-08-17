<?php

namespace Shared\Infrastructure\RabbitMQ;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RabbitMQ\RabbitMqConnection;

class Publisher
{
    private $channel;

    public function __construct(private RabbitMqConnection $rabbitMqConnection)
    {
        $this->channel = $rabbitMqConnection->getChannel();
    }

    public function publish($message, $routingKey): void
    {
        $this->channel->queue_declare($routingKey, false, false, false, false);

        $msg = new AMQPMessage($message);

        $this->channel->basic_publish($msg, '', $routingKey);


    }
}
