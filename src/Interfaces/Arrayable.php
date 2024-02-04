<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Interfaces;

interface Arrayable
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
