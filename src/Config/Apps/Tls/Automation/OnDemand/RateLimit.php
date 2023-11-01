<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class RateLimit implements Arrayable
{
    private ?string $_interval;

    private ?int $_burst;

    public function setInterval(string $interval): static
    {
        $this->_interval = $interval;

        return $this;
    }

    public function setBurst(int $burst): static
    {
        $this->_burst = $burst;

        return $this;
    }


    public function toArray(): array
    {
        $config = [];

        if (isset($this->_interval)) {
            $config['interval'] = $this->_interval;
        }

        if (isset($this->_interval)) {
            $config['burst'] = $this->_burst;
        }

        return $config;
    }
}