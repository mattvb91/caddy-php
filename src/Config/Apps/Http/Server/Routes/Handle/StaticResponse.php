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

    private ?string $_body;

    private int $_statusCode;

    /** @var string[]  */
    private array $_headers;

    public function __construct(?string $body = null, int $statusCode = 200)
    {
        $body ? $this->_body = $body : null;
        $this->_statusCode = $statusCode;
    }

    /**
     * @param string[] $headers
     * @return $this
     */
    public function setHeaders(array $headers): static
    {
        $this->_headers = $headers;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'handler'     => $this->getHandler(),
            'status_code' => $this->_statusCode,
        ];

        if (isset($this->_body)) {
            $config['body'] = $this->_body;
        }

        if (isset($this->_headers)) {
            $config['headers'] = $this->_headers;
        }

        return $config;
    }

    public function getHandler(): string
    {
        return 'static_response';
    }
}