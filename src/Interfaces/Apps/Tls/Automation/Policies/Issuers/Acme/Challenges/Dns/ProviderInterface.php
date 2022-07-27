<?php

namespace mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\Issuers\Acme\Challenges\Dns;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

interface ProviderInterface extends Arrayable
{
    public function getProviderName(): string;
}