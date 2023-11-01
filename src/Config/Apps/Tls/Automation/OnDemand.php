<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand\RateLimit;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class OnDemand implements Arrayable
{
    private ?RateLimit $rateLimit;

    private ?string $ask;

    public function setRateLimit(RateLimit $rateLimit): static
    {
        $this->rateLimit = $rateLimit;

        return $this;
    }

    public function setAsk(string $ask): static
    {
        $this->ask = $ask;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->rateLimit)) {
            $config['rate_limit'] = $this->rateLimit->toArray();
        }

        if (isset($this->ask)) {
            $config['ask'] = $this->ask;
        }

        return $config;
    }
}
