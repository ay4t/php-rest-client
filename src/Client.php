<?php

namespace Ay4t\RestClient;

use GuzzleHttp\Psr7\Request;
use Ay4t\RestClient\Traits\RequestTrait;
use GuzzleHttp\Exception\GuzzleException;
use Ay4t\RestClient\Abstracts\AbstractClient;
use Ay4t\RestClient\Interfaces\ClientInterface;
use Ay4t\RestClient\Interfaces\LoggerInterface;
use Ay4t\RestClient\Logger\DefaultLogger;
use Ay4t\RestClient\Exceptions\ApiException;
use Ay4t\RestClient\Config\Config;

class Client extends AbstractClient implements ClientInterface
{
    use RequestTrait;

    /**
     * @var array
     */
    private $request_options = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var int
     */
    private $maxRetries = 3;

    /**
     * @var int
     */
    private $retryDelay = 1000; // milliseconds

    /**
     * Client constructor.
     * @param array|Config $config Configuration array or Config object
     * @param LoggerInterface|null $logger Optional logger instance
     */
    public function __construct($config = [], LoggerInterface $logger = null)
    {
        if (is_array($config)) {
            $configObj = new Config();
            if (isset($config['base_uri'])) {
                $configObj->setBaseUri($config['base_uri']);
            }
            if (isset($config['headers']['Authorization'])) {
                $apiKey = str_replace('Bearer ', '', $config['headers']['Authorization']);
                $configObj->setApiKey($apiKey);
            }
            $config = $configObj;
        }

        parent::__construct($config);
        $this->logger = $logger ?? new DefaultLogger();
    }

    /**
     * Set the maximum number of retries for failed requests
     */
    public function setMaxRetries(int $maxRetries): self
    {
        $this->maxRetries = $maxRetries;
        return $this;
    }

    /**
     * Set the delay between retries in milliseconds
     */
    public function setRetryDelay(int $delay): self
    {
        $this->retryDelay = $delay;
        return $this;
    }

    /**
     * setRequestOptions
     * @param array $request_options
     * @return self
     */
    public function setRequestOptions(array $request_options): self {
        $this->request_options = $request_options;
        return $this;
    }

    /**
     * Perform a request to the API server with retry mechanism.
     *
     * @param string $method The HTTP method to use for the request.
     * @param string $command The command to send to the API.
     * @param array $params The parameters to send in the request.
     * @return mixed The response from the API server.
     * @throws ApiException If the request to the API server fails after all retries.
     */
    public function cmd(string $method = 'GET', string $command, array $params = [])
    {
        $url = $this->config->getBaseUri() . '/' . $command;
        $requestOptions = [];

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

        // Log the request
        $this->logger->logRequest($method, $url, $requestOptions);

        $attempts = 0;
        $lastException = null;

        while ($attempts < $this->maxRetries) {
            try {
                $response = $this->client->request($method, $url, $requestOptions);
                $body = $response->getBody()->getContents();
                
                // Log successful response
                $this->logger->logResponse($response->getStatusCode(), $body);
                
                return json_decode($body, $this->response_associative);
            } catch (GuzzleException $e) {
                $lastException = $e;
                $this->logger->logError($e);
                
                // Don't retry if it's a client error (4xx)
                if ($e->getCode() >= 400 && $e->getCode() < 500) {
                    break;
                }
                
                $attempts++;
                if ($attempts < $this->maxRetries) {
                    usleep($this->retryDelay * 1000); // Convert milliseconds to microseconds
                }
            }
        }

        // If we get here, all retries failed
        throw new ApiException(
            'API request failed after ' . $attempts . ' attempts: ' . $lastException->getMessage(),
            $lastException->getCode() ?? 0,
            $lastException->getResponse() ? $lastException->getResponse()->getBody()->getContents() : null,
            $lastException
        );
    }
}
