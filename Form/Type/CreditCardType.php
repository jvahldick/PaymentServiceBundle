<?php

namespace JHV\Payment\ServiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

/**
 * Type
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class CreditCardType extends AbstractType
{
    
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', 'text')
            ->addEventListener(FormEvents::POST_BIND, function(FormEvent $e) {
                $e->setData(array());
                print_r($e->getData());
            })
        ;
        
        
        
        parent::buildForm($builder, $options);
    }
    
    public function getName()
    {
        return 'credit_card';
    }
    
}