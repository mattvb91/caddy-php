<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server;

use mattvb91\caddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;
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

    private ?string $_group;

    /** @var HandlerInterface[] */
    private array $_handle = [];

    private ?array $_match;

    private ?bool $_terminal;

    public function setGroup(string $group)
    {
        $this->_group = $group;
    }

    public function addMatch($match): static
    {
        $this->_match[] = $match;
        return $this;
    }

    public function addHandle(HandlerInterface $handler): static
    {
        $this->_handle[] = $handler;

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if (isset($this->_group)) {
            $config['group'] = $this->_group;
        }

        $config['handle'] = [...array_map(static function (HandlerInterface $handler) {
            return $handler->toArray();
        }, $this->_handle)];

        return $config;
    }
}