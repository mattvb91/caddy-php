<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Traits;

trait IterableProps
{
    /**
     * @return array<string, mixed>
     */
    public function iterateAllProperties(): array
    {
        return get_object_vars($this);
    }
}
