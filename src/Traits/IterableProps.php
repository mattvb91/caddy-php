<?php

namespace mattvb91\CaddyPhp\Traits;

trait IterableProps
{
    public function iterateAllProperties(): array
    {
        return get_object_vars($this);
    }

}