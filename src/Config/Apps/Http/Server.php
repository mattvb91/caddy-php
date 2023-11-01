<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Interfaces\Arrayable;
use mattvb91\CaddyPhp\Traits\IterableProps;

/**
 * Servers is the list of servers, keyed by arbitrary names chosen at your discretion for your own convenience;
 * the keys do not affect functionality.
 */
class Server implements Arrayable
{
    use IterableProps;

    /** @var string[] */
    private array $listen = [':80'];

    /** @var Route[] */
    private array $routes = [];

    private int $readTimeout;

    private int $readHeaderTimeout;

    private int $writeTimeout;

    private int $idleTimeout;

    private int $maxHeaderBytes;

    private bool $strictSniHost;

    /**
     * @param string[] $listen
     * @return $this
     */
    public function setListen(array $listen): static
    {
        $this->listen = $listen;

        return $this;
    }

    public function addRoute(Route $route): static
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * @param Route[] $routes
     * @return $this
     */
    public function setRoutes(array $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    public function setReadTimeout(int $readTimeout): static
    {
        $this->readTimeout = $readTimeout;

        return $this;
    }

    public function setReadHeaderTimeout(int $readHeaderTimeout): static
    {
        $this->readHeaderTimeout = $readHeaderTimeout;

        return $this;
    }

    public function setWriteTimeout(int $writeTimeout): static
    {
        $this->writeTimeout = $writeTimeout;

        return $this;
    }

    public function setIdleTimeout(int $idleTimeout): static
    {
        $this->idleTimeout = $idleTimeout;

        return $this;
    }

    public function setMaxHeaderBytes(int $maxHeaderBytes): static
    {
        $this->maxHeaderBytes = $maxHeaderBytes;

        return $this;
    }

    public function setStrictSniHost(bool $strictSniHost): static
    {
        $this->strictSniHost = $strictSniHost;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'listen' => $this->listen,
            'routes' => [...array_map(static function (Route $route) {
                return $route->toArray();
            }, $this->routes)
            ],
        ];

        if (isset($this->readTimeout)) {
            $config['read_timeout'] = $this->readTimeout;
        }

        if (isset($this->readHeaderTimeout)) {
            $config['read_header_timeout'] = $this->readHeaderTimeout;
        }

        if (isset($this->writeTimeout)) {
            $config['write_timeout'] = $this->writeTimeout;
        }

        if (isset($this->idleTimeout)) {
            $config['idle_timeout'] = $this->idleTimeout;
        }

        if (isset($this->maxHeaderBytes)) {
            $config['max_header_bytes'] = $this->maxHeaderBytes;
        }

        if (isset($this->strictSniHost)) {
            $config['strict_sni_host'] = $this->strictSniHost;
        }

        return $config;
    }
}
