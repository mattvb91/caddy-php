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
    private ?Request $request;

    private ?Response $response;

    public function setRequest(?Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function setResponse(?Response $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->response)) {
            $array['response'] = $this->response->toArray();
        }

        if (isset($this->request)) {
            $array['request'] = $this->request->toArray();
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'headers';
    }
}
