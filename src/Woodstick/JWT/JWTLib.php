<?php

namespace Woodstick\JWT;

use Woodstick\JWT\Token;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

class JWTLib {

    protected $secret;
    protected $signer;

    public function __construct($secret, $signerType, $signerAlgo) {
        $algo = "Lcobucci\\JWT\\Signer\\$signerType\\$signerAlgo";
        
        $this->secret = $secret;
        $this->signer = new $algo();
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

        $token = $builder->getToken();

        return new Token($token);
    }

    /**
     *
     */
    public function parse($token) {
        $parser = new Parser();

        return new Token(
            $parser->parse((string) $token)
        );
    }

    /**
     *
     */
    public function verify(Token $token) {
        return $token->getInternalToken()->verify($this->signer, $this->secret);
    }
}
