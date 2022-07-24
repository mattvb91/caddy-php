<?php

namespace mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\ReverseProxy;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface TransportInterface extends Arrayable
{
    public function getProtocol(): string;
}