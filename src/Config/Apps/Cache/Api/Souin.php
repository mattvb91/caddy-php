<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache\Api;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Souin implements Arrayable
{
    private string $_basePath = '/souin';

    private bool $_enable = true;

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->_basePath = $basePath;
    }

    /**
     * @param bool $enable
     */
    public function setEnable(bool $enable): void
    {
        $this->_enable = $enable;
    }

    public function toArray(): array
    {
        return [
            'basepath' => $this->_basePath,
            'enable'   => $this->_enable
        ];
    }
}