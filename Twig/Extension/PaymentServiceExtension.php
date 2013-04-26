<?php

namespace JHV\Payment\ServiceBundle\Twig\Extension;

/**
 * PaymentServiceExtension
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class PaymentServiceExtension extends \Twig_Extension
{
    
    protected $container;
    protected $formTemplate;
    
    public function __construct($container, $formTemplate)
    {
        $this->container = $container;
        $this->formTemplate = $formTemplate;
    }
    
    /**
     * Definição de funções que podem ser executadas por esta extensão twig
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'qp_render_payment_methods' => new \Twig_Function_Method($this, 'renderPaymentMethods', array("is_safe" => array("html"))),
            'qp_get_payment_methods'    => new \Twig_Function_Method($this, 'getPaymentMethods', array("is_safe" => array("html"))),
        );
    }
    
    /**
     * Nome identificador da extensão twig
     * @return string
     */
    public function getName()
    {
        return 'jhv_payment_service_extension';
    }
    
    /**
     * 
     */
    public function renderPaymentMethods($amount, $currency = 'BRL', $options = array())
    {
        $form = $this->getFormFactory()->create($amount, $currency, array_merge(array('client_ip' => $this->getRequest()->getClientIp()), $options));
        if ($this->getRequest()->getMethod() === 'POST') {
            $form->bind($this->getRequest());
            
            // Tratamento caso o formulário for válido
            if ($form->isValid()) {
                $instruction = $form->getData();
                
                // Gerenciador dos pagamentos
                $payment_manager = $this->container->get('jhv_payment_core.manager.payment');
                
                // Efetua a persistência da instrução de pagamento
                $payment_manager->createPaymentInstruction($instruction);
                $debit = $payment_manager->createDebit($instruction, $instruction->getAmount());
                
                $result = $payment_manager->authorizeCapture($debit, $debit->getTargetAmount());
            }
        }
        
        return $this->getTwigEngine()->render($this->formTemplate, array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * Localiza o FormFactory para montagem e renderização do formulário
     * @return \JHV\Payment\ServiceBundle\Factory\PaymentFormFactory
     */
    protected function getFormFactory()
    {
        return $this->container->get('jhv_payment_service.factory.payment_process');
    }
    
    /**
     * Localizar array dos meios de pagamento
     * @return array
     */
    public function getPaymentMethods()
    {
        return $this->container->get('jhv_payment_service.manager.payment_method')->all();
    }
    
    /**
     * Localiza o request do container atual
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }
    
    /**
     * Localiza o controlador de layout twig
     * @return \Twig_Environment
     */
    protected function getTwigEngine()
    {
        return $this->container->get('twig');
    }
    
}