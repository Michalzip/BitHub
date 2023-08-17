<?php

namespace Shared\Infrastructure\Bus\Command;

use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Messenger\HandleTrait;
use Shared\Domain\IBus\ICommand\CommandInterface;
use Shared\Domain\IBus\ICommand\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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

            $envelope = $this->messageBus->dispatch($command);
            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();



        } catch (HandlerFailedException $e) {
            /** @var array{0: \Throwable} $exceptions */
            $exceptions = $e->getNestedExceptions();

            throw $exceptions[0];
        }
    }
}
