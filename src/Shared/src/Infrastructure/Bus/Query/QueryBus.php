<?php

namespace Shared\Infrastructure\Bus\Query;

use Throwable;
use Symfony\Component\Messenger\HandleTrait;

use Shared\Domain\IBus\IQuery\QueryInterface;
use Shared\Domain\IBus\IQuery\QueryBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(private readonly  MessageBusInterface $queryBus)
    {
    }

    public function ask(QueryInterface $query)
    {
        try {
            $envelope = $this->queryBus->dispatch($query);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();

        } catch (HandlerFailedException $e) {

            $exceptions = $e->getNestedExceptions();

            throw $exceptions[0];
        }
    }
}
