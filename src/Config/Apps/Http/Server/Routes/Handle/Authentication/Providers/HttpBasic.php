<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\ProviderInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\Providers\HttpBasic\HashInterface;

class HttpBasic implements ProviderInterface
{
    private ?array $_accounts;

    private ?HashInterface $_hash;

    public function addAccount(Account $account): static
    {
        if (!isset($this->_accounts)) {
            $this->_accounts = [$account];
        } else {
            $this->_accounts[] = $account;
        }
        return $this;
    }

    public function setHash(HashInterface $hash): static
    {
        $this->_hash = $hash;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_accounts)) {
            $config['accounts'] = [...array_map(function (Account $account) {
                return $account->toArray();
            }, $this->_accounts)];
        }

        if (isset($this->_hash)) {
            $config['hash'] = $this->_hash->toArray();
        }

        return $config;
    }

    public function getModuleName(): string
    {
        return 'http_basic';
    }

}