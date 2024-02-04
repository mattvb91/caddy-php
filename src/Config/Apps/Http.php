<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Http\Server;
use mattvb91\CaddyPhp\Interfaces\App;
use mattvb91\CaddyPhp\Traits\IterableProps;

class Http implements App
{
    use IterableProps;

    private int $httpPort;

    private int $httpsPort;

    private int $gracePeriod;

    /** @var Server[] */
    private array $servers = [];

    public function addServer(string $key, Server $server): static
    {
        $this->servers[$key] = $server;

        return $this;
    }

    public function setHttpPort(int $httpPort): static
    {
        $this->httpPort = $httpPort;

        return $this;
    }

    public function setHttpsPort(int $httpsPort): static
    {
        $this->httpsPort = $httpsPort;

        return $this;
    }

    public function setGracePeriod(int $gracePeriod): static
    {
        $this->gracePeriod = $gracePeriod;
        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->httpPort)) {
            $config['http_port'] = $this->httpPort;
        }

        if (isset($this->httpsPort)) {
            $config['https_port'] = $this->httpsPort;
        }

        if (isset($this->gracePeriod)) {
            $config['grace_period'] = $this->gracePeriod;
        }

        $servers = [];
        array_map(static function (Server $server, string $key) use (&$servers): void {
            $servers[$key] = $server->toArray();
        }, $this->servers, array_keys($this->servers));

        $config['servers'] = $servers;

        return $config;
    }
}
