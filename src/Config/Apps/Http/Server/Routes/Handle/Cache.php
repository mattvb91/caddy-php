<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Logs\LogLevel;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

class Cache implements HandlerInterface
{
    private ?LogLevel $_logLevel;

    private ?array $_allowedHttpVerbs;

    private ?string $_defaultCacheControl;

    public function setLogLevel(?LogLevel $logLevel): static
    {
        $this->_logLevel = $logLevel;

        return $this;
    }

    public function setAllowedHttpVerbs(array $allowedHttpVerbs): static
    {
        $this->_allowedHttpVerbs = $allowedHttpVerbs;

        return $this;
    }

    public function setDefaultCacheControl(string $defaultCacheControl): static
    {
        $this->_defaultCacheControl = $defaultCacheControl;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->_logLevel)) {
            $array['log_level'] = $this->_logLevel->value;
        }

        if (isset($this->_allowedHttpVerbs)) {
            $array['allowed_http_verbs'] = $this->_allowedHttpVerbs;
        }

        if (isset($this->_defaultCacheControl)) {
            $array['default_cache_control'] = $this->_defaultCacheControl;
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'cache';
    }

}