<?php
namespace josejwt\lib;

use josejwt\lib\JWE;
use josejwt\lib\JWS;
use josejwt\lib\URLSafeBase64;
use josejwt\lib\exception\JoseExceptionInvalidFormat;

class JWT
{
    var $header = array(
        'typ' => 'JWT',
        'alg' => 'RS256'
    );
    var $claims = array();
    var $signature = '';
    var $raw;

    function __construct($claims = array(), $header = array()) {
        $this->claims = $claims;
        $this->header = array_merge($this->header, $header);
    }

    function toString() {
        return implode('.', array(
            $this->compact((object) $this->header),
            $this->compact((object) $this->claims),
            $this->compact($this->signature)
        ));
    }

    function __toString() {
        return $this->toString();
    }

    function sign($private_key_or_secret, $algorithm = 'HS256') {
        $jws = $this->toJWS();
        $jws->sign($private_key_or_secret, $algorithm);
        return $jws;
    }

    function verify($public_key_or_secret, $alg = null) {
        $jws = $this->toJWS();
        $jws->verify($public_key_or_secret, $alg);
        return $jws;
    }

    function encrypt($public_key_or_secret, $algorithm = 'RSA1_5', $encryption_method = 'A128CBC-HS256') {
        $jwe = new JWE($this);
        $jwe->encrypt($public_key_or_secret, $algorithm, $encryption_method);
        return $jwe;
    }

    static function encode($claims) {
        return new self($claims);
    }

    static function decode($jwt_string) {
        $segments = explode('.', $jwt_string);
        switch (count($segments)) {
            case 3:
                $jwt = new self();
                $jwt->raw = $jwt_string;
                $jwt->header = (array) $jwt->extract($segments[0]);
                $jwt->claims = (array) $jwt->extract($segments[1]);
                $jwt->signature      = $jwt->extract($segments[2], 'as_binary');
                return $jwt;
            case 5:
                $jwe = new JWE($jwt_string);
                $jwe->auth_data  = $segments[0];
                $jwe->header     = (array) $jwe->extract($segments[0]);
                $jwe->jwe_encrypted_key  = $jwe->extract($segments[1], 'as_binary');
                $jwe->iv                 = $jwe->extract($segments[2], 'as_binary');
                $jwe->cipher_text        = $jwe->extract($segments[3], 'as_binary');
                $jwe->authentication_tag = $jwe->extract($segments[4], 'as_binary');
                return $jwe;
            default:
                throw new JoseExceptionInvalidFormat('JWT should have exact 3 or 5 segments');
        }
    }

    protected function compact($segment) {
        if (is_object($segment)) {
            $stringified = str_replace("\/", "/", json_encode($segment));
        } else {
            $stringified = $segment;
        }
        if ($stringified === 'null' && $segment !== null) { // shouldn't happen, just for safe
            throw new JoseExceptionInvalidFormat('Compact seriarization failed');
        }
        return URLSafeBase64::encode($stringified);
    }

    protected function extract($segment, $as_binary = false) {
        $stringified = URLSafeBase64::decode($segment);
        if ($as_binary) {
            $extracted = $stringified;
        } else {
            $extracted = json_decode($stringified);
            if ($stringified !== 'null' && $extracted === null) {
                throw new JoseExceptionInvalidFormat('Compact de-serialization failed');
            }
        }
        return $extracted;
    }

    private function toJWS() {
        return new JWS($this);
    }
}
