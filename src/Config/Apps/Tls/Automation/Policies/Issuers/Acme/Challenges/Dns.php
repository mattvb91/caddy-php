<?php

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns\ProviderInterface;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Dns implements Arrayable
{
    private ?ProviderInterface $_provider;

    public function setProvider(ProviderInterface $provider): static
    {
        $this->_provider = $provider;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_provider)) {
            $config['provider'] = $this->_provider->toArray();
        }

        return $config;
    }

}