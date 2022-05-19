<?php

namespace mattvb91\CaddyPhp;

use GuzzleHttp\Client;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Caddy implements Arrayable
{
    private Client $_client;

    private Admin $_admin;

    public function __construct(?string $hostname = 'caddy', ?Admin $admin = new Admin())
    {
        $this->setAdmin($admin);

        $this->_client = new Client([
            'base_uri' => $hostname . $this->getAdmin()->getListen() . '/config',
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
        return $this->_client->post('/load', [
                'json' => $this->toArray(),
            ])->getStatusCode() === 200;
    }

    /**
     * If you need to query something directly you can use the Guzzle client
     */
    public function getClient(): Client
    {
        return $this->_client;
    }

    public function getAdmin(): ?Admin
    {
        return $this->_admin;
    }

    protected function setAdmin(Admin $admin): static
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