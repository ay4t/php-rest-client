<?php

namespace Ay4t\RestClient;

use GuzzleHttp\Psr7\Request;
use Ay4t\RestClient\Traits\RequestTrait;
use GuzzleHttp\Exception\GuzzleException;
use Ay4t\RestClient\Abstracts\AbstractClient;
use Ay4t\RestClient\Interfaces\ClientInterface;

class Client extends AbstractClient implements ClientInterface
{
    use RequestTrait;

    /**
     * Perform a request to the API server.
     *
     * @param string $method The HTTP method to use for the request.
     * @param string $command The command to send to the API.
     * @param array $params The parameters to send in the request.
     * @return mixed The response from the API server.
     * @throws \Exception If the request to the API server fails.
     */
    public function cmd(string $method = 'GET', string $command, array $params = [])
    {
        $url = $this->config->apiUrl . '/' . $command;
        $options = [
            'headers'   => $this->prepareHeaders(),
            'query'     => $method === 'GET' ? $params : [],
            'json'      => $method === 'POST' ? $params : [],
        ];

        try {
            $response = $this->client->request($method, $url, $options);
            return json_decode($response->getBody()->getContents(), $this->response_associative);
        } catch (GuzzleException $e) {
            // Error handling
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
