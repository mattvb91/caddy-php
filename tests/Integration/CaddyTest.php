<?php

namespace Integration;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\StaticResponse;
use mattvb91\CaddyPhp\Config\Logging;
use mattvb91\CaddyPhp\Config\Logs\Log;
use PHPUnit\Framework\TestCase;

class CaddyTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\Caddy::load
     */
    public function test_can_load_config(): void
    {
        $caddy = new Caddy();

        $this->assertTrue($caddy->load());
    }

    /**
     * @coversNothing
     */
    public function test_can_load_with_logs(): void
    {
        $caddy = new Caddy();
        $caddy->setLogging((new Logging())
            ->addLog(new Log())
        );

        $this->assertTrue($caddy->load());
    }

    /**
     * @coversNothing
     */
    public function test_can_load_with_http_app(): void
    {
        $caddy = new Caddy();
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())
            ))
        );

        $this->assertTrue($caddy->load());
    }

    /**
     * @coversNothing
     */
    public function test_can_load_static_response_app(): void
    {
        $caddy = new Caddy();
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())->addHandle(
                    new StaticResponse('phpunit', 200)
                )
            ))
        );

        $this->assertTrue($caddy->load());

        $client = new Client([
            'base_uri' => 'caddy',
        ]);

        $request = $client->get('');

        $this->assertEquals(200, $request->getStatusCode());
        $this->assertEquals('phpunit', $request->getBody());
    }
}