<?php

namespace Tests\Unit\Apps\Http\Server\Routes;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Error;
use Tests\TestCase;

class HandlerTest extends TestCase
{
    /**
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Error::getHandler
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Error::toArray
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Error::setError
     * @covers \mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Error::setStatusCode
     */
    public function test_error_hander()
    {
        $error = (new Error())
            ->setStatusCode(501)
            ->setError('this is an error');

        $this->assertEquals([
            'handler'     => 'error',
            'status_code' => 501,
            'error'       => 'this is an error'
        ], $error->toArray());
    }
}