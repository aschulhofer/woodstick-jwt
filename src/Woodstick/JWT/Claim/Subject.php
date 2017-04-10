<?php

namespace Woodstick\JWT\Claim;

use Woodstick\JWT\Claim\Claim as BaseClaim;

class Subject extends BaseClaim {

    public function __construct($value = null) {
        parent::__construct("sub", $value);
    }
}
