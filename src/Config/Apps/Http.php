<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Http\Server;
use mattvb91\CaddyPhp\Interfaces\App;
use mattvb91\CaddyPhp\Traits\IterableProps;

class Http implements App
{
    use IterableProps;
    
    /** @var Server[] */
    private array $_servers = [];

    public function addServer(string $key, Server $server): static
    {
        $this->_servers[$key] = $server;

        return $this;
    }

    public function toArray(): array
    {
        $servers = [];

        array_map(static function (Server $server, string $key) use (&$servers) {
            $servers[$key] = $server->toArray();
        }, $this->_servers, array_keys($this->_servers));

        return [
            'servers' => $servers,
        ];
    }
}