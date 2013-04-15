<?php

namespace JHV\Payment\ServiceBundle\Model;

/**
 * PaymentMethod
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class PaymentMethod implements PaymentMethodInterface
{
    
    protected $id;
    protected $name;
    protected $description;
    protected $enabled;
    protected $visible;
    protected $plugin;
    protected $code;
    protected $image;
    protected $extendedData;
            
    function __construct($id, $name, $description, $enabled, $visible, $plugin, $code = null, $image = null, array $extraData = array())
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->image = $image;
        $this->enabled = $enabled;
        $this->visible = $visible;
        $this->plugin = $plugin;
        $this->description = $description;
        $this->extendedData = $extraData;
    }
    
    public function getId()
    {
        return $this->id;
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
    
    public function setVisible($visible)
    {
        $this->visible = $visible;
        return $this;
    }
    
    public function isVisible()
    {
        return $this->visible;
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
    
    public function getExtendedData()
    {
        return $this->extendedData;
    }

    public function setExtendedData(array $data)
    {
        $this->extendedData = $data;
        return $this;
    }
    
}