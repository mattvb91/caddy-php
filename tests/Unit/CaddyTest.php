<?php

namespace Unit;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Config\Apps\Tls;
use mattvb91\CaddyPhp\Exceptions\CaddyClientException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CaddyTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::setAdmin
     * @covers \mattvb91\CaddyPhp\Caddy::toArray
     * @covers \mattvb91\CaddyPhp\Caddy::getAdmin
     * @covers \mattvb91\CaddyPhp\Caddy::getClient
     * @covers \mattvb91\CaddyPhp\Caddy::__construct
     */
    public function test_can_instantiate(): void
    {
        $caddy = new Caddy();
        $this->assertInstanceOf(Caddy::class, $caddy);
        $this->assertEquals([
            'admin' => [
                'disabled' => false,
                'listen'   => ':2019',
            ],
        ], $caddy->toArray());

        $this->assertInstanceOf(Admin::class, $caddy->getAdmin());
        $this->assertInstanceOf(Client::class, $caddy->getClient());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::toArray
     * @covers \mattvb91\CaddyPhp\Caddy::addApp
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http::setHttpPort
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http::setHttpsPort
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http::setGracePeriod
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http::toArray
     */
    public function test_can_add_app()
    {
        $caddy = new Caddy();
        $caddy->addApp((new Http())
            ->setHttpPort(1)
            ->setHttpsPort(2)
            ->setGracePeriod(3)
        )->addApp(new Tls());

        self::assertArraySubset([
            'apps' => [
                'http' => [
                    'http_port'    => 1,
                    'https_port'   => 2,
                    'grace_period' => 3,
                    'servers'      => [],
                ],
                'tls'  => [],
            ],
        ], $caddy->toArray());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::load
     */
    public function test_client_exception()
    {
        /** @var MockObject|Caddy $mockClient */
        $mockClient = $this->createPartialMock(Client::class, ['post']);
        $mockClient->method('post')->willThrowException(new ClientException('error', new Request('post', '/'), new Response(500)));
        $this->expectException(CaddyClientException::class);

        $caddy = new Caddy(client: $mockClient);
        $caddy->load();
    }

    /**
     * @covers \mattvb91\CaddyPhp\Config\Admin::setDisabled
     * @covers \mattvb91\CaddyPhp\Config\Admin::setListen
     * @covers \mattvb91\CaddyPhp\Config\Admin::toArray
     * @covers \mattvb91\CaddyPhp\Config\Admin::getListen
     */
    public function test_admin()
    {
        $admin = (new Admin())
            ->setDisabled(true)
            ->setListen(':2020');

        $this->assertEquals([
            'disabled' => true,
            'listen'   => ':2020',
        ], $admin->toArray());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setListen
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::addRoute
     */
    public function test_server()
    {
        $server = (new Http\Server())
            ->setListen([':122'])
            ->addRoute(new Http\Server\Route());

        $this->assertEquals([
            'listen' => [':122'],
            'routes' => [
                [
                    'handle' => [],
                ],
            ],
        ], $server->toArray());
    }
}