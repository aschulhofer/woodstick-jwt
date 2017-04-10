<?php

namespace Woodstick\JWT;

use Woodstick\JWT\Claim\Subject;
use Woodstick\JWT\Claim\Claim;
use Woodstick\JWT\Claim\IssuedAt;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWTLib {

    protected $secret = 'secret';

    protected $signer;

    public function __construct() {
        $this->signer = new Sha256();
    }

    /**
     *
     */
    public function create($claims) {
        $builder = new Builder();

        foreach($claims as $claim) {
            $builder->set($claim->getName(), $claim->getValue());
        }

        $builder->sign($this->signer, $this->secret);

        return $builder->getToken();
    }

    /**
     *
     */
    public function parse($token) {
        $parser = new Parser();

        return $parser->parse((string) $token);
    }

    /**
     *
     */
    public function verify($token) {
        return $token->verify($this->signer, $this->secret);
    }
}
