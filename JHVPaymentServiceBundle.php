<?php

namespace JHV\Payment\ServiceBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use JHV\Payment\ServiceBundle\DependencyInjection\Compiler\PluginInjector;
use JHV\Payment\ServiceBundle\DependencyInjection\Compiler\PaymentMethodInjector;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JHVPaymentServiceBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new PluginInjector());
        $container->addCompilerPass(new PaymentMethodInjector());
    }
    
}
