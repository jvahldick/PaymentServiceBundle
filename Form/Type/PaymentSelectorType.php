<?php

namespace JHV\Payment\ServiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;

use JHV\Payment\ServiceBundle\Manager\PaymentMethodManagerInterface;
use JHV\Payment\ServiceBundle\Manager\PluginManagerInterface;
use JHV\Payment\ServiceBundle\Form\EventListener\PaymentSelectorSubscriber;
use JHV\Payment\ServiceBundle\Model\PaymentMethodInterface;
use JHV\Payment\ServiceBundle\Security\EncrypterInterface;

/**
 * PaymentSelectorType
 * 
 * @author Jorge Vahldick <jvahldick@gmail.com>
 * @license Please view /Resources/meta/LICENCE
 * @copyright (c) 2013, Quality Press <http://www.qualitypress.com.br>
 * @copyright (c) 2013, Jorge Vahldick <jvahldick@gmail.com>
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
        $subscriber = new PaymentSelectorSubscriber($options);
        $builder
            ->add('payment_method', 'choice', array(
                'choices'   => $this->buildPaymentMethodChoices(),
                'expanded'  => true
            ))
            ->addEventSubscriber($subscriber)
        ;
        
        $this->processExtraForms($builder);
        
        $self = $this;
        $builder->addModelTransformer(new CallbackTransformer(
            function($data) use ($self, $options) {
                return $self->transform($data, $options);
            },
            function($data) use ($self, $options) {
                return $self->reverseTransform($data, $options);
            }
        ), true);
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
        foreach ($this->paymentMethodManager->all() as $id => $paymentMethod)
        {
            if (true === $paymentMethod->isEnabled()) {
                if (null !== $paymentMethod->getImage())
                    $choices[$id] = html_entity_decode('<img src="'. $paymentMethod->getImage() .'" alt="'. $paymentMethod->getName() .'" title="'. $paymentMethod->getDescription() .'" />', ENT_NOQUOTES, 'UTF-8');
                else
                    $choices[$id] = sprintf('form.payment.label.%s', strtolower($id));
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
        ));
        
        $resolver->setAllowedTypes(array(
            'amount'                => 'numeric',
            'currency'              => 'string',
            'vars'                  => 'array',
            'predefined_data'       => 'array',
        ));
    }
    
    public function processExtraForms(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        foreach ($this->paymentMethodManager->all() as $key => $pm) {
            if (null !== $type = $this->pluginManager->getExtraForm($pm->getPlugin()->getName())) {
                $builder->add('data_' . $key, $type);
            }
        }
    }
    
    public function transform($data, array $options)
    {        
        if (null === $data) {
            return null;
        }

        if ($data instanceof \JHV\Payment\ServiceBundle\Instruction\PaymentInstruction) {            
            $method = $data->getPaymentMethod();
            $methodData = array_map(function($v) { return $v[0]; }, $data->getExtendedData()->all());
            if (isset($options['predefined_data'][$method])) {
                $methodData = array_diff_key($methodData, $options['predefined_data'][$method]);
            }

            return array(
                'method'        => $method,
                'data_'.$method => $methodData,
            );
        }

        throw new \RuntimeException(sprintf('Unsupported data of type "%s".', ('object' === $type = gettype($data)) ? get_class($data) : $type));
    }
    
    public function reverseTransform($data, array $options)
    {        
        $method = isset($data['payment_method']) ? $data['payment_method'] : null;
        $data = isset($data['data_'.$method]) ? $data['data_'.$method] : array();
        $encryptedData = (is_array($data)) ? $this->encrypter->recursiveEncrypt($data) : $this->encrypter->encrypt($data);
        
        $payment_method = $this->paymentMethodManager->get($method);        
        if ($payment_method instanceof PaymentMethodInterface) {
            $object = new $this->dataClass;
            $object
                ->setCurrency($options['currency'])
                ->setAmount($options['amount'])
                ->setExtendedData($encryptedData)
                ->setPaymentMethod($method)
                ->setServiceName($this->paymentMethodManager->get($method)->getPlugin()->getName())
            ;
        } else {
            $object = $data;
        }
        
        print_r($this->encrypter->recursiveDecrypt($object->getExtendedData()));
        
        return $object;        
    }
    
};