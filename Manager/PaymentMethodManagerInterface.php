<?php

namespace JHV\Payment\ServiceBundle\Manager;

use JHV\Payment\ServiceBundle\Model\PaymentMethodInterface;

/**
 * PaymentMethodManagerInterface
 * 
 * Gerenciador dos meios de pagamentos.
 * Através desta classe é possível efetuar a localização de algum meio de pagamento,
 * efetuar novos registros e verificação de existência.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
interface PaymentMethodManagerInterface
{
    
    /**
     * Adicionar um novo meio de pagamento.
     * Através deste método poderá ser adicionado um novo 
     * meio de pagamento ao gerenciador.
     * 
     * @param string $id
     * @param \JHV\Payment\ServiceBundle\Model\PaymentMethodInterface $paymentMethod
     * @return self
     */
    function add($id, PaymentMethodInterface $paymentMethod);
    
    /**
     * Efetua a criação de um novo meio de pagamento e adicionará
     * automaticamente a um array com os meios de pagamento registrados.
     * 
     * @param string $id
     * @param array $args
     * @param boolean $add
     * 
     * @return self
     */
    function create($id, array $args, $add = true);
    
    /**
     * Verifica se o meio de pagamento está registrado.
     * 
     * @param string $name Identificador do meio de pagamento
     * @return boolean
     */
    function has($name);
    
    /**
     * Através de um nome identificador do meio de pagmaento, o gerenciador
     * efetuará uma busca para sua localização.
     * 
     * @param string $name
     * @return \JHV\Payment\ServiceBundle\Plugin\PluginInterface
     */
    function get($name);
    
    /**
     * Localizar todos os meios de pagamento.
     * Retornará através de um array, todos os meios de pagamento registrados.
     * 
     * @return array
     */
    function all();
    
}