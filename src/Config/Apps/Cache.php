<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Cache\Api;
use mattvb91\CaddyPhp\Config\Apps\Cache\Cdn;
use mattvb91\CaddyPhp\Config\Apps\Cache\Nuts;
use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Cache implements Arrayable
{
    private Api $_api;

    private Cdn $_cdn;

    private Nuts $_nuts;

    private LogLevel $_logLevel = LogLevel::INFO;

    private string $_stale = '3600s';

    private string $_ttl = '3600s';

    public function __construct(
        Api $_api = new Api(),
        Cdn $_cdn = new Cdn())
    {
        $this->_api = $_api;
        $this->_cdn = $_cdn;

        //This shouldnt be here, we need to add optional named parameters
        //to constructor instead
        $this->_nuts = new Nuts();
    }

    public function setApi(Api $api): void
    {
        $this->_api = $api;
    }

    public function setCdn(Cdn $cdn): void
    {
        $this->_cdn = $cdn;
    }

    public function setLogLevel(LogLevel $logLevel): void
    {
        $this->_logLevel = $logLevel;
    }

    public function setStale(string $stale): void
    {
        $this->_stale = $stale;
    }

    public function setTtl(string $ttl): void
    {
        $this->_ttl = $ttl;
    }

    public function setNuts(Nuts $nuts): void
    {
        $this->_nuts = $nuts;
    }

    public function toArray(): array
    {
        return [
            'cache' => [
                'api'       => $this->_api->toArray(),
                'cdn'       => $this->_cdn->toArray(),
                'nuts'      => $this->_nuts->toArray(),
                'log_level' => $this->_logLevel->value,
                'stale'     => $this->_stale,
                'ttl'       => $this->_ttl,
            ]
        ];
    }
}