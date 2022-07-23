<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Cdn implements Arrayable
{
    private bool $_dynamic;
    private string $_strategy;

    /**
     * @param bool $_dynamic
     * @param string $_strategy
     */
    public function __construct(bool $_dynamic = true, string $_strategy = 'hard')
    {
        $this->_dynamic = $_dynamic;
        $this->_strategy = $_strategy;
    }

    /**
     * @param bool $dynamic
     */
    public function setDynamic(bool $dynamic): void
    {
        $this->_dynamic = $dynamic;
    }

    /**
     * @param string $strategy
     */
    public function setStrategy(string $strategy): void
    {
        $this->_strategy = $strategy;
    }


    public function toArray(): array
    {
        return [
            'dynamic'  => $this->_dynamic,
            'strategy' => $this->_strategy
        ];
    }
}