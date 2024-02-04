<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * https://caddyserver.com/docs/json/admin/
 *
 * AdminConfig configures Caddy's API endpoint,
 * which is used to manage Caddy while it is running.
 *
 */
class Admin implements Arrayable
{
    /**
     * If true, the admin endpoint will be completely disabled.
     * Note that this makes any runtime changes to the config impossible,
     * since the interface to do so is through the admin endpoint.
     */
    private bool $disabled = false;

    /**
     * The address to which the admin endpoint's listener should bind itself.
     * Can be any single network address that can be parsed by Caddy. Default: localhost:2019
     */
    private string $listen = ":2019";

    public function setDisabled(bool $disabled): static
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function getListen(): string
    {
        return $this->listen;
    }

    public function setListen(string $listen): static
    {
        $this->listen = $listen;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'disabled' => $this->disabled,
            'listen'   => $this->getListen(),
        ];
    }
}
