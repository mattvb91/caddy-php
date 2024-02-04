<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand;
use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Automation implements Arrayable
{
    private ?OnDemand $onDemand;

    /** @var array<Policies>|null  */
    private ?array $policies;

    public function setOnDemand(OnDemand $onDemand): static
    {
        $this->onDemand = $onDemand;

        return $this;
    }

    public function addPolicies(Policies $policies): static
    {
        if (!isset($this->policies)) {
            $this->policies = [$policies];
        } else {
            $this->policies[] = $policies;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->onDemand)) {
            $config['on_demand'] = $this->onDemand->toArray();
        }

        if (isset($this->policies)) {
            $config['policies'] = array_map(function (Policies $policies): array {
                return $policies->toArray();
            }, $this->policies);
        }

        return $config;
    }
}
