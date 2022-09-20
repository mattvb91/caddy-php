<?php

namespace Integration\Apps;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Cache;
use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Logs\LogLevel;
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

    /**
     * @coversNothing
     */
    public function test_keys()
    {
        $caddy = new Caddy();

        $cacheApi = new Cache\Api();
        $cacheApi->setBasePath('/__cache');

        $cache = new Cache($cacheApi);
        $cache->setLogLevel(LogLevel::DEBUG)
            ->setStale('0s')
            ->addCacheKey(new Cache\Key(pattern: '/_next\/static/', disable_host: true));

        $caddy->addApp($cache);
        $this->assertCaddyConfigLoaded($caddy);
    }

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::flushSurrogates
     */
    public function test_surrogate_key_flush()
    {
        $caddy = new Caddy();

        $http = new Http();
        $server = new Http\Server();
        $route = new Http\Server\Route();

        $route->addHandle(new Http\Server\Routes\Handle\Cache())
            ->addHandle((new Http\Server\Routes\Handle\StaticResponse('cache test'))
                ->setHeaders([
                        'Surrogate-Key' => [
                            'test_cache_key',
                        ],
                    ]
                )
            );

        $server->addRoute($route);
        $http->addServer(key: 'cacheServer', server: $server);

        $caddy->addApp(new Cache());
        $caddy->addApp($http);
        $this->assertCaddyConfigLoaded($caddy);

        $caddy->flushSurrogates(['test_cache_key']);

        $client = new Client([
            'base_uri' => 'caddy',
        ]);

        $client->request('PURGE', 'caddy/cache/souin/GET-caddy-/');
        $client->request('PURGE', 'caddy/cache/souin/GET-localhost-/');
        sleep(1);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());

        $this->assertEquals('cache test', $request->getBody()->getContents());
        $this->assertStringContainsString('Souin; fwd=uri-miss; stored', $request->getHeader('cache-status')[0]);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());
        $this->assertStringContainsString('Souin; hit;', $request->getHeader('cache-status')[0]);

        $caddy->flushSurrogates(['test_cache_key']);
        sleep(1);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());
        $this->assertStringContainsString('Souin; fwd=uri-miss; stored', $request->getHeader('cache-status')[0]);

    }

    /**
     * @coversNothing
     */
    public function test_can_load_with_redis()
    {
        $caddy = new Caddy();

        $cacheApi = new Cache\Api();
        $cache = new Cache($cacheApi);
        $cache->setRedis((new Cache\Redis('redis:6379')));

        $caddy->addApp($cache);
        $this->assertCaddyConfigLoaded($caddy);
    }
}