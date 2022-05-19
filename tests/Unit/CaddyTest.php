<?php

namespace Unit;

use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Admin;
use PHPUnit\Framework\TestCase;

class CaddyTest extends TestCase
{
    public function test_can_instantiate(): void
    {
        $caddy = new Caddy();
        $this->assertInstanceOf(Caddy::class, $caddy);
        $this->assertEquals([], $caddy->toArray());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Caddy::setAdmin
     * @covers \mattvb91\CaddyPhp\Caddy::toArray
     */
    public function test_can_add_admin_config()
    {
        $caddy = new Caddy();
        $caddy->setAdmin(new Admin());

        $this->assertEquals([
            'admin' => [
                'disabled' => false,
                'listen'   => ':2019',
            ],
        ], $caddy->toArray());
    }
}