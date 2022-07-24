<?php

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Upstream;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\ReverseProxy\TransportInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/
 */
class ReverseProxy implements HandlerInterface
{
    private ?array $_upstreams;

    private ?array $_transport;

    public function addUpstream(Upstream $upstream): static
    {
        if (!isset($this->_upstreams)) {
            $this->_upstreams = [$upstream];
        } else {
            $this->_upstreams[] = $upstream;
        }

        return $this;
    }

    public function addTransport(TransportInterface $transport): static
    {
        if (!isset($this->_transport)) {
            $this->_transport = [$transport];
        } else {
            $this->_transport[] = $transport;
        }

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->_transport)) {
            $array['transport'] = array_map(static function (TransportInterface $transport) {
                return $transport->toArray();
            }, $this->_transport)[0]; //TODO there has to be a better way than [0] access to get this level
        }

        if (isset($this->_upstreams)) {
            $array['upstreams'] = [...array_map(static function (Upstream $upstream) {
                return $upstream->toArray();
            }, $this->_upstreams)];
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'reverse_proxy';
    }
}