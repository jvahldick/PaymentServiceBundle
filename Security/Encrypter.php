<?php

namespace JHV\Payment\ServiceBundle\Security;

/**
 * Encrypter
 */
class Encrypter implements EncrypterInterface
{
    
    protected $secretKey;
    protected $cipher;
    protected $mode;
    
    public function __construct($secretKey, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CFB)
    {
        if (false === extension_loaded('mcrypt'))
            throw new \RuntimeException('The extension mcrypt extension was not enabled, please enabled it.');
            
        if (!in_array($cipher, mcrypt_list_algorithms(), true))
            throw new \InvalidArgumentException(sprintf('The cipher "%s" is not supported.', $cipher));

        if (!in_array($mode, mcrypt_list_modes(), true))
            throw new \InvalidArgumentException(sprintf('The mode "%s" is not supported.', $mode));

        $encryptionDescriptor = mcrypt_module_open($cipher, '', $mode, '');
        $key = hash('sha256', $secretKey, true);
        if (strlen($key) > $size = mcrypt_enc_get_key_size($encryptionDescriptor)) {
            $key = substr($key, 0, $size);
        }
        
        $this->secretKey = $key;
        $this->cipher = $cipher;
        $this->mode = $mode;
    }

    public function decrypt($string)
    {
        $size = mcrypt_get_iv_size($this->cipher, $this->mode);
        $string = base64_decode($string);
        $iv = substr($string, 0, $size);

        return rtrim(mcrypt_decrypt($this->cipher, $this->secretKey, substr($string, $size), $this->mode, $iv));
    }

    public function encrypt($string)
    {
        $size = mcrypt_get_iv_size($this->cipher, $this->mode);
        $iv = mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);

        return base64_encode($iv.mcrypt_encrypt($this->cipher, $this->secretKey, $string, $this->mode, $iv));
    }
    
    public function recursiveEncrypt(array $array)
    {
        $arr = array();
        foreach ($array as $key => $value) {
            $arr[$this->encrypt($key)] = (is_array($value)) ? $this->recursiveEncrypt($value) : $this->encrypt($value);
        }
        
        return $arr;
    }
    
    public function recursiveDecrypt(array $array)
    {
        $arr = array();
        foreach ($array as $key => $value) {
            $arr[$this->decrypt($key)] = (is_array($value)) ? $this->recursiveDecrypt($value) : $this->decrypt($value);
        }
        
        return $arr;
    }
    
}