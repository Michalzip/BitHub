<?php

namespace App\Shared\Infrastructure\Bus\Command;

use Symfony\Component\Messenger\HandleTrait;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(CommandInterface $command): void
    {
        try {

            $this->messageBus->dispatch($command);

        } catch (HandlerFailedException $e) {
            /** @var array{0: \Throwable} $exceptions */
            $exceptions = $e->getNestedExceptions();

            throw $exceptions[0];
        }
    }
}
