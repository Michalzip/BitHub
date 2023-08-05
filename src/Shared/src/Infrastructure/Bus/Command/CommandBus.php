<?php

namespace Shared\Infrastructure\Bus\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Messenger\HandleTrait;
use Shared\Domain\IBus\ICommand\CommandInterface;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(CommandInterface $command): mixed
    {
        try {



            return $this->messageBus->dispatch($command);

        } catch (HandlerFailedException $e) {
            /** @var array{0: \Throwable} $exceptions */
            $exceptions = $e->getNestedExceptions();

            throw $exceptions[0];
        }
    }
}
