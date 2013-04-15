<?php

namespace JHV\Payment\ServiceBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use JHV\Payment\ServiceBundle\Model\PaymentMethodInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * PaymentMethodIntoPaymentInstructionTransformer
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class PaymentMethodIntoPaymentInstructionTransformer implements DataTransformerInterface
{
    
    protected $selector;
    protected $options;
    
    public function __construct(FormTypeInterface $selector, array $options)
    {
        $this->selector = $selector;
        $this->options = $options;
    }
    
    public function reverseTransform($value)
    {
        $ppm    = $this->selector->getPaymentMethodManager();
        $method = isset($value['payment_method']) ? $ppm->get($value['payment_method']) : null;
        
        if (null !== $method && null !== $plugin = $method->getPlugin()) {
            $value = isset($value['data_'.$plugin->getName()]) ? $value['data_'.$plugin->getName()] : array();
            if (isset($this->options['predefined_data'][$method->getId()])) {
                $value = array_merge($value, $this->options['predefined_data'][$method->getId()]);
            }
            
            // $encryptedData = (is_array($value)) ? $this->selector->getEncrypter()->recursiveEncrypt($value) : $this->selector->getEncrypter()->encrypt($value);
            $encryptedData = $value;
        }
        
        if ($method instanceof PaymentMethodInterface) {
            $class = $this->selector->getDataClass();
            $object = new $class($this->options['amount'], $this->options['currency']);
            $object
                ->setExtendedData($encryptedData)
                ->setPaymentMethod($method->getId())
                ->setServiceName($plugin->getName())
            ;
        } else {
            $object = $value;
        }
        
        return $object; 
    }

    public function transform($value)
    {
        if (null !== $value) {
            return $value->getPaymentMethod();
        }
    }
    
}