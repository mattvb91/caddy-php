<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Headers;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Response implements Arrayable
{
    /**
     * Names of HTTP header fields to delete.
     * @var string[]
     */
    private array $delete = [];

    /**
     * @var array<string, string[]>
     */
    private array $add = [];

    private bool $deferred = false;

    public function addDeleteHeader(string $header): static
    {
        if (!isset($this->delete)) {
            $this->delete = [$header];
        } else {
            $this->delete[] = $header;
        }

        return $this;
    }

    public function addHeader(string $name, string $value): static
    {
        $this->add[$name] = [$value];

        return $this;
    }

    public function setDeferred(bool $deferred): static
    {
        $this->deferred = $deferred;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (count($this->delete)) {
            $array['delete'] = $this->delete;
        }

        if (count($this->add)) {
            $array['add'] = $this->add;
        }

        $array['deferred'] = $this->deferred;

        return $array;
    }
}
