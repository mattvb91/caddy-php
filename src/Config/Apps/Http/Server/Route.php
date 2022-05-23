<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * Routes describes how this server will handle requests.
 * Routes are executed sequentially. First a route's matchers are evaluated, then its grouping.
 * If it matches and has not been mutually-excluded by its grouping, then its handlers are executed sequentially.
 * The sequence of invoked handlers comprises a compiled middleware chain that flows from each matching route and its handlers to the next.
 *
 * https://caddyserver.com/docs/json/apps/http/servers/routes/
 */
class Route implements Arrayable
{

    private string $_group = "";

    private array $_match = [];

    private bool $_terminal = false;

    public function toArray(): array
    {
        return [
            'group' => $this->_group,
        ];
    }
}