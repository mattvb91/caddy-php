<?php

namespace Tests\Unit;

use mattvb91\CaddyPhp\Config\Apps\Http;
use PHPUnit\Framework\TestCase;

use function mattvb91\CaddyPhp\findHost;

class MiscTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\findHost
     */
    public function testFindingHost()
    {
        $http = new Http();
        $server = new Http\Server();
        $server->setListen([":80"]);


        $host = (new Http\Server\Routes\Match\Host('shops'))
            ->setHosts([
                "{http.request.host}.localhost",
            ]);

        $shopDeploymentsRoute = new Http\Server\Route();
        $shopDeploymentsRoute->addMatch($host)
            ->setTerminal(true);


        $server->addRoute($shopDeploymentsRoute);
        $http->addServer('platform', $server);

        $this->assertEquals($host, findHost($http, 'shops')['host']);
    }
}
