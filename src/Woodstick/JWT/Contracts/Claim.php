<?php

namespace Woodstick\JWT\Contracts;

interface Claim {
    public function setValue($value);

    public function getValue();

    public function setName($name);

    public function getName();
}
