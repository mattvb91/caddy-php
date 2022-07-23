<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class Cache implements HandlerInterface
{

    public function toArray(): array
    {
        return [
            'handler' => $this->getHandler(),
        ];
    }

    public function getHandler(): string
    {
        return 'cache';
    }
}