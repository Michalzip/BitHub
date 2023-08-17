<?php

namespace UserService\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use UserService\Application\Dto\JoinAuctionDto;
use UserService\Infrastructure\ApiPlatform\State\Processor\JoinAuctionProccesor;
use UserService\Infrastructure\ApiPlatform\State\Provider\AuctionWinnerProvider;
use UserService\Infrastructure\ApiPlatform\State\Processor\PriceSuggestionProcessor;
use UserService\Infrastructure\ApiPlatform\State\Provider\AuctionCollectionProvider;
use UserService\Infrastructure\ApiPlatform\State\Provider\AuctionBidsCollectionProvider;
use UserService\Infrastructure\ApiPlatform\State\Provider\AuctionUserCollectionProvider;

#[ApiResource(
    shortName: 'User Operation',
    operations: [

    new Post(
        "/user/price-suggestion",
        openapiContext: ['summary' => 'the user proposes a price for the auction'],
        input: JoinAuctionDto::class,
        processor: PriceSuggestionProcessor::class,
    ),

    new Post(
        "/user/join-auction",
        openapiContext: ['summary' => 'the user can join to the auction'],
        input: JoinAuctionDto::class,
        processor: JoinAuctionProccesor::class,
    ),

    new Get(
        "/user/get-auction-collection",
        openapiContext: ['summary' => 'the user proposes a price for the auction'],
        provider: AuctionCollectionProvider::class,
    )
,
    new Get(
        "/user/get-auction-bids/{auctionId}",
        openapiContext: ['summary' => 'the user can check bids from choosen auction'],
        provider: AuctionBidsCollectionProvider::class,
    ),
    new Get(
        "/user/get-auction-winner/{auctionId}",
        openapiContext: ['summary' => 'the user can check winner from choosen auction'],
        provider: AuctionWinnerProvider::class,
    )
    ,
    new Get(
        "/user/get-my-auction",
        openapiContext: ['summary' => 'the user can check him current auction'],
        provider: AuctionUserCollectionProvider::class,
    )
    ],
)]
final class UserResource
{
}
