<?php

namespace mattvb91\CaddyPhp\Traits;

trait IterableProps
{
    public function iterateAllProperties(): array
    {
        $props = [];
        foreach ($this as $key => $value) {
            $props[$key] = &$value;
        }

        return $props;
    }

}