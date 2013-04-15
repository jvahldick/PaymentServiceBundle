<?php

namespace JHV\Payment\ServiceBundle\Plugin;

use JHV\Payment\ServiceBundle\Exception\UnaccessibleFunctionException;
use JHV\Payment\ServiceBundle\Model\PaymentMethodInterface;
use JHV\Payment\CoreBundle\Financial\TransactionInterface;

/**
 * Plugin
 * 
 * Descrição:
 * Classe abstrata no intuito de definir os métodos comuns que serão
 * chamados pelo operador dos plugins.
 * 
 * Caso o método não tenha sido implementado até o momento de seu chamado,
 * causará erro auxiliando ao "usuário/desenvolvedor" para implementação do mesmo.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013
 */
abstract class Plugin implements PluginInterface
{
    
    public function authorize(TransactionInterface $transaction, PaymentMethodInterface $method)
    {
        throw new UnaccessibleFunctionException(sprintf(array(
            'The "%s" function has not been developed yet for this plugin.',
            'authorize'
        )));
    }

        public function authorizeCapture(TransactionInterface $transaction, PaymentMethodInterface $method)
    {
        throw new UnaccessibleFunctionException(sprintf(array(
            'The "%s" function has not been developed yet for this plugin.',
            'authorizeCapture'
        )));
    }

    public function capture(TransactionInterface $transaction, PaymentMethodInterface $method)
    {
        throw new UnaccessibleFunctionException(sprintf(array(
            'The "%s" function has not been developed yet for this plugin.',
            'capture'
        )));
    }

    public function refund(TransactionInterface $transaction, PaymentMethodInterface $method)
    {
        throw new UnaccessibleFunctionException(sprintf(array(
            'The "%s" function has not been developed yet for this plugin.',
            'refund'
        )));
    }

    public abstract function getName();
    
}