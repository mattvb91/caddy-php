<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Authentication\Providers\HttpBasic\Hash;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\Providers\HttpBasic\HashInterface;

class Bcrypt implements HashInterface
{
    public function toArray(): array
    {
        return [
            'algorithm' => $this->getAlgorithm(),
        ];
    }

    public function getAlgorithm(): string
    {
        return 'bcrypt';
    }
}