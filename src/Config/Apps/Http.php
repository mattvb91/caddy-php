<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Http\Server;
use mattvb91\CaddyPhp\Interfaces\App;
use mattvb91\CaddyPhp\Traits\IterableProps;

class Http implements App
{
    use IterableProps;

    private int $_httpPort;

    private int $_httpsPort;

    private int $_gracePeriod;

    /** @var Server[] */
    private array $_servers = [];

    public function addServer(string $key, Server $server): static
    {
        $this->_servers[$key] = $server;

        return $this;
    }

    public function setHttpPort(int $httpPort): static
    {
        $this->_httpPort = $httpPort;

        return $this;
    }

    public function setHttpsPort(int $httpsPort): static
    {
        $this->_httpsPort = $httpsPort;

        return $this;
    }

    public function setGracePeriod(int $gracePeriod): static
    {
        $this->_gracePeriod = $gracePeriod;
        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_httpPort)) {
            $config['http_port'] = $this->_httpPort;
        }

        if (isset($this->_httpsPort)) {
            $config['https_port'] = $this->_httpsPort;
        }

        if (isset($this->_gracePeriod)) {
            $config['grace_period'] = $this->_gracePeriod;
        }

        $servers = [];
        array_map(static function (Server $server, string $key) use (&$servers) {
            $servers[$key] = $server->toArray();
        }, $this->_servers, array_keys($this->_servers));

        $config['servers'] = $servers;

        return $config;
    }
}