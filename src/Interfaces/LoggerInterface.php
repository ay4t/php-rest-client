<?php

namespace Ay4t\RestClient\Interfaces;

interface LoggerInterface
{
    public function logRequest(string $method, string $url, array $options): void;
    public function logResponse(int $statusCode, string $body): void;
    public function logError(\Throwable $exception): void;
}
