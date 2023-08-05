<?php

namespace UserService\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use UserService\Infrastructure\ApiPlatform\State\PriceSuggestionProcessor;

#[ApiResource(
    shortName: 'User Operation',
    operations: [

    new Post(
        "/user/price-suggestion",
        openapiContext: ['summary' => 'the user proposes a price for the auction'],
        processor: PriceSuggestionProcessor::class,
    )
    ],
)]
final class UserResource
{
}
