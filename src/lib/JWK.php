<?php
namespace josejwt\lib;

use josejwt\lib\JWT;
use josejwt\lib\URLSafeBase64;
use josejwt\lib\exception\JoseExceptionUnexpectedAlgorithm;
use josejwt\lib\exception\JoseExceptionInvalidFormat;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;
use phpseclib\Crypt\Hash;

class JWK
{
    var $components = array();

    function __construct($components = array()) {
        if (!array_key_exists('kty', $components)) {
            throw new JoseExceptionInvalidFormat('"kty" is required');
        }
        $this->components = $components;
        if (!array_key_exists('kid', $this->components)) {
            $this->components['kid'] = $this->thumbprint();
        }
    }

    function toKey() {
        switch ($this->components['kty']) {
            case 'RSA':
                $rsa = new RSA();
                $n = new BigInteger('0x' . bin2hex(URLSafeBase64::decode($this->components['n'])), 16);
                $e = new BigInteger('0x' . bin2hex(URLSafeBase64::decode($this->components['e'])), 16);
                if (array_key_exists('d', $this->components)) {
                    throw new JoseExceptionUnexpectedAlgorithm('RSA private key isn\'t supported');
                } else {
                    $pem_string = $rsa->_convertPublicKey($n, $e);
                }
                $rsa->loadKey($pem_string);
                return $rsa;
            default:
                throw new JoseExceptionUnexpectedAlgorithm('Unknown key type');
        }
    }

    function thumbprint($hash_algorithm = 'sha256') {
        $hash = new Hash($hash_algorithm);
        return URLSafeBase64::encode(
            $hash->hash(
                json_encode($this->normalized())
            )
        );
    }

    private function normalized() {
        switch ($this->components['kty']) {
            case 'RSA':
                return array(
                    'e'   => $this->components['e'],
                    'kty' => $this->components['kty'],
                    'n'   => $this->components['n']
                );
            default:
                throw new JoseExceptionUnexpectedAlgorithm('Unknown key type');
        }
    }

    function toString() {
        return json_encode($this->components);
    }
    function __toString() {
        return $this->toString();
    }

    static function encode($key, $extra_components = array()) {
        switch(get_class($key)) {
            case 'phpseclib\Crypt\RSA':
                $components = array(
                    'kty' => 'RSA',
                    'e' => URLSafeBase64::encode($key->publicExponent->toBytes()),
                    'n' => URLSafeBase64::encode($key->modulus->toBytes())
                );
                if ($key->exponent != $key->publicExponent) {
                    $components = array_merge($components, array(
                        'd' => URLSafeBase64::encode($key->exponent->toBytes())
                    ));
                }
                return new self(array_merge($components, $extra_components));
            default:
                throw new JoseExceptionUnexpectedAlgorithm('Unknown key type');
        }
    }

    static function decode($components) {
        $jwk = new self($components);
        return $jwk->toKey();
    }
}