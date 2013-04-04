<?php

namespace JHV\Payment\ServiceBundle\Manager;

use JHV\Payment\ServiceBundle\Manager\PluginManagerInterface;

/**
 * PaymentMethodManager
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class PaymentMethodManager implements PaymentMethodManagerInterface, \Countable
{
    
    protected $paymentMethods;
    protected $class;
    protected $pluginManager;
    
    public function __construct(PluginManagerInterface $pluginManager, $dataClass)
    {
        $this->class = $dataClass;
        $this->pluginManager = $pluginManager;
        $this->paymentMethods = array();
    }
    
    public function all()
    {
        return $this->paymentMethods;
    }
    
    public function count()
    {
        return count($this->paymentMethods, COUNT_NORMAL);
    }
    
    public function get($name)
    {
        return ($this->has($name)) ? $this->paymentMethods[$name] : null;
    }
    
    public function has($name)
    {
        return (isset($this->paymentMethods[$name]));
    }
    
    public function add($id, \JHV\Payment\ServiceBundle\Model\PaymentMethodInterface $paymentMethod)
    {
        $this->paymentMethods[$id] = $paymentMethod;
    }
    
    public function create($id, array $args, $add = true)
    {
        $required_args = array('name', 'description', 'enabled', 'code', 'plugin', 'image');
        if (count($diff = array_diff(array_keys($args), $required_args))) {
            throw new \InvalidArgumentException(sprintf(
                'The arguments: %s must be setted',
                $diff
            ));
        }
        
        
        if (false === $this->pluginManager->has($args['plugin'])) {
            throw new \InvalidArgumentException(sprintf(
                'The plugin %s was not registered. You need register it first.',
                $args['plugin']
            ));
        }
        
        $args['plugin'] = $this->pluginManager->get($args['plugin']);
        $class = $this->class;
        $object = new $class($args['name'], $args['description'], $args['enabled'], $args['plugin'], $args['code'], $args['image']);
        
        if (true === $add) {
            $this->add($id, $object);
        }
        
        return $object;
    }
    
}