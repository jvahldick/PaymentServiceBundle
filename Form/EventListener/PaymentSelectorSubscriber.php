<?php

namespace JHV\Payment\ServiceBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * PaymentSelectorSubscriber
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class PaymentSelectorSubscriber implements EventSubscriberInterface
{
    
    protected $options;
    
    public function __construct(array $options)
    {
        $this->options = $options;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_BIND => 'doPreBind',
        );
    }
    
    public function doPreBind(FormEvent $event)
    {
        $data = $event->getData();
    }
    
}