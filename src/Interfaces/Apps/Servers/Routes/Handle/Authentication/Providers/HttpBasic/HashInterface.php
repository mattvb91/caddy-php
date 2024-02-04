<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication\Providers\HttpBasic;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface HashInterface extends Arrayable
{
    public function getAlgorithm(): string;
}
