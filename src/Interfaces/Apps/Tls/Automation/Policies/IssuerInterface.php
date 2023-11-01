<?php

namespace mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface IssuerInterface extends Arrayable
{
    public function getModuleName(): string;
}
