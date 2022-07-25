<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache\Api;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Souin implements Arrayable
{
    private string $_basePath = '/souin';

    private bool $_enable = true;

    public function setBasePath(string $basePath): static
    {
        $this->_basePath = $basePath;

        return $this;
    }

    public function setEnable(bool $enable): static
    {
        $this->_enable = $enable;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'basepath' => $this->_basePath,
            'enable'   => $this->_enable
        ];
    }
}