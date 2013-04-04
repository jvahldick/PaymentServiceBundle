PaymentServiceBundle
====================

Symfony2 Bundle :: Create and manipulate payment methods and "services or
gateways"



`### JHVPaymentServiceBundle`

`jhv_payment_service:`

`    security:`

`        secret_key  : "secret key"`

`        cipher      : "rijndael-256"`

`        mode        : "cfb"  `



`    ### Definição das classes`

`    classes:`

`        ### Managers`

`        plugin_manager            :
"JHV\\Payment\\ServiceBundle\\Manager\\PluginManager"`

`        payment_method_manager    :
"JHV\\Payment\\ServiceBundle\\Manager\\PaymentMethodManager"        `



`        ### FormType`

`        payment_selector_type     :
"JHV\\Payment\\ServiceBundle\\Form\\Type\\PaymentSelectorType"        `



`        ### Objetos`

`        payment_method_class      :
"JHV\\Payment\\ServiceBundle\\Model\\PaymentMethod"`

`        payment_instruction_class :
"JHV\\Payment\\ServiceBundle\\Instruction\\PaymentInstruction"        `



`        ### Segurança`

`        encrypter                 :
"JHV\\Payment\\ServiceBundle\\Security\\Encrypter"`



`    ### Formas de pagamento disponíveis`

`    payment_methods:`

`        visa:`

`            code          : "VISA"`

`            name          : "Cartão visa"`

`            description   : "Pagamento com o cartão visa"`

`            enabled       : true`

`            plugin        : plugin_name`

`            image         : /bundles/bundlename/images/planos/ct-visa.jpg`