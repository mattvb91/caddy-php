<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Headers;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * https://caddyserver.com/docs/modules/http.handlers.headers
 */
class Request implements Arrayable
{
    /**
     * Names of HTTP header fields to delete.
     * @var string[]
     */
    private array $delete = [];

    public function addDeleteHeader(string $header): static
    {
        $this->delete[] = $header;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (count($this->delete)) {
            $array['delete'] = $this->delete;
        }

        return $array;
    }
}
