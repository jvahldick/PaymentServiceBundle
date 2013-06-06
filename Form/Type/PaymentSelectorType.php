<?php

namespace JHV\Payment\ServiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

use JHV\Payment\ServiceBundle\Manager\PaymentMethodManagerInterface;
use JHV\Payment\ServiceBundle\Manager\PluginManagerInterface;
use JHV\Payment\ServiceBundle\Form\DataTransformer\PaymentMethodIntoPaymentInstructionTransformer;
use JHV\Payment\ServiceBundle\Security\EncrypterInterface;

/**
 * PaymentSelectorType
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013
 */
class PaymentSelectorType extends AbstractType
{
    
    protected $paymentMethodManager;
    protected $pluginManager;
    protected $encrypter;
    protected $dataClass;
    
    public function __construct(PaymentMethodManagerInterface $paymentMethodManager, PluginManagerInterface $pluginManager, EncrypterInterface $encrypter, $entityClass)
    {
        $this->paymentMethodManager = $paymentMethodManager;
        $this->pluginManager = $pluginManager;
        $this->encrypter = $encrypter;
        $this->dataClass = $entityClass;
    }
    
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $transformer    = new PaymentMethodIntoPaymentInstructionTransformer($this, $options);        
        $builder
            ->add('payment_method', 'choice', array(
                'choices'   => $this->buildPaymentMethodChoices(),
                'expanded'  => true,
                'label'     => 'form_label.payment_method'
            ))
            ->addModelTransformer($transformer)
        ;
        
        $this->processExtraForms($builder);
    }
    
    /**
     * Definição do nome do FormType
     * @return string
     */
    public function getName()
    {
        return 'payment_selector';
    }
    
    /**
     * Efetua a criação dos meios de pagamentos registrados
     * Caso esteja habilitado e tenha imagem o sistema tenta inserir
     * no local do label uma imagem, caso contrário irá inserir texto.
     * 
     * @return array
     */
    protected function buildPaymentMethodChoices()
    {
        $choices = array();
        foreach ($this->paymentMethodManager->all() as $paymentMethod)
        {
            if (true === $paymentMethod->isEnabled() && true === $paymentMethod->isVisible()) {
                if (null !== $paymentMethod->getImage())
                    $choices[$paymentMethod->getId()] = html_entity_decode('<img src="'. $paymentMethod->getImage() .'" alt="'. $paymentMethod->getName() .'" title="'. $paymentMethod->getDescription() .'" />', ENT_NOQUOTES, 'UTF-8');
                else
                    $choices[$paymentMethod->getId()] = sprintf('form.payment.label.%s', strtolower($paymentMethod->getId()));
            }
        }
        
        return $choices;
    }
    
    /**
     * Definição das configurações padrões para o modelo de formulário
     * Obrigatoriamente junto ao formulário deve-se passar:
     * - currency (moeda)
     * - amount (valor)
     * 
     * Opcionalmente o usuário poderá fornecer mais duas opções em formato de array:
     * - vars
     * Para toda opção adicionada com chave e valor para vars, estes serão acrescidos
     * a variável vars do formulário, podendo acessá-los: form.vars.KEY
     * 
     * - predefined_data
     * Nesta variável deve-se passar como chave o nome do serviço em questão, no
     * qual fornecerá através do formulário extra o acréscimo destas informações
     * Por exemplo: array('credit_card' => array(
     *      success_path => 'http://www.jorgehv.com.br',
     *      error_path => 'http://www.jorgehv.com.br',
     * ));
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    { 
       $resolver->setDefaults(array(
            'vars'                  => array(),
            'predefined_data'       => array(),
        ));
        
        $resolver->setRequired(array(
            'amount',
            'currency',
            'client_ip',
        ));
        
        $resolver->setAllowedTypes(array(
            'amount'                => 'numeric',
            'currency'              => 'string',
            'client_ip'             => 'string',
            'vars'                  => 'array',
            'predefined_data'       => 'array',
        ));
    }
    
    /**
     * Efetua a criação dos formulários extras de acordo com os
     * meio de pagamentos registrados.
     * 
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     */
    public function processExtraForms(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        foreach ($this->paymentMethodManager->all() as $paymentMethod) {
            if (null !== $type = $this->pluginManager->getExtraForm($paymentMethod->getPlugin()->getName())) {
                $builder->add('data_' . $paymentMethod->getPlugin()->getName(), $type, array(
                    'label'     => sprintf('form_label.data.%s', $paymentMethod->getPlugin()->getName()),
                    'attr'      => array(
                        'class'     => sprintf('payment_data_%s', $paymentMethod->getPlugin()->getName())
                    )
                ));
            }
        }
    }
    
    /**
     * Objetivo do buildView nesta classe: definir variáveis de exibição
     * 
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options)
    {
        if (isset($options['vars'])) {
            $view->vars = array_merge($view->vars, $options['vars']);
        }
    }
    
    /**
     * Localiza o gerenciador de plugins
     * @return PluginManagerInterface
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
    
    /**
     * Localiza o gerenciador de meios de pagamento
     * @return PaymentMethodManagerInterface
     */
    public function getPaymentMethodManager()
    {
        return $this->paymentMethodManager;
    }
    
    /**
     * Localiza o encriptador
     * @return EncrypterInterface
     */
    public function getEncrypter()
    {
        return $this->encrypter;
    }
    
    /**
     * Localiza a string do objeto relacionado instrução de pagamento
     * @return string
     */
    public function getDataClass()
    {
        return $this->dataClass;
    }
    
};