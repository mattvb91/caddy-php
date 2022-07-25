<?php

namespace Unit;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Config\Apps\Http;
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
     */
    public function test_can_add_app()
    {
        $caddy = new Caddy();
        $caddy->addApp(new Http());

        self::assertArraySubset([
            'apps' => [
                'http' => [
                    'servers' => [],
                ],
            ],
        ], $caddy->toArray());
    }
}