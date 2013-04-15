<?php

namespace JHV\Payment\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultController
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013
 */
class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('JHVPaymentServiceBundle::teste.html.twig', array());
    }
    
}