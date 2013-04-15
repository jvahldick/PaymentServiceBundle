<?php

namespace JHV\Payment\ServiceBundle\Manager;

use JHV\Payment\ServiceBundle\Plugin\PluginInterface;

/**
 * PluginManagerInterface
 * 
 * Descrição:
 * Interface para implementação de funções básicas para um bom funcionamento
 * do gerenciador de plugins.
 * 
 * Lembrando que o gerenciador de plugins, no caso, efetuará 
 * somente as operações externas ao banco de dados.
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE file
 * @copyright (c) 2013
 */
interface PluginManagerInterface
{
    
    /**
     * Adicionar um novo plugin.
     * Através deste método poderá ser adicionado um novo plugin ao gerenciador.
     * 
     * @param \JHV\Payment\ServiceBundle\Plugin\PluginInterface $plugin
     * @return self
     */
    function add(PluginInterface $plugin);
    
    /**
     * Verificará se na listagem de plugins registrados, há algum
     * que se encaixa com o identificador fornecido por parâmetro.
     * 
     * @param string $name
     * @return boolean
     */
    function has($name);
    
    /**
     * Através de um nome identificador do plugin, o gerenciador
     * efetuará uma busca dos plugins registrados para sua localização.
     * 
     * @param string $name
     * @return \JHV\Payment\ServiceBundle\Plugin\PluginInterface
     */
    function get($name);
    
    /**
     * Localizar todos os plugins.
     * Retornará através de um array, todos os plugins já registrados.
     * 
     * @return array
     */
    function all();
    
    /**
     * Através do nome do plugin, este método adicionará em uma variável
     * do tipo array, através do nome do plugin como chave de identificação,
     * o nome de um formulário extra para ser exibido nos meios de pagamento.
     * 
     * Exemplo: 
     * Cartão de Crédito - Adicionará um formulário com informações extras de
     * nome do usuário, número do cartão, etc.
     * 
     * @param string $name              Nome do plugin
     * @param string $form_type_name    Nome do formType
     * @return self
     */
    function addExtraForm($name, $form_type_name);
    
    /**
     * Verificará se há algum formulário extra a ser adicionado através
     * do nome do plugin.
     * 
     * @param string $name Nome do plugin
     * @return boolean
     */
    function hasExtraForm($name);
    
    /**
     * Localizará o nome do formType associado ao plugin.
     * Através do nome do plugin, localizará o nome do formulário extra
     * a ser adicionado.
     * 
     * @param string $name Nome do plugin (getName do plugin)
     * @return string|null
     */
    function getExtraForm($name);
    
}