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
            'stale'     => '3600s',
            'ttl'       => '3600s',
        ], $cache->ToArray());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache::setNuts
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache::toArray
     */
    public function testSetNutsCache()
    {
        $cache = new Cache();
        $nuts = new Cache\Nuts();

        $cache->setNuts($nuts);
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
            'nuts'      => [
                'path' => '/tmp/nuts-souin',
            ],
            'log_level' => 'INFO',
            'stale'     => '3600s',
            'ttl'       => '3600s',
        ], $cache->ToArray());
    }

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache::setRedis
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache::toArray
     */
    public function testSetRedisCache()
    {
        $cache = new Cache();
        $redis = new Cache\Redis('localhost:6379');

        $cache->setRedis($redis);
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
            'redis'     => [
                'url' => 'localhost:6379',
            ],
            'log_level' => 'INFO',
            'stale'     => '3600s',
            'ttl'       => '3600s',
        ], $cache->ToArray());
    }
}