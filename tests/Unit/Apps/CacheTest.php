<?php

namespace Unit\Apps;

use mattvb91\CaddyPhp\Config\Apps\Cache;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache::toArray
     */
    public function testCacheInit()
    {
        $cache = new Cache();

        $this->assertEquals([
            'api'       => [
                'basepath' => '/cache',
                'souin'    => [
                    'basepath' => '/souin',
                    'enable'   => true,
                ],
            ],
            'cdn'       => [
                'dynamic'  => true,
                'strategy' => 'hard',
            ],
            'log_level' => 'INFO',
            'nuts'      => [
                'path' => '/tmp/nuts-souin',
            ],
            'stale'     => '3600s',
            'ttl'       => '3600s',
        ], $cache->ToArray());
    }
}