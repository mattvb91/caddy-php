<?php

declare(strict_types=1);

namespace mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle;

use mattvb91\CaddyPhp\Config\Apps\Http\Server\Routes\Handle\ReverseProxy\Upstream;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\HandlerInterface;
use mattvb91\CaddyPhp\Interfaces\Apps\Servers\Routes\Handle\ReverseProxy\TransportInterface;

/**
 * https://caddyserver.com/docs/json/apps/http/servers/routes/handle/reverse_proxy/
 */
class ReverseProxy implements HandlerInterface
{
    /** @var Upstream[]|null  */
    private ?array $upstreams;

    /** @var TransportInterface[]|null  */
    private ?array $transport;

    public function addUpstream(Upstream $upstream): static
    {
        if (!isset($this->upstreams)) {
            $this->upstreams = [$upstream];
        } else {
            $this->upstreams[] = $upstream;
        }

        return $this;
    }

    public function addTransport(TransportInterface $transport): static
    {
        if (!isset($this->transport)) {
            $this->transport = [$transport];
        } else {
            $this->transport[] = $transport;
        }

        return $this;
    }

    public function toArray(): array
    {
        $array = [
            'handler' => $this->getHandler(),
        ];

        if (isset($this->transport)) {
            $array['transport'] = array_map(static function (TransportInterface $transport): array {
                return $transport->toArray();
            }, $this->transport)[0]; //TODO there has to be a better way than [0] access to get this level
        }

        if (isset($this->upstreams)) {
            $array['upstreams'] = [...array_map(static function (Upstream $upstream): array {
                return $upstream->toArray();
            }, $this->upstreams)
            ];
        }

        return $array;
    }

    public function getHandler(): string
    {
        return 'reverse_proxy';
    }
}
