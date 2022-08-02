<?php

namespace Tests\Unit\Apps\Http\Server;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use mattvb91\CaddyPhp\Config\Apps\Http\Server;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use ArraySubsetAsserts;

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setReadTimeout
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setReadHeaderTimeout
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setWriteTimeout
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setIdleTimeout
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setMaxHeaderBytes
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setStrictSniHost
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setExperimentalHttp3
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::setAllowH2c
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server::toArray
     */
    public function test_server()
    {
        $server = $this->getServerForTest();

        $this->assertArraySubset([
            "listen"              => [":80"],
            "read_timeout"        => 1,
            "read_header_timeout" => 2,
            "write_timeout"       => 3,
            "idle_timeout"        => 4,
            "max_header_bytes"    => 5,
            "strict_sni_host"     => true,
            "experimental_http3"  => true,
            "allow_h2c"           => true,
        ], $server->toArray());
    }
}