<?php

namespace Tests\Unit;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use mattvb91\CaddyPhp\Config\Apps\Cache\Api;
use Tests\TestCase;

class CacheTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api::setBasePath
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api::__construct
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api\Souin::setBasePath
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api\Souin::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Cache\Api\Souin::setEnable
     */
    public function testApi()
    {
        $api = new Api(
            (new Api\Souin())
                ->setBasePath('/test2')
                ->setEnable(false)
        );
        $api->setBasePath('/test');

        $this->assertEquals([
            'basepath' => '/test',
            'souin'    => [
                'basepath' => '/test2',
                'enable'   => false,
            ],
        ], $api->toArray());
    }
}
