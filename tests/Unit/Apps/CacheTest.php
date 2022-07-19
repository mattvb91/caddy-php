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
            'cache' => [
                'api' => [
                    'basepath' => '/cache',
                    'souin' => [
                        'basepath' => '/souin',
                        'enable' => true,
                    ],
                ],
                'cdn' => [
                    'dynamic' => true,
                    'strategy' => 'hard',
                ],
                'log_level' => 'DEBUG',
                'nuts' => [
                    'path' => '/tmp/nuts-souin',
                ],
                'stale' => '0s',
                'ttl' => '3600s',
            ],
        ], $cache->ToArray());
    }
}