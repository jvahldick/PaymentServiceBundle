PaymentServiceBundle
==================================

Symfony2 Bundle :: Create and manipulate payment methods and "services or gateways"

### Configuration Reference

Arquivo de configuração padrão.

``` yaml
# app/config.yml
### JHVPaymentServiceBundle
jhv_payment_service:
	### Template
    default_template: "JHVPaymentServiceBundle:Form:payment_methods.html.twig"

    security:
        secret_key  : "secret key"
        cipher      : "rijndael-256"
        mode        : "cfb"
  
    ### Definição das classes
    classes:
        ### Managers
        plugin_manager            : "JHV\\Payment\\ServiceBundle\\Manager\\PluginManager"
        payment_method_manager    : "JHV\\Payment\\ServiceBundle\\Manager\\PaymentMethodManager"
        
        ### Form
        payment_selector_type     : "JHV\\Payment\\ServiceBundle\\Form\\Type\\PaymentSelectorType"
        payment_selector_factory  : "JHV\\Payment\\ServiceBundle\\Factory\\PaymentFormFactory"
        
        ### Objetos
        payment_method_class      : "JHV\\Payment\\ServiceBundle\\Model\\PaymentMethod"
        payment_instruction_class : "PaymentInstruction"
        
        ### Segurança
        encrypter                 : "JHV\\Payment\\ServiceBundle\\Security\\Encrypter"
        
        ### Twig extension
        twig_extension            : "JHV\\Payment\\ServiceBundle\\Twig\\Extension\\PaymentServiceExtension"
        
            
    ### Formas de pagamento disponíveis
    payment_methods:
        cobrebem_visa:
            code          : "VISA"
            name          : "Cartão visa"
            description   : "Pagamento com o cartão visa"
            enabled       : true
			visible       : true
            plugin        : plugin_name
            image         : /bundles/nome-bundle/images/cartao-visa.jpg
			extra_data    :
                operadora : CIELO
```