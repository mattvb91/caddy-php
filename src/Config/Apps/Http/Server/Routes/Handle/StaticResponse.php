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
    private ?string $body;

    private int $statusCode;

    /** @var string[]  */
    private array $headers;

    public function __construct(?string $body = null, int $statusCode = 200)
    {
        $body ? $this->body = $body : null;
        $this->statusCode = $statusCode;
    }

    /**
     * @param string[] $headers
     * @return $this
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    public function toArray(): array
    {
        $config = [
            'handler'     => $this->getHandler(),
            'status_code' => $this->statusCode,
        ];

        if (isset($this->body)) {
            $config['body'] = $this->body;
        }

        if (isset($this->headers)) {
            $config['headers'] = $this->headers;
        }

        return $config;
    }

    public function getHandler(): string
    {
        return 'static_response';
    }
}
