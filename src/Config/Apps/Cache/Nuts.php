<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Nuts implements Arrayable
{
    private string $path;

    public function __construct(string $_path = '/tmp/nuts-souin')
    {
        $this->path = $_path;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path
        ];
    }
}
