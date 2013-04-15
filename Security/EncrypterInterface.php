<?php

namespace JHV\Payment\ServiceBundle\Security;

/**
 * EncrypterInterface
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
interface EncrypterInterface
{
    
    /**
     * Encripta alguma string passada por parâmetro
     * 
     * @param string $string
     * @return string
     */
    function encrypt($string);
    
    /**
     * Efetua a desencripta alguma string criptografada passada por parâmetro
     * 
     * @param string $string
     * @return
     */
    function decrypt($string);
    
    /**
     * Percorre o array para efetuando a criptografia dos itens
     * 
     * @param array $array
     * @return array
     */
    function recursiveEncrypt(array $array);
    
    /**
     * Percorre o array para efetuando a descriptografia dos itens
     * 
     * @param array $array
     * @return array
     */
    function recursiveDecrypt(array $array);
    
}