<?php

namespace AuctionService\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use AuctionService\Application\Dto\AddAuctionDto;
use AuctionService\Infrastructure\ApiPlatform\State\AddAuctionProcessor;

#[ApiResource(
    shortName: 'Auction Operation',
    operations: [

    new Post(
        "/auction/add-auction",
        openapiContext: ['summary' => 'create auction for users'],
        input: AddAuctionDto::class,
        processor: AddAuctionProcessor::class
    )
    ],
)]
class AuctionResource
{
}
