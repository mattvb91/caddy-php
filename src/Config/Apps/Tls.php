<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation;
use mattvb91\CaddyPhp\Interfaces\App;

/**
 * https://caddyserver.com/docs/json/apps/tls/
 */
class Tls implements App
{
    private ?Automation $_automation;

    public function setAutomation(Automation $automation): static
    {
        $this->_automation = $automation;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_automation)) {
            $config['automation'] = $this->_automation->toArray();
        }

        return $config;
    }
}