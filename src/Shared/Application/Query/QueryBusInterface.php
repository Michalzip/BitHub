<?php

namespace Shared\Application\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query);
}
