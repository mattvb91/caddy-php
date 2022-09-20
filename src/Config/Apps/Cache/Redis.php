<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Redis implements Arrayable
{
    private string $_url;

    public function __construct(string $_url)
    {
        $this->_url = $_url;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->_url,
        ];
    }
}