<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache\Api;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Souin implements Arrayable
{
    private string $basePath = '/souin';

    private bool $enable = true;

    public function setBasePath(string $basePath): static
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function setEnable(bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'basepath' => $this->basePath,
            'enable'   => $this->enable
        ];
    }
}
