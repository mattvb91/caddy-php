<?php

namespace Unit;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Admin;
use PHPUnit\Framework\TestCase;

class CaddyTest extends TestCase
{
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
}