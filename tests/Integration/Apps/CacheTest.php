<?php

namespace Integration\Apps;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Cache;
use mattvb91\CaddyPhp\Config\Apps\Http;
use Tests\TestCase;

class CacheTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\Caddy::addApp
     */
    public function test_request_returns_cache_header()
    {
        $caddy = new Caddy();

        $http = new Http();
        $server = new Http\Server();
        $route = new Http\Server\Route();

        $route->addHandle(new Http\Server\Routes\Handle\Cache())
            ->addHandle(new Http\Server\Routes\Handle\StaticResponse('cache test'));

        $server->addRoute($route);
        $http->addServer(key: 'cacheServer', server: $server);

        $caddy->addApp(new Cache());
        $caddy->addApp($http);
        $this->assertCaddyConfigLoaded($caddy);

        $client = new Client([
            'base_uri' => 'caddy',
        ]);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());

        $this->assertEquals('cache test', $request->getBody()->getContents());
        $this->assertStringContainsString('Souin;', $request->getHeader('cache-status')[0]);
    }
}