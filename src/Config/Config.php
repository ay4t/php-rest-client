<?php

namespace Ay4t\RestClient\Config;

class Config
{
	/**
	 * The API key used for authentication.
	 * @var string
	 */
	public $apiKey;


	/**
	 * The secret key used for authentication.
	 * @var string
	 */
	public $secretKey;

	/**
	 * The base URL of the API endpoint.
	 * @var string
	 */
	public $apiUrl;

	private function validateParameters(string $apiKey, string $secretKey, string $apiUrl): bool
	{
	  if (empty($apiKey) || empty($secretKey) || empty($apiUrl)) {
	        throw new \InvalidArgumentException('API key, secret key, dan API URL tidak boleh kosong');
	    }
	
	    if (!is_string($apiKey) || !is_string($secretKey) || !is_string($apiUrl)) {
	        throw new \InvalidArgumentException('Semua parameter harus berupa string');
	    }
	
	    if (strlen($apiKey) < 10 || strlen($secretKey) < 10) {
	        throw new \InvalidArgumentException('API key dan secret key harus memiliki panjang minimal 10 karakter');
	    }
	
	    if (!preg_match('/^https?:\/\//', $apiUrl)) {
	        throw new \InvalidArgumentException('API URL tidak valid');
	    }
	
	    return true;
	}
	
	public function __construct(string $apiKey, string $secretKey, string $apiUrl)
	{
	    if ($this->validateParameters($apiKey, $secretKey, $apiUrl)) {
	        $this->apiKey = $apiKey;
	        $this->secretKey = $secretKey;
	        $this->apiUrl = $apiUrl;
	    }
	}

}
