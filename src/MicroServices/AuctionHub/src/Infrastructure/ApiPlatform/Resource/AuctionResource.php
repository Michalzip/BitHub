<?php

namespace AuctionService\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(
    shortName: 'User Operation',
    operations: [

    new Post(
        "/auction/price-suggestion",
        openapiContext: ['summary' => 'the user proposes a price for the auction'],
       
    )
    ],
)]
class AuctionResource
{
}
