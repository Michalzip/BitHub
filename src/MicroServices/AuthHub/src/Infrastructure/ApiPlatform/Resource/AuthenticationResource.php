<?php

namespace App\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Application\Dto\UserSignInDto;
use App\Application\Dto\UserSignUpDto;
use App\Domain\Entity\User\Model\User;
use App\Infrastructure\ApiPlatform\State\TestProvider;
use App\Infrastructure\ApiPlatform\State\Processor\UserSignInProcessor;
use App\Infrastructure\ApiPlatform\State\Processor\UserSignUpProcessor;

#[ApiResource(
    shortName: 'Authentication Operation',
    operations: [

    new Post(
        "sign-in",
        openapiContext: ['summary' => 'user sign in'],
        input: UserSignInDto::class,
        processor: UserSignInProcessor::class,
    ),

    new Post(
        "sign-up",
        openapiContext: ['summary' => 'user sign up'],
        input: UserSignUpDto::class,
        processor: UserSignUpProcessor::class,
    ),
    ],
)]
final class AuthenticationResource
{
}
