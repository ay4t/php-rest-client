<?php

use Ay4t\RestClient\Client;
use Ay4t\RestClient\Config\Config;
use Kint\Kint;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$env = $dotenv->load();


/* Kint::dump( $env );
die; */

$groq_api_key       = $env['GROQ_API_KEY'];
$groq_secret_key    = $env['GROQ_SECRET_KEY'];
$groq_api_url       = $env['GROQ_API_URL'];

$config     = new Config();
$config->setBaseUri($groq_api_url)
    ->setApiKey($groq_api_key);
    
$client     = new Client($config);

/* list all models */
$cmd = $client->cmd('GET', 'models', [

]);
echo '<pre>';
print_r($cmd);
echo '</pre>';
die;

/* chat/completions */
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
die;
