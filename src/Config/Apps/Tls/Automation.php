<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\OnDemand;
use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Automation implements Arrayable
{
    private ?OnDemand $_onDemand;

    private ?array $_policies;

    public function setOnDemand(OnDemand $onDemand): static
    {
        $this->_onDemand = $onDemand;

        return $this;
    }

    public function addPolicies(Policies $policies): static
    {
        if (!isset($this->_policies)) {
            $this->_policies = [$policies];
        } else {
            $this->_policies[] = $policies;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_onDemand)) {
            $config['on_demand'] = $this->_onDemand->toArray();
        }

        if (isset($this->_policies)) {
            $config['policies'] = array_map(function (Policies $policies) {
                return $policies->toArray();
            }, $this->_policies);
        }

        return $config;
    }


}