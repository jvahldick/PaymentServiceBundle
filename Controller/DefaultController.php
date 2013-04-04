<?php

namespace JHV\Payment\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * DefaultController
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {   
        $plugin = $this->get('jhv_payment_service.manager.payment_method');
        $object = $plugin->get('cobrebem_visa');
        
        $form = $this->createForm('payment_selector', null, array(
            'currency' => 'BRL',
            'amount' => 10.50
        ));
        
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            $data = $form->getData();
            
            echo '<pre>';
            print_r($data);
        }
        
        return $this->render('JHVPaymentServiceBundle:Form:payment_methods.html.twig', array(
            'teste' => $object,
            'form'  => $form->createView()
        ));
    }
    
}