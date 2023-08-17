<?php

namespace Shared\Infrastructure\RPC;

use PhpAmqpLib\Message\AMQPMessage;
use Shared\Infrastructure\RabbitMQ\RabbitMqConnection;

class RpcClient
{
    private $channel;
    private $callback_queue;
    private $corr_id;
    private $response;

    public function __construct(private RabbitMqConnection $rabbitMqConnection)
    {

        $this->channel = $rabbitMqConnection->getChannel();

        list($this->callback_queue, , ) = $this->channel->queue_declare('', false, false, true, false);

        $this->channel->basic_consume($this->callback_queue, '', false, false, false, false, array($this,'OnResponse'));
    }

    public function OnResponse($rep)
    {
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;

        }
    }

    public function call($message, $routingKey): mixed
    {
        $this->corr_id = uniqid();
        $this->response = null;

        $msg = new AMQPMessage(
            $message,
            [
                'correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue,
            ]
        );

        $this->channel->basic_publish($msg, '', $routingKey);

        while (!$this->response) {
            $this->channel->wait();
        }

        return $this->response;
    }

}
