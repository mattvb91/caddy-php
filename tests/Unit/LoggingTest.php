<?php

namespace Unit;

use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Logging;
use mattvb91\CaddyPhp\Config\Logs\Log;
use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggingTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\Caddy::setLogging
     * @covers \mattvb91\CaddyPhp\Caddy::toArray
     */
    public function testAddingDefaultLog()
    {
        $caddy = new Caddy();
        $caddy->setLogging((new Logging())
            ->addLog(new Log()));

        $this->assertEquals([
            'logs' => [
                'default' => [
                    'level' => LogLevel::DEBUG,
                ]
            ]
        ], $caddy->toArray()['logging']);
    }
}
