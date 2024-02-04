<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Cache;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Key implements Arrayable
{
    private string $pattern;

    private bool $disable_host;

    private bool $disable_body;

    private bool $disable_method;

    public function __construct(
        string $pattern,
        bool $disable_host = false,
        bool $disable_body = false,
        bool $disable_method = false
    ) {
        $this->pattern = $pattern;
        $this->disable_host = $disable_host;
        $this->disable_body = $disable_body;
        $this->disable_method = $disable_method;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function setDisableHost(bool $disable_host): static
    {
        $this->disable_host = $disable_host;

        return $this;
    }

    public function setDisableBody(bool $disable_body): static
    {
        $this->disable_body = $disable_body;

        return $this;
    }

    public function setDisableMethod(bool $disable_domain): static
    {
        $this->disable_method = $disable_domain;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'disable_host'   => $this->disable_host,
            'disable_body'   => $this->disable_body,
            'disable_method' => $this->disable_method,
        ];
    }
}
