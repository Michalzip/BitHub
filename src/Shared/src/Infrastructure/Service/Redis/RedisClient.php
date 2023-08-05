<?php

namespace Shared\Infrastructure\Service\Redis;

use Predis\Client;

class RedisClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function set(string $key, $data)
    {
        $jsonData = json_encode($data);

        $this->client->set($key, $jsonData);

    }

    public function get(string $key)
    {
        $jsonData = $this->client->get($key);

        return $jsonData ? json_decode($jsonData, true) : null;

    }
}
