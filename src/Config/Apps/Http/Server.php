<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http;

use mattvb91\caddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * Servers is the list of servers, keyed by arbitrary names chosen at your discretion for your own convenience; the keys do not affect functionality.
 */
class Server implements Arrayable
{
    private array $_listen = [];

    /** @var Route[] */
    private array $_routes = [];


    public function setListen(array $listen): static
    {
        $this->_listen = $listen;

        return $this;
    }

    public function addRoute(Route $route): static
    {
        $this->_routes[] = $route;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'listen' => $this->_listen,
            'routes' => [...array_map(static function (Route $route) {
                return $route->toArray();
            }, $this->_routes)],
        ];
    }
}