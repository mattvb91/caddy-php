<?php

namespace Feature;

use mattvb91\CaddyPhp\Caddy;
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
}