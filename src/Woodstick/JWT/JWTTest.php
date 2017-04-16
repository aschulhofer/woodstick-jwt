<?php

namespace Woodstick\JWT;

use Woodstick\JWT\JWTLib;
use Woodstick\JWT\Claim\Subject;
use Woodstick\JWT\Claim\Claim;
use Woodstick\JWT\Claim\IssuedAt;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWTTest {

    private $jwtLib;

    public function __construct() {
        $this->jwtLib = new JWTLib('secret', 'Hmac', 'Sha256');
    }

    /**
     * "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ3b29keSIsIm50YiI6MTQ5MTg1ODU0MywiZXhwIjoxNDkxODYyMDgzLCJzdWIiOiJ0b2tlbiIsImlhdCI6MTQ5MTg1ODQ4MywiZGF0YSI6eyJhZG1pbiI6dHJ1ZSwicm9sZXMiOlsiQSIsIkIiXSwicmFuZCI6MTU1MDh9fQ.XXPhJ8LbRmS5cgsCh2twcOcYiWrMs3qlHrJuCx_ox7Y"
     */
    public function runLib() {

        $dataClaim = new Claim();
        $dataClaim
            ->setName('data')
            ->setValue([
              'admin' => true,
              'roles' => ['A', 'B'],
              'rand' => rand()
            ]);

        $claims = [
            new Claim("iss", "woody"),
            new Claim("ntb", time() + 60),
            new Claim("exp", time() + 3600),
            new Subject("token"),
            new IssuedAt(time()),
            $dataClaim,
        ];

        $token = $this->jwtLib->create($claims);
        $verification = $this->jwtLib->verify($token);
        $parsed = $this->jwtLib->parse(strval($token));
        $isExpired = $token->isExpired();

        return response()->json([
            "token" => strval($token),
            "verify" => $verification,
            "parsed" => strval($parsed),
            "isExpired" => $isExpired,
        ]);
    }

    public function run() {
      $signer  = new Sha256();
      $builder = new Builder();

      $iat = new IssuedAt(time());

      $sub = new Subject("token");

      $dataClaim = new Claim();
      $dataClaim
          ->setName('data')
          ->setValue([
            'admin' => true,
            'roles' => ['A', 'B'],
            'rand' => rand()
          ]);


      $token = $builder->setIssuer('http://example.com') // Configures the issuer (iss claim)
                       ->setAudience('http://example.org') // Configures the audience (aud claim)
                      //  ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                       ->setIssuedAt($iat->getValue()) // Configures the time that the token was issue (iat claim)
                       ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                       ->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)

                       ->setSubject($sub->getValue())
                       ->set('uid', 1) // Configures a new claim, called "uid"

                       ->set('u-' . $iat->getName(), $iat->getValue()) // Configures a new claim, called "uid"

                       ->set($dataClaim->getName(), $dataClaim->getValue())
                       ->set('data2', [
                         'admin' => true,
                         'roles' => ['A', 'B'],
                         'rand' => rand()
                       ])
                       ->sign($signer, 'secret') // creates a signature using "secret" as key
                       ->getToken(); // Retrieves the generated token

      // $token->getHeaders(); // Retrieves the token headers
      // $token->getClaims(); // Retrieves the token claims

      // echo $token->getHeader('jti'); // will print "4f1g23a12aa"
      // echo $token->getClaim('iss'); // will print "http://example.com"
      // echo $token->getClaim('uid'); // will print "1"
      return $token; // The string representation of the object is a JWT string (pretty easy, right?)
    }

}
