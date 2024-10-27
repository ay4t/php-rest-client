<?php

require __DIR__ . '/../vendor/autoload.php';

use Ay4t\RestClient\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use Ay4t\RestClient\Abstracts\AbstractClient;
use Ay4t\RestClient\Config\Config;
use Ay4t\RestClient\Traits\RequestTrait;

class ClientTest extends TestCase
{
    private $client;
    private $mockHandler;
    private $handlerStack;

    /* api endpoint Ollama LLM */
    private $base_url_test = 'http://127.0.0.1:8080';

    /**
    * __construct
    * @return parent::__construct()
    */
    public function init()
    {
        $this->mockHandler  = new MockHandler();
        $this->handlerStack = HandlerStack::create($this->mockHandler);

        $config             = new Config('api_key_panjang_sampai_10_karakter', 'secret_key_panjang_sampai_10_karakter', $this->base_url_test);
        $this->client       = new Client($config);
    }


    public function testCmdSuccessPostRequest()
    {
        $this->init();

        // Test
        $result = $this->client->cmd('POST', 'v1/chat/completions', [
            'model' => 'llama3.2:latest',
            'messages' => [
                [
                    'role' => 'user',
                    'content'  => 'hi, why is sea water salty?',
                ], [
                    'role'  => 'system',
                    'content' => 'You are a helpful assistant.',
                ]
            ],
            'stream' => false,
        ]);

        // $llm_response = $result->choices[0]->message->content;
        // $llm_response = $result;
        print_r($result);

        $llm_response = $result['choices'][0]['message']['content'];
        print_r($llm_response);
        
        $this->assertTrue(!empty($llm_response));

    }

}
