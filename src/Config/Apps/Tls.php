<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation;
use mattvb91\CaddyPhp\Interfaces\App;

/**
 * https://caddyserver.com/docs/json/apps/tls/
 */
class Tls implements App
{
    private ?Automation $automation;

    public function setAutomation(Automation $automation): static
    {
        $this->automation = $automation;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->automation)) {
            $config['automation'] = $this->automation->toArray();
        }

        return $config;
    }
}
