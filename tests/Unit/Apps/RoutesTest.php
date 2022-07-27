<?php

namespace Tests\Unit\Apps;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\StaticResponse;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\MatchProtocol;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Protocol;
use Tests\TestCase;

class RoutesTest extends TestCase
{

    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\StaticResponse::setHeaders
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\StaticResponse::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Match\Protocol::toArray
     */
    public function test_set_headers_and_match_protocol()
    {
        $route = (new Route())
            ->addHandle((new StaticResponse(statusCode: 308))
                ->setHeaders([
                    'Location' => [
                        'https://{http.request.hostport}{http.request.uri}',
                    ],
                ]))
            ->addMatch(new Protocol(MatchProtocol::HTTP))
            ->setTerminal(true);

        $this->assertEquals([
            "handle"   => [
                [
                    "handler"     => "static_response",
                    'status_code' => 308,
                    'headers'     => [
                        'Location' => [
                            'https://{http.request.hostport}{http.request.uri}',
                        ],
                    ],
                ],
            ],
            "match"    => [
                [
                    'protocol' => 'http',
                ],
            ],
            "terminal" => true,
        ], $route->toArray());
    }

}