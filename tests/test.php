<?php

use Ay4t\RestClient\Client;
use Ay4t\RestClient\Config\Config;
use Kint\Kint;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$env = $dotenv->load();


// Kint::dump( $env );
// die;

$groq_api_key       = $env['API_KEY'];
$groq_api_url       = $env['GROQ_API_URL'];

// Cara 1: Menggunakan Config object (direkomendasikan)
/* $config = new Config();
$config->setBaseUri($groq_api_url)
       ->setApiKey($groq_api_key); */

// Cara 2: Menggunakan array (alternatif)
$config = [
    'base_uri' => $groq_api_url,
    'headers' => [
        'Authorization' => 'Bearer ' . $groq_api_key
    ]
];

$client     = new Client($config);

/* list all models */
try {
    $response = $client->cmd('GET', 'models');
    print_r($response);
} catch (Ay4t\RestClient\Exceptions\ApiException $e) {
    echo "Error: " . $e->getMessage();
    echo "HTTP Status: " . $e->getHttpStatusCode();
    echo "Response Body: " . $e->getResponseBody();
}
die;

/* chat/completions */
try {
    $cmd = $client->cmd('POST', 'chat/completions', [
        'model' => 'deepseek-r1-distill-llama-70b',
        'messages' => [
            [
                'role' => 'user',
                'content'  => 'hi, why is sea water salty?',
            ]
        ]
    ]);

    print_r($cmd);

} catch (Ay4t\RestClient\Exceptions\ApiException $e) {
    echo "Error: " . $e->getMessage();
    echo "HTTP Status: " . $e->getHttpStatusCode();
    echo "Response Body: " . $e->getResponseBody();
}
die;
