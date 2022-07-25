<?php

namespace mattvb91\CaddyPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use mattvb91\CaddyPhp\Config\Admin;
use mattvb91\CaddyPhp\Config\Logging;
use mattvb91\CaddyPhp\Exceptions\CaddyClientException;
use mattvb91\caddyPhp\Interfaces\App;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Caddy implements Arrayable
{
    private Client $_client;

    private Admin $_admin;

    private ?Logging $_logging;

    /** @var App[] */
    private array $_apps;

    public function __construct(?string $hostname = 'caddy', ?Admin $admin = new Admin(), ?Client $client = null)
    {
        $this->setAdmin($admin);

        $this->_client = $client ?? new Client([
                    'base_uri' => $hostname . $this->getAdmin()->getListen() . '/config',
                    'headers'  => [
                        'Content-Type' => 'application/json',
                    ],
                ]
            );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function load(): bool
    {
        try {
            return $this->_client->post('/load', [
                    'json' => $this->toArray(),
                ])->getStatusCode() === 200;
        } catch (ClientException $e) {
            throw new CaddyClientException($e->getResponse()->getBody() . PHP_EOL . json_encode($this->toArray(), JSON_PRETTY_PRINT));
        }
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

    public function setLogging(Logging $logging)
    {
        $this->_logging = $logging;

        return $this;
    }

    public function addApp(App $app): static
    {
        $namespace = strtolower(substr(strrchr(get_class($app), '\\'), 1));

        if (!isset($this->_apps)) {
            $this->_apps = [$namespace => $app];
        } else {
            $this->_apps[$namespace] = $app;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_admin)) {
            $config['admin'] = $this->_admin->toArray();
        }

        if (isset($this->_logging)) {
            $config['logging'] = $this->_logging->toArray();
        }

        if (isset($this->_apps)) {
            $apps = [];

            array_map(static function (App $app, string $appNamespace) use (&$apps) {
                $apps[$appNamespace] = $app->toArray();
            }, $this->_apps, array_keys($this->_apps));

            $config['apps'] = $apps;
        }

        return $config;
    }
}