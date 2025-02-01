# PHP REST Client

A flexible and robust PHP REST Client with advanced features for handling API requests.

## Features

- 🚀 Simple and intuitive API
- 🔄 Automatic retry mechanism for failed requests
- 📝 Comprehensive logging system
- ⚡ Custom exception handling
- 🔒 Configurable request options
- 🛠 Extensible architecture

## Installation

Install via Composer:

```bash
composer require ay4t/php-rest-client
```

## Basic Usage

### Using Config Object (Recommended)

```php
use Ay4t\RestClient\Client;
use Ay4t\RestClient\Config\Config;

// Initialize config
$config = new Config();
$config->setBaseUri('https://api.example.com')
       ->setApiKey('your-api-key-here');

$client = new Client($config);

// Make a GET request
try {
    $response = $client->cmd('GET', 'users');
    print_r($response);
} catch (Ay4t\RestClient\Exceptions\ApiException $e) {
    echo "Error: " . $e->getMessage();
    echo "HTTP Status: " . $e->getHttpStatusCode();
    echo "Response Body: " . $e->getResponseBody();
}
```

### Using Array Configuration (Alternative)

```php
use Ay4t\RestClient\Client;

// Initialize with array config
$config = [
    'base_uri' => 'https://api.example.com',
    'headers' => [
        'Authorization' => 'Bearer your-api-key-here'
    ]
];

$client = new Client($config);
```

## Advanced Features

### Custom Logging

```php
use Ay4t\RestClient\Logger\DefaultLogger;
use Ay4t\RestClient\Config\Config;

// Setup configuration
$config = new Config();
$config->setBaseUri('https://api.example.com')
       ->setApiKey('your-api-key-here');

// Custom log file location
$logger = new DefaultLogger('/path/to/custom.log');
$client = new Client($config, $logger);

// Logs will include:
// - Request details (method, URL, options)
// - Response status and body
// - Any errors that occur
```

### Retry Mechanism

```php
// Configure retry settings
$client->setMaxRetries(5)      // Maximum number of retry attempts
       ->setRetryDelay(2000);  // Delay between retries in milliseconds

// The client will automatically:
// - Retry failed requests (except 4xx errors)
// - Wait between attempts
// - Throw ApiException after all retries fail
```

### Request Options

```php
// Set global request options
$client->setRequestOptions([
    'timeout' => 30,
    'verify' => false,  // Disable SSL verification
    'headers' => [
        'User-Agent' => 'My Custom User Agent'
    ]
]);
```

### Error Handling

```php
use Ay4t\RestClient\Exceptions\ApiException;

try {
    $response = $client->cmd('POST', 'users', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);
} catch (ApiException $e) {
    // Get detailed error information
    $statusCode = $e->getHttpStatusCode();
    $responseBody = $e->getResponseBody();
    $message = $e->getMessage();
    
    // Handle different status codes
    switch ($statusCode) {
        case 404:
            echo "Resource not found";
            break;
        case 401:
            echo "Unauthorized access";
            break;
        default:
            echo "An error occurred: $message";
    }
}
```

## Implementing Custom Logger

You can implement your own logger by implementing the `LoggerInterface`:

```php
use Ay4t\RestClient\Interfaces\LoggerInterface;

class MyCustomLogger implements LoggerInterface
{
    public function logRequest(string $method, string $url, array $options): void
    {
        // Your custom request logging logic
    }

    public function logResponse(int $statusCode, string $body): void
    {
        // Your custom response logging logic
    }

    public function logError(\Throwable $exception): void
    {
        // Your custom error logging logic
    }
}

// Use your custom logger
$client = new Client($config, new MyCustomLogger());
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.