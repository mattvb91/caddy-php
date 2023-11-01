<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Match\MatcherInterface;
use mattvb91\CaddyPhp\Interfaces\Arrayable;
use mattvb91\CaddyPhp\Traits\IterableProps;

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
    use IterableProps;

    private ?string $_group;

    /** @var HandlerInterface[] */
    private array $_handle = [];

    /** @var MatcherInterface[]|null  */
    private ?array $_match;

    private ?bool $_terminal;

    public function setGroup(string $group): static
    {
        $this->_group = $group;

        return $this;
    }

    public function addMatch(MatcherInterface $match): static
    {
        if (!isset($this->_match)) {
            $this->_match = [$match];
        } else {
            $this->_match[] = $match;
        }

        return $this;
    }

    public function addHandle(HandlerInterface $handler): static
    {
        $this->_handle[] = $handler;

        return $this;
    }

    public function setTerminal(bool $terminal): static
    {
        $this->_terminal = $terminal;

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

        if (isset($this->_match)) {

            $config['match'] = array_map(static function (MatcherInterface $matcher) {
                return $matcher->toArray();
            }, $this->_match);

            /**
             * TODO this is a brutal hack, check / test why we need to do this.
             * Currently its when we have multiple matchers for example file & not
             */
            if (count($config['match']) > 1) {
                $matches = [];
                foreach ($config['match'] as $match) {
                    $matches[array_key_first($match)] = array_pop($match);
                }
                $config['match'] = [$matches];
            }
        }

        if (isset($this->_terminal)) {
            $config['terminal'] = $this->_terminal;
        }

        return $config;
    }
}