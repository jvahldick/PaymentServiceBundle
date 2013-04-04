<?php

namespace JHV\Payment\ServiceBundle\Plugin;

/**
 * GatewayPlugin
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
abstract class GatewayPlugin extends Plugin
{
    
    protected $curlOptions;
    
    public function __construct()
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('The cURL PHP Extension is not accessible, please activate it first.');
        }
        
        $this->curlOptions = array();
    }
    
    /**
     * 
     * 
     * @param type $name
     * @param type $value
     * 
     * @return \JHV\Payment\ServiceBundle\Plugin\GatewayPlugin
     * @throws \RuntimeException
     */
    public function addCurlOption($name, $value)
    {        
        $this->curlOptions[$name] = $value;
        return $this;
    }
    
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }
    
}