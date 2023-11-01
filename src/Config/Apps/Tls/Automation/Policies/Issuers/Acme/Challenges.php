<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Challenges implements Arrayable
{
    private ?Dns $dns;

    public function setDns(Dns $dns): static
    {
        $this->dns = $dns;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->dns)) {
            $config['dns'] = $this->dns->toArray();
        }

        return $config;
    }
}
