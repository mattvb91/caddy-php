<?php

namespace mattvb91\CaddyPhp\Interfaces;

interface Arrayable
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}