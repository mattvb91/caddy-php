<?php

namespace Unit;

use mattvb91\CaddyPhp\Caddy;
use PHPUnit\Framework\TestCase;

class CaddyTest extends TestCase
{
    public function test_can_instantiate(): void
    {
        $caddy = new Caddy();
        $this->assertInstanceOf(Caddy::class, $caddy);
    }
}