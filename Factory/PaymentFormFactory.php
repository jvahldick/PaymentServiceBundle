<?php

namespace JHV\Payment\ServiceBundle\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormInterface;

/**
 * PaymentFormFactory
 * 
 * Serviço funcionando como um atalho para criação do formulário
 * Através do método create automaticamente o form factory do Symfony
 * será acessado e criará um formulário para seleção de meios de pagamento
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class PaymentFormFactory
{
    
    protected $factory;
    protected $formType;
    
    public function __construct(FormFactoryInterface $formFactory, FormTypeInterface $formType)
    {
        $this->factory = $formFactory;
        $this->formType = $formType;
    }
    
    /**
     * Método de atalho para criação do formulário com a lista
     * de meios de pagamento para exibição ao usuário
     * 
     * @param decimal $amount
     * @param string $currency
     * @param array $options
     * 
     * @return FormInterface
     */
    public function create($amount, $currency, $options = array())
    {
        if (false === is_float($amount)) {
            throw new \InvalidArgumentException(sprintf('The amount value "%s" must has float format', $amount));
        }
        
        if (false === is_string($currency) || strlen($currency) !== 3) {
            throw new \InvalidArgumentException(sprintf('Currency "%s" is invalid. The currency argument must be compatible with ISO 4217. Please check: http://www.xe.com/iso4217.php', $currency));
        }
        
        $options = array_merge(array(
            'amount' => $amount,
            'currency' => $currency,
        ), $options);
        
        return $this->factory->create($this->formType, null, $options);
    }
    
}