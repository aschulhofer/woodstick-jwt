<?php

namespace Woodstick\JWT\Claim;

use Woodstick\JWT\Contracts\Claim as ClaimContract;

class Claim implements ClaimContract {

    protected $name;
    protected $value;

    public function __construct($name = null, $value = null) {
        $this->setName($name);
        $this->setValue($value);
    }

    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getName() {
        return $this->name;
    }
}
