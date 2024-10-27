<?php

namespace Ay4t\RestClient\Traits;

trait RequestTrait
{
    /**
     * Set response to associative array or object
     * @var boolean
     */
    protected $response_associative = true;

    
    /**
     * Set response to associative array or object
     * @param {boolean} value if true, response will be associative array or object
     * @return {this} instance of class
     */
    public function setResponseAssociative(bool $value) : self
    {
        $this->response_associative = $value;
        return $this;
    }

    public function prepareParams(array $params): string
    {
        return http_build_query($params);
    }
}
