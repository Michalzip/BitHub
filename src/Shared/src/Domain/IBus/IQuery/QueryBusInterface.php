<?php

namespace Shared\Domain\IBus\IQuery;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}
