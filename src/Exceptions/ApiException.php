<?php

namespace Ay4t\RestClient\Exceptions;

class ApiException extends \Exception
{
    private $httpStatusCode;
    private $responseBody;

    public function __construct(string $message, int $httpStatusCode = 0, $responseBody = null, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->httpStatusCode = $httpStatusCode;
        $this->responseBody = $responseBody;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }
}
