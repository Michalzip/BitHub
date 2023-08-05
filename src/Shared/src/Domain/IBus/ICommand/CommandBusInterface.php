<?php

namespace  Shared\Domain\IBus\ICommand;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): mixed;
}
