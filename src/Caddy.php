<?php

namespace mattvb91\CaddyPhp;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Caddy implements Arrayable
{
    private Client $_client;

    private ?Admin $_admin;

    public function __construct($hostname = 'caddy')
    {
        $this->_client = new Client([
            'base_uri' => $hostname,
            'headers'  => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function load(): bool
    {
        return $this->_client->put('/load', [
                'json' => $this->toArray(),
            ])->getStatusCode() === 200;
    }

    public function getAdmin(): ?Admin
    {
        return $this->_admin;
    }

    public function setAdmin(Admin $admin): static
    {
        $this->_admin = $admin;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_admin)) {
            $config['admin'] = $this->_admin->toArray();
        }

        return $config;
    }
}