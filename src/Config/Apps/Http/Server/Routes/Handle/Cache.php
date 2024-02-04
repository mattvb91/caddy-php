<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class Cache implements HandlerInterface
{
    private ?LogLevel $logLevel;

    /**
     * @var string[]|null
     */
    private ?array $allowedHttpVerbs;

    private ?string $defaultCacheControl;

    public function setLogLevel(?LogLevel $logLevel): static
    {
        $this->logLevel = $logLevel;

        return $this;
    }

    /**
     * @param string[] $allowedHttpVerbs
     * @return $this
     */
    public function setAllowedHttpVerbs(array $allowedHttpVerbs): static
    {
        $this->allowedHttpVerbs = $allowedHttpVerbs;

        return $this;
    }

    public function setDefaultCacheControl(string $defaultCacheControl): static
    {
        $this->defaultCacheControl = $defaultCacheControl;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->logLevel)) {
            $array['log_level'] = $this->logLevel->value;
        }

        if (isset($this->allowedHttpVerbs)) {
            $array['allowed_http_verbs'] = $this->allowedHttpVerbs;
        }

        if (isset($this->defaultCacheControl)) {
            $array['default_cache_control'] = $this->defaultCacheControl;
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'cache';
    }
}
