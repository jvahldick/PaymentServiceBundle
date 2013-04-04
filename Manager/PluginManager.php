<?php

namespace JHV\Payment\ServiceBundle\Manager;

use JHV\Payment\ServiceBundle\Plugin\PluginInterface;

/**
 * PluginManager
 * 
 * Descrição:
 * Classe que gerenciará os plugins registrados.
 * Basicamente os métodos contidos neste, trabalharão sob um controle
 * de um array, onde estarão objetos do implementados de PluginInterface.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class PluginManager implements PluginManagerInterface, \Countable
{
    
    protected $plugins;
    protected $formTypes;
    
    public function __construct()
    {
        $this->plugins = array();
        $this->formTypes = array();
    }
    
    public function count()
    {
        return count($this->plugins, COUNT_NORMAL);
    }

    public function add(PluginInterface $plugin)
    {
        $this->plugins[$plugin->getName()] = $plugin;
    }

    public function all()
    {
        return $this->plugins;
    }

    public function get($name)
    {
        return ($this->has($name)) ? $this->plugins[$name] : null;
    }

    public function has($name)
    {
        return key_exists($name, $this->plugins);
    }
    
    public function addExtraForm($name, $form_type_name)
    {
        $this->formTypes[$name] = $form_type_name;
        return $this;
    }

    public function getExtraForm($name)
    {
        return ($this->hasExtraForm($name)) ? $this->formTypes[$name] : null;
    }

    public function hasExtraForm($name)
    {
        return isset($this->formTypes[$name]);
    }
    
}