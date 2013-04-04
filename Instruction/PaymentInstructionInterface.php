<?php

namespace JHV\Payment\ServiceBundle\Instruction;

/**
 * PaymentInstructionInterface
 * 
 * @copyright (c) 2013, Quality Press
 * @author Jorge Vahldick <jvahldick@gmail.com>
 */
interface PaymentInstructionInterface
{
    
    const STATE_OPENED = 1;
    const STATE_CLOSED = 2;
    const STATE_INVALID = 3;
    
    /**
     * Define o nome do "plugin" utilizado para transação
     * Serviço: nome do gateway definido em ServiceBundle
     * 
     * @param string $service
     * @return self
     */
    function setServiceName($service);
    
    /**
     * Localização do nome do serviço / plugin utilizado para transação
     * 
     * @return string
     */
    function getServiceName();
    
    /**
     * Define o meio de pagamento escolhido
     * 
     * @param string $paymentMethod
     * @return self
     */
    function setPaymentMethod($paymentMethod);
    
    /**
     * Localiza o nome do meio de pagamento escolhido
     * 
     * @return string
     */
    function getPaymentMethod();
    
    /**
     * Definirá qual a moeda do pagamento
     * A moeda deverá ser definida com sua sigla, de acordo
     * com as regras da ISO-4217
     * 
     * @link http://www.iso.org/iso/home/standards/currency_codes.htm Descrição da ISO
     * @link http://www.xe.com/iso4217.php Siglas em conformidade com seus países
     * 
     * @param string $currency
     * @return self
     */
    function setCurrency($currency);
    
    /**
     * Localizará a sigla da moeda escolhida para instrução de pagamento
     * Sigla esta armazenada de acordo com ISO-4217
     * 
     * @return string
     */
    function getCurrency();
    
    /**
     * Definição do valor de pagamento
     * 
     * @param decimal $amount
     * @return self
     */
    function setAmount($amount);
    
    /**
     * Localiza qual o valor definido para o pagamento
     * 
     * @return decimal
     */
    function getAmount();
    
    /**
     * Definirá o estado da instrução de pagamento
     * Estados disponíveis:
     * 1: STATE_OPENED  - Instrução em aberto
     * 2: STATE_CLOSED  - Instrução já finalizada
     * 3: STATE_INVALID - Instrução inválida
     * 
     * @param integer $state
     * @return self
     */
    function setState($state);
    
    /**
     * Localizará em qual estado a instrução de pagamento se encontra
     * 
     * 1: STATE_OPENED  - Instrução em aberto
     * Este estado significa que ainda há operações internas em aberto
     * 
     * 2: STATE_CLOSED  - Instrução já finalizada
     * Não há transações ou operações em aberto
     * 
     * 3: STATE_INVALID - Instrução inválida
     * Significa que houve erros em relação a "última tentativa" de executar
     * uma operação junto ao serviço definido
     * 
     * @return integer
     */
    function getState();
    
    /**
     * Método para definir informações extras quanto a instrução
     * Por exemplo: dados de cartão de crédito
     * 
     * Por momento este dados não serão armazenados no banco de dados
     * por questões de segurança
     * 
     * @param array $data
     * @return self
     */
    function setExtendedData(array $data);
    
    /**
     * Método no qual localizará os dados extras de
     * um serviço de pagamento
     * 
     * Estes dados serão visíveis somente em uma mesma
     * requisição cliente / servidor por questões de segurança
     * 
     * @return array|null
     */
    function getExtendedData();
    
}
