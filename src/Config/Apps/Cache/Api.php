<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Config\Apps\Cache\Api\Souin;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Api implements Arrayable
{
    private string $_basePath = '/cache';

    private Souin $_souin;

    public function __construct(Souin $souin = new Souin())
    {
        $this->_souin = $souin;
    }

    public function setBasePath(string $basePath): static
    {
        $this->_basePath = $basePath;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'basepath' => $this->_basePath,
            'souin'    => $this->_souin->toArray(),
        ];
    }
}