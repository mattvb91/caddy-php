<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Tls\Automation\Policies\Issuers;

use mattvb91\CaddyPhp\Interfaces\Apps\Tls\Automation\Policies\IssuerInterface;

class Internal implements IssuerInterface
{
    public function getModuleName(): string
    {
        return 'internal';
    }

    public function toArray(): array
    {
        return [
            'module' => $this->getModuleName(),
        ];
    }
}
