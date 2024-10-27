<?php

require __DIR__ . '/../vendor/autoload.php';

use Ay4t\RestClient\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function testKonstruktorDenganApiKeySekretKeyDanApiUrl()
    {
        $apiKey = '1234567890';
        $secretKey = 'abcdefghij';
        $apiUrl = 'https://example.com/api';

        $config = new Config($apiKey, $secretKey, $apiUrl);

        $this->assertEquals($apiKey, $config->apiKey);
        $this->assertEquals($secretKey, $config->secretKey);
        $this->assertEquals($apiUrl, $config->apiUrl);
    }

    /**
     * @test
     */
    public function testKonstruktorDenganApiKeyKosong()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('', 'abcdefghij', 'https://example.com/api');
    }

    /**
     * @test
     */
    public function testKonstruktorDenganSecretKeyKosong()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('1234567890', '', 'https://example.com/api');
    }

    /**
     * @test
     */
    public function testKonstruktorDenganApiUrlKosong()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('1234567890', 'abcdefghij', '');
    }

    /**
     * @test
     */
    public function testKonstruktorDenganApiKeyTidakValid()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('abc', 'abcdefghij', 'https://example.com/api');
    }

    /**
     * @test
     */
    public function testKonstruktorDenganSecretKeyTidakValid()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('1234567890', 'abc', 'https://example.com/api');
    }

    /**
     * @test
     */
    public function testKonstruktorDenganApiUrlTidakValid()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Config('1234567890', 'abcdefghij', 'abc');
    }
}
