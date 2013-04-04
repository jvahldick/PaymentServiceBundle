<?php

namespace JHV\Payment\ServiceBundle\Model;

/**
 * PaymentMethod
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class PaymentMethod implements PaymentMethodInterface
{
    
    protected $name;
    protected $description;
    protected $enabled;
    protected $plugin;
    protected $code;
    protected $image;
    
    function __construct($name, $description, $enabled, $plugin, $code = null, $image = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->image = $image;
        $this->enabled = $enabled;
        $this->plugin = $plugin;
        $this->description = $description;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
    
    public function getPlugin()
    {
        return $this->plugin;
    }
    
    public function setPlugin(\JHV\Payment\ServiceBundle\Plugin\PluginInterface $plugin)
    {
        $this->plugin = $plugin;
        return $this;
    }
    
}