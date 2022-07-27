<?php

namespace Tests\Integration\Apps\Http;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account;
use Tests\TestCase;

class HandlerTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication::addProvider
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication::getHandler
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic::addAccount
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic::getModuleName
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Account::__construct
     */
    public function test_auth_handler()
    {
        $handler = new Authentication();
        $handler->addProvider(
            (new Authentication\Providers\HttpBasic())
                ->addAccount(
                    new Account('test', 'test123')
                )
        );

        self::assertArraySubset([
            'handler'   => 'authentication',
            'providers' => [
                'http_basic' => [
                    'accounts' => [
                        [
                            'username' => 'test',
                        ],
                    ],
                ],
            ],
        ], $handler->toArray());
    }
}