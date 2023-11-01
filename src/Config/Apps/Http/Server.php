<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Interfaces\Arrayable;
use mattvb91\CaddyPhp\Traits\IterableProps;

/**
 * Servers is the list of servers, keyed by arbitrary names chosen at your discretion for your own convenience; the keys do not affect functionality.
 */
class Server implements Arrayable
{
    use IterableProps;

    /** @var string[] */
    private array $_listen = [':80'];

    /** @var Route[] */
    private array $_routes = [];

    private int $_readTimeout;

    private int $_readHeaderTimeout;

    private int $_writeTimeout;

    private int $_idleTimeout;

    private int $_maxHeaderBytes;

    private bool $_strictSniHost;

    /**
     * @param string[] $listen
     * @return $this
     */
    public function setListen(array $listen): static
    {
        $this->_listen = $listen;

        return $this;
    }

    public function addRoute(Route $route): static
    {
        $this->_routes[] = $route;

        return $this;
    }

    /**
     * @param Route[] $routes
     * @return $this
     */
    public function setRoutes(array $routes): static
    {
        $this->_routes = $routes;

        return $this;
    }

    public function setReadTimeout(int $readTimeout): static
    {
        $this->_readTimeout = $readTimeout;

        return $this;
    }

    public function setReadHeaderTimeout(int $readHeaderTimeout): static
    {
        $this->_readHeaderTimeout = $readHeaderTimeout;

        return $this;
    }

    public function setWriteTimeout(int $writeTimeout): static
    {
        $this->_writeTimeout = $writeTimeout;

        return $this;
    }

    public function setIdleTimeout(int $idleTimeout): static
    {
        $this->_idleTimeout = $idleTimeout;

        return $this;
    }

    public function setMaxHeaderBytes(int $maxHeaderBytes): static
    {
        $this->_maxHeaderBytes = $maxHeaderBytes;

        return $this;
    }

    public function setStrictSniHost(bool $strictSniHost): static
    {
        $this->_strictSniHost = $strictSniHost;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'listen' => $this->_listen,
            'routes' => [...array_map(static function (Route $route) {
                return $route->toArray();
            }, $this->_routes)],
        ];

        if (isset($this->_readTimeout)) {
            $config['read_timeout'] = $this->_readTimeout;
        }

        if (isset($this->_readHeaderTimeout)) {
            $config['read_header_timeout'] = $this->_readHeaderTimeout;
        }

        if (isset($this->_writeTimeout)) {
            $config['write_timeout'] = $this->_writeTimeout;
        }

        if (isset($this->_idleTimeout)) {
            $config['idle_timeout'] = $this->_idleTimeout;
        }

        if (isset($this->_maxHeaderBytes)) {
            $config['max_header_bytes'] = $this->_maxHeaderBytes;
        }

        if (isset($this->_strictSniHost)) {
            $config['strict_sni_host'] = $this->_strictSniHost;
        }

        return $config;
    }
}