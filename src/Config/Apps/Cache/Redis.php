<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Redis implements Arrayable
{
    private string $url;

    public function __construct(string $_url)
    {
        $this->url = $_url;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
