<?php

namespace Ay4t\RestClient\Config;

class Config
{
	/**
	 * The base URI of the API endpoint.
	 * @var string
	 */
	private $baseUri;

	/**
	 * The API key used for authentication.
	 * @var string
	 */
	private $apiKey;

	/**
	 * The secret key used for authentication (optional).
	 * @var string|null
	 */
	private $secretKey;

	/**
     * Constructor.
     *
     * @param string|null $baseUri
     * @param string|null $apiKey
     * @param string|null $secretKey
     */
    public function __construct(?string $baseUri = null, ?string $apiKey = null, ?string $secretKey = null)
    {
        if ($baseUri !== null) {
            $this->setBaseUri($baseUri);
        }
        if ($apiKey !== null) {
            $this->setApiKey($apiKey);
        }
        if ($secretKey !== null) {
            $this->setSecretKey($secretKey);
        }
    }

	/**
	 * Set the base URI for the API.
	 * 
	 * @param string $baseUri
	 * @return self
	 */
	public function setBaseUri(string $baseUri): self
	{
		$this->validateBaseUri($baseUri);
		$this->baseUri = $baseUri;
		return $this;
	}

	/**
	 * Set the API key.
	 * 
	 * @param string $apiKey
	 * @return self
	 */
	public function setApiKey(string $apiKey): self
	{
		$this->validateApiKey($apiKey);
		$this->apiKey = $apiKey;
		return $this;
	}

	/**
	 * Set the secret key (optional).
	 * 
	 * @param string $secretKey
	 * @return self
	 */
	public function setSecretKey(string $secretKey): self
	{
		$this->validateSecretKey($secretKey);
		$this->secretKey = $secretKey;
		return $this;
	}

	/**
	 * Get the base URI.
	 * 
	 * @return string
	 */
	public function getBaseUri(): string
	{
		return $this->baseUri;
	}

	/**
	 * Get the API key.
	 * 
	 * @return string
	 */
	public function getApiKey(): string
	{
		return $this->apiKey;
	}

	/**
	 * Get the secret key.
	 * 
	 * @return string|null
	 */
	public function getSecretKey(): ?string
	{
		return $this->secretKey;
	}

	/**
	 * Validate the base URI.
	 * 
	 * @param string $baseUri
	 * @throws \InvalidArgumentException
	 */
	private function validateBaseUri(string $baseUri): void
	{
		if (empty($baseUri) || !filter_var($baseUri, FILTER_VALIDATE_URL)) {
			throw new \InvalidArgumentException('Base URI is not valid');
		}
	}

	/**
	 * Validate the API key.
	 * 
	 * @param string $apiKey
	 * @throws \InvalidArgumentException
	 */
	private function validateApiKey(string $apiKey): void
	{
		if (empty($apiKey) || strlen($apiKey) < 10) {
			throw new \InvalidArgumentException('API key must be at least 10 characters long');
		}
	}

	/**
	 * Validate the secret key.
	 * 
	 * @param string $secretKey
	 * @throws \InvalidArgumentException
	 */
	private function validateSecretKey(string $secretKey): void
	{
		if (!empty($secretKey) && strlen($secretKey) < 10) {
			throw new \InvalidArgumentException('Secret key, if provided, must be at least 10 characters long');
		}
	}
}