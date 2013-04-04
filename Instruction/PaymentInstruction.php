<?php

namespace JHV\Payment\ServiceBundle\Instruction;

/**
 * PaymentInstruction
 * 
 * @copyright (c) 2013, Quality Press
 * @author Jorge Vahldick <jvahldick@gmail.com>
 */
class PaymentInstruction implements PaymentInstructionInterface
{
    
    protected $serviceName;
    protected $paymentMethod;
    protected $currency;
    protected $amount;
    protected $state;
    protected $extendedData;
    
    public function __construct()
    {
        $this->amount   = 0.00;
        $this->state    = PaymentInstructionInterface::STATE_OPENED;
        $this->extendedData = array();
    }
    
    
    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getExtendedData()
    {
        return $this->extendedData;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function setExtendedData(array $data)
    {
        $this->extendedData = $data;
        return $this;
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function setServiceName($service)
    {
        $this->serviceName = $service;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    
}