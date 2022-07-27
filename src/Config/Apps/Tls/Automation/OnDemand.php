<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand\RateLimit;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class OnDemand implements Arrayable
{
    private ?RateLimit $_rateLimit;

    private ?string $_ask;

    public function setRateLimit(RateLimit $rateLimit): static
    {
        $this->_rateLimit = $rateLimit;

        return $this;
    }

    public function setAsk(string $ask): static
    {
        $this->_ask = $ask;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_rateLimit)) {
            $config['rate_limit'] = $this->_rateLimit->toArray();
        }

        if (isset($this->_ask)) {
            $config['ask'] = $this->_ask;
        }

        return $config;
    }

}