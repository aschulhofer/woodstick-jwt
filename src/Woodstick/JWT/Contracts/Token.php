<?php

namespace Woodstick\JWT\Contracts;

use DateTimeInterface;

interface Token {

    public function hasHeader($name);

    public function getHeader($name, $default = null);

    public function hasClaim($name);

    public function getClaim($name, $default = null);

    public function isExpired(DateTimeInterface $now = null);

    public function asString();
}
