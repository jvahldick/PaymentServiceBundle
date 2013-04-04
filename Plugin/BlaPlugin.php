<?php

namespace JHV\Payment\ServiceBundle\Plugin;

/**
 * BlaPlugin
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class BlaPlugin extends GatewayPlugin
{
    public function getName()
    {
        return 'bla_plugin';
    }    
}