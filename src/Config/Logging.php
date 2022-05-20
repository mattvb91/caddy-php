<?php

namespace mattvb91\CaddyPhp\Config;

use mattvb91\CaddyPhp\Config\Logs\Log;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * Logging facilitates logging within Caddy.
 * The default log is called "default" and you can customize it.
 * You can also define additional logs.
 *
 * https://caddyserver.com/docs/json/logging/
 */
class Logging implements Arrayable
{
    /** @var Log[] $_logs */
    private $_logs = [];

    public function addLog(Log $log, ?string $name = 'default')
    {
        if (array_key_exists('', $this->_logs)) {
            throw new \Exception('Log with this name alread exists');
        }
        $this->_logs[$name] = $log;

        return $this;
    }

    public function toArray(): array
    {
        $logs = [];

        array_map(function (string $key, Log $log) use (&$logs) {
            $logs[$key] = $log->toArray();
        }, array_keys($this->_logs), $this->_logs);

        return [
            'logs' => $logs,
        ];
    }
}