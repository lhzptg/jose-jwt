<?php


namespace josejwt;

use josejwt\lib\JWT;

/**
 *
 *生成KEYPair
 * $rsa = new phpseclib\Crypt\RSA();
 * $rsa->setHash('sha256');
 * $key = $rsa->createKey(2048, false);
 *
 * eg:print_r($key);
 * Array ( [privatekey] => -----BEGIN RSA PRIVATE KEY----- MIIEowIBAAKCAQEA05GmNfxzUGxoNYQcf22kIJs0RfEBUQhgbH/wiKmb
 * PAe8NOVU +Yss41CX4viWS5cOyE1jiJW5re/iXsVpL2VjNCIFLguo0QaradYKu8c8Jj1s0Sfa bYUQmu431hneLxGVlrWcnGO205f0niz6XwW3qq
 * 3yy0QzWHIHcFSI5Ep3AUPgqYOk mqeyZhPS95k5HpLU+81OGDuHkRIZGUO90TB830jEaQmVZnLWvJYM9Fjew7JhZ516 kDZPGZDlHhbe9hgEjRfo
 * d0G9p0QeeFmPvtUmvq7rNW4YPTTmHuABsMWtb2XXI7yr ic7wa6SdDhA3pFClR22KqID8DcqRnd9+qzVZPwIDAQABAoIBAALXQdQXv7SkwAF3 9K
 * oBXuLRMrJ9ufbMlf7e+Ovc2yjDMdPEAJAZPlEPE/sIO3xoWtp1r5B18jhTsEZ1 gCQSyHI6wrcLkQi9fi+9oAdFdZlN2dg1IMm3r7Fk4XsOfd1D7
 * y5G4gN3k0zkDXTS Rcpg2UaBb3ErSUU2wsLPX8cw+MgbivWtGrQAtdKvRjiA1v30lEi3mCqVOtVqNfSw GqXJotGmusQ9dbbHtA9rVG56jREUuaa
 * Gw6WtdHLlIHSTTO8GutcvoAvcsavI8a4P iJ6GDmU1Zv5kHYAul9DAfyxKoZ2VKglXMhnmDwvUjjr/JXmfzJqdHN0o+dhgIvl8 P6iPeoECgYEA9
 * 5PEM/bk7KgDDX1nd4UQSH0cpdVpG84XyIYgFNVLOv39JSTKi1u8 io4GvrPlI25HTDAEeeEG80vYVYS7BYzYj5kHJIa7bxho94rxi8PELHi7F/ix
 * /Ygr JpJHVG1fIuElJ9NzKRhrTTwk7tgGGS2gqLcOyqvTSZhsaDSqingolMsCgYEA2sRG T7xeKyejIE4/3eCd0xl9M0OUVgv7qVTeCQP1Xy2lGb+Gn
 * cD9neRDtnPys0uWgacv pKDmmDX9Z4pNclWQXkl1D7meTBdnhqKUniVXsS2TLzmAylRt0luiAfq67pDvV0/t vqI3JPaYrldiawoZOrLHoRJAmsr
 * mfwxXh77v8t0CgYA/f7XeAiAbFsiZqCVmgUl4 3iX/3qmzyPtOoiAOV9qQyd4orbQJZEEKZH0UYn2NxdYhk1tCi1XGBxj4bi+tr79H rV8oninqx
 * 578hrWHPHHPWjPaZR35wfgXT4NeAyNYhdiKy3AJBUtYJunuHJgL0ykW vMTddI6fnKmJXKC1HTaDWwKBgQCLkjWZoYAi4EL+1W2BzVBj4hsynacB
 * zttciTyv W8ssUh7Hcp4b/4jPN1bMDOWG5m67gUKwMcdszOVDLcWDcHuO7Ca3RaFswnHWP9u5 mfF8pKsGshUtAPigAL43rROeKPHKLsBro2qzNn
 * Dqqe2shODbxjv+03pMR68O13zw qizEMQKBgHQcZPlKh+tULJs8TVjRgnldRx64jK/BstMArH+gy6YsZeFlm+6SRSL9 O8V+AdkhQvsMo+Ps1Ngk
 * o9mdszcG3PyuY3CE451evWnl/0AzWYL3tOJqBwOESwIE jHhZm2IUYix7xTezsV5ZiLoDDPSbNuvKIn+JXMTMUBVZC4ek+X3/ -----END RSA
 * PRIVATE KEY----- [publickey] => -----BEGIN PUBLIC KEY----- MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA05GmNfxzU
 * GxoNYQcf22k IJs0RfEBUQhgbH/wiKmbPAe8NOVU+Yss41CX4viWS5cOyE1jiJW5re/iXsVpL2Vj NCIFLguo0QaradYKu8c8Jj1s0SfabYUQmu4
 * 31hneLxGVlrWcnGO205f0niz6XwW3 qq3yy0QzWHIHcFSI5Ep3AUPgqYOkmqeyZhPS95k5HpLU+81OGDuHkRIZGUO90TB8 30jEaQmVZnLWvJYM9
 * Fjew7JhZ516kDZPGZDlHhbe9hgEjRfod0G9p0QeeFmPvtUm vq7rNW4YPTTmHuABsMWtb2XXI7yric7wa6SdDhA3pFClR22KqID8DcqRnd9+qzVZ
 * PwIDAQAB -----END PUBLIC KEY----- [partialkey] => )
 *
 *如需要将key转换为json
 * $public_key = new phpseclib\Crypt\RSA();
 * $public_key->loadKey($key['publickey']);
 * $p = JOSE_JWK::encode($public_key);
 *
 * eg:print_r(json_encode($p));
 *{"components":{"kty":"RSA","e":"AQAB","n":"05GmNfxzUGxoNYQcf22kIJs0RfEBUQhgbH_wiKmbPAe8NOVU-Yss41CX4viWS5cOyE1jiJ
 * W5re_iXsVpL2VjNCIFLguo0QaradYKu8c8Jj1s0SfabYUQmu431hneLxGVlrWcnGO205f0niz6XwW3qq3yy0QzWHIHcFSI5Ep3AUPgqYOkmqeyZh
 * PS95k5HpLU-81OGDuHkRIZGUO90TB830jEaQmVZnLWvJYM9Fjew7JhZ516kDZPGZDlHhbe9hgEjRfod0G9p0QeeFmPvtUmvq7rNW4YPTTmHuABsM
 * Wtb2XXI7yric7wa6SdDhA3pFClR22KqID8DcqRnd9-qzVZPw","kid":"cdLpwqHGSsFRavhKQ5x02XRzdoICHdqXLFjWZ1MxIMA"}}
 *
 *创建id_token
 * $claim = [
 *  'sub'=>'1234567890',
 *  'name'=>'John Doe',
 *  'userId'=>136,
 *  'exp'=>time()+7200 ,
 *  'iss'=>'54354354',
 *  'iat'=>time()
 * ];
 * $jwtO = new JOSE_JWT($claim);
 * $jws = $jwtO->sign($key['privatekey'],'RS256');
 * eg:print_r($jws->toString());
 *eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6IjU0NTllNTc0MGU1MTQ3ZWZiMjU0ZDA2NjNjNjIxZTY4In0.eyJzdWIiOiIxMjM0NTY3O
 * DkwIiwibmFtZSI6IkpvaG4gRG9lIiwidXNlcklkIjoxMzYsImV4cCI6MTUzMTU1NjYxMiwiaXNzIjoieGJ1bGwiLCJpYXQiOjE1MzE1NDk0MTJ9
 * .MWGWBn9QvqH2LRXqtIhrTmuI3cnZYd0ip1xDVdqxIrytPWXEmqVjTQ-Ihmne0UnqNqKtqbV99lqzoSXxM0z6Rk8rjkXNN9qgTLoefYUvSLbcRY
 * EGBqmf3ekoInP2aEBjD-yec333ap0H0koTrWFauhfdihG7CGrFVa8d-wgBr_3BQaBqIyqEE_NUCn4dvgKjcg00G1SBpWQyM1SB3HQn_vUnbpAwh
 * dQ7fLObjfF1kkqSefGEXf6R7ltGZ1bEcvdpZvCwR_3TyMhpWuTRnz1Eb1i0YVJPQhVzsa6Y9WOecSxcS8NUJ5ajsKqxgyHp5cmGzRw2J6bpZ108
 * j1s4JjTdOA
 *
 *
 * keypair生成后，可以一直使用，除非发现公钥泄露后，则才需要重新生成。将公钥转换为json格式添加到阿里云API网关。
 *
 *
 * 此库来自jsonwebkey，此类库依赖“phpseclib/phpseclib”
 * User: leeyuan
 * Date: 2018/12/12
 * Time: 17:22
 */
class JoseJWT
{

    /**
     *创建idToken
     *
     * @param array $claim
     *  array(
     *      "iss" => "http://example.org",   #非必须。issuer 请求实体，可以是发起请求的用户的信息，也可是jwt的签发者。
     *      "iat" => 1356999524,                #非必须。issued at。 token创建时间，unix时间戳格式
     *      "exp" => "1548333419",            #非必须。expire 指定token的生命周期。unix时间戳格式
     *      "aud" => "http://example.com",   #非必须。接收该JWT的一方。
     *      "sub" => "jrocket@example.com",  #非必须。该JWT所面向的用户
     *      "nbf" => 1357000000,   # 非必须。not before。如果当前时间在nbf里的时间之前，则Token不被接受；一般都会留一些余地，比如几分钟。
     *      "jti" => '222we',     # 非必须。JWT ID。针对当前token的唯一标识
     *
     *      "GivenName" => "Jonny", # 自定义字段
     *      "Surname" => "Rocket",  # 自定义字段
     *      "Email" => "jrocket@example.com", # 自定义字段
     *      "Role" => ["Manager", "Project Administrator"] # 自定义字段
     *  );
     *
     * @param array $header
     *  {
     *      "typ": "JWT",
     *      "alg": "HS256"
     *   }
     * @param string $publicKey  公共密钥
     * @return string
     * @author lizy
     * @date 2018-7-14
     */
    public function createIdToken( $claim=[], $header=[], $privateKey='')
    {

        $jwtO = new JWT($claim, $header);
        $jws = $jwtO->sign($privateKey,'RS256');
        return $jws->toString();
    }

    /**
     * 解码IdToken
     *
     * @param string $IdToken
     * @return \josejwt\lib\JWT
     * @throws \josejwt\lib\exception\JoseExceptionInvalidFormat
     */
    public function decodeIdToken(string $IdToken)
    {
        return JWT::decode($IdToken);
    }

    /**
     * @param string $IdToken
     * @param string $publicKey
     * @return mixed
     */
    public function verifyIdToken( $IdToken, $publicKey)
    {
        $jwt = $this->decodeIdToken($IdToken);
        return $jwt->verify($publicKey);
    }

    public function refreshIdToken( $jwt, $privateKey)
    {
        $jws = $jwt->sign($privateKey,'RS256');
        return $jws->toString();
    }

}