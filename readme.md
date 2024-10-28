Multipurpose PHP Rest Client
=============================

A multipurpose PHP rest client for consuming RESTful web services. This package is designed to be very simple and easy to use.

### Installation

You can install the package via composer:

```bash
composer require ay4t/php-rest-client
```

### Description
Example usage of the `Client` class.

### Example Usage

```php

$config = new Config();
$config->setBaseUri('https://api.openai.com/v1/')
    ->setApiKey('your-api-key-here')
    // optional
    ->setSecretKey('your-secret-key-here');

$client = new Client($config);
$response = $client->cmd('GET', 'models');

echo '<pre>';
print_r($response);
echo '</pre>';
```

or

```php
$cmd = $client->cmd('POST', 'chat/completions', [
    'model' => 'llama-3.1-70b-versatile',
    'messages' => [
        [
            'role' => 'user',
            'content'  => 'hi, why is sea water salty?',
        ]
    ]
]);

echo '<pre>';
print_r($cmd);
echo '</pre>';
```