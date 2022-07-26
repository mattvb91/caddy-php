<?php

namespace Integration;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\StaticResponse;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Host;
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

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::addHostname
     * @covers \mattvb91\CaddyPhp\Caddy::removeHostname
     * @covers \mattvb91\CaddyPhp\findHost
     */
    public function test_can_add_remove_hosts()
    {
        $caddy = new Caddy();
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())->addHandle(
                    new StaticResponse('host test', 200)
                )->addMatch((new Host('main'))
                    ->setHosts(['test.localhost'])
                )
            )->addRoute((new Route())
                ->addHandle(new StaticResponse('Not found', 404))
                ->addMatch((new Host('notFound'))
                    ->setHosts(['*.localhost'])
                )
            ))
        );

        $this->assertTrue($caddy->load());
        $this->assertTrue($caddy->addHostname('main', 'new.localhost'));

        $client = new Client([
            'base_uri' => 'caddy',
            'headers'  => [
                'Host' => 'new.localhost',
            ],
        ]);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());

        $client = new Client([
            'base_uri' => 'caddy',
            'headers'  => [
                'Host' => 'test.localhost',
            ],
        ]);

        $request = $client->get('');
        $this->assertEquals(200, $request->getStatusCode());

        $client = new Client([
            'base_uri'    => 'caddy',
            'http_errors' => false,
            'headers'     => [
                'Host' => 'notfound.localhost',
            ],
        ]);

        $request = $client->get('');
        $this->assertEquals(404, $request->getStatusCode());

        $caddy->removeHostname('main', 'test.localhost');

        $client = new Client([
            'base_uri'    => 'caddy',
            'http_errors' => false,
            'headers'     => [
                'Host' => 'test.localhost',
            ],
        ]);

        $request = $client->get('');
        $this->assertEquals(404, $request->getStatusCode());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::syncHosts
     */
    public function test_sync_hosts_works()
    {
        $caddy = new Caddy();
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())->addHandle(
                    new StaticResponse('host test', 200)
                )->addMatch((new Host('main'))
                    ->setHosts([
                        'test.localhost',
                        'test2.localhost',
                        'localhost',
                    ])
                )
            ))
        );
        $caddy->load();

        //Create instance without setting hosts
        $caddy = new Caddy();
        $mainHost = new Host('main');
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())->addHandle(
                    new StaticResponse('host test', 200)
                )->addMatch($mainHost)
            ))
        );

        $caddy->syncHosts('main');
        $this->assertCount(3, $mainHost->getHosts());
    }

    /**
     * @coversNothing
     */
    public function test_http_basic_auth()
    {
        $caddy = new Caddy();
        $caddy->addApp(
            (new Http())->addServer(
                'server1', (new Http\Server())->addRoute(
                (new Route())
                    ->addHandle((new Authentication())
                        ->addProvider((new HttpBasic())
                            ->addAccount(new Account('test', 'test123'))))
                    ->addHandle(
                        new StaticResponse('auth test', 200)
                    )->addMatch((new Host('main'))
                        ->setHosts([
                            'localhost',
                        ])
                    )
            ))
        );
        $caddy->load();

        $client = new Client([
            'base_uri'    => 'caddy',
            'http_errors' => false,
            'headers'     => [
                'Host' => 'localhost',
            ],
        ]);

        $request = $client->get('');
        $this->assertEquals(401, $request->getStatusCode());

        $request = $client->request('GET', '', [
            'auth' => [
                'test',
                'test123',
            ],
        ]);
        $this->assertEquals(200, $request->getStatusCode());

    }
}