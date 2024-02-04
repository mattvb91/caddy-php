<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Logs;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * Logs are your logs, keyed by an arbitrary name of your choosing.
 * The default log can be customized by defining a log called "default".
 * You can further define other logs and filter what kinds of entries they accept.
 *
 * https://caddyserver.com/docs/json/logging/logs/
 */
class Log implements Arrayable
{
    private LogLevel $level;

    public function __construct(LogLevel $level = LogLevel::DEBUG)
    {
        $this->level = $level;
    }

    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function toArray(): array
    {
        return [
            'level' => $this->getLevel(),
        ];
    }
}
