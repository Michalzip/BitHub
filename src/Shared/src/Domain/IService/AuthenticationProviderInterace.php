<?php

namespace Shared\Domain\IService;

interface AuthenticationProviderInterace
{
    public function generateToken(string $uuid, string $email, string $firstName, $lastName): string;
}
