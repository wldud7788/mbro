<?php
namespace App\Libraries\AdditionService;

class StringSecurity
{
    public static function getEnIv () { return str_repeat(chr(0), 16); }
    /**
     * OpenSSL 암호화
     * 
     * @param string $str   = 암호화할 문자열
     * @param string $key   - 암호화할 KEY 값
     * 
     * @return string
     */
    public static function SecurityEncode (String $str, String $key)
    {
        $en_iv  = self::getEnIv();
        $en_key = substr(hash('sha256', $key, true), 0, 32);
        
        return base64_encode(openssl_encrypt($str, 'aes-256-cbc', $en_key, OPENSSL_RAW_DATA, $en_iv));
    }

    /**
     * OpenSSL 복호화
     * 
     * @param string $str   = 복호화할 문자열
     * @param string $key   - 복호화할 KEY 값
     * 
     * @return string
     */
    public static function SecurityDecode (String $str, String $key)
    {
        $en_iv  = self::getEnIv();
        $en_key = substr(hash('sha256', $key, true), 0, 32);
        
        return openssl_decrypt(base64_decode($str), 'aes-256-cbc', $en_key, OPENSSL_RAW_DATA, $en_iv);
    }
}