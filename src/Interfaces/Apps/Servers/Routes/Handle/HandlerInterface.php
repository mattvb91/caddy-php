<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface HandlerInterface extends Arrayable
{
    public function getHandler(): string;
}
