<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Config\Apps\Cache\Api\Souin;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Api implements Arrayable
{
    private string $basePath = '/cache';

    private Souin $souin;

    public function __construct(Souin $souin = new Souin())
    {
        $this->souin = $souin;
    }

    public function setBasePath(string $basePath): static
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'basepath' => $this->basePath,
            'souin'    => $this->souin->toArray(),
        ];
    }
}
