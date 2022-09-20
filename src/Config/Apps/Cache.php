<?php

namespace mattvb91\CaddyPhp\Config\Apps;

use mattvb91\CaddyPhp\Config\Apps\Cache\Api;
use mattvb91\CaddyPhp\Config\Apps\Cache\Cdn;
use mattvb91\CaddyPhp\Config\Apps\Cache\Key;
use mattvb91\CaddyPhp\Config\Apps\Cache\Nuts;
use mattvb91\CaddyPhp\Config\Apps\Cache\Redis;
use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use mattvb91\CaddyPhp\Interfaces\App;

class Cache implements App
{
    private Api $_api;

    private Cdn $_cdn;

    private ?Nuts $_nuts;

    private ?Redis $_redis;

    private LogLevel $_logLevel = LogLevel::INFO;

    /** @var Key[] */
    private ?array $_cacheKeys;

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

    public function setApi(Api $api): static
    {
        $this->_api = $api;

        return $this;
    }

    public function setCdn(Cdn $cdn): static
    {
        $this->_cdn = $cdn;

        return $this;
    }

    public function setLogLevel(LogLevel $logLevel): static
    {
        $this->_logLevel = $logLevel;

        return $this;
    }

    public function setStale(string $stale): static
    {
        $this->_stale = $stale;

        return $this;
    }

    public function setTtl(string $ttl): static
    {
        $this->_ttl = $ttl;

        return $this;
    }

    public function setNuts(Nuts $nuts): static
    {
        $this->_nuts = $nuts;

        return $this;
    }

    public function setRedis(?Redis $redis): static
    {
        $this->_redis = $redis;

        return $this;
    }

    public function addCacheKey(Key $key): static
    {
        if (!isset($this->_cacheKeys)) {
            $this->_cacheKeys = [$key];
        } else {
            $this->_cacheKeys[] = $key;
        }

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'api'       => $this->_api->toArray(),
            'cdn'       => $this->_cdn->toArray(),
            'log_level' => $this->_logLevel->value,
            'stale'     => $this->_stale,
            'ttl'       => $this->_ttl,
        ];

        if (isset($this->_nuts)) {
            $array['nuts'] = $this->_nuts->toArray();
        }

        if (isset($this->_redis)) {
            $array['redis'] = $this->_redis->toArray();
        }

        if (isset($this->_cacheKeys)) {
            $array['cache_keys'] = array_map(static function (Key $key) {
                return [$key->getPattern() => $key->toArray()];
            }, $this->_cacheKeys)[0]; //TODO there has to be a better way than [0] access to get this level
        }

        return $array;
    }
}