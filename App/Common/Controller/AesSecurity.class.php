<?php

/**
 *  AES算法名称/加密模式/填充方式：AES/CBC/PKCS5Padding
 *  加密结果编码格式 base64
 *
 * 1、所需接口参数token
 *  token：是 AES【userId+分隔符（半角逗号）+ 时间戳(毫秒级) +分隔符（半角逗号）+  随机数字】组成
 *  2、token与接口中的字段AES加密如下：
 *  AES算法名称/加密模式/填充方式：AES/CBC/PKCS5Padding
 *  示例加密密钥：GSjrKhDXXtCLschp（加密密钥由平台统一分配）
 *  密钥偏移量：5234428559899782
 *  加密结果编码方式：base64
 *  extend示例：
 *  加密前：20180375,1416374455361,553204
 *  加密后：TBHvUxwy/apNzyjvpafzl3ArQmhBAWlJWL2SqmLxUpk=
 *
 *  【调用方法】
 *  $aes = AesSecurity::instance();
 *  echo $aes->encrypt('20180375,1416374455361,553204');
 *  echo $aes->decrypt('TBHvUxwy/apNzyjvpafzl3ArQmhBAWlJWL2SqmLxUpk=');
 */
namespace Common\Controller;

class AesSecurity
{
    protected static $instance = null;
    private          $iv       = '5234428559899782';//偏移量
    private          $key      = 'GSjrKhDXXtCLschp';//密钥

    public static function instance()
    {
        if (self::$instance == null) {
            $class_name     = __CLASS__;
            self::$instance = new $class_name();
        }
        return self::$instance;
    }

    /**
     * 设置 偏移量
     */
    public function setIv($iv)
    {
        $this->iv = $iv;
    }

    /**
     * 设置 密钥
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * 加密处理
     */
    public function encrypt($input)
    {
        $size  = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $input = AesSecurity::Pkcs5Padding($input, $size);
        $td    = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    /**
     * 解密处理
     */
    public function decrypt($sStr)
    {
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($sStr), MCRYPT_MODE_CBC,$this->iv);
        $dec_s     = strlen($decrypted);
        $padding   = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    private static function Pkcs5Padding($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function getToken($data){
        $aes = AesSecurity::instance();
        $token = $aes->encrypt($data.','.time().','.rand(11111,99999));
        return $token;
    }
}

//echo AesSecurity::decrypt('TBHvUxwy/apNzyjvpafzl3ArQmhBAWlJWL2SqmLxUpk=');
//$aes = AesSecurity::instance();
//echo $aes->decrypt('TBHvUxwy/apNzyjvpafzl3ArQmhBAWlJWL2SqmLxUpk=');
//echo '<br>';
//echo $aes->encrypt('20180375,1416374455361,553204');