<?php

namespace JHV\Payment\ServiceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jhv_payment_service');

        $rootNode
            ->children()
                
                // Template de exibição do twig
                ->scalarNode('default_template')->defaultValue('JHVPaymentServiceBundle:Form:payment_methods.html.twig')->end()
                
                // Security data
                ->arrayNode('security')
                    ->children()
                        ->scalarNode('secret_key')->isRequired()->end()
                        ->scalarNode('cipher')->defaultValue(MCRYPT_RIJNDAEL_256)->end()
                        ->scalarNode('mode')->defaultValue(MCRYPT_MODE_CFB)->end()
                    ->end()
                ->end()
                
                // Verificar as classes registradas
                ->arrayNode('classes')
                    ->children()
                        ->scalarNode('plugin_manager')->defaultValue('JHV\\Payment\\ServiceBundle\\Manager\\PluginManager')->end()
                        ->scalarNode('payment_method_manager')->defaultValue('JHV\\Payment\\ServiceBundle\\Manager\\PaymentMethodManager')->end()
                        ->scalarNode('payment_method_class')->defaultValue('JHV\\Payment\\ServiceBundle\\Model\\PaymentMethod')->end()
                        ->scalarNode('payment_selector_type')->defaultValue('JHV\\Payment\\ServiceBundle\\Form\\Type\\PaymentSelectorType')->end()
                        ->scalarNode('payment_selector_factory')->defaultValue('JHV\\Payment\\ServiceBundle\\Factory\\PaymentFormFactory')->end()
                        ->scalarNode('encrypter')->defaultValue('JHV\\Payment\\ServiceBundle\\Security\\Encrypter')->end()
                        ->scalarNode('twig_extension')->defaultValue('JHV\\Payment\\ServiceBundle\\Twig\\Extension\\PaymentServiceExtension')->end()
                        ->scalarNode('payment_instruction_class')->isRequired()->end()
                    ->end()
                ->end()
                
                // Listagem de meios de pagamentos registrados
                ->arrayNode('payment_methods')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('code')->cannotBeEmpty()->isRequired()->end()
                            ->scalarNode('name')->cannotBeEmpty()->isRequired()->end()
                            ->scalarNode('plugin')->cannotBeEmpty()->isRequired()->end()
                            ->scalarNode('enabled')->defaultTrue()->end()
                            ->scalarNode('visible')->defaultTrue()->end()
                            ->scalarNode('description')->defaultNull()->end()
                            ->scalarNode('image')->defaultNull()->end()
                            ->arrayNode('extra_data')
                                ->useAttributeAsKey('id')
                                    ->prototype('scalar')
                                ->end()
                                ->defaultValue(array())
                            ->end()
                        ->end()
                    ->end()
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }
}
