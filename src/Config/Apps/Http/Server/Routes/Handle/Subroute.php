<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Route;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/subroute/
 */
class Subroute implements HandlerInterface
{
    /** @var Route[]  */
    private array $routes = [];

    public function addRoute(Route $route): static
    {
        $this->routes[] = $route;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'handler' => $this->getHandler(),
            'routes'  => [...array_map(static function (Route $route): array {
                return $route->toArray();
            }, $this->routes)
            ],
        ];
    }

    public function getHandler(): string
    {
        return 'subroute';
    }
}
