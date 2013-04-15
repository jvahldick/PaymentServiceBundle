<?php

namespace JHV\Payment\ServiceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JHVPaymentServiceExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        // Definição de classes
        $classes = $config['classes'];
        $container->setParameter('jhv_payment_service.classes.plugin_manager', $classes['plugin_manager']);
        $container->setParameter('jhv_payment_service.classes.payment_method_manager', $classes['payment_method_manager']);
        $container->setParameter('jhv_payment_service.classes.payment_method_class', $classes['payment_method_class']);
        $container->setParameter('jhv_payment_service.classes.payment_selector_type', $classes['payment_selector_type']);
        $container->setParameter('jhv_payment_service.classes.payment_selector_factory', $classes['payment_selector_factory']);
        $container->setParameter('jhv_payment_service.classes.payment_instruction_class', $classes['payment_instruction_class']);
        $container->setParameter('jhv_payment_service.classes.encrypter', $classes['encrypter']);
        $container->setParameter('jhv_payment_service.classes.twig_extension', $classes['twig_extension']);
        
        // Parâmetro para exibição do template
        $container->setParameter('jhv_payment_service.template.default_template', $config['default_template']);
        
        // Definição de parâmetros de segurança
        $security = $config['security'];
        $container->setParameter('jhv_payment_service.security.param.secret_key', $security['secret_key']);
        $container->setParameter('jhv_payment_service.security.param.cipher', $security['cipher']);
        $container->setParameter('jhv_payment_service.security.param.mode', $security['mode']);
        
        $container->setParameter('payment_methods', $config['payment_methods']);
    }
}
