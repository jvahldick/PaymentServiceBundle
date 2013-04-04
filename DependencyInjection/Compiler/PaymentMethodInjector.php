<?php

namespace JHV\Payment\ServiceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * PaymentMethodInjector
 * 
 * Descrição:
 * Efetuará injeção de todos os meios de pagamentos registrados
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class PaymentMethodInjector implements CompilerPassInterface
{
    
    /**
     * O processo efetuará verificação dos plugins definidos com 
     * TAG "jhv_payment.plugin_extension", analisando a existência da classe
     * deste plugin. Caso exista será executado método add do plugin manager
     * registrando assim o plugin na listagem de plugins
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {        
        if (true === $container->hasDefinition('jhv_payment_service.manager.payment_method')) {
            $definition = $container->getDefinition('jhv_payment_service.manager.payment_method');
            $paymentMethods = $container->getParameter('payment_methods');
            
            if (false === class_exists($container->getParameter('jhv_payment_service.classes.payment_method_manager'))) {
                throw new \InvalidArgumentException(sprintf(
                    'The class "%s" of parameter "%s" does not exist',
                    $container->getParameter('jhv_payment_service.classes.payment_method_class'),
                    'jhv_payment_service.classes.payment_method_manager'
                ));
            }
            
            foreach ($paymentMethods as $id => $args) {
                $definition->addMethodCall('create', array($id, $args));
            }
        }
    }
    
}