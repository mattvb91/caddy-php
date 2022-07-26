<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Key implements Arrayable
{
    private string $_pattern;

    private bool $_disable_host;

    private bool $_disable_body;

    private bool $_disable_method;

    public function __construct(
        string $pattern,
        bool   $disable_host = false,
        bool   $disable_body = false,
        bool   $disable_method = false)
    {
        $this->_pattern = $pattern;
        $this->_disable_host = $disable_host;
        $this->_disable_body = $disable_body;
        $this->_disable_method = $disable_method;
    }

    public function getPattern(): string
    {
        return $this->_pattern;
    }

    public function setDisableHost(bool $disable_host): static
    {
        $this->_disable_host = $disable_host;

        return $this;
    }

    public function setDisableBody(bool $disable_body): static
    {
        $this->_disable_body = $disable_body;

        return $this;
    }

    public function setDisableMethod(bool $disable_domain): static
    {
        $this->_disable_method = $disable_domain;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'disable_host'   => $this->_disable_host,
            'disable_body'   => $this->_disable_body,
            'disable_method' => $this->_disable_method,
        ];
    }
}