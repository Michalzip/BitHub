<?php

namespace AuctionHub\Infrastructure\RabbitMq\Rpc\Response;

class ConsumerResponse
{
    private $status;
    private $message;

    public function __construct($status, $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}
