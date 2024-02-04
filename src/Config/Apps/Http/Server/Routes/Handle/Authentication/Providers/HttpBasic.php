<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\ProviderInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\Providers\HttpBasic\HashInterface;

class HttpBasic implements ProviderInterface
{
    /** @var Account[] */
    private array $accounts = [];

    private ?HashInterface $hash;

    public function addAccount(Account $account): static
    {
        $this->accounts[] = $account;

        return $this;
    }

    public function setHash(HashInterface $hash): static
    {
        $this->hash = $hash;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if ($this->accounts !== []) {
            $config['accounts'] = [...array_map(function (Account $account): array {
                return $account->toArray();
            }, $this->accounts)
            ];
        }

        if (isset($this->hash)) {
            $config['hash'] = $this->hash->toArray();
        }

        return $config;
    }

    public function getModuleName(): string
    {
        return 'http_basic';
    }
}
