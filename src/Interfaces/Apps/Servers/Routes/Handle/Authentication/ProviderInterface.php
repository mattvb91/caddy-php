<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\Authentication;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface ProviderInterface extends Arrayable
{
    public function getModuleName(): string;
}
