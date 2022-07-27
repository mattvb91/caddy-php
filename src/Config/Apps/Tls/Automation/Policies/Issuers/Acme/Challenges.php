<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme;

use mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Challenges implements Arrayable
{

    private ?Dns $_dns;

    public function setDns(Dns $dns): static
    {
        $this->_dns = $dns;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_dns)) {
            $config['dns'] = $this->_dns->toArray();
        }

        return $config;
    }
}