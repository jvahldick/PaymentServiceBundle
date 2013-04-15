<?php

namespace JHV\Payment\ServiceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * PluginInjector
 * 
 * Descrição:
 * Classe com o principal objeto de checar todos os plugins já criados
 * e posteriormente adicioná-los ao gerenciador de plugins.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013
 */
class PluginInjector implements CompilerPassInterface
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
        if (true === $container->hasDefinition('jhv_payment_service.manager.plugin')) {
            $definition = $container->getDefinition('jhv_payment_service.manager.plugin');
            foreach ($container->findTaggedServiceIds('jhv_payment.plugin_extension') as $id => $attributes) {
                $definition->addMethodCall('add', array(new Reference($id)));
            }
            
            // Processar formulários extras para os plugins
            $this->processExtraForm($container);
        }
    }
    
    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \RuntimeException
     */
    protected function processExtraForm(ContainerBuilder $container)
    {
        $plugin_manager = $container->get('jhv_payment_service.manager.plugin');
        $pmDefinition = $container->getDefinition('jhv_payment_service.manager.plugin');
        
        foreach ($container->findTaggedServiceIds('jhv_payment.payment_method') as $id => $attributes) {
            $definition = $container->getDefinition($id);
                
            // Verifica se foi definido um formType o meio de pagamento
            $formTypeAttr = $definition->getTag('form.type');
            if (!$formTypeAttr || false == isset($formTypeAttr[0]['alias'])) {
                $errorMsg = (!$formTypeAttr) ? 'tag form.type' : 'alias';
                throw new \RuntimeException(sprintf(
                    'The %s for %s payment method was not defined.',
                    $errorMsg,
                    $id
                ));
            }

            // Verifica se o atributo de plugin está definido
            $methodAttr = $definition->getTag('jhv_payment.payment_method');
            if (false === isset($methodAttr[0]['plugin'])) {
                throw new \RuntimeException(sprintf(
                    'The plugin attribute for %s payment method was not defined',
                    $id
                ));
            }

            // Verifica existência do plugin
            if (false === $plugin_manager->has($methodAttr[0]['plugin'])) {
                throw new \RuntimeException(sprintf(
                    'The plugin %s was not registered',
                    $methodAttr[0]['plugin']
                ));
            }

            // Caso as informações sejam válidas, associará um formType name ao nome do plugin
            $pmDefinition->addMethodCall('addExtraForm', array(
                $methodAttr[0]['plugin'], $formTypeAttr[0]['alias']
            ));
        }
    }
    
}