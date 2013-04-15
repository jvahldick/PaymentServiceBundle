<?php

namespace JHV\Payment\ServiceBundle\Http;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Request
 * Classe que atua para efetuar requisições a rede.
 */
class Request
{
    
    protected   $method;
    protected   $endpoint;
    public      $request;
    public      $headers;

    public function __construct($endpoint, $method, array $request = array(), array $headers = array())
    {
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->request = new ParameterBag($request);
        $this->headers = new HeaderBag($headers);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }
    
}