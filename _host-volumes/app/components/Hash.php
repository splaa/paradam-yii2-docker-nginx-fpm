<?php

namespace app\components;

class Hash
{
    const SECRET_KEY = 'paradam-me';
    const SECRET_IV = 'aTIHmfVU';

    const ENCODE = 'e';
    const DECODE = 'd';

    public $string;

    public function run($action)
    {
        // you may change these values to your own
        $secret_key = self::SECRET_KEY;
        $secret_iv = self::SECRET_IV;

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($this->string, $encrypt_method, $key, 0, $iv));
        } else {
            if ($action == 'd') {
                $output = openssl_decrypt(base64_decode($this->string), $encrypt_method, $key, 0, $iv);
            }
        }

        return $output;
    }
}