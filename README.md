PaymentServiceBundle
==================================

Symfony2 Bundle :: Create and manipulate payment methods and "services or gateways"

### Configuration Reference

Arquivo de configuração padrão.

``` yaml
# app/config/security.yml
### JHVPaymentServiceBundle
jhv_payment_service:
    security:
        secret_key  : "secret key"
        cipher      : "rijndael-256"
        mode        : "cfb"
  
    ### Definição das classes
    classes:
        ### Managers
        plugin_manager            : "JHV\\Payment\\ServiceBundle\\Manager\\PluginManager"
        payment_method_manager    : "JHV\\Payment\\ServiceBundle\\Manager\\PaymentMethodManager"
        
        ### FormType
        payment_selector_type     : "JHV\\Payment\\ServiceBundle\\Form\\Type\\PaymentSelectorType"
        
        ### Objetos
        payment_method_class      : "JHV\\Payment\\ServiceBundle\\Model\\PaymentMethod"
        payment_instruction_class : "JHV\\Payment\\ServiceBundle\\Instruction\\PaymentInstruction"
        
        ### Segurança
        encrypter                 : "JHV\\Payment\\ServiceBundle\\Security\\Encrypter"
        
            
    ### Formas de pagamento disponíveis
    payment_methods:
        cobrebem_visa:
            code          : "VISA"
            name          : "Cartão visa"
            description   : "Pagamento com o cartão visa"
            enabled       : true
            plugin        : bla_plugin
            image         : /bundles/mailforwebsitecore/images/planos/ct-visa.jpg
```