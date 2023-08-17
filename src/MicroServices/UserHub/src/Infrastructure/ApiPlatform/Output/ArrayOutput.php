<?php

namespace UserService\Infrastructure\ApiPlatform\Output;

final class ArrayOutput
{
    private function __construct(
        public readonly array $array,
    ) {
    }

    public static function fromArrayToObject(array $array): ArrayOutput
    {
        return new self((array) $array);
    }
}
