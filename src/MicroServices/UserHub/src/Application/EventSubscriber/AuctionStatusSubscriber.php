<?php

namespace UserService\Application\EventSubscriber;

use Shared\Infrastructure\RabbitMQ\Publisher;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Shared\Infrastructure\RabbitMQ\RabbitMqConnection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuctionStatusSubscriber implements EventSubscriberInterface
{
    private const ROUTING_KEY = 'check_auction_status_queue';
    public function __construct(private readonly Publisher $publisher)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
    public function onKernelRequest(RequestEvent $event): void
    {

        $this->publisher->publish("", AuctionStatusSubscriber::ROUTING_KEY);

    }
}
