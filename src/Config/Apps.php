<?php

namespace mattvb91\CaddyPhp\Config;

use mattvb91\CaddyPhp\Config\Apps\Http;
use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * AppsRaw are the apps that Caddy will load and run.
 * The app module name is the key, and the app's config is the associated value.
 *
 * https://caddyserver.com/docs/json/apps/
 */
class Apps implements Arrayable
{
    private Http $_http;

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}