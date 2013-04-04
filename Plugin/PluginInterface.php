<?php

namespace JHV\Payment\ServiceBundle\Plugin;

use JHV\Payment\ProcessBundle\Model\TransactionInterface;

/**
 * PluginInterface
 * Interface reference ao Plugin
 * 
 * Descrição
 * Definição de métodos padrões / comuns aos gateways
 * Não deverão necessariamente implementados
 * 
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
interface PluginInterface
{
   
    /**
     * Efetuará a aprovação da transação junto a operadora.
     * 
     * Verificará junto a operadora, através dos dados enviados,
     * se o cliente tem fundos para continuar a operação.
     * 
     * @param \JHV\Payment\ProcessBundle\Model\TransactionInterface $transaction
     * @return void
     */
    function authorize(TransactionInterface $transaction);
    
    /**
     * Efetuará a autorização e captura de fundos.
     * 
     * Verificará se o requisitante tem fundos para continuação da transação,
     * caso o resultado seja positivo, na sequência, estes fundos verificados
     * serão solicitados para uma "transferência", no qual identifica que
     * a transação está completa.
     * 
     * @param \JHV\Payment\ProcessBundle\Model\TransactionInterface $transaction
     * @return void
     */
    function authorizeCapture(TransactionInterface $transaction);
    
    /**
     * Solicitação de transferência de fundos.
     * 
     * Este método efetuará uma requisição junto a operadora para que haja
     * uma transferência de fundos da conta do cliente para conta do
     * prestador de serviços.
     * 
     * @param \JHV\Payment\ProcessBundle\Model\TransactionInterface $transaction
     * @return void
     */
    function capture(TransactionInterface $transaction);
    
    /**
     * Cancelamento e estorno de fundos da transação.
     * 
     * Operação que realizará o cancelamento da transação realizada, e também
     * efetuará uma requisição para que haja um estorno de fundos para conta
     * do cliente no qual efetuou a requisição.
     * 
     * @param \JHV\Payment\ProcessBundle\Model\TransactionInterface $transaction
     */
    function refund(TransactionInterface $transaction);
    
    /**
     * Identificar o nome do plugin em questão.
     * Obrigatoriamente este método deve ser implementado em cada plugin.
     * 
     * @return string
     */
    function getName();
    
}