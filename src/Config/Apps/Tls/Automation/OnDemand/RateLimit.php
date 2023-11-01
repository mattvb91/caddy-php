<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class RateLimit implements Arrayable
{
    private ?string $interval;

    private ?int $burst;

    public function setInterval(string $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function setBurst(int $burst): static
    {
        $this->burst = $burst;

        return $this;
    }


    public function toArray(): array
    {
        $config = [];

        if (isset($this->interval)) {
            $config['interval'] = $this->interval;
        }

        if (isset($this->interval)) {
            $config['burst'] = $this->burst;
        }

        return $config;
    }
}
