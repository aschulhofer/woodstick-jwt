<?php

namespace Woodstick\JWT;

use Woodstick\JWT\Contracts\Token as TokenContract;

class Token implements TokenContract {

    // Lcobucci\JWT\Token;
    protected $jwtToken;

    public function __construct($jwtToken) {
        $this->jwtToken = $jwtToken;
    }

    public function getInternalToken() {
        return $this->jwtToken;
    }

    /**
     * Returns if the header is configured
     *
     * @param string $name
     *
     * @return boolean
     */
    public function hasHeader($name)
    {
        return $this->jwtToken->hasHeader($name);
    }

    /**
     * Returns the value of a token header
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     *
     * @throws OutOfBoundsException
     */
    public function getHeader($name, $default = null)
    {
        return $this->jwtToken->getHeader($name, $default);
    }

    /**
     * Returns if the claim is configured
     *
     * @param string $name
     *
     * @return boolean
     */
    public function hasClaim($name)
    {
        return $this->jwtToken->hasClaim($name);
    }

    /**
     * Returns the value of a token claim
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     *
     * @throws OutOfBoundsException
     */
    public function getClaim($name, $default = null)
    {
        return $this->jwtToken->getClaim($name, $default);
    }

    /**
     * Determine if the token is expired.
     *
     * @param DateTimeInterface $now Defaults to the current time.
     *
     * @return bool
     */
    public function isExpired(DateTimeInterface $now = null)
    {
        return $this->jwtToken->isExpired($now);
    }

    /**
     * Returns an encoded representation of the token
     *
     * @return string
     */
    public function asString() {
        return strval($this);
    }

    /**
     * Returns an encoded representation of the token
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->jwtToken);
    }
}
