<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Cdn implements Arrayable
{
    private bool $dynamic;
    private string $strategy;

    public function __construct(bool $_dynamic = true, string $_strategy = 'hard')
    {
        $this->dynamic = $_dynamic;
        $this->strategy = $_strategy;
    }

    public function setDynamic(bool $dynamic): void
    {
        $this->dynamic = $dynamic;
    }

    public function setStrategy(string $strategy): void
    {
        $this->strategy = $strategy;
    }


    public function toArray(): array
    {
        return [
            'dynamic'  => $this->dynamic,
            'strategy' => $this->strategy
        ];
    }
}
