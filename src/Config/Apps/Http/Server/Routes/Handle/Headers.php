<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Headers\Request;
use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\Headers\Response;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * https://caddyserver.com/docs/modules/http.handlers.headers
 */
class Headers implements HandlerInterface
{
    private ?Request $_request;

    private ?Response $_response;

    public function setRequest(?Request $request): static
    {
        $this->_request = $request;

        return $this;
    }

    public function setResponse(?Response $response): static
    {
        $this->_response = $response;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->_response)) {
            $array['response'] = $this->_response->toArray();
        }

        if (isset($this->_request)) {
            $array['request'] = $this->_request->toArray();
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'headers';
    }
}