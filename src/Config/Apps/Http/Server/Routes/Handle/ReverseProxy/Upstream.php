<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/upstreams/
 */
class Upstream implements Arrayable
{
    private ?string $_dial;

    public function setDial(string $dial): static
    {
        $this->_dial = $dial;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (isset($this->_dial)) {
            $array['dial'] = $this->_dial;
        }

        return $array;
    }

}