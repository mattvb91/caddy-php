<?php

declare(strict_types=1);

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
    private Api $api;

    private Cdn $cdn;

    private ?Nuts $nuts;

    private ?Redis $redis;

    private LogLevel $logLevel = LogLevel::INFO;

    /** @var Key[] */
    private ?array $cacheKeys;

    private string $stale = '3600s';

    private string $ttl = '3600s';

    public function __construct(
        Api $_api = new Api(),
        Cdn $_cdn = new Cdn()
    ) {
        $this->api = $_api;
        $this->cdn = $_cdn;
    }

    public function setApi(Api $api): static
    {
        $this->api = $api;

        return $this;
    }

    public function setCdn(Cdn $cdn): static
    {
        $this->cdn = $cdn;

        return $this;
    }

    public function setLogLevel(LogLevel $logLevel): static
    {
        $this->logLevel = $logLevel;

        return $this;
    }

    public function setStale(string $stale): static
    {
        $this->stale = $stale;

        return $this;
    }

    public function setTtl(string $ttl): static
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function setNuts(Nuts $nuts): static
    {
        $this->nuts = $nuts;

        return $this;
    }

    public function setRedis(?Redis $redis): static
    {
        $this->redis = $redis;

        return $this;
    }

    public function addCacheKey(Key $key): static
    {
        if (!isset($this->cacheKeys)) {
            $this->cacheKeys = [$key];
        } else {
            $this->cacheKeys[] = $key;
        }

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'api'       => $this->api->toArray(),
            'cdn'       => $this->cdn->toArray(),
            'log_level' => $this->logLevel->value,
            'stale'     => $this->stale,
            'ttl'       => $this->ttl,
        ];

        if (isset($this->nuts)) {
            $array['nuts'] = $this->nuts->toArray();
        }

        if (isset($this->redis)) {
            $array['redis'] = $this->redis->toArray();
        }

        if (isset($this->cacheKeys)) {
            $array['cache_keys'] = array_map(static function (Key $key): array {
                return [$key->getPattern() => $key->toArray()];
            }, $this->cacheKeys)[0]; //TODO there has to be a better way than [0] access to get this level
        }

        return $array;
    }
}
