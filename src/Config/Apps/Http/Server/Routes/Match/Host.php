<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;

class Host implements MatcherInterface
{
    private array $_hosts = [];

    public function setHosts(array $hosts): static
    {
        $this->_hosts = $hosts;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'host' => $this->_hosts,
        ];
    }
}