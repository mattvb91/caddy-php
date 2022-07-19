<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Cache\Api;
use mattvb91\CaddyPhp\Config\Apps\Cache\Cdn;
use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

class Cache implements Arrayable
{
    private Api $_api;

    private Cdn $_cdn;

    private LogLevel $_logLevel = LogLevel::DEBUG;

    public function __construct(
        Api $_api = new Api(),
        Cdn $_cdn = new Cdn())
    {
        $this->_api = $_api;
        $this->_cdn = $_cdn;
    }

    public function setApi(Api $api): void
    {
        $this->_api = $api;
    }

    public function setCdn(Cdn $cdn): void
    {
        $this->_cdn = $cdn;
    }

    public function toArray(): array
    {
        return [
            'cache' => [
                'api'       => $this->_api->toArray(),
                'cdn'       => $this->_cdn->toArray(),
                'log_level' => $this->_logLevel->value,
            ]
        ];
    }
}