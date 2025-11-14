<?php

namespace Ay4t\RestClient\Abstracts;

use Ay4t\RestClient\Config\Config;
use GuzzleHttp\Client as GuzzleClient;
use Ay4t\RestClient\Interfaces\ClientInterface;

abstract class AbstractClient implements ClientInterface
{
    protected $client;
    protected $config;

    /**
     * @var bool
     */
    protected $verifySSL = true;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = new GuzzleClient([
            'base_uri' => $config->getBaseUri(),
            'verify' => $this->verifySSL
        ]);
    }

    /**
     * Set SSL verification
     * @param bool $verify
     * @return self
     */
    public function setVerifySSL(bool $verify): self
    {
        $this->verifySSL = $verify;
        $this->client = new GuzzleClient([
            'base_uri' => $this->config->getBaseUri(),
            'verify' => $this->verifySSL
        ]);
        return $this;
    }

    protected function prepareHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        $apiKey = $this->config->getApiKey();
        if (!empty($apiKey)) {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        return $headers;
    }
}
