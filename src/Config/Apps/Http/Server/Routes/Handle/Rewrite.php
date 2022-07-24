<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/subroute/errors/routes/handle/rewrite/
 */
class Rewrite implements HandlerInterface
{
    private ?string $_stripPathPrefix;

    private ?string $_uri;

    public function setStripPathPrefix(?string $stripPathPrefix): static
    {
        $this->_stripPathPrefix = $stripPathPrefix;

        return $this;
    }

    public function setUri(string $uri): static
    {
        $this->_uri = $uri;

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->_stripPathPrefix)) {
            $array['strip_path_prefix'] = $this->_stripPathPrefix;
        }

        if (isset($this->_uri)) {
            $array['uri'] = $this->_uri;
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'rewrite';
    }

}