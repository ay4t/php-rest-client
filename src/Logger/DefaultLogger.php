<?php

namespace Ay4t\RestClient\Logger;

use Ay4t\RestClient\Interfaces\LoggerInterface;

class DefaultLogger implements LoggerInterface
{
    private $logFile;

    public function __construct(string $logFile = null)
    {
        $this->logFile = $logFile ?? sys_get_temp_dir() . '/rest-client.log';
    }

    public function logRequest(string $method, string $url, array $options): void
    {
        $message = sprintf(
            "[%s] Request: %s %s\nOptions: %s\n",
            date('Y-m-d H:i:s'),
            $method,
            $url,
            json_encode($options, JSON_PRETTY_PRINT)
        );
        $this->writeLog($message);
    }

    public function logResponse(int $statusCode, string $body): void
    {
        $message = sprintf(
            "[%s] Response: Status %d\nBody: %s\n",
            date('Y-m-d H:i:s'),
            $statusCode,
            $body
        );
        $this->writeLog($message);
    }

    public function logError(\Throwable $exception): void
    {
        $message = sprintf(
            "[%s] Error: %s\nStack trace: %s\n",
            date('Y-m-d H:i:s'),
            $exception->getMessage(),
            $exception->getTraceAsString()
        );
        $this->writeLog($message);
    }

    private function writeLog(string $message): void
    {
        file_put_contents($this->logFile, $message . "\n", FILE_APPEND);
    }
}
