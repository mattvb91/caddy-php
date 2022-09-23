<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Headers;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Response implements Arrayable
{
    /**
     * Names of HTTP header fields to delete.
     */
    private ?array $_delete;

    private ?array $_add;

    private bool $_deferred = false;

    public function addDeleteHeader(string $header): static
    {
        if (!isset($this->_delete)) {
            $this->_delete = [$header];
        } else {
            $this->_delete[] = $header;
        }

        return $this;
    }

    public function addHeader(string $name, string $value): static
    {
        $this->_add[$name] = [$value];

        return $this;
    }

    public function setDeferred(bool $deferred): static
    {
        $this->_deferred = $deferred;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (isset($this->_delete)) {
            $array['delete'] = $this->_delete;
        }

        if (isset($this->_add)) {
            $array['add'] = $this->_add;
        }

        $array['deferred'] = $this->_deferred;

        return $array;
    }
}