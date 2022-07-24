<?php

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Key implements Arrayable
{
    private string $_pattern;

    private bool $_disable_host;

    private bool $_disable_body;

    private bool $_disable_domain;

    public function __construct(
        string $pattern,
        bool   $disable_host = false,
        bool   $disable_body = false,
        bool   $disable_domain = false)
    {
        $this->_pattern = $pattern;
        $this->_disable_host = $disable_host;
        $this->_disable_body = $disable_body;
        $this->_disable_domain = $disable_domain;
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

    public function setDisableDomain(bool $disable_domain): static
    {
        $this->_disable_domain = $disable_domain;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'disable_host'   => $this->_disable_host,
            'disable_body'   => $this->_disable_body,
            'disable_domain' => $this->_disable_domain,
        ];
    }
}