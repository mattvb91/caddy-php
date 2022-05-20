<?php

namespace Integration;

use mattvb91\CaddyPhp\Caddy;
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
}