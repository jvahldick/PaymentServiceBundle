<?php

namespace JHV\Payment\ServiceBundle\Model;

/**
 * PaymentMethodInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
 */
interface PaymentMethodInterface
{
 
    /**
     * Define o nome do meio de pagamento
     * 
     * @param string $name
     * @return self
     */
    function setName($name);
    
    /**
     * Localiza o nome do meio de pagamento
     * 
     * @return string
     */
    function getName();
    
    /**
     * Define uma descrição para o meio de pagamento
     * 
     * @param string $description
     * @return self
     */
    function setDescription($description);
    
    /**
     * Localiza a descrição definida para o meio de pagamento
     * 
     * @return string
     */
    function getDescription();
    
    /**
     * Pergunta: Deseja ativar o meio de pagamento?
     * Define a visibilidade para o meio de pagamento.
     * 
     * @param boolean $boolean
     * @return self
     */
    function setEnabled($boolean);
    
    /**
     * Retorno para pergunta:
     * O meio de pagamento está habilitado?
     * 
     * @return boolean
     */
    function isEnabled();
    
    /**
     * Método no qual define qual o serviço (plugin) que está 
     * associado ao meio de pagamento
     * 
     * @param \JHV\Payment\ServiceBundle\Plugin\PluginInterface $plugin
     * @return self
     */
    function setPlugin(\JHV\Payment\ServiceBundle\Plugin\PluginInterface $plugin);
    
    /**
     * Retorna o objeto Plugin associado ao meio de pagamento.
     * 
     * @return \JHV\Payment\ServiceBundle\Plugin\PluginInterface
     */
    function getPlugin();
    
    /**
     * Este método serve para definir este código de integração.
     * 
     * Para integração coms os serviços de pagamento, é necessário
     * uma definição de um código para identificar o meio de pagamento.
     * 
     * @param string $code
     * @return self
     */
    function setCode($code);
    
    /**
     * Localiza o código de integração do meio de pagamento
     * 
     * @return string
     */
    function getCode();
    
    /**
     * Define uma imagem para o meio de pagamento.
     * Deverá ser informado o caminho completo de onde a imagem se encontra.
     * 
     * @param string $image
     * @return self
     */
    function setImage($image);
    
    /**
     * Localiza a imagem para o meio de pagamento.
     * 
     * @return string
     */
    function getImage();
    
}