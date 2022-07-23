<?php

namespace Integration\Apps;

use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Cache;
use mattvb91\CaddyPhp\Config\Apps\Http;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    public function test_cache_returns_cache_header()
    {
        $caddy = new Caddy();

        $http = new Http();
        $server = new Http\Server();
        $route = new Http\Server\Route();

        $route->addHandle(new Http\Server\Routes\Handle\Cache())
            ->addHandle(new Http\Server\Routes\Handle\StaticResponse('hello world'));


        $server->addRoute($route);
        $http->addServer(key: 'cacheServer', server: $server);

        $caddy->addApp(new Cache());
        $caddy->addApp($http);
        $caddy->load();
    }
}