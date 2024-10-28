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
     * $request_options
     * @var array
     */
    private $request_options = [];

    /**
     * setRequestOptions
     * @param array $request_options
     * @return void
     */
    public function setRequestOptions(array $request_options) {
        $this->request_options = $request_options;
        return $this;
    }
    

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
        $url = $this->config->getBaseUri() . '/' . $command;
        $requestOptions     = [];

        // Merge default options with user-provided options
        $defaultOptions = [
            'headers' => $this->prepareHeaders(),
        ];

        // Handle different HTTP methods and params
        if (in_array(strtoupper($method), ['GET', 'DELETE'])) {
            $defaultOptions['query'] = $params;
        } elseif (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'])) {
            $defaultOptions['json'] = $params;
        }

        $requestOptions = array_merge($defaultOptions, $this->request_options);

        try {
            $response = $this->client->request($method, $url, $requestOptions);
            return json_decode($response->getBody()->getContents(), $this->response_associative);
        } catch (GuzzleException $e) {
            // Error handling
            throw new \Exception('API request failed: ' . $e->getMessage());
        }
    }
}
