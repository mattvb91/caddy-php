<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns\ProviderInterface;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Dns implements Arrayable
{
    private ?ProviderInterface $provider;

    public function setProvider(ProviderInterface $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->provider)) {
            $config['provider'] = $this->provider->toArray();
        }

        return $config;
    }
}
