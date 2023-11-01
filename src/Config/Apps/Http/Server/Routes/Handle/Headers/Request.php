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
    private array $_delete = [];

    public function addDeleteHeader(string $header): static
    {
        $this->_delete[] = $header;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (count($this->_delete)) {
            $array['delete'] = $this->_delete;
        }

        return $array;
    }
}