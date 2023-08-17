<?php

namespace Shared\Infrastructure\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMqConnection
{
    private $connection;
    private $channel;
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

        $this->channel = $this->connection->channel();
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
