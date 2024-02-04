<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns\Provider;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns\ProviderInterface;

class Route53 implements ProviderInterface
{
    private ?int $maxRetries;

    public function setMaxRetries(int $maxRetries): static
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'name' => $this->getProviderName(),
        ];

        if (isset($this->maxRetries)) {
            $config['max_retries'] = $this->maxRetries;
        }

        return $config;
    }

    public function getProviderName(): string
    {
        return 'route53';
    }
}
