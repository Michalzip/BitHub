<?php

namespace Shared\Application\Command;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
