<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy;

use mattvb91\CaddyPhp\Interfaces\Arrayable;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/upstreams/
 */
class Upstream implements Arrayable
{
    private ?string $dial;

    public function setDial(string $dial): static
    {
        $this->dial = $dial;

        return $this;
    }

    public function toArray(): array
    {
        $array = [];

        if (isset($this->dial)) {
            $array['dial'] = $this->dial;
        }

        return $array;
    }
}
