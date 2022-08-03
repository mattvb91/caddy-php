<?php

namespace Tests\Integration\Apps\Http;

use mattvb91\CaddyPhp\Caddy;
use mattvb91\CaddyPhp\Config\Apps\Http;
use Tests\TestCase;

class ServerTest extends TestCase
{
    /**
     * @coversNothing
     */
    public function test_server()
    {
        $server = $this->getServerForTest();

        $caddy = (new Caddy())
            ->addApp((new Http())->addServer('test', $server));

        $this->assertCaddyConfigLoaded($caddy);
    }
}