<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/subroute/errors/routes/handle/rewrite/
 */
class Rewrite implements HandlerInterface
{
    private ?string $stripPathPrefix;

    private ?string $uri;

    public function setStripPathPrefix(?string $stripPathPrefix): static
    {
        $this->stripPathPrefix = $stripPathPrefix;

        return $this;
    }

    public function setUri(string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->stripPathPrefix)) {
            $array['strip_path_prefix'] = $this->stripPathPrefix;
        }

        if (isset($this->uri)) {
            $array['uri'] = $this->uri;
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'rewrite';
    }
}
