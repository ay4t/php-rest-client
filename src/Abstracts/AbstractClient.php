<?php

namespace Ay4t\RestClient\Abstracts;

use Ay4t\RestClient\Config\Config;
use GuzzleHttp\Client as GuzzleClient;
use Ay4t\RestClient\Interfaces\ClientInterface;

abstract class AbstractClient implements ClientInterface
{
    protected $client;
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new GuzzleClient(['base_uri' => $config->apiUrl]);
    }

    protected function prepareHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->config->apiKey,
            'Accept' => 'application/json',
        ];
    }
}
