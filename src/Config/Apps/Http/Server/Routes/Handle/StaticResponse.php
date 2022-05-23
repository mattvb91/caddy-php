<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * StaticResponse implements a simple responder for static responses.
 *
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/static_response/
 */
class StaticResponse implements HandlerInterface
{

    private string $_body;

    private int $_statusCode;

    public function __construct(string $body, int $statusCode)
    {
        $this->_body = $body;
        $this->_statusCode = $statusCode;
    }

    public function toArray(): array
    {
        return [
            'handler'     => $this->getHandler(),
            'body'        => $this->_body,
            'status_code' => $this->_statusCode,
        ];
    }

    public function getHandler(): string
    {
        return 'static_response';
    }
}