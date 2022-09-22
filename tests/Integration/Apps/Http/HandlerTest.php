<?php

namespace Tests\Integration\Apps\Http;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http;
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

    /**
     * @coversNothing
     */
    public function test_error_handler()
    {
        $caddy = new Caddy();
        $caddy->addApp((new Http())
            ->addServer('errorServer', (new Http\Server())
                ->addRoute((new Http\Server\Route())
                    ->addHandle((new Http\Server\Routes\Handle\Error())
                        ->setError("this is an error")
                        ->setStatusCode(501)
                    )
                )
            )
        );

        $this->assertCaddyConfigLoaded($caddy);
    }

    /**
     * @coversNothing
     */
    public function test_static_file_server_handler()
    {
        $caddy = new Caddy();
        $caddy->addApp((new Http())
            ->addServer('staticFileServer', (new Http\Server())
                ->addRoute((new Http\Server\Route())
                    ->addHandle((new Http\Server\Routes\Handle\FileServer())
                        ->setRoot('/var/files')
                    )
                )
            )
        );

        $this->assertCaddyConfigLoaded($caddy);

        $client = new Client([
            'base_uri'    => 'caddy',
            'http_errors' => false,
            'headers'     => [
                'Host' => 'localhost',
            ],
        ]);

        $request = $client->request('GET', 'caddy/');
        $this->assertEquals(404, $request->getStatusCode());

        $request = $client->request('GET', 'caddy/static.txt');
        $this->assertEquals(200, $request->getStatusCode());
    }
}